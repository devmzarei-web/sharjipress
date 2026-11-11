<?php
/**
 * Sharji Press - Custom Post Types & Meta Boxes
 * League Teams, Newspapers, and Match Fixtures
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// 1. League Teams CPT
function sharji_register_league_cpt() {
    register_post_type( 'league_team', [
        'labels' => [
            'name'          => 'تیم‌های لیگ',
            'singular_name' => 'تیم',
            'add_new'       => 'افزودن تیم',
            'add_new_item'  => 'افزودن تیم جدید',
            'edit_item'     => 'ویرایش آمار تیم',
            'all_items'     => 'همه تیم‌ها',
            'search_items'  => 'جستجوی تیم',
        ],
        'public'      => true,
        'has_archive' => false,
        'menu_icon'   => 'dashicons-shield',
        'supports'    => ['title', 'thumbnail'],
        'rewrite'     => ['slug' => 'team'],
    ]);
}
add_action( 'init', 'sharji_register_league_cpt' );

// 2. Newspaper CPT
function sharji_register_newspaper_cpt() {
    register_post_type( 'newspaper', [
        'labels' => [
            'name'          => 'روزنامه‌ها',
            'singular_name' => 'روزنامه',
            'add_new'       => 'افزودن جلد',
            'add_new_item'  => 'افزودن جلد روزنامه',
            'edit_item'     => 'ویرایش',
            'all_items'     => 'همه روزنامه‌ها',
            'menu_name'     => 'پیشخوان روزنامه',
        ],
        'public'        => true,
        'menu_icon'     => 'dashicons-media-document',
        'menu_position' => 6,
        'supports'      => ['title', 'thumbnail', 'page-attributes'],
        'rewrite'       => ['slug' => 'newspaper'],
    ]);
}
add_action( 'init', 'sharji_register_newspaper_cpt' );

// 3. Match Fixtures CPT
function sharji_register_fixtures_cpt() {
    register_post_type( 'fixtures', [
        'labels' => [
            'name'          => 'بازی‌های هفته',
            'singular_name' => 'بازی',
            'add_new'       => 'افزودن بازی',
            'add_new_item'  => 'افزودن بازی جدید',
            'edit_item'     => 'ویرایش بازی',
            'all_items'     => 'همه بازی‌ها',
            'menu_name'     => 'بازی‌های هفته',
        ],
        'public'        => true,
        'menu_position' => 5,
        'menu_icon'     => 'dashicons-calendar-alt',
        'supports'      => ['title', 'page-attributes'],
    ]);
}
add_action( 'init', 'sharji_register_fixtures_cpt' );

// 4. Fixtures Meta Box
function sharji_fixtures_meta_box() {
    add_meta_box( 'fixtures_details', 'اطلاعات مسابقه', 'sharji_fixtures_callback', 'fixtures', 'normal', 'high' );
}
add_action( 'add_meta_boxes', 'sharji_fixtures_meta_box' );

function sharji_fixtures_callback( $post ) {
    wp_nonce_field( 'sharji_save_fixtures_action', 'sharji_fixtures_nonce' );

    $host   = get_post_meta( $post->ID, '_fixture_host', true );
    $guest  = get_post_meta( $post->ID, '_fixture_guest', true );
    $time   = get_post_meta( $post->ID, '_fixture_time', true );
    $date   = get_post_meta( $post->ID, '_fixture_date', true );
    $status = get_post_meta( $post->ID, '_fixture_status', true );
    $link   = get_post_meta( $post->ID, '_fixture_link', true );

    ?>
    <div style="display:flex; flex-wrap:wrap; gap:20px;">
        <div style="flex:1; min-width:200px;">
            <label><strong>تیم میزبان:</strong></label><br>
            <input type="text" name="fixture_host" value="<?php echo esc_attr( $host ); ?>" style="width:100%; margin-top:5px;" placeholder="پرسپولیس">
        </div>
        <div style="flex:1; min-width:200px;">
            <label><strong>تیم میهمان:</strong></label><br>
            <input type="text" name="fixture_guest" value="<?php echo esc_attr( $guest ); ?>" style="width:100%; margin-top:5px;" placeholder="استقلال">
        </div>
        <div style="flex:1; min-width:150px;">
            <label><strong>ساعت بازی:</strong></label><br>
            <input type="text" name="fixture_time" value="<?php echo esc_attr( $time ); ?>" style="width:100%; margin-top:5px;" placeholder="18:30">
        </div>
        <div style="flex:1; min-width:150px;">
            <label><strong>تاریخ/متن:</strong></label><br>
            <input type="text" name="fixture_date" value="<?php echo esc_attr( $date ); ?>" style="width:100%; margin-top:5px;" placeholder="امروز">
        </div>
        <div style="flex:1; min-width:250px;">
            <label><strong>لینک پخش زنده:</strong></label><br>
            <input type="text" name="fixture_link" value="<?php echo esc_attr( $link ); ?>" style="width:100%; margin-top:5px; direction:ltr;" placeholder="https://...">
        </div>
        <div style="width:100%; margin-top:15px; border-top:1px solid #eee; padding-top:10px;">
            <label><strong>وضعیت نمایشی:</strong></label><br>
            <select name="fixture_status" style="width:200px;">
                <option value="future" <?php selected( $status, 'future' ); ?>>آینده</option>
                <option value="live" <?php selected( $status, 'live' ); ?>>زنده</option>
                <option value="end" <?php selected( $status, 'end' ); ?>>پایان یافته</option>
            </select>
        </div>
    </div>
    <?php
}

function sharji_save_fixtures_meta( $post_id ) {
    if ( ! isset( $_POST['sharji_fixtures_nonce'] ) || ! wp_verify_nonce( $_POST['sharji_fixtures_nonce'], 'sharji_save_fixtures_action' ) ) {
        return;
    }
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }
    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    $fields = ['fixture_host', 'fixture_guest', 'fixture_time', 'fixture_date', 'fixture_status', 'fixture_link'];
    foreach ( $fields as $field ) {
        if ( isset( $_POST[$field] ) ) {
            $val = ( $field === 'fixture_link' ) ? esc_url_raw( $_POST[$field] ) : sanitize_text_field( $_POST[$field] );
            update_post_meta( $post_id, '_' . $field, $val );
        }
    }
}
add_action( 'save_post_fixtures', 'sharji_save_fixtures_meta' );

