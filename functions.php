<?php
/**
 * Sharji Theme Functions - FINAL LOCAL VERSION
 * Fixed: AJAX Layout, Local Assets, Performance Optimized, Video Previews
 */

error_reporting(0);
@ini_set('display_errors', 0);

// ==========================================
// 1. تنظیمات اولیه
// ==========================================
function sharji_setup() {
    add_theme_support('post-thumbnails');
    add_theme_support('title-tag');
    add_theme_support('html5', ['comment-list', 'comment-form', 'search-form', 'gallery', 'caption', 'style', 'script']);
    register_nav_menus( array( 'main-menu' => 'Main Menu' ) );
}
add_action('after_setup_theme', 'sharji_setup');

// ==========================================
// 2. حذف فایل‌های غیرضروری از هدر
// ==========================================
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');
remove_action('admin_print_scripts', 'print_emoji_detection_script');
remove_action('admin_print_styles', 'print_emoji_styles');
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'wp_shortlink_wp_head');
remove_action('wp_head', 'rest_output_link_wp_head');
remove_action('wp_head', 'wp_oembed_add_discovery_links');

// حذف jQuery Migrate
add_action('wp_default_scripts', function($scripts) {
    if (!is_admin() && isset($scripts->registered['jquery'])) {
        $script = $scripts->registered['jquery'];
        if ($script->deps) {
            $script->deps = array_diff($script->deps, ['jquery-migrate']);
        }
    }
});

// غیرفعال کردن XML-RPC
add_filter('xmlrpc_enabled', '__return_false');

// غیرفعال کردن heartbeat در فرانت‌اند
add_action('init', function() {
    if (!is_admin()) {
        wp_deregister_script('heartbeat');
    }
});

// ==========================================
// 3. تنظیمات آپلود و URL
// ==========================================
add_filter( 'wp_lazy_loading_enabled', '__return_false' );

add_filter( 'wp_get_attachment_url', function( $url ) {
    if ( is_ssl() ) { $url = str_replace( 'http://', 'https://', $url ); }
    return $url;
});

// فشرده‌سازی JPEG
add_filter('jpeg_quality', function($arg) { return 85; });

// ==========================================
// 4. حذف CDN های خارجی - همه فایل‌ها لوکال هستن
// ==========================================
function sharji_scripts() {
    // Font Awesome و Tailwind از فایل‌های لوکال توی هدر لود میشن
    // اینجا چیزی اضافه نمی‌کنیم
}
add_action('wp_enqueue_scripts', 'sharji_scripts');

// جلوگیری از لود شدن فایل‌های CDN توسط افزونه‌ها
add_action('wp_default_styles', function($styles) {
    if (!is_admin()) {
        // حذف font-awesome اگه از CDN لود بشه
        foreach($styles->registered as $handle => $style) {
            if (strpos($style->src, 'cdnjs.cloudflare.com') !== false || 
                strpos($style->src, 'cdn.jsdelivr.net') !== false ||
                strpos($style->src, 'cdn.tailwindcss.com') !== false) {
                wp_deregister_style($handle);
                wp_dequeue_style($handle);
            }
        }
    }
}, 100);

add_action('wp_default_scripts', function($scripts) {
    if (!is_admin()) {
        foreach($scripts->registered as $handle => $script) {
            if (strpos($script->src, 'cdnjs.cloudflare.com') !== false || 
                strpos($script->src, 'cdn.jsdelivr.net') !== false ||
                strpos($script->src, 'cdn.tailwindcss.com') !== false) {
                wp_deregister_script($handle);
                wp_dequeue_script($handle);
            }
        }
    }
}, 100);

// ==========================================
// 5. ابزارک‌ها (Widgets)
// ==========================================
add_action( 'widgets_init', function() {
    register_sidebar( array( 'name' => 'سایدبار صفحه خبر ۱', 'id' => 'single-sidebar', 'before_widget' => '<div class="widget-wrapper mb-6 bg-white border border-slate-200 rounded-xl overflow-hidden shadow-sm">', 'after_widget' => '</div>', 'before_title' => '<div class="bg-slate-800 text-white p-4 yekan-bold text-xs">', 'after_title' => '</div>' ));
    register_sidebar( array( 'name' => 'سایدبار صفحه خبر ۲', 'id' => 'single-sidebar-2', 'before_widget' => '<div class="widget-wrapper mb-6 bg-white border border-slate-200 rounded-xl overflow-hidden shadow-sm">', 'after_widget' => '</div>', 'before_title' => '<div class="bg-slate-800 text-white p-4 yekan-bold text-xs">', 'after_title' => '</div>' ));
    register_sidebar( array( 'name' => 'تبلیغات تک نوشته', 'id' => 'ads-single', 'before_widget' => '<div class="single-ad-container">', 'after_widget' => '</div>' ) );
    register_sidebar( array( 'name' => 'تبلیغات سرویس ویدئو', 'id' => 'ads-video-sidebar', 'before_widget' => '', 'after_widget' => '' ) );
    register_sidebar( array( 'name' => 'تبلیغات سرویس تصویر', 'id' => 'ads-image-sidebar', 'before_widget' => '', 'after_widget' => '' ) );
    register_sidebar( array( 'name' => 'تبلیغات هدر راست', 'id' => 'header_ad_right', 'before_widget' => '<div class="header_ad_item">', 'after_widget' => '</div>' ) );
    register_sidebar( array( 'name' => 'تبلیغات هدر چپ', 'id' => 'header_ad_left', 'before_widget' => '<div class="header_ad_item">', 'after_widget' => '</div>' ) );

    // محل تبلیغ مخصوص صفحه اصلی در موبایل
    register_sidebar( array(
        'name' => 'تبلیغات موبایل صفحه اصلی',
        'id' => 'home-mobile-ad',
        'before_widget' => '<div class="mobile-home-ad-widget">',
        'after_widget' => '</div>',
        'before_title' => '<div class="mobile-home-ad-title">',
        'after_title' => '</div>'
    ) );
});

// ==========================================
// 6. توابع بازدید پست (AJAX-powered for Caching Compatibility)
// ==========================================
add_action('wp_ajax_sharji_increment_views', 'sharji_ajax_increment_views_handler');
add_action('wp_ajax_nopriv_sharji_increment_views', 'sharji_ajax_increment_views_handler');
function sharji_ajax_increment_views_handler() {
    $post_id = isset($_POST['post_id']) ? intval($_POST['post_id']) : 0;
    if ( $post_id ) {
        $count = (int) get_post_meta($post_id, 'views', true);
        $count++;
        update_post_meta($post_id, 'views', $count);
        update_post_meta($post_id, 'post_views_count', $count); // همگام‌سازی با متای قدیمی قالب
        wp_send_json_success($count);
    }
    wp_send_json_error();
}

add_action('wp_ajax_sharji_get_bulk_views', 'sharji_ajax_get_bulk_views_handler');
add_action('wp_ajax_nopriv_sharji_get_bulk_views', 'sharji_ajax_get_bulk_views_handler');
function sharji_ajax_get_bulk_views_handler() {
    $post_ids = isset($_POST['post_ids']) ? array_map('intval', $_POST['post_ids']) : [];
    $results = [];
    if ( !empty($post_ids) ) {
        foreach ($post_ids as $id) {
            $count = get_post_meta($id, 'views', true);
            $results[$id] = empty($count) ? "0" : $count;
        }
        wp_send_json_success($results);
    }
    wp_send_json_error();
}

add_action('wp_footer', function() {
    if ( is_single() ) {
        ?>
        <script>
        document.addEventListener("DOMContentLoaded", function() {
            var fd = new FormData();
            fd.append('action', 'sharji_increment_views');
            fd.append('post_id', '<?php echo get_the_ID(); ?>');
            fetch('<?php echo admin_url('admin-ajax.php'); ?>', { method: 'POST', body: fd });
        });
        </script>
        <?php
    }
});

function get_post_views($postID){
    $count = get_post_meta($postID, 'views', true); 
    $count = empty($count) ? "0" : $count;
    if ( ! is_admin() ) {
        return '<span class="live-view-count" data-id="' . $postID . '">' . $count . '</span>';
    }
    return $count;
}

// ==========================================
// 7. Lazy Loading و کش
// ==========================================
function add_lazy_loading_attribute($content) { return str_replace('<img', '<img loading="lazy"', $content); }
add_filter('the_content', 'add_lazy_loading_attribute');
add_filter('post_thumbnail_html', 'add_lazy_loading_attribute');

// محدود کردن بازبینی‌ها
add_filter('wp_revisions_to_keep', function($num, $post) { return 3; }, 10, 2);

// کش پست‌های مرتبط
function clear_redis_cache_on_save( $post_id ) {
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
    wp_cache_delete( 'related_posts_' . $post_id, 'single_page' );
    wp_cache_delete( 'editor_picks_sidebar', 'sidebar' );
}
add_action( 'save_post', 'clear_redis_cache_on_save' );
add_action( 'deleted_post', 'clear_redis_cache_on_save' );

// ==========================================
// 8. AJAX - Load More Desktop
// ==========================================
add_action('wp_ajax_load_more_home_action', 'load_more_home_callback');
add_action('wp_ajax_nopriv_load_more_home_action', 'load_more_home_callback');

function load_more_home_callback() {
    $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
    
    $side_offset = 8 + (($page - 1) * 8); 
    $center_offset = 6 + (($page - 1) * 6);
    
    $response = ['most_viewed' => '', 'latest' => '', 'interviews' => ''];

    // پربازدیدترین‌ها
    $args_mv = [
        'post_type'           => 'post',
        'posts_per_page'      => 8, 
        'offset'              => $side_offset, 
        'suppress_filters'    => true, 
        'orderby'             => 'meta_value_num', 
        'meta_key'            => 'views',
        'order'               => 'DESC'
    ];
    $q1 = new WP_Query($args_mv);
    
    if($q1->have_posts()){ while($q1->have_posts()){ $q1->the_post(); ob_start(); ?>
        <a href="<?php the_permalink(); ?>" class="n-box">
            <div class="w-20 h-16 flex-shrink-0 overflow-hidden rounded"><?php the_post_thumbnail('thumbnail', ['class'=>'rounded object-cover w-full h-full', 'style' => 'object-fit:cover!important;']); ?></div>
            <div class="flex-1 flex flex-col justify-between">
                <div>
                    <h4 class="font-diba blue-title side-title"><?php the_title(); ?></h4>
                    <div class="side-excerpt"><?php echo get_the_excerpt(); ?></div>
                </div>
                <div class="view-badge"><i class="fas fa-eye text-xs"></i> <span class="live-view-count" data-id="<?php the_ID(); ?>"><?php if(function_exists('get_post_views')) echo get_post_views(get_the_ID()); ?></span></div>
            </div>
        </a>
    <?php $response['most_viewed'] .= ob_get_clean(); } }

    // آخرین اخبار
    $q2 = new WP_Query(['category_name'=>'news', 'posts_per_page'=>6, 'offset' => $center_offset, 'ignore_sticky_posts' => 1]);
    if($q2->have_posts()){ while($q2->have_posts()){ $q2->the_post(); ob_start(); ?>
        <a href="<?php the_permalink(); ?>" class="special-row">
            <div class="w-[180px] h-[120px] overflow-hidden rounded flex-shrink-0"><?php the_post_thumbnail('large', ['class'=>'w-full h-full object-cover', 'style' => 'object-fit:cover!important;']); ?></div>
            <div class="flex-1 flex flex-col justify-center h-full">
                <h4 class="font-diba text-xl blue-title mb-2 leading-tight"><?php the_title(); ?></h4>
                <div class="text-gray-600 text-xs line-clamp-3 leading-relaxed text-justify"><?php echo get_the_excerpt(); ?></div>
                <div class="read-more">ادامه خبر <i class="fas fa-angle-double-left"></i></div>
            </div>
        </a>
    <?php $response['latest'] .= ob_get_clean(); } }

    // گفت‌وگوی ویژه
    $q3 = new WP_Query(['category_name'=>'interviews', 'posts_per_page'=>8, 'offset' => $side_offset, 'ignore_sticky_posts' => 1]);
    if($q3->have_posts()){ while($q3->have_posts()){ $q3->the_post(); ob_start(); ?>
        <a href="<?php the_permalink(); ?>" class="n-box flex-col md:flex-row">
            <div class="w-20 h-16 flex-shrink-0 relative overflow-hidden rounded"><?php the_post_thumbnail('thumbnail', ['class'=>'rounded w-full h-full object-cover', 'style' => 'object-fit:cover!important;']); ?></div>
            <div class="flex-1 flex flex-col justify-between">
                <div>
                    <h4 class="font-diba blue-title side-title"><?php the_title(); ?></h4>
                    <div class="side-excerpt"><?php echo get_the_excerpt(); ?></div>
                </div>
            </div>
        </a>
    <?php $response['interviews'] .= ob_get_clean(); } }
    
    wp_reset_postdata();
    wp_send_json_success($response);
}

// ==========================================
// 9. AJAX - Load More Mobile
// ==========================================
add_action('wp_ajax_load_more_mobile_action', 'load_more_mobile_callback');
add_action('wp_ajax_nopriv_load_more_mobile_action', 'load_more_mobile_callback');

function load_more_mobile_callback() {
    $page = isset($_POST['page']) ? intval($_POST['page']) : 2;
    $type = isset($_POST['type']) ? sanitize_text_field($_POST['type']) : 'news';
    
    $args = [
        'posts_per_page' => 5,
        'paged'          => $page,
        'post_status'    => 'publish',
    ];
    
    switch ($type) {
        case 'news':
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
            $args['orderby'] = 'meta_value_num';
            $args['order'] = 'DESC';
            $args['meta_key'] = 'views';
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

        case 'latest':
            $args['category_name'] = 'news';
            break;

        default:
            $args['category_name'] = 'news';
            break;
    }

    $query = new WP_Query($args);

    $html = '';

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();

            ob_start();

            $icon_html = '';

            // Video Preview Custom Field
            $video_preview = get_post_meta(get_the_ID(), 'video_preview_url', true);
            $thumb_bg = ($type === 'video' && $video_preview) ? 'bg-black' : '';

            if ($type === 'video') {
                $icon_cls = has_category('video') ? 'fa-play' : 'fa-camera';
                $icon_html = '<div class="absolute inset-0 bg-black/30 flex items-center justify-center text-white"><i class="fas ' . esc_attr($icon_cls) . '"></i></div>';
            }

            if ($type === 'sport') :
                ?>
                <a href="<?php echo esc_url( add_query_arg('theme', 'sport', get_permalink()) ); ?>" class="sport-mobile-row">
                    <div class="sport-mobile-thumb">
                        <?php if ( has_post_thumbnail() ) : ?>
                            <?php the_post_thumbnail('thumbnail', ['class' => 'w-full h-full object-cover', 'style' => 'object-fit:cover!important;']); ?>
                        <?php endif; ?>
                    </div>

                    <div class="sport-mobile-row-content">
                        <h4 class="sport-mobile-row-title"><?php the_title(); ?></h4>

                        <div class="sport-mobile-row-excerpt">
                            <?php echo wp_trim_words(get_the_excerpt(), 18, '...'); ?>
                        </div>

                        <div class="sport-mobile-row-meta">
                            <i class="far fa-clock"></i>
                            <?php echo get_the_date('j F Y'); ?>
                        </div>
                    </div>
                </a>
                <?php
            else :
                ?>
                <a href="<?php the_permalink(); ?>" class="m-news-row">
                    <div class="m-row-thumb relative <?php echo $thumb_bg; ?>">
                        <?php if ($type === 'video' && $video_preview) : ?>
                            <video src="<?php echo esc_url($video_preview); ?>" loop muted playsinline class="w-full h-full object-cover" style="object-fit:cover!important; opacity:0.8;"></video>
                        <?php elseif ( has_post_thumbnail() ) : ?>
                            <?php the_post_thumbnail('thumbnail', ['class' => 'w-full h-full object-cover', 'style' => 'object-fit:cover!important;']); ?>
                        <?php endif; ?>

                        <?php echo $icon_html; ?>
                    </div>

                    <div class="m-row-content">
                        <h4 class="m-row-title"><?php the_title(); ?></h4>

                        <div class="m-row-excerpt">
                            <?php echo wp_trim_words(get_the_excerpt(), 20, '...'); ?>
                        </div>

                        <div class="m-row-meta">
                            <?php if ($type === 'most_viewed') : ?>
                                <span class="text-xs text-blue-600 bg-blue-50 px-2 rounded-full ml-2">
                                    <?php echo $query->current_post + 1 + (($page - 1) * 5); ?>#
                                </span>
                                <i class="far fa-eye ml-1"></i>
                                <span class="live-view-count" data-id="<?php the_ID(); ?>"><?php if(function_exists('get_post_views')) echo get_post_views(get_the_ID()); ?></span>
                            <?php else : ?>
                                <i class="far fa-clock ml-1"></i>
                                <?php echo get_the_date('j F Y'); ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </a>
                <?php
            endif;

            $html .= ob_get_clean();
        }

        wp_reset_postdata();

        wp_send_json_success([
            'html' => $html,
        ]);
    } else {
        wp_send_json_error([
            'message' => 'No more posts',
        ]);
    }
}

// ==========================================
// 10. سطح دسترسی کاربران
// ==========================================
add_action( 'um_registration_complete', 'sharji_assign_custom_role', 10, 2 );
function sharji_assign_custom_role( $user_id, $args ) {
    if ( isset( $args['role_select'] ) ) {
        $selected_role = $args['role_select'];
        $allowed_roles = array( 'um_custom_role_1', 'um_custom_role_2' );
        if ( in_array( $selected_role, $allowed_roles ) ) {
            $user = new WP_User( $user_id );
            $user->remove_role( 'subscriber' ); 
            $user->add_role( $selected_role );
        }
    }
}

add_action( 'admin_init', 'sharji_upgrade_sardabir_role' );
function sharji_upgrade_sardabir_role() {
    $sardabir_role = get_role( 'um_custom_role_3' );
    $wp_editor_role = get_role( 'editor' );
    if ( $sardabir_role && $wp_editor_role ) {
        foreach ( $wp_editor_role->capabilities as $cap => $grant ) {
            if ( $grant ) $sardabir_role->add_cap( $cap );
        }
        $sardabir_role->add_cap( 'manage_categories' );
        $sardabir_role->add_cap( 'edit_theme_options' );
    }
}

add_filter( 'um_access_backend_privileges_roles', 'sharji_allow_sardabir_to_admin', 10, 1 );
function sharji_allow_sardabir_to_admin( $roles ) {
    $roles = (array) $roles;
    if ( !in_array( 'um_custom_role_3', $roles ) ) {
        $roles[] = 'um_custom_role_3'; 
    }
    return $roles;
}

add_action( 'admin_init', 'sharji_prevent_admin_redirect', 1 );
function sharji_prevent_admin_redirect() {
    if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) return;
    if ( is_user_logged_in() ) {
        $user = wp_get_current_user();
        if ( in_array( 'um_custom_role_3', (array) $user->roles ) ) {
            remove_action( 'admin_init', 'default_admin_redirect', 1 );
        }
    }
}

add_filter( 'show_admin_bar', function( $show ) {
    if ( current_user_can( 'um_custom_role_3' ) ) { return true; }
    return $show;
}, 999 );

// ==========================================
// 11. Load Sport Template based on URL
// ==========================================
add_filter('template_include', function($template) {
    if (is_single() && isset($_GET['theme']) && $_GET['theme'] === 'sport') {
        $new_template = locate_template(['single-sport.php']);
        if ($new_template) { return $new_template; }
    }
    return $template;
});

// ==========================================
// 12. Custom Post Types
// ==========================================
function sharji_register_league_cpt() {
    register_post_type('league_team', [
        'labels' => [
            'name' => 'تیم‌های لیگ', 'singular_name' => 'تیم',
            'add_new' => 'افزودن تیم', 'add_new_item' => 'افزودن تیم جدید',
            'edit_item' => 'ویرایش آمار تیم', 'all_items' => 'همه تیم‌ها', 'search_items' => 'جستجوی تیم',
        ],
        'public' => true, 'has_archive' => false,
        'menu_icon' => 'dashicons-shield',
        'supports' => ['title', 'thumbnail'],
        'rewrite' => ['slug' => 'team'],
    ]);
}
add_action('init', 'sharji_register_league_cpt');

function sharji_register_newspaper_cpt() {
    register_post_type('newspaper', [
        'labels' => [
            'name' => 'روزنامه‌ها', 'singular_name' => 'روزنامه',
            'add_new' => 'افزودن جلد', 'add_new_item' => 'افزودن جلد روزنامه',
            'edit_item' => 'ویرایش', 'all_items' => 'همه روزنامه‌ها', 'menu_name' => 'پیشخوان روزنامه'
        ],
        'public' => true, 'menu_icon' => 'dashicons-media-document',
        'menu_position' => 6,
        'supports' => ['title', 'thumbnail', 'page-attributes'],
        'rewrite' => ['slug' => 'newspaper'],
    ]);
}
add_action('init', 'sharji_register_newspaper_cpt');

function sharji_register_fixtures_cpt() {
    register_post_type('fixtures', [
        'labels' => [
            'name' => 'بازی‌های هفته', 'singular_name' => 'بازی',
            'add_new' => 'افزودن بازی', 'add_new_item' => 'افزودن بازی جدید',
            'edit_item' => 'ویرایش بازی', 'all_items' => 'همه بازی‌ها', 'menu_name' => 'بازی‌های هفته'
        ],
        'public' => true, 'menu_position' => 5,
        'menu_icon' => 'dashicons-calendar-alt',
        'supports' => ['title', 'page-attributes'],
    ]);
}
add_action('init', 'sharji_register_fixtures_cpt');

// ==========================================
// 13. Fixtures Meta Box
// ==========================================
function sharji_fixtures_meta_box() {
    add_meta_box('fixtures_details', 'اطلاعات مسابقه', 'sharji_fixtures_callback', 'fixtures', 'normal', 'high');
}
add_action('add_meta_boxes', 'sharji_fixtures_meta_box');

function sharji_fixtures_callback($post) {
    wp_nonce_field('sharji_save_fixtures_action', 'sharji_fixtures_nonce');
    
    $host = get_post_meta($post->ID, '_fixture_host', true);
    $guest = get_post_meta($post->ID, '_fixture_guest', true);
    $time = get_post_meta($post->ID, '_fixture_time', true);
    $date = get_post_meta($post->ID, '_fixture_date', true);
    $status = get_post_meta($post->ID, '_fixture_status', true);
    $link = get_post_meta($post->ID, '_fixture_link', true);
    
    echo '<div style="display:flex; flex-wrap:wrap; gap:20px;">';
    echo '<div style="flex:1; min-width:200px;"><label><strong>تیم میزبان:</strong></label><br><input type="text" name="fixture_host" value="' . esc_attr($host) . '" style="width:100%; margin-top:5px;" placeholder="پرسپولیس"></div>';
    echo '<div style="flex:1; min-width:200px;"><label><strong>تیم میهمان:</strong></label><br><input type="text" name="fixture_guest" value="' . esc_attr($guest) . '" style="width:100%; margin-top:5px;" placeholder="استقلال"></div>';
    echo '<div style="flex:1; min-width:150px;"><label><strong>ساعت بازی:</strong></label><br><input type="text" name="fixture_time" value="' . esc_attr($time) . '" style="width:100%; margin-top:5px;" placeholder="18:30"></div>';
    echo '<div style="flex:1; min-width:150px;"><label><strong>تاریخ/متن:</strong></label><br><input type="text" name="fixture_date" value="' . esc_attr($date) . '" style="width:100%; margin-top:5px;" placeholder="امروز"></div>';
    echo '<div style="flex:1; min-width:250px;"><label><strong>لینک پخش زنده:</strong></label><br><input type="text" name="fixture_link" value="' . esc_attr($link) . '" style="width:100%; margin-top:5px; direction:ltr;" placeholder="https://..."></div>';
    echo '<div style="width:100%; margin-top:15px; border-top:1px solid #eee; padding-top:10px;"><label><strong>وضعیت نمایشی:</strong></label><br><select name="fixture_status" style="width:200px;"><option value="future" ' . selected($status, 'future', false) . '>آینده</option><option value="live" ' . selected($status, 'live', false) . '>زنده</option><option value="end" ' . selected($status, 'end', false) . '>پایان یافته</option></select></div>';
    echo '</div>';
}

// ==========================================
// 14. Comment Callbacks
// ==========================================
function sharji_main_comment_callback($comment, $args, $depth) {
    $GLOBALS['comment'] = $comment;
    ?>
    <li <?php comment_class('mb-6 list-none'); ?> id="comment-<?php comment_ID(); ?>">
        <div class="comment-body bg-white border border-slate-100 p-4 rounded-xl shadow-sm hover:shadow-md transition relative">
            <div class="flex items-start gap-3">
                <div class="flex-shrink-0">
                    <div class="w-10 h-10 rounded-full overflow-hidden border border-slate-200">
                        <?php echo get_avatar($comment, 50, '', 'Avatar', ['class' => 'w-full h-full object-cover']); ?>
                    </div>
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex flex-wrap items-center justify-between mb-2">
                        <div class="flex items-center gap-2">
                            <h5 class="text-sm font-bold text-slate-800"><?php echo get_comment_author(); ?></h5>
                            <?php if ($comment->user_id === get_the_author_meta('ID')) : ?>
                                <span class="text-[10px] bg-blue-100 text-blue-600 px-2 py-0.5 rounded-full">نویسنده</span>
                            <?php endif; ?>
                        </div>
                        <span class="text-[11px] text-slate-400"><?php printf(__('%1$s'), get_comment_date('j F Y')); ?></span>
                    </div>
                    <div class="text-slate-600 text-sm leading-7 text-justify">
                        <?php if ($comment->comment_approved == '0') : ?>
                            <p class="text-orange-500 text-xs bg-orange-50 p-2 rounded mb-2">دیدگاه شما در انتظار تأیید است.</p>
                        <?php endif; ?>
                        <?php comment_text(); ?>
                    </div>
                    <div class="mt-2 text-left">
                        <?php comment_reply_link(array_merge($args, ['depth' => $depth, 'max_depth' => $args['max_depth'], 'reply_text' => '<i class="fas fa-reply text-[10px]"></i> پاسخ', 'class' => 'text-[11px] text-slate-400 hover:text-blue-600 transition inline-flex items-center gap-1'])); ?>
                    </div>
                </div>
            </div>
        </div>
    <?php
}

// ==========================================
// 15. Gamification System
// ==========================================
function get_sharji_user_rank($user_id) {
    $score = (int) get_user_meta($user_id, 'prediction_score', true);
    if ($score >= 100) return ['title' => 'اختاپوس پیش‌گو', 'color' => '#ef4444', 'icon' => 'fa-crow'];
    if ($score >= 50)  return ['title' => 'پروفسور لیگ', 'color' => '#3b82f6', 'icon' => 'fa-graduation-cap'];
    if ($score >= 20)  return ['title' => 'آنالیزور خبره', 'color' => '#10b981', 'icon' => 'fa-chart-line'];
    if ($score >= 5)   return ['title' => 'نیمکت‌نشین', 'color' => '#f59e0b', 'icon' => 'fa-shirt'];
    return ['title' => 'توریست ورزشگاه', 'color' => '#94a3b8', 'icon' => 'fa-ticket-alt'];
}

function show_sharji_user_gamification($user) {
    $score = (int) get_user_meta($user->ID, 'prediction_score', true);
    $rank = get_sharji_user_rank($user->ID);
    ?>
    <h3>آمار ورزشی و گیمیفیکیشن</h3>
    <table class="form-table">
        <tr>
            <th><label for="prediction_score">امتیاز پیش‌بینی</label></th>
            <td>
                <input type="number" name="prediction_score" id="prediction_score" value="<?php echo esc_attr($score); ?>" class="regular-text" />
                <p class="description">لقب فعلی: <strong style="color: <?php echo $rank['color']; ?>;"><?php echo $rank['title']; ?></strong></p>
            </td>
        </tr>
    </table>
    <?php
}
add_action('show_user_profile', 'show_sharji_user_gamification');
add_action('edit_user_profile', 'show_sharji_user_gamification');

function save_sharji_user_gamification($user_id) {
    if (current_user_can('edit_user', $user_id) && isset($_POST['prediction_score'])) {
        update_user_meta($user_id, 'prediction_score', intval($_POST['prediction_score']));
    }
}
add_action('personal_options_update', 'save_sharji_user_gamification');
add_action('edit_user_profile_update', 'save_sharji_user_gamification');

function sharji_sport_comment_callback($comment, $args, $depth) {
    $GLOBALS['comment'] = $comment;
    $user_id = $comment->user_id;
    $rank = $user_id ? get_sharji_user_rank($user_id) : ['title' => 'مهمان', 'color' => '#94a3b8', 'icon' => 'fa-user'];
    ?>
    <li <?php comment_class('mb-6 list-none'); ?> id="comment-<?php comment_ID(); ?>">
        <div class="comment-body bg-[#1e293b] border border-gray-700 p-4 rounded-xl shadow-lg relative hover:border-blue-500/50 transition">
            <div class="flex items-start gap-4">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 rounded-full overflow-hidden border-2 border-gray-600 shadow-md">
                        <?php echo get_avatar($comment, 60, '', 'Avatar', ['class' => 'w-full h-full object-cover']); ?>
                    </div>
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex flex-wrap items-center justify-between mb-2">
                        <div class="flex items-center gap-2">
                            <h5 class="text-sm font-bold text-white"><?php echo get_comment_author(); ?></h5>
                            <span class="text-[10px] px-2 py-0.5 rounded bg-[#0f172a] border border-gray-700 flex items-center gap-1 shadow-inner" style="color: <?php echo $rank['color']; ?>;">
                                <i class="fas <?php echo $rank['icon']; ?>"></i> <?php echo $rank['title']; ?>
                            </span>
                        </div>
                        <span class="text-[11px] text-gray-500"><?php printf(__('%1$s'), get_comment_date('j F Y')); ?></span>
                    </div>
                    <div class="text-gray-300 text-sm leading-7 text-justify">
                        <?php if ($comment->comment_approved == '0') : ?>
                            <p class="text-yellow-400 text-xs bg-yellow-900/20 p-2 rounded mb-2 border border-yellow-500/20">دیدگاه شما در انتظار تأیید است.</p>
                        <?php endif; ?>
                        <?php comment_text(); ?>
                    </div>
                    <div class="mt-3 text-left">
                        <?php comment_reply_link(array_merge($args, ['depth' => $depth, 'max_depth' => $args['max_depth'], 'reply_text' => '<i class="fas fa-reply text-[10px]"></i> پاسخ', 'class' => 'text-[11px] text-blue-400 hover:text-white bg-[#0f172a] px-3 py-1 rounded border border-gray-700 transition inline-flex items-center gap-1'])); ?>
                    </div>
                </div>
            </div>
        </div>
    <?php
}

// ==========================================
// 16. Excerpt Meta Box
// ==========================================
function move_excerpt_after_title() {
    remove_meta_box('postexcerpt', 'post', 'normal');
    add_action('edit_form_after_title', 'render_custom_excerpt_box');
}
add_action('add_meta_boxes', 'move_excerpt_after_title');

function render_custom_excerpt_box($post) {
    if (!post_type_supports($post->post_type, 'excerpt')) return;
    ?>
    <div style="margin-top: 20px; margin-bottom: 20px;">
        <label for="excerpt" style="font-weight: bold; font-size: 14px; margin-bottom: 5px; display: block;">چکیده (خلاصه متن):</label>
        <textarea name="excerpt" id="excerpt" style="width: 100%; height: 80px; padding: 10px;" placeholder="چکیده مطلب را اینجا بنویسید..."><?php echo esc_textarea($post->post_excerpt); ?></textarea>
        <p style="font-size: 12px; color: #666; margin-top: 5px;">چکیده‌ها، خلاصه‌ای اختیاری از نوشته شما هستند.</p>
    </div>
    <?php
}

// ==========================================
// 17. Sport Sidebars
// ==========================================
function sharji_register_sport_sidebar() {
    register_sidebar( array(
        'name' => 'سایدبار اختصاصی ورزشی', 'id' => 'sport-sidebar',
        'before_widget' => '<div id="%1$s" class="bg-[#1e293b] rounded-xl border border-gray-700/50 overflow-hidden shadow-xl mb-4 widget %2$s">',
        'after_widget' => '</div></div>',
        'before_title' => '<div class="flex border-b border-gray-700 bg-[#161f2f]"><span class="flex-1 py-3 text-sm font-bold text-white border-b-2 border-blue-500 bg-gray-800/50 px-4">',
        'after_title' => '</span></div><div class="p-4">',
    ));
}
add_action( 'widgets_init', 'sharji_register_sport_sidebar' );

function sharji_register_sport_ad_sidebar() {
    register_sidebar( array(
        'name' => 'تبلیغات سایدبار ورزشی', 'id' => 'sport-ad-sidebar',
        'before_widget' => '<div id="%1$s" class="bg-gradient-to-r from-blue-900 to-blue-800 rounded-xl overflow-hidden shadow-xl mb-4 border border-blue-700/30 widget %2$s">',
        'after_widget' => '</div>',
    ));
}
add_action( 'widgets_init', 'sharji_register_sport_ad_sidebar' );

// ==========================================
// 18. Global Local Fonts Enqueue (Fixes Single Page Fonts & Speed)
// ==========================================
add_action('wp_head', 'sharji_inject_global_fonts_and_styles', 1);
function sharji_inject_global_fonts_and_styles() {
    ?>
    <style>
        @font-face { 
            font-family: 'Diba'; 
            src: url('<?php echo get_template_directory_uri(); ?>/fonts/Diba.woff2') format('woff2'); 
            font-weight: bold; font-style: normal; font-display: swap;
        }
        @font-face { 
            font-family: 'Vazirmatn'; 
            src: url('<?php echo get_template_directory_uri(); ?>/fonts/Vazirmatn.woff2') format('woff2'); 
            font-weight: normal; font-style: normal; font-display: swap;
        }
        @font-face { 
            font-family: 'Vazirmatn'; 
            src: url('<?php echo get_template_directory_uri(); ?>/fonts/Vazirmatn-Bold.woff2') format('woff2'); 
            font-weight: bold; font-style: normal; font-display: swap;
        }
        /* اعمال سراسری فونت برای رفع کامل مشکل ناوبری سایدبار و هدر صفحات داخلی */
        body, html, header, nav, .menu-item, a, p, span, div {
            font-family: 'Vazirmatn', sans-serif;
        }
    </style>
    <?php
}

// ==========================================
// 19. Custom Avatar Override for Admins
// ==========================================
add_action('show_user_profile', 'sharji_admin_avatar_field');
add_action('edit_user_profile', 'sharji_admin_avatar_field');

function sharji_admin_avatar_field($user) {
    if (!current_user_can('manage_options')) {
        return;
    }
    
    $custom_avatar = get_user_meta($user->ID, 'sharji_override_avatar', true);
    ?>
    <h3>تنظیمات آواتار اختصاصی (فقط مدیران)</h3>
    <table class="form-table">
        <tr>
            <th><label for="sharji_override_avatar">لینک مستقیم تصویر</label></th>
            <td>
                <?php if (!empty($custom_avatar)) : ?>
                    <div style="margin-bottom: 15px;">
                        <img src="<?php echo esc_url($custom_avatar); ?>" style="width: 80px; height: 80px; border-radius: 50%; object-fit: cover; border: 3px solid #e2e8f0;" alt="Current Avatar">
                    </div>
                <?php endif; ?>
                <input type="url" name="sharji_override_avatar" id="sharji_override_avatar" value="<?php echo esc_url($custom_avatar); ?>" class="regular-text ltr" placeholder="https://...">
                <p class="description">برای تغییر تصویر این کاربر, عکس را در رسانه آپلود کرده و لینک مستقیم آن را اینجا قرار دهید.</p>
            </td>
        </tr>
    </table>
    <?php
}

add_action('personal_options_update', 'sharji_save_admin_avatar_field');
add_action('edit_user_profile_update', 'sharji_save_admin_avatar_field');

function sharji_save_admin_avatar_field($user_id) {
    if (!current_user_can('manage_options')) {
        return false;
    }

    if (isset($_POST['sharji_override_avatar'])) {
        update_user_meta($user_id, 'sharji_override_avatar', esc_url_raw($_POST['sharji_override_avatar']));
    }
}

add_filter('get_avatar_url', 'sharji_use_admin_avatar_url', 10, 3);
function sharji_use_admin_avatar_url($url, $id_or_email, $args) {
    $user_id = 0;

    if (is_numeric($id_or_email)) {
        $user_id = (int) $id_or_email;
    } elseif (is_string($id_or_email) && ($user = get_user_by('email', $id_or_email))) {
        $user_id = $user->ID;
    } elseif (is_object($id_or_email) && !empty($id_or_email->user_id)) {
        $user_id = (int) $id_or_email->user_id;
    }

    if ($user_id) {
        $custom_avatar = get_user_meta($user_id, 'sharji_override_avatar', true);
        if (!empty($custom_avatar)) {
            return esc_url($custom_avatar);
        }
    }

    return $url;
}

// ==========================================
// 20. Frontend Form: Register Fields & Save Logic
// ==========================================
if( function_exists('acf_add_local_field_group') ):

    if ( ! is_admin() ) {
        acf_add_local_field_group(array(
            'key' => 'group_sharji_frontend_news',
            'title' => 'Frontend News Meta',
            'fields' => array(
                array(
                    'key' => 'field_front_image',
                    'label' => 'تصویر شاخص',
                    'name' => 'frontend_image',
                    'type' => 'image',
                    'return_format' => 'id',
                    'preview_size' => 'medium',
                    'library' => 'all',
                ),
                array(
                    'key' => 'field_front_excerpt',
                    'label' => 'چکیده خبر',
                    'name' => 'frontend_excerpt',
                    'type' => 'textarea',
                    'rows' => 3,
                ),
                array(
                    'key' => 'field_front_video_preview',
                    'label' => 'لینک پیش‌نمایش ویدئو',
                    'name' => 'video_preview_url',
                    'type' => 'url',
                    'instructions' => 'لینک مستقیم ویدئو (MP4)',
                ),
                array(
                    'key' => 'field_front_cats',
                    'label' => 'دسته‌بندی‌ها',
                    'name' => 'frontend_categories',
                    'type' => 'taxonomy',
                    'taxonomy' => 'category',
                    'field_type' => 'checkbox',
                    'save_terms' => 1,
                    'load_terms' => 1,
                    'return_format' => 'id',
                ),
                array(
                    'key' => 'field_front_tags',
                    'label' => 'برچسب‌ها',
                    'name' => 'frontend_tags',
                    'type' => 'taxonomy',
                    'taxonomy' => 'post_tag',
                    'field_type' => 'multi_select',
                    'save_terms' => 1,
                    'load_terms' => 1,
                    'return_format' => 'id',
                ),
                array(
                    'key' => 'field_front_status',
                    'label' => 'وضعیت انتشار',
                    'name' => 'frontend_status',
                    'type' => 'select',
                    'choices' => array(
                        'draft' => 'پیش‌نویس (نیاز به تایید)',
                        'publish' => 'انتشار فوری',
                    ),
                    'default_value' => 'draft',
                ),
            ),
            'location' => array(
                array(
                    array('param' => 'post_type', 'operator' => '==', 'value' => 'post'),
                ),
            ),
            'active' => true,
        ));
    } 
    else {
        acf_add_local_field_group(array(
            'key' => 'group_sharji_admin_video',
            'title' => 'تنظیمات ویدئو خبر',
            'fields' => array(
                array(
                    'key' => 'field_admin_video_preview',
                    'label' => 'لینک پیش‌نمایش ویدئو',
                    'name' => 'video_preview_url',
                    'type' => 'url',
                    'instructions' => 'لینک مستقیم ویدئو (MP4)',
                ),
            ),
            'location' => array(
                array(
                    array('param' => 'post_type', 'operator' => '==', 'value' => 'post'),
                ),
            ),
            'active' => true,
        ));
    }

endif;

add_action('acf/save_post', 'sharji_map_frontend_submission', 20);
function sharji_map_frontend_submission($post_id) {
    if (is_admin()) return;

    $post_data = array('ID' => $post_id);
    $update_needed = false;

    $excerpt = get_field('frontend_excerpt', $post_id);
    $status = get_field('frontend_status', $post_id);
    $image_id = get_field('frontend_image', $post_id);

    if (!empty($excerpt)) { $post_data['post_excerpt'] = $excerpt; $update_needed = true; }
    if (!empty($status)) { $post_data['post_status'] = $status; $update_needed = true; }

    if ($update_needed) { wp_update_post($post_data); }
    if (!empty($image_id)) { set_post_thumbnail($post_id, $image_id); }
}

// ==========================================
// 21. Dual Corner Promotional Popups (ACF Workaround)
// ==========================================
add_action('init', 'sharji_ensure_popup_container_exists');
function sharji_ensure_popup_container_exists() {
    if ( ! get_page_by_path('popup-settings') ) {
        wp_insert_post(array(
            'post_title'  => 'تنظیمات پاپ‌آپ',
            'post_name'   => 'popup-settings',
            'post_status' => 'publish',
            'post_type'   => 'page',
        ));
    }
}

add_action('admin_menu', 'sharji_popup_sidebar_menu');
function sharji_popup_sidebar_menu() {
    $popup_page = get_page_by_path('popup-settings');
    if ( $popup_page ) {
        add_menu_page('تنظیمات پاپ‌آپ', 'تنظیمات پاپ‌آپ', 'edit_posts', 'post.php?post=' . $popup_page->ID . '&action=edit', '', 'dashicons-images-alt2', 60);
    }
}

add_action('acf/init', 'sharji_register_popup_fields');
function sharji_register_popup_fields() {
    $popup_page = get_page_by_path('popup-settings');
    $page_id = $popup_page ? $popup_page->ID : 0;

    if( function_exists('acf_add_local_field_group') ):
    acf_add_local_field_group(array(
        'key' => 'group_sharji_bottom_popup',
        'title' => 'تنظیمات پاپ‌آپ‌های گوشه‌ای صفحه اصلی',
        'fields' => array(
            // --- RIGHT POPUP ---
            array(
                'key' => 'field_popup_right_tab',
                'label' => 'پاپ‌آپ سمت راست',
                'type' => 'tab',
            ),
            array(
                'key' => 'field_popup_status_right',
                'label' => 'وضعیت پاپ‌آپ راست',
                'name' => 'enable_right_popup',
                'type' => 'true_false',
                'ui' => 1,
            ),
            array(
                'key' => 'field_popup_image_right',
                'label' => 'تصویر بنر راست',
                'name' => 'right_popup_image',
                'type' => 'image',
                'conditional_logic' => array(array(array('field' => 'field_popup_status_right', 'operator' => '==', 'value' => '1'))),
                'return_format' => 'id',
                'preview_size' => 'medium',
            ),
            array(
                'key' => 'field_popup_url_right',
                'label' => 'لینک ارجاع راست',
                'name' => 'right_popup_link',
                'type' => 'url',
                'conditional_logic' => array(array(array('field' => 'field_popup_status_right', 'operator' => '==', 'value' => '1'))),
            ),
            // --- LEFT POPUP ---
            array(
                'key' => 'field_popup_left_tab',
                'label' => 'پاپ‌آپ سمت چپ',
                'type' => 'tab',
            ),
            array(
                'key' => 'field_popup_status_left',
                'label' => 'وضعیت پاپ‌آپ چپ',
                'name' => 'enable_left_popup',
                'type' => 'true_false',
                'ui' => 1,
            ),
            array(
                'key' => 'field_popup_image_left',
                'label' => 'تصویر بنر چپ',
                'name' => 'left_popup_image',
                'type' => 'image',
                'conditional_logic' => array(array(array('field' => 'field_popup_status_left', 'operator' => '==', 'value' => '1'))),
                'return_format' => 'id',
                'preview_size' => 'medium',
            ),
            array(
                'key' => 'field_popup_url_left',
                'label' => 'لینک ارجاع چپ',
                'name' => 'left_popup_link',
                'type' => 'url',
                'conditional_logic' => array(array(array('field' => 'field_popup_status_left', 'operator' => '==', 'value' => '1'))),
            ),
        ),
        'location' => array(array(array('param' => 'page', 'operator' => '==', 'value' => $page_id))),
    ));
    endif;
}