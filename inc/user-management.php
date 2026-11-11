<?php
/**
 * Sharji Press - User Roles, Gamification & Avatar Management
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// 1. Assign Custom Role on Ultimate Member Registration
add_action( 'um_registration_complete', 'sharji_assign_custom_role', 10, 2 );
function sharji_assign_custom_role( $user_id, $args ) {
    if ( isset( $args['role_select'] ) ) {
        $selected_role = $args['role_select'];
        $allowed_roles = ['um_custom_role_1', 'um_custom_role_2'];
        if ( in_array( $selected_role, $allowed_roles ) ) {
            $user = new WP_User( $user_id );
            $user->remove_role( 'subscriber' );
            $user->add_role( $selected_role );
        }
    }
}

// 2. Upgrade Sardabir (Editor) Role Capabilities
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
    if ( ! in_array( 'um_custom_role_3', $roles ) ) {
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

// 3. Gamification Ranking
function get_sharji_user_rank( $user_id ) {
    $score = (int) get_user_meta( $user_id, 'prediction_score', true );
    if ( $score >= 100 ) return ['title' => 'اختاپوس پیش‌گو', 'color' => '#ef4444', 'icon' => 'fa-crow'];
    if ( $score >= 50 )  return ['title' => 'پروفسور لیگ', 'color' => '#3b82f6', 'icon' => 'fa-graduation-cap'];
    if ( $score >= 20 )  return ['title' => 'آنالیزور خبره', 'color' => '#10b981', 'icon' => 'fa-chart-line'];
    if ( $score >= 5 )   return ['title' => 'نیمکت‌نشین', 'color' => '#f59e0b', 'icon' => 'fa-shirt'];
    return ['title' => 'توریست ورزشگاه', 'color' => '#94a3b8', 'icon' => 'fa-ticket-alt'];
}

function show_sharji_user_gamification( $user ) {
    $score = (int) get_user_meta( $user->ID, 'prediction_score', true );
    $rank = get_sharji_user_rank( $user->ID );
    ?>
    <h3>آمار ورزشی و گیمیفیکیشن</h3>
    <table class="form-table">
        <tr>
            <th><label for="prediction_score">امتیاز پیش‌بینی</label></th>
            <td>
                <input type="number" name="prediction_score" id="prediction_score" value="<?php echo esc_attr( $score ); ?>" class="regular-text" />
                <p class="description">لقب فعلی: <strong style="color: <?php echo esc_attr( $rank['color'] ); ?>;"><?php echo esc_html( $rank['title'] ); ?></strong></p>
            </td>
        </tr>
    </table>
    <?php
}
add_action( 'show_user_profile', 'show_sharji_user_gamification' );
add_action( 'edit_user_profile', 'show_sharji_user_gamification' );

function save_sharji_user_gamification( $user_id ) {
    if ( current_user_can( 'edit_user', $user_id ) && isset( $_POST['prediction_score'] ) ) {
        update_user_meta( $user_id, 'prediction_score', intval( $_POST['prediction_score'] ) );
    }
}
add_action( 'personal_options_update', 'save_sharji_user_gamification' );
add_action( 'edit_user_profile_update', 'save_sharji_user_gamification' );

// 4. Custom Avatar Override for Admins
add_action( 'show_user_profile', 'sharji_admin_avatar_field' );
add_action( 'edit_user_profile', 'sharji_admin_avatar_field' );
function sharji_admin_avatar_field( $user ) {
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }
    $custom_avatar = get_user_meta( $user->ID, 'sharji_override_avatar', true );
    ?>
    <h3>تنظیمات آواتار اختصاصی (فقط مدیران)</h3>
    <table class="form-table">
        <tr>
            <th><label for="sharji_override_avatar">لینک مستقیم تصویر</label></th>
            <td>
                <?php if ( ! empty( $custom_avatar ) ) : ?>
                    <div style="margin-bottom: 15px;">
                        <img src="<?php echo esc_url( $custom_avatar ); ?>" style="width: 80px; height: 80px; border-radius: 50%; object-fit: cover; border: 3px solid #e2e8f0;" alt="Current Avatar">
                    </div>
                <?php endif; ?>
                <input type="url" name="sharji_override_avatar" id="sharji_override_avatar" value="<?php echo esc_url( $custom_avatar ); ?>" class="regular-text ltr" placeholder="https://...">
                <p class="description">برای تغییر تصویر این کاربر, عکس را در رسانه آپلود کرده و لینک مستقیم آن را اینجا قرار دهید.</p>
            </td>
        </tr>
    </table>
    <?php
}

add_action( 'personal_options_update', 'sharji_save_admin_avatar_field' );
add_action( 'edit_user_profile_update', 'sharji_save_admin_avatar_field' );
function sharji_save_admin_avatar_field( $user_id ) {
    if ( ! current_user_can( 'manage_options' ) ) {
        return false;
    }
    if ( isset( $_POST['sharji_override_avatar'] ) ) {
        update_user_meta( $user_id, 'sharji_override_avatar', esc_url_raw( $_POST['sharji_override_avatar'] ) );
    }
}

add_filter( 'get_avatar_url', 'sharji_use_admin_avatar_url', 10, 3 );
function sharji_use_admin_avatar_url( $url, $id_or_email, $args ) {
    $user_id = 0;
    if ( is_numeric( $id_or_email ) ) {
        $user_id = (int) $id_or_email;
    } elseif ( is_string( $id_or_email ) && ( $user = get_user_by( 'email', $id_or_email ) ) ) {
        $user_id = $user->ID;
    } elseif ( is_object( $id_or_email ) && ! empty( $id_or_email->user_id ) ) {
        $user_id = (int) $id_or_email->user_id;
    }

    if ( $user_id ) {
        $custom_avatar = get_user_meta( $user_id, 'sharji_override_avatar', true );
        if ( ! empty( $custom_avatar ) ) {
            return esc_url( $custom_avatar );
        }
    }
    return $url;
}

