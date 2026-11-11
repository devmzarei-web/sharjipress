<?php
/**
 * Sharji Theme Functions - STABLE BACKUP
 */

// 1. Basic Setup
function sharji_setup() {
    add_theme_support('post-thumbnails');
    add_theme_support('title-tag');
    register_nav_menus( array( 'main-menu' => 'Main Menu' ) );
}
add_action('after_setup_theme', 'sharji_setup');

// 2. Uploads & URLs
add_filter( 'wp_lazy_loading_enabled', '__return_false' );
update_option( 'upload_url_path', 'http://mohammadalizarei.ir/wp-content/uploads' );
add_filter( 'wp_get_attachment_url', function( $url ) {
    if ( is_ssl() ) { $url = str_replace( 'http://', 'https://', $url ); }
    return $url;
});

// 3. Assets
function sharji_scripts() {
    // Load Font Awesome (Icons)
    wp_enqueue_style('font-awesome-5', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css');
    // Load Tailwind (CSS Framework)
    wp_enqueue_script('tailwind-cdn', 'https://cdn.tailwindcss.com', array(), null, false);
}
add_action('wp_enqueue_scripts', 'sharji_scripts');

// 4. Widgets
add_action( 'widgets_init', function() {
    register_sidebar( array(
        'name' => 'سایدبار صفحه خبر ۱', 
        'id' => 'single-sidebar',
        'before_widget' => '<div class="widget-wrapper mb-6 bg-white border border-slate-200 rounded-xl overflow-hidden shadow-sm">', 
        'after_widget' => '</div>',
        'before_title' => '<div class="bg-slate-800 text-white p-4 yekan-bold text-xs">', 
        'after_title' => '</div>',
    ));

    register_sidebar( array(
        'name' => 'سایدبار صفحه خبر ۲', 
        'id' => 'single-sidebar-2',
        'before_widget' => '<div class="widget-wrapper mb-6 bg-white border border-slate-200 rounded-xl overflow-hidden shadow-sm">', 
        'after_widget' => '</div>',
        'before_title' => '<div class="bg-slate-800 text-white p-4 yekan-bold text-xs">', 
        'after_title' => '</div>',
    ));

    register_sidebar( array( 'name' => 'تبلیغات تک نوشته', 'id' => 'ads-single', 'before_widget' => '<div class="single-ad-container">', 'after_widget' => '</div>' ) );
    register_sidebar( array( 'name' => 'تبلیغات سرویس ویدئو', 'id' => 'ads-video-sidebar', 'before_widget' => '', 'after_widget' => '' ) );
    register_sidebar( array( 'name' => 'تبلیغات سرویس تصویر', 'id' => 'ads-image-sidebar', 'before_widget' => '', 'after_widget' => '' ) );
    register_sidebar( array( 'name' => 'تبلیغات هدر راست', 'id' => 'header_ad_right', 'before_widget' => '<div class="header_ad_item">', 'after_widget' => '</div>' ) );
    register_sidebar( array( 'name' => 'تبلیغات هدر چپ', 'id' => 'header_ad_left', 'before_widget' => '<div class="header_ad_item">', 'after_widget' => '</div>' ) );
});

// 5. Helper Functions & Views
function set_post_views($postID) {
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        $count = 0;
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
    }else{
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
}
add_action( 'wp_head', function() {
    if ( is_single() ) {
        set_post_views( get_the_ID() );
    }
});

function get_post_views($postID){
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count == ''){
        if (function_exists('pvc_get_post_views')) {
            return pvc_get_post_views($postID);
        }
        $count = get_post_meta($postID, 'post_views', true);
        if($count == ''){
            $count = get_post_meta($postID, 'views', true); 
            if($count == '') {
                delete_post_meta($postID, $count_key);
                add_post_meta($postID, $count_key, '0');
                return "0";
            }
        }
    }
    return $count;
}

add_filter('http_request_timeout', function($timeout) { return 30; });
require_once get_template_directory() . '/prayer-times.php';

// 6. Lazy Load Fix
function add_lazy_loading_attribute($content) {
    return str_replace('<img', '<img loading="lazy"', $content);
}
add_filter('the_content', 'add_lazy_loading_attribute');
add_filter('post_thumbnail_html', 'add_lazy_loading_attribute');

// 7. Cache Handling
function clear_redis_cache_on_save( $post_id ) {
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
    wp_cache_delete( 'related_posts_' . $post_id, 'single_page' );
    wp_cache_delete( 'editor_picks_sidebar', 'sidebar' );
}
add_action( 'save_post', 'clear_redis_cache_on_save' );
add_action( 'deleted_post', 'clear_redis_cache_on_save' );

// 8. Desktop AJAX Load More
add_action('wp_ajax_load_more_home_action', 'load_more_home_callback');
add_action('wp_ajax_nopriv_load_more_home_action', 'load_more_home_callback');

function load_more_home_callback() {
    $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
    $side_offset = 8 + (($page - 1) * 5);
    $special_offset = 6 + (($page - 1) * 3);
    $response = ['most_viewed' => '', 'special' => '', 'videos' => ''];

    // 1. Most Viewed
    $args_mv = [
        'posts_per_page' => 5, 
        'offset' => $side_offset,
        'suppress_filters' => false,
        'orderby' => 'meta_value_num',
        'meta_key' => 'post_views_count',
        'order' => 'DESC'
    ];
    $q1 = new WP_Query($args_mv);

    // Fallbacks
    if(!$q1->have_posts()) {
        $args_mv['orderby'] = 'post_views';
        unset($args_mv['meta_key']);
        $q1 = new WP_Query($args_mv);
    }
    if(!$q1->have_posts()) {
        $args_mv['orderby'] = 'meta_value_num';
        $args_mv['meta_key'] = 'views'; 
        $q1 = new WP_Query($args_mv);
    }
    if(!$q1->have_posts()) {
        unset($args_mv['meta_key']);
        unset($args_mv['orderby']);
        $q1 = new WP_Query($args_mv);
    }
    
    if($q1->have_posts()){
        while($q1->have_posts()){ $q1->the_post(); ob_start(); ?>
            <a href="<?php the_permalink(); ?>" class="n-box">
                <div class="w-20 h-16 flex-shrink-0 overflow-hidden rounded"><?php the_post_thumbnail('thumbnail', ['class'=>'rounded object-cover w-full h-full']); ?></div>
                <div class="flex-1">
                    <h4 class="font-diba blue-title side-title"><?php the_title(); ?></h4>
                    <div class="side-excerpt"><?php echo get_the_excerpt(); ?></div>
                    <div class="view-badge"><i class="fas fa-eye text-xs"></i> <?php if(function_exists('get_post_views')) echo get_post_views(get_the_ID()); ?></div>
                </div>
            </a>
        <?php $response['most_viewed'] .= ob_get_clean(); }
    }

    // 2. Special News
    $q2 = new WP_Query(['category_name'=>'inews', 'posts_per_page'=>3, 'offset' => $special_offset]);
    if($q2->have_posts()){
        while($q2->have_posts()){ $q2->the_post(); ob_start(); ?>
            <a href="<?php the_permalink(); ?>" class="special-row">
                <div class="w-[180px] h-[120px] overflow-hidden rounded flex-shrink-0"><?php the_post_thumbnail('large', ['class'=>'w-full h-full object-cover']); ?></div>
                <div class="flex-1 flex flex-col justify-center h-full">
                    <h4 class="font-diba text-xl blue-title mb-2 leading-tight"><?php the_title(); ?></h4>
                    <div class="text-gray-600 text-xs line-clamp-3 leading-relaxed text-justify"><?php echo get_the_excerpt(); ?></div>
                    <div class="read-more">ادامه خبر <i class="fas fa-angle-double-left"></i></div>
                </div>
            </a>
        <?php $response['special'] .= ob_get_clean(); }
    }

    // 3. Latest News
    $q3 = new WP_Query(['posts_per_page'=>5, 'offset' => $side_offset]);
    if($q3->have_posts()){
        while($q3->have_posts()){ $q3->the_post(); ob_start(); ?>
            <a href="<?php the_permalink(); ?>" class="n-box">
                <div class="w-20 h-16 flex-shrink-0 relative overflow-hidden rounded">
                    <?php the_post_thumbnail('thumbnail', ['class'=>'rounded w-full h-full object-cover']); ?>
                </div>
                <div class="flex-1">
                    <h4 class="font-diba blue-title side-title"><?php the_title(); ?></h4>
                    <div class="side-excerpt"><?php echo get_the_excerpt(); ?></div>
                    <span class="view-badge"><i class="far fa-clock"></i> <?php echo get_the_time('H:i'); ?></span>
                </div>
            </a>
        <?php $response['videos'] .= ob_get_clean(); }
    }
    wp_reset_postdata();
    wp_send_json_success($response);
}

// 9. Mobile AJAX Load More
add_action('wp_ajax_load_more_mobile_action', 'load_more_mobile_callback');
add_action('wp_ajax_nopriv_load_more_mobile_action', 'load_more_mobile_callback');

function load_more_mobile_callback() {
    $page = isset($_POST['page']) ? intval($_POST['page']) : 2;
    $type = isset($_POST['type']) ? sanitize_text_field($_POST['type']) : 'inews';
    
    $args = ['posts_per_page' => 5, 'paged' => $page, 'post_status' => 'publish'];

    switch ($type) {
        case 'inews': $args['category_name'] = 'inews'; break;
        case 'tahlil': 
            $args['tax_query'] = [ 'relation' => 'OR', ['taxonomy'=>'category', 'field'=>'slug', 'terms'=>'tahlil'], ['taxonomy'=>'post_tag', 'field'=>'slug', 'terms'=>'tahlil'] ];
            break;
        case 'most_viewed': 
            $args['suppress_filters'] = false;
            $args['orderby'] = 'meta_value_num';
            $args['meta_key'] = 'post_views_count';
            $args['order'] = 'DESC';
            break;
        case 'video':
            $args['category_name'] = 'multimedia'; 
            break;
        case 'latest': break;
        default: $args['category_name'] = 'inews'; break;
    }

    $query = new WP_Query($args);
    if($type === 'most_viewed' && !$query->have_posts()) {
        $args['orderby'] = 'meta_value_num';
        $args['meta_key'] = 'views';
        $query = new WP_Query($args);
    }

    $html = '';
    if($query->have_posts()){
        while($query->have_posts()){ $query->the_post(); ob_start(); 
            $icon_html = '';
            if($type === 'video') {
                $icon_cls = (has_category('video')) ? 'fa-play' : 'fa-camera';
                $icon_html = '<div class="absolute inset-0 bg-black/30 flex items-center justify-center text-white"><i class="fas '.$icon_cls.'"></i></div>';
            }
            ?>
            <a href="<?php the_permalink(); ?>" class="m-news-row">
                <div class="m-row-thumb relative">
                    <?php the_post_thumbnail('thumbnail', ['class'=>'w-full h-full object-cover']); ?>
                    <?php echo $icon_html; ?>
                </div>
                <div class="m-row-content">
                    <h4 class="m-row-title"><?php the_title(); ?></h4>
                    <div class="m-row-excerpt"><?php echo wp_trim_words(get_the_excerpt(), 20, '...'); ?></div>
                    <div class="m-row-meta">
                        <?php if($type === 'most_viewed'): ?>
                            <span class="text-xs text-blue-600 bg-blue-50 px-2 rounded-full ml-2"><?php echo $query->current_post + 1 + (($page-1)*5); ?>#</span>
                            <i class="far fa-eye ml-1"></i> <?php if(function_exists('get_post_views')) echo get_post_views(get_the_ID()); ?>
                        <?php else: ?>
                            <i class="far fa-clock ml-1"></i> <?php echo get_the_date('j F Y'); ?>
                        <?php endif; ?>
                    </div>
                </div>
            </a>
        <?php $html .= ob_get_clean(); }
        wp_reset_postdata();
        wp_send_json_success(['html' => $html]);
    } else {
        wp_send_json_error(['message' => 'No more posts']);
    }
}

// 10. ASSIGN ROLE FROM REGISTRATION DROPDOWN
add_action( 'um_registration_complete', 'sharji_assign_custom_role', 10, 2 );
function sharji_assign_custom_role( $user_id, $args ) {
    
    // Check if the user selected a value in 'role_select'
    if ( isset( $args['role_select'] ) ) {
        $selected_role = $args['role_select'];

        // SECURITY: Whitelist Allowed Roles
        $allowed_roles = array( 
            'um_custom_role_1', // خبرنگار
            'um_custom_role_2', // بیننده
        );

        if ( in_array( $selected_role, $allowed_roles ) ) {
            $user = new WP_User( $user_id );
            // Remove default role (usually 'subscriber')
            $user->remove_role( 'subscriber' ); 
            // Add the selected role
            $user->add_role( $selected_role );
        }
    }
}
?>