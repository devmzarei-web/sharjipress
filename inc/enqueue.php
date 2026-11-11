<?php
/**
 * Sharji Press - Asset Enqueue
 * Standardized, 100% local script and stylesheet management
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function sharji_enqueue_scripts() {
    $theme_dir = get_template_directory();
    $theme_uri = get_template_directory_uri();

    // Helper for file versioning via modification time
    $get_ver = function( $rel_path ) use ( $theme_dir ) {
        $file_path = $theme_dir . '/' . ltrim( $rel_path, '/' );
        return file_exists( $file_path ) ? filemtime( $file_path ) : '8.0';
    };

    // 1. Local Fonts & Core Styles
    wp_enqueue_style( 'sharji-fonts', $theme_uri . '/assets/css/fonts.css', [], $get_ver( 'assets/css/fonts.css' ) );
    wp_enqueue_style( 'sharji-core', $theme_uri . '/assets/css/core.css', ['sharji-fonts'], $get_ver( 'assets/css/core.css' ) );
    wp_enqueue_style( 'font-awesome', $theme_uri . '/assets/css/fontawesome.min.css', [], $get_ver( 'assets/css/fontawesome.min.css' ) );

    // 2. Swiper Library (Local)
    wp_register_style( 'swiper-css', $theme_uri . '/assets/css/swiper-bundle.min.css', [], $get_ver( 'assets/css/swiper-bundle.min.css' ) );
    wp_register_script( 'swiper-js', $theme_uri . '/assets/js/swiper-bundle.min.js', [], $get_ver( 'assets/js/swiper-bundle.min.js' ), true );

    // 3. Navigation Script (Mobile drawer & search)
    wp_enqueue_script( 'sharji-navigation', $theme_uri . '/assets/js/navigation.js', [], $get_ver( 'assets/js/navigation.js' ), true );
    wp_localize_script( 'sharji-navigation', 'sharjiSettings', [
        'homeUrl' => home_url(),
        'ajaxUrl' => admin_url( 'admin-ajax.php' ),
    ]);

    // Check if current view is part of the Sport sub-theme
    $is_sport_section = is_category( 'sport' ) 
        || is_page_template( 'page-league-table.php' ) 
        || is_page_template( 'page-newspapers.php' ) 
        || is_page_template( 'page-wlivescores.php' )
        || ( is_single() && ( has_category( 'sport' ) || ( isset( $_GET['theme'] ) && $_GET['theme'] === 'sport' ) ) );

    // 4. Sport Theme vs Main Theme
    if ( $is_sport_section ) {
        wp_enqueue_style( 'swiper-css' );
        wp_enqueue_script( 'swiper-js' );
        wp_enqueue_style( 'sharji-sport-theme', $theme_uri . '/assets/css/sport-theme.css', ['sharji-core'], $get_ver( 'assets/css/sport-theme.css' ) );
        wp_enqueue_script( 'sharji-sport-js', $theme_uri . '/assets/js/sport.js', ['swiper-js'], $get_ver( 'assets/js/sport.js' ), true );
    } else {
        wp_enqueue_style( 'sharji-main-theme', $theme_uri . '/assets/css/main-theme.css', ['sharji-core'], $get_ver( 'assets/css/main-theme.css' ) );
    }

    // 5. Template Specific Styles & Scripts
    if ( is_front_page() ) {
        wp_enqueue_style( 'swiper-css' );
        wp_enqueue_script( 'swiper-js' );
        wp_enqueue_style( 'sharji-front-page', $theme_uri . '/assets/css/front-page.css', ['sharji-main-theme'], $get_ver( 'assets/css/front-page.css' ) );
        wp_enqueue_script( 'sharji-front-page-js', $theme_uri . '/assets/js/front-page.js', ['swiper-js'], $get_ver( 'assets/js/front-page.js' ), true );
        wp_enqueue_script( 'sharji-sliders', $theme_uri . '/assets/js/sliders.js', ['swiper-js'], $get_ver( 'assets/js/sliders.js' ), true );
    } elseif ( is_single() ) {
        wp_enqueue_style( 'swiper-css' );
        wp_enqueue_script( 'swiper-js' );
        if ( ! $is_sport_section ) {
            wp_enqueue_style( 'sharji-single', $theme_uri . '/assets/css/single.css', ['sharji-main-theme'], $get_ver( 'assets/css/single.css' ) );
            wp_enqueue_style( 'sharji-comments', $theme_uri . '/assets/css/comments.css', ['sharji-single'], $get_ver( 'assets/css/comments.css' ) );
        }
        wp_enqueue_script( 'sharji-single-js', $theme_uri . '/assets/js/single.js', [], $get_ver( 'assets/js/single.js' ), true );
        wp_enqueue_script( 'sharji-sliders', $theme_uri . '/assets/js/sliders.js', ['swiper-js'], $get_ver( 'assets/js/sliders.js' ), true );
    } elseif ( is_archive() || is_search() ) {
        if ( ! is_category( 'sport' ) ) {
            wp_enqueue_style( 'sharji-archive', $theme_uri . '/assets/css/archive.css', ['sharji-main-theme'], $get_ver( 'assets/css/archive.css' ) );
        }
    } elseif ( is_page_template( 'page-auth.php' ) ) {
        wp_enqueue_style( 'sharji-auth', $theme_uri . '/assets/css/page-auth.css', ['sharji-fonts'], $get_ver( 'assets/css/page-auth.css' ) );
    } else {
        // Standard pages, page-about-us, page-contact, weather, etc.
        if ( ! $is_sport_section ) {
            wp_enqueue_style( 'sharji-pages', $theme_uri . '/assets/css/custom-pages.css', ['sharji-main-theme'], $get_ver( 'assets/css/custom-pages.css' ) );
            wp_enqueue_script( 'sharji-pages-js', $theme_uri . '/assets/js/pages.js', [], $get_ver( 'assets/js/pages.js' ), true );
        }
    }
}
add_action( 'wp_enqueue_scripts', 'sharji_enqueue_scripts' );

// Clean deregistration of external CDNs injected by third-party plugins
add_action( 'wp_enqueue_scripts', function() {
    global $wp_styles, $wp_scripts;
    if ( ! is_admin() ) {
        if ( isset( $wp_styles ) && ! empty( $wp_styles->registered ) ) {
            foreach ( $wp_styles->registered as $handle => $style ) {
                if ( ! empty( $style->src ) && is_string( $style->src ) ) {
                    if ( strpos( $style->src, 'cdnjs.cloudflare.com' ) !== false || 
                         strpos( $style->src, 'cdn.jsdelivr.net' ) !== false ||
                         strpos( $style->src, 'cdn.tailwindcss.com' ) !== false ) {
                        wp_dequeue_style( $handle );
                        wp_deregister_style( $handle );
                    }
                }
            }
        }
        if ( isset( $wp_scripts ) && ! empty( $wp_scripts->registered ) ) {
            foreach ( $wp_scripts->registered as $handle => $script ) {
                if ( ! empty( $script->src ) && is_string( $script->src ) ) {
                    if ( strpos( $script->src, 'cdnjs.cloudflare.com' ) !== false || 
                         strpos( $script->src, 'cdn.jsdelivr.net' ) !== false ||
                         strpos( $script->src, 'cdn.tailwindcss.com' ) !== false ) {
                        wp_dequeue_script( $handle );
                        wp_deregister_script( $handle );
                    }
                }
            }
        }
    }
}, 9999 );

