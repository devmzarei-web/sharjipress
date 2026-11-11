<?php
/**
 * Sharji Press - Advanced Custom Fields (ACF) Local Groups
 * Frontend submission fields and corner promotional popups
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// 1. Frontend Form Fields & Admin Video Meta
if ( function_exists( 'acf_add_local_field_group' ) ) :

    if ( ! is_admin() ) {
        acf_add_local_field_group( [
            'key'    => 'group_sharji_frontend_news',
            'title'  => 'Frontend News Meta',
            'fields' => [
                [
                    'key'           => 'field_front_image',
                    'label'         => 'تصویر شاخص',
                    'name'          => 'frontend_image',
                    'type'          => 'image',
                    'return_format' => 'id',
                    'preview_size'  => 'medium',
                    'library'       => 'all',
                ],
                [
                    'key'   => 'field_front_excerpt',
                    'label' => 'چکیده خبر',
                    'name'  => 'frontend_excerpt',
                    'type'  => 'textarea',
                    'rows'  => 3,
                ],
                [
                    'key'          => 'field_front_video_preview',
                    'label'        => 'لینک پیش‌نمایش ویدئو',
                    'name'         => 'video_preview_url',
                    'type'         => 'url',
                    'instructions' => 'لینک مستقیم ویدئو (MP4)',
                ],
                [
                    'key'           => 'field_front_cats',
                    'label'         => 'دسته‌بندی‌ها',
                    'name'          => 'frontend_categories',
                    'type'          => 'taxonomy',
                    'taxonomy'      => 'category',
                    'field_type'    => 'checkbox',
                    'save_terms'    => 1,
                    'load_terms'    => 1,
                    'return_format' => 'id',
                ],
                [
                    'key'           => 'field_front_tags',
                    'label'         => 'برچسب‌ها',
                    'name'          => 'frontend_tags',
                    'type'          => 'taxonomy',
                    'taxonomy'      => 'post_tag',
                    'field_type'    => 'multi_select',
                    'save_terms'    => 1,
                    'load_terms'    => 1,
                    'return_format' => 'id',
                ],
                [
                    'key'           => 'field_front_status',
                    'label'         => 'وضعیت انتشار',
                    'name'          => 'frontend_status',
                    'type'          => 'select',
                    'choices'       => [
                        'draft'   => 'پیش‌نویس (نیاز به تایید)',
                        'publish' => 'انتشار فوری',
                    ],
                    'default_value' => 'draft',
                ],
            ],
            'location' => [
                [
                    ['param' => 'post_type', 'operator' => '==', 'value' => 'post'],
                ],
            ],
            'active' => true,
        ] );
    } else {
        acf_add_local_field_group( [
            'key'    => 'group_sharji_admin_video',
            'title'  => 'تنظیمات ویدئو خبر',
            'fields' => [
                [
                    'key'          => 'field_admin_video_preview',
                    'label'        => 'لینک پیش‌نمایش ویدئو',
                    'name'         => 'video_preview_url',
                    'type'         => 'url',
                    'instructions' => 'لینک مستقیم ویدئو (MP4)',
                ],
            ],
            'location' => [
                [
                    ['param' => 'post_type', 'operator' => '==', 'value' => 'post'],
                ],
            ],
            'active' => true,
        ] );
    }

endif;

add_action( 'acf/save_post', 'sharji_map_frontend_submission', 20 );
function sharji_map_frontend_submission( $post_id ) {
    if ( is_admin() ) return;

    $post_data = ['ID' => $post_id];
    $update_needed = false;

    $excerpt  = get_field( 'frontend_excerpt', $post_id );
    $status   = get_field( 'frontend_status', $post_id );
    $image_id = get_field( 'frontend_image', $post_id );

    if ( ! empty( $excerpt ) ) {
        $post_data['post_excerpt'] = $excerpt;
        $update_needed = true;
    }
    if ( ! empty( $status ) ) {
        $post_data['post_status'] = $status;
        $update_needed = true;
    }

    if ( $update_needed ) {
        wp_update_post( $post_data );
    }
    if ( ! empty( $image_id ) ) {
        set_post_thumbnail( $post_id, $image_id );
    }
}

// 2. Dual Corner Promotional Popups
add_action( 'init', 'sharji_ensure_popup_container_exists' );
function sharji_ensure_popup_container_exists() {
    if ( ! get_page_by_path( 'popup-settings' ) ) {
        wp_insert_post( [
            'post_title'  => 'تنظیمات پاپ‌آپ',
            'post_name'   => 'popup-settings',
            'post_status' => 'publish',
            'post_type'   => 'page',
        ] );
    }
}

add_action( 'admin_menu', 'sharji_popup_sidebar_menu' );
function sharji_popup_sidebar_menu() {
    $popup_page = get_page_by_path( 'popup-settings' );
    if ( $popup_page ) {
        add_menu_page( 'تنظیمات پاپ‌آپ', 'تنظیمات پاپ‌آپ', 'edit_posts', 'post.php?post=' . $popup_page->ID . '&action=edit', '', 'dashicons-images-alt2', 60 );
    }
}

add_action( 'acf/init', 'sharji_register_popup_fields' );
function sharji_register_popup_fields() {
    $popup_page = get_page_by_path( 'popup-settings' );
    $page_id = $popup_page ? $popup_page->ID : 0;

    if ( function_exists( 'acf_add_local_field_group' ) ) :
        acf_add_local_field_group( [
            'key'    => 'group_sharji_bottom_popup',
            'title'  => 'تنظیمات پاپ‌آپ‌های گوشه‌ای صفحه اصلی',
            'fields' => [
                // Right Popup
                [
                    'key'   => 'field_popup_right_tab',
                    'label' => 'پاپ‌آپ سمت راست',
                    'type'  => 'tab',
                ],
                [
                    'key'   => 'field_popup_status_right',
                    'label' => 'وضعیت پاپ‌آپ راست',
                    'name'  => 'enable_right_popup',
                    'type'  => 'true_false',
                    'ui'    => 1,
                ],
                [
                    'key'               => 'field_popup_image_right',
                    'label'             => 'تصویر بنر راست',
                    'name'              => 'right_popup_image',
                    'type'              => 'image',
                    'conditional_logic' => [[['field' => 'field_popup_status_right', 'operator' => '==', 'value' => '1']]],
                    'return_format'     => 'id',
                    'preview_size'      => 'medium',
                ],
                [
                    'key'               => 'field_popup_url_right',
                    'label'             => 'لینک ارجاع راست',
                    'name'              => 'right_popup_link',
                    'type'              => 'url',
                    'conditional_logic' => [[['field' => 'field_popup_status_right', 'operator' => '==', 'value' => '1']]],
                ],
                // Left Popup
                [
                    'key'   => 'field_popup_left_tab',
                    'label' => 'پاپ‌آپ سمت چپ',
                    'type'  => 'tab',
                ],
                [
                    'key'   => 'field_popup_status_left',
                    'label' => 'وضعیت پاپ‌آپ چپ',
                    'name'  => 'enable_left_popup',
                    'type'  => 'true_false',
                    'ui'    => 1,
                ],
                [
                    'key'               => 'field_popup_image_left',
                    'label'             => 'تصویر بنر چپ',
                    'name'              => 'left_popup_image',
                    'type'              => 'image',
                    'conditional_logic' => [[['field' => 'field_popup_status_left', 'operator' => '==', 'value' => '1']]],
                    'return_format'     => 'id',
                    'preview_size'      => 'medium',
                ],
                [
                    'key'               => 'field_popup_url_left',
                    'label'             => 'لینک ارجاع چپ',
                    'name'              => 'left_popup_link',
                    'type'              => 'url',
                    'conditional_logic' => [[['field' => 'field_popup_status_left', 'operator' => '==', 'value' => '1']]],
                ],
            ],
            'location' => [
                [
                    ['param' => 'page', 'operator' => '==', 'value' => $page_id],
                ],
            ],
        ] );
    endif;
}

