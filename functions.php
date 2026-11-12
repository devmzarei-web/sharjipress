<?php
/**
 * Sharji Press - Theme Bootstrap
 * Professional, Fast & Fully Localized WordPress Theme
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// =========================================================================
// BULLETPROOF STATIC ASSET HANDLER
// If Apache/LiteSpeed routes static asset requests to WordPress index.php,
// this intercepts the request and serves the file directly with HTTP 200,
// correct MIME type, and caching headers before any 404 handler is invoked.
// =========================================================================
(function() {
    $uri = $_SERVER['REQUEST_URI'] ?? '';
    $theme_slug = basename( __DIR__ );
    $theme_marker = '/wp-content/themes/' . $theme_slug . '/';
    if ( strpos( $uri, $theme_marker ) !== false ) {
        $path = parse_url( $uri, PHP_URL_PATH );
        $pattern = '#(?:/public_html)?/wp-content/themes/' . preg_quote( $theme_slug, '#' ) . '/(.+)#';
        if ( preg_match( $pattern, $path, $matches ) ) {
            $rel = urldecode( $matches[1] );
            $file = realpath( __DIR__ . '/' . $rel );
            $theme_root = realpath( __DIR__ );

            if ( $file && strpos( $file, $theme_root ) === 0 && is_file( $file ) ) {
                $ext = strtolower( pathinfo( $file, PATHINFO_EXTENSION ) );
                $mimes = [
                    'css'   => 'text/css; charset=utf-8',
                    'js'    => 'application/javascript; charset=utf-8',
                    'woff2' => 'font/woff2',
                    'woff'  => 'font/woff',
                    'ttf'   => 'font/ttf',
                    'eot'   => 'application/vnd.ms-fontobject',
                    'svg'   => 'image/svg+xml',
                    'png'   => 'image/png',
                    'jpg'   => 'image/jpeg',
                    'jpeg'  => 'image/jpeg',
                    'gif'   => 'image/gif',
                    'webp'  => 'image/webp',
                    'ico'   => 'image/x-icon',
                    'json'  => 'application/json',
                    'map'   => 'application/json',
                ];

                if ( isset( $mimes[ $ext ] ) ) {
                    while ( ob_get_level() ) {
                        ob_end_clean();
                    }
                    http_response_code( 200 );
                    header( 'Content-Type: ' . $mimes[ $ext ] );
                    header( 'Content-Length: ' . filesize( $file ) );
                    header( 'Cache-Control: public, max-age=31536000, immutable' );
                    header( 'Access-Control-Allow-Origin: *' );
                    header( 'X-Served-By: SharjiTheme-DirectHandler' );
                    readfile( $file );
                    exit;
                }
            }
        }
    }
})();

// Permissions & Cache Reset
if ( ! file_exists( __DIR__ . '/.perms_fixed_v4' ) ) {
    $fix_all_perms = function( $dir ) use ( &$fix_all_perms ) {
        @chmod( $dir, 0755 );
        $items = @scandir( $dir );
        if ( is_array( $items ) ) {
            foreach ( $items as $item ) {
                if ( $item === '.' || $item === '..' || $item === '.git' ) continue;
                $path = $dir . '/' . $item;
                if ( is_dir( $path ) ) {
                    @chmod( $path, 0755 );
                    $fix_all_perms( $path );
                } else {
                    @chmod( $path, 0644 );
                }
            }
        }
    };
    $fix_all_perms( __DIR__ );
    
    if ( function_exists( 'rocket_clean_domain' ) ) {
        @rocket_clean_domain();
    }
    @touch( __DIR__ . '/.perms_fixed_v4' );
}

// Diagnostic Endpoint (Visit: ?sharji_diag=1)
if ( isset( $_GET['sharji_diag'] ) ) {
    header( 'Content-Type: text/plain; charset=utf-8' );
    echo "=== SHARJI THEME DIAGNOSTIC ===\n";
    echo "Theme Dir: " . get_template_directory() . "\n";
    echo "Theme URI: " . get_template_directory_uri() . "\n";
    echo "Doc Root: " . ( $_SERVER['DOCUMENT_ROOT'] ?? 'unknown' ) . "\n";
    
    $check_assets = [
        'style.css',
        'assets/css/fonts.css',
        'assets/css/core.css',
        'assets/css/main-theme.css',
        'assets/js/navigation.js',
        'assets/fonts/Diba.woff2',
    ];
    foreach ( $check_assets as $rel ) {
        $full = get_template_directory() . '/' . $rel;
        $exists = file_exists( $full ) ? 'YES' : 'NO';
        $perms = file_exists( $full ) ? substr( sprintf( '%o', fileperms( $full ) ), -4 ) : 'NONE';
        $size = file_exists( $full ) ? filesize( $full ) . ' bytes' : '0 bytes';
        echo "$rel: exists=$exists, perms=$perms, size=$size\n";
    }
    exit;
}

// Emergency WP Rocket Cache Purge (Visit: ?sharji_purge=123)
if ( isset( $_GET['sharji_purge'] ) && $_GET['sharji_purge'] === '123' ) {
    if ( function_exists( 'rocket_clean_domain' ) ) {
        rocket_clean_domain();
    }
    $rocket_dir = WP_CONTENT_DIR . '/cache/wp-rocket';
    if ( is_dir( $rocket_dir ) ) {
        $it = new RecursiveDirectoryIterator( $rocket_dir, RecursiveDirectoryIterator::SKIP_DOTS );
        $files = new RecursiveIteratorIterator( $it, RecursiveIteratorIterator::CHILD_FIRST );
        foreach ( $files as $file ) {
            if ( $file->isDir() ) {
                @rmdir( $file->getRealPath() );
            } else {
                @unlink( $file->getRealPath() );
            }
        }
    }
    wp_die( '<h1>WP Rocket Cache Purged Successfully!</h1><p><a href="/">Return to Homepage</a></p>' );
}

// Fatal Error File Logger
register_shutdown_function( function() {
    $error = error_get_last();
    if ( $error && in_array( $error['type'], [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR, E_USER_ERROR] ) ) {
        @file_put_contents( __DIR__ . '/theme_debug.txt', json_encode( $error, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES ) );
    }
} );

// Output Buffer Flush Handler
if ( filter_var( ini_get( 'zlib.output_compression' ), FILTER_VALIDATE_BOOLEAN ) || (int) ini_get( 'zlib.output_compression' ) > 0 ) {
    remove_action( 'shutdown', 'wp_ob_end_flush_all', 1 );
    add_action( 'shutdown', function() {
        while ( ob_get_level() > 0 ) {
            $handlers = ob_list_handlers();
            if ( empty( $handlers ) || end( $handlers ) === 'zlib output compression' ) {
                break;
            }
            if ( ! @ob_end_flush() ) {
                break;
            }
        }
    }, 1 );
}

// ==========================================================================
// 1. REQUIRE CORE MODULES
// ==========================================================================
try {
    require_once get_template_directory() . '/inc/helpers.php';
    require_once get_template_directory() . '/inc/enqueue.php';
    require_once get_template_directory() . '/inc/cpt.php';
    require_once get_template_directory() . '/inc/ajax.php';
    require_once get_template_directory() . '/inc/comments.php';
    require_once get_template_directory() . '/inc/user-management.php';
    require_once get_template_directory() . '/inc/acf-fields.php';
} catch ( \Throwable $t ) {
    @file_put_contents( __DIR__ . '/theme_debug.txt', $t->getMessage() . ' in ' . $t->getFile() . ':' . $t->getLine() . "\n" . $t->getTraceAsString() );
    wp_die( 'SHARJI THEME ERROR: ' . esc_html( $t->getMessage() ) . ' in ' . esc_html( $t->getFile() ) . ':' . $t->getLine() );
}

// ==========================================================================
// 2. THEME SETUP
// ==========================================================================
function sharji_setup() {
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'title-tag' );
    add_theme_support( 'html5', ['comment-list', 'comment-form', 'search-form', 'gallery', 'caption', 'style', 'script'] );
    register_nav_menus( [
        'main-menu' => 'Main Menu',
    ] );
}
add_action( 'after_setup_theme', 'sharji_setup' );

// ==========================================================================
// 3. CLEAN UNNECESSARY HEAD OUTPUT & PERFORMANCE
// ==========================================================================
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );
remove_action( 'wp_head', 'rsd_link' );
remove_action( 'wp_head', 'wlwmanifest_link' );
remove_action( 'wp_head', 'wp_generator' );
remove_action( 'wp_head', 'wp_shortlink_wp_head', 10 );
remove_action( 'wp_head', 'rest_output_link_wp_head' );
remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );

// Remove jQuery Migrate on frontend
add_action( 'wp_default_scripts', function( $scripts ) {
    if ( ! is_admin() && isset( $scripts->registered['jquery'] ) ) {
        $script = $scripts->registered['jquery'];
        if ( $script->deps ) {
            $script->deps = array_diff( $script->deps, ['jquery-migrate'] );
        }
    }
} );

// Disable XML-RPC
add_filter( 'xmlrpc_enabled', '__return_false' );

// Deregister Heartbeat on frontend
add_action( 'init', function() {
    if ( ! is_admin() ) {
        wp_deregister_script( 'heartbeat' );
    }
} );

// ==========================================================================
// 4. MEDIA & UPLOAD FILTERS
// ==========================================================================
add_filter( 'wp_lazy_loading_enabled', '__return_false' );

add_filter( 'wp_get_attachment_url', function( $url ) {
    if ( is_ssl() ) {
        $url = str_replace( 'http://', 'https://', $url );
    }
    return $url;
} );

add_filter( 'jpeg_quality', function( $arg ) {
    return 85;
} );

function add_lazy_loading_attribute( $content ) {
    return str_replace( '<img', '<img loading="lazy"', $content );
}
add_filter( 'the_content', 'add_lazy_loading_attribute' );
add_filter( 'post_thumbnail_html', 'add_lazy_loading_attribute' );

add_filter( 'wp_revisions_to_keep', function( $num, $post ) {
    return 3;
}, 10, 2 );

// ==========================================================================
// 5. WIDGET AREAS (SIDEBARS)
// ==========================================================================
add_action( 'widgets_init', function() {
    register_sidebar( [
        'name'          => 'سایدبار صفحه خبر ۱',
        'id'            => 'single-sidebar',
        'before_widget' => '<div class="widget-wrapper mb-6 bg-white border border-slate-200 rounded-xl overflow-hidden shadow-sm">',
        'after_widget'  => '</div>',
        'before_title'  => '<div class="bg-slate-800 text-white p-4 yekan-bold text-xs">',
        'after_title'   => '</div>',
    ] );

    register_sidebar( [
        'name'          => 'سایدبار صفحه خبر ۲',
        'id'            => 'single-sidebar-2',
        'before_widget' => '<div class="widget-wrapper mb-6 bg-white border border-slate-200 rounded-xl overflow-hidden shadow-sm">',
        'after_widget'  => '</div>',
        'before_title'  => '<div class="bg-slate-800 text-white p-4 yekan-bold text-xs">',
        'after_title'   => '</div>',
    ] );

    register_sidebar( [
        'name'          => 'تبلیغات تک نوشته',
        'id'            => 'ads-single',
        'before_widget' => '<div class="single-ad-container">',
        'after_widget'  => '</div>',
    ] );

    register_sidebar( [
        'name'          => 'تبلیغات سرویس ویدئو',
        'id'            => 'ads-video-sidebar',
        'before_widget' => '',
        'after_widget'  => '',
    ] );

    register_sidebar( [
        'name'          => 'تبلیغات سرویس تصویر',
        'id'            => 'ads-image-sidebar',
        'before_widget' => '',
        'after_widget'  => '',
    ] );

    register_sidebar( [
        'name'          => 'تبلیغات هدر راست',
        'id'            => 'header_ad_right',
        'before_widget' => '<div class="header_ad_item">',
        'after_widget'  => '</div>',
    ] );

    register_sidebar( [
        'name'          => 'تبلیغات هدر چپ',
        'id'            => 'header_ad_left',
        'before_widget' => '<div class="header_ad_item">',
        'after_widget'  => '</div>',
    ] );

    register_sidebar( [
        'name'          => 'تبلیغات موبایل صفحه اصلی',
        'id'            => 'home-mobile-ad',
        'before_widget' => '<div class="mobile-ad-container p-2 flex justify-center">',
        'after_widget'  => '</div>',
    ] );
} );

// Sport Sidebars
function sharji_register_sport_sidebars() {
    register_sidebar( [
        'name'          => 'سایدبار اختصاصی ورزشی',
        'id'            => 'sport-sidebar',
        'before_widget' => '<div id="%1$s" class="bg-[#1e293b] rounded-xl border border-gray-700/50 overflow-hidden shadow-xl mb-4 widget %2$s">',
        'after_widget'  => '</div></div>',
        'before_title'  => '<div class="flex border-b border-gray-700 bg-[#161f2f]"><span class="flex-1 py-3 text-sm font-bold text-white border-b-2 border-blue-500 bg-gray-800/50 px-4">',
        'after_title'   => '</span></div><div class="p-4">',
    ] );

    register_sidebar( [
        'name'          => 'تبلیغات سایدبار ورزشی',
        'id'            => 'sport-ad-sidebar',
        'before_widget' => '<div id="%1$s" class="bg-gradient-to-r from-blue-900 to-blue-800 rounded-xl overflow-hidden shadow-xl mb-4 border border-blue-700/30 widget %2$s">',
        'after_widget'  => '</div>',
    ] );
}
add_action( 'widgets_init', 'sharji_register_sport_sidebars' );

// ==========================================================================
// 6. SPORT TEMPLATE ROUTER
// ==========================================================================
add_filter( 'template_include', function( $template ) {
    if ( function_exists( 'sharji_is_sport_single' ) && sharji_is_sport_single() ) {
        $new_template = locate_template( ['single-sport.php'] );
        if ( $new_template ) {
            return $new_template;
        }
    }
    return $template;
} );

// ==========================================================================
// 7. EXCERPT META BOX POSITIONING
// ==========================================================================
function move_excerpt_after_title() {
    remove_meta_box( 'postexcerpt', 'post', 'normal' );
    add_action( 'edit_form_after_title', 'render_custom_excerpt_box' );
}
add_action( 'add_meta_boxes', 'move_excerpt_after_title' );

function render_custom_excerpt_box( $post ) {
    if ( ! post_type_supports( $post->post_type, 'excerpt' ) ) return;
    ?>
    <div style="margin-top: 20px; margin-bottom: 20px;">
        <label for="excerpt" style="font-weight: bold; font-size: 14px; margin-bottom: 5px; display: block;">چکیده (خلاصه متن):</label>
        <textarea name="excerpt" id="excerpt" style="width: 100%; height: 80px; padding: 10px;" placeholder="چکیده مطلب را اینجا بنویسید..."><?php echo esc_textarea( $post->post_excerpt ); ?></textarea>
        <p style="font-size: 12px; color: #666; margin-top: 5px;">چکیده‌ها، خلاصه‌ای اختیاری از نوشته شما هستند.</p>
    </div>
    <?php
}

// ==========================================================================
// 8. ADMIN-ONLY AUTHOR VISIBILITY META BOX
// ==========================================================================
function sharji_register_author_visibility_meta_box() {
    if ( ! function_exists( 'sharji_can_manage_author_visibility' ) || ! sharji_can_manage_author_visibility() ) {
        return;
    }
    add_meta_box(
        'sharji_author_visibility_box',
        'نمایش اطلاعات نویسنده',
        'sharji_render_author_visibility_meta_box',
        'post',
        'side',
        'high'
    );
}
add_action( 'add_meta_boxes', 'sharji_register_author_visibility_meta_box' );

function sharji_render_author_visibility_meta_box( $post ) {
    if ( ! function_exists( 'sharji_can_manage_author_visibility' ) || ! sharji_can_manage_author_visibility() ) {
        return;
    }
    $current = get_post_meta( $post->ID, '_sharji_show_author', true ) === '1' ? '1' : '0';
    wp_nonce_field( 'sharji_author_visibility_save', 'sharji_author_visibility_nonce' );
    ?>
    <div style="direction: rtl; text-align: right; line-height: 1.9;">
        <label style="display: block; margin-bottom: 8px; cursor: pointer;">
            <input type="radio" name="sharji_show_author" value="0" <?php checked( $current, '0' ); ?>>
            مخفی (پیش‌فرض)
        </label>
        <label style="display: block; cursor: pointer;">
            <input type="radio" name="sharji_show_author" value="1" <?php checked( $current, '1' ); ?>>
            نمایش نام و تصویر نویسنده
        </label>
    </div>
    <?php
}

function sharji_save_author_visibility_meta_box( $post_id ) {
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }
    if ( wp_is_post_revision( $post_id ) ) {
        return;
    }
    if ( ! function_exists( 'sharji_can_manage_author_visibility' ) || ! sharji_can_manage_author_visibility() ) {
        return;
    }
    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }
    if ( ! isset( $_POST['sharji_author_visibility_nonce'] ) ) {
        return;
    }
    $nonce = sanitize_text_field( wp_unslash( $_POST['sharji_author_visibility_nonce'] ) );
    if ( ! wp_verify_nonce( $nonce, 'sharji_author_visibility_save' ) ) {
        return;
    }
    $value = ( isset( $_POST['sharji_show_author'] ) && wp_unslash( $_POST['sharji_show_author'] ) === '1' ) ? '1' : '0';
    update_post_meta( $post_id, '_sharji_show_author', $value );
}
add_action( 'save_post_post', 'sharji_save_author_visibility_meta_box' );
