<?php
/**
 * Sharji Press - AJAX Endpoints & Dynamic Loading
 * Post views tracking, homepage infinite load, and mobile feed pagination
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// 1. AJAX: Increment Single Post Views (100% Unified with Post Views Counter & Meta)
add_action( 'wp_ajax_sharji_increment_views', 'sharji_ajax_increment_views_handler' );
add_action( 'wp_ajax_nopriv_sharji_increment_views', 'sharji_ajax_increment_views_handler' );
function sharji_ajax_increment_views_handler() {
    $post_id = isset( $_POST['post_id'] ) ? absint( $_POST['post_id'] ) : 0;
    if ( $post_id > 0 && get_post_status( $post_id ) === 'publish' ) {
        // Fetch current highest recorded count across all mechanisms
        $current = function_exists( 'sharji_get_raw_post_views' ) 
            ? sharji_get_raw_post_views( $post_id ) 
            : (int) get_post_meta( $post_id, 'views', true );
        
        $new_count = $current + 1;

        // Atomically update both meta keys
        update_post_meta( $post_id, 'views', $new_count );
        update_post_meta( $post_id, 'post_views_count', $new_count );

        // If Post Views Counter plugin is active, increment its internal table as well
        if ( function_exists( 'pvc_view_post' ) ) {
            pvc_view_post( $post_id, 1 );
        }

        $farsi_val = function_exists( 'sharji_to_farsi_digits' ) 
            ? sharji_to_farsi_digits( number_format_i18n( $new_count ) ) 
            : (string) $new_count;

        wp_send_json_success( [
            'post_id' => $post_id,
            'views'   => $new_count,
            'farsi'   => $farsi_val,
        ] );
    }
    wp_send_json_error( 'Invalid post' );
}

// 2. AJAX: Bulk Views Fetcher (Returns live Farsi numerals)
add_action( 'wp_ajax_sharji_get_bulk_views', 'sharji_ajax_get_bulk_views_handler' );
add_action( 'wp_ajax_nopriv_sharji_get_bulk_views', 'sharji_ajax_get_bulk_views_handler' );
function sharji_ajax_get_bulk_views_handler() {
    $post_ids = isset( $_POST['post_ids'] ) ? array_map( 'absint', $_POST['post_ids'] ) : [];
    $results = [];
    if ( ! empty( $post_ids ) ) {
        foreach ( $post_ids as $id ) {
            if ( $id > 0 ) {
                $count = function_exists( 'sharji_get_raw_post_views' ) 
                    ? sharji_get_raw_post_views( $id ) 
                    : (int) get_post_meta( $id, 'views', true );

                $results[$id] = function_exists( 'sharji_to_farsi_digits' ) 
                    ? sharji_to_farsi_digits( number_format_i18n( $count ) ) 
                    : (string) $count;
            }
        }
        wp_send_json_success( $results );
    }
    wp_send_json_error( 'No IDs provided' );
}

// 3. Single Post View Increment Trigger in Footer (Reliable with caching & keepalive)
add_action( 'wp_footer', function() {
    if ( is_single() ) {
        $post_id = get_the_ID();
        if ( ! $post_id ) return;
        ?>
        <script>
        (function() {
            var postId = '<?php echo esc_js( $post_id ); ?>';
            if (!postId) return;

            // Session check prevents duplicate count spikes on accidental fast refresh
            var storageKey = 'sharji_v_' + postId;
            try {
                if (sessionStorage.getItem(storageKey)) return;
                sessionStorage.setItem(storageKey, '1');
            } catch(e) {}

            var ajaxUrl = (typeof sharjiSettings !== 'undefined' && sharjiSettings.ajaxUrl) 
                ? sharjiSettings.ajaxUrl 
                : '/wp-admin/admin-ajax.php';

            var fd = new FormData();
            fd.append('action', 'sharji_increment_views');
            fd.append('post_id', postId);

            if (navigator.sendBeacon) {
                navigator.sendBeacon(ajaxUrl, fd);
            } else {
                fetch(ajaxUrl, { method: 'POST', body: fd, keepalive: true }).catch(function(){});
            }
        })();
        </script>
        <?php
    }
}, 99 );

// 4. Cache Clearing
function clear_redis_cache_on_save( $post_id ) {
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
    wp_cache_delete( 'related_posts_' . $post_id, 'single_page' );
    wp_cache_delete( 'editor_picks_sidebar', 'sidebar' );
}
add_action( 'save_post', 'clear_redis_cache_on_save' );

// 5. AJAX: Load More Desktop (Homepage)
add_action( 'wp_ajax_load_more_home_action', 'load_more_home_callback' );
add_action( 'wp_ajax_nopriv_load_more_home_action', 'load_more_home_callback' );
function load_more_home_callback() {
    $page = isset( $_POST['page'] ) ? intval( $_POST['page'] ) : 1;

    $side_offset   = 8 + ( ( $page - 1 ) * 8 );
    $center_offset = 6 + ( ( $page - 1 ) * 6 );

    $response = ['most_viewed' => '', 'latest' => '', 'interviews' => ''];

    // Most Viewed
    $args_mv = [
        'post_type'        => 'post',
        'posts_per_page'   => 8,
        'offset'           => $side_offset,
        'suppress_filters' => true,
        'orderby'          => 'meta_value_num',
        'meta_key'         => 'views',
        'order'            => 'DESC',
    ];
    $q1 = new WP_Query( $args_mv );
    if ( $q1->have_posts() ) {
        while ( $q1->have_posts() ) {
            $q1->the_post();
            ob_start();
            ?>
            <a href="<?php the_permalink(); ?>" class="n-box">
                <div class="w-20 h-16 flex-shrink-0 overflow-hidden rounded"><?php the_post_thumbnail( 'thumbnail', ['class' => 'rounded object-cover w-full h-full', 'style' => 'object-fit:cover!important;'] ); ?></div>
                <div class="flex-1 flex flex-col justify-between">
                    <div>
                        <h4 class="font-diba blue-title side-title"><?php the_title(); ?></h4>
                        <div class="side-excerpt"><?php echo get_the_excerpt(); ?></div>
                    </div>
                    <div class="view-badge"><i class="fas fa-eye text-xs"></i> <span class="live-view-count" data-id="<?php the_ID(); ?>"><?php echo get_post_views( get_the_ID() ); ?></span></div>
                </div>
            </a>
            <?php
            $response['most_viewed'] .= ob_get_clean();
        }
    }

    // Latest News
    $q2 = new WP_Query( ['category_name' => 'news', 'posts_per_page' => 6, 'offset' => $center_offset, 'ignore_sticky_posts' => 1] );
    if ( $q2->have_posts() ) {
        while ( $q2->have_posts() ) {
            $q2->the_post();
            ob_start();
            ?>
            <a href="<?php the_permalink(); ?>" class="special-row">
                <div class="w-[180px] h-[120px] overflow-hidden rounded flex-shrink-0"><?php the_post_thumbnail( 'large', ['class' => 'w-full h-full object-cover', 'style' => 'object-fit:cover!important;'] ); ?></div>
                <div class="flex-1 flex flex-col justify-center h-full">
                    <h4 class="font-diba text-xl blue-title mb-2 leading-tight"><?php the_title(); ?></h4>
                    <div class="text-gray-600 text-xs line-clamp-3 leading-relaxed text-justify"><?php echo get_the_excerpt(); ?></div>
                    <div class="read-more">ادامه خبر <i class="fas fa-angle-double-left"></i></div>
                </div>
            </a>
            <?php
            $response['latest'] .= ob_get_clean();
        }
    }

    // Interviews
    $q3 = new WP_Query( ['category_name' => 'interviews', 'posts_per_page' => 8, 'offset' => $side_offset, 'ignore_sticky_posts' => 1] );
    if ( $q3->have_posts() ) {
        while ( $q3->have_posts() ) {
            $q3->the_post();
            ob_start();
            ?>
            <a href="<?php the_permalink(); ?>" class="n-box flex-col md:flex-row">
                <div class="w-20 h-16 flex-shrink-0 relative overflow-hidden rounded"><?php the_post_thumbnail( 'thumbnail', ['class' => 'rounded w-full h-full object-cover', 'style' => 'object-fit:cover!important;'] ); ?></div>
                <div class="flex-1 flex flex-col justify-between">
                    <div>
                        <h4 class="font-diba blue-title side-title"><?php the_title(); ?></h4>
                        <div class="side-excerpt"><?php echo get_the_excerpt(); ?></div>
                    </div>
                </div>
            </a>
            <?php
            $response['interviews'] .= ob_get_clean();
        }
    }

    wp_reset_postdata();
    wp_send_json_success( $response );
}

// 6. AJAX: Load More Mobile (News, Sports, Videos, Most Viewed)
add_action( 'wp_ajax_load_more_mobile_action', 'load_more_mobile_callback' );
add_action( 'wp_ajax_nopriv_load_more_mobile_action', 'load_more_mobile_callback' );
function load_more_mobile_callback() {
    $page = isset( $_POST['page'] ) ? intval( $_POST['page'] ) : 2;
    $type = isset( $_POST['type'] ) ? sanitize_text_field( $_POST['type'] ) : 'news';

    $args = [
        'posts_per_page' => 5,
        'paged'          => $page,
        'post_status'    => 'publish',
    ];

    switch ( $type ) {
        case 'news':
        case 'latest':
            $args['category_name'] = 'news';
            break;
        case 'tahlil':
            $args['category_name'] = 'tahlil';
            break;
        case 'sport':
            $args['category_name'] = 'sport';
            break;
        case 'most_viewed':
            $args['suppress_filters'] = true;
            $args['orderby']          = 'meta_value_num';
            $args['order']            = 'DESC';
            $args['meta_key']         = 'views';
            break;
        case 'video':
            $media_cat_ids = [];
            foreach ( ['multimedia', 'video', 'image'] as $media_slug ) {
                $media_cat = get_category_by_slug( $media_slug );
                if ( $media_cat ) {
                    $media_cat_ids[] = (int) $media_cat->term_id;
                }
            }
            if ( ! empty( $media_cat_ids ) ) {
                $args['category__in'] = $media_cat_ids;
            } else {
                $args['category_name'] = 'multimedia';
            }
            break;
        case 'interviews':
            $args['category_name'] = 'interviews';
            break;
        default:
            $args['category_name'] = 'news';
            break;
    }

    $query = new WP_Query( $args );
    $html = '';

    if ( $query->have_posts() ) {
        while ( $query->have_posts() ) {
            $query->the_post();
            ob_start();

            $icon_html = '';
            $video_preview = get_post_meta( get_the_ID(), 'video_preview_url', true );
            $thumb_bg = ( $type === 'video' && $video_preview ) ? 'bg-black' : '';

            if ( $type === 'video' ) {
                $icon_cls = has_category( 'video' ) ? 'fa-play' : 'fa-camera';
                $icon_html = '<div class="absolute inset-0 bg-black/30 flex items-center justify-center text-white"><i class="fas ' . esc_attr( $icon_cls ) . '"></i></div>';
            }

            if ( $type === 'sport' ) :
                ?>
                <a href="<?php echo esc_url( add_query_arg( 'theme', 'sport', get_permalink() ) ); ?>" class="sport-mobile-row">
                    <div class="sport-mobile-thumb">
                        <?php if ( has_post_thumbnail() ) : ?>
                            <?php the_post_thumbnail( 'thumbnail', ['class' => 'w-full h-full object-cover', 'style' => 'object-fit:cover!important;'] ); ?>
                        <?php endif; ?>
                    </div>
                    <div class="sport-mobile-row-content">
                        <h4 class="sport-mobile-row-title"><?php the_title(); ?></h4>
                        <div class="sport-mobile-row-excerpt">
                            <?php echo wp_trim_words( get_the_excerpt(), 18, '...' ); ?>
                        </div>
                        <div class="sport-mobile-row-meta">
                            <i class="far fa-clock"></i>
                            <?php echo get_the_date( 'j F Y' ); ?>
                        </div>
                    </div>
                </a>
                <?php
            else :
                ?>
                <a href="<?php the_permalink(); ?>" class="m-news-row">
                    <div class="m-row-thumb relative <?php echo esc_attr( $thumb_bg ); ?>">
                        <?php if ( $type === 'video' && $video_preview ) : ?>
                            <video src="<?php echo esc_url( $video_preview ); ?>" loop muted playsinline class="w-full h-full object-cover" style="object-fit:cover!important; opacity:0.8;"></video>
                        <?php elseif ( has_post_thumbnail() ) : ?>
                            <?php the_post_thumbnail( 'thumbnail', ['class' => 'w-full h-full object-cover', 'style' => 'object-fit:cover!important;'] ); ?>
                        <?php endif; ?>
                        <?php echo $icon_html; ?>
                    </div>
                    <div class="m-row-content">
                        <h4 class="m-row-title"><?php the_title(); ?></h4>
                        <div class="m-row-excerpt">
                            <?php echo wp_trim_words( get_the_excerpt(), 20, '...' ); ?>
                        </div>
                        <div class="m-row-meta">
                            <?php if ( $type === 'most_viewed' ) : ?>
                                <span class="text-xs text-blue-600 bg-blue-50 px-2 rounded-full ml-2">
                                    <?php echo $query->current_post + 1 + ( ( $page - 1 ) * 5 ); ?>#
                                </span>
                                <i class="far fa-eye ml-1"></i>
                                <span class="live-view-count" data-id="<?php the_ID(); ?>"><?php echo get_post_views( get_the_ID() ); ?></span>
                            <?php else : ?>
                                <i class="far fa-clock ml-1"></i>
                                <?php echo get_the_date( 'j F Y' ); ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </a>
                <?php
            endif;

            $html .= ob_get_clean();
        }

        wp_reset_postdata();
        wp_send_json_success( ['html' => $html] );
    } else {
        wp_send_json_error( ['message' => 'No more posts'] );
    }
}

