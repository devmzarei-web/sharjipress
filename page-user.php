<?php 
/* Template Name: Sharji User Profile */
get_header(); 

function sharji_to_persian_num($number) {
    $english = array('0','1','2','3','4','5','6','7','8','9');
    $persian = array('۰','۱','۲','۳','۴','۵','۶','۷','۸','۹');
    return str_replace($english, $persian, $number);
}

$profile_id = um_profile_id(); 
$current_id = get_current_user_id();
$is_owner   = ($profile_id == $current_id);
$is_editing = (isset($_GET['um_action']) && $_GET['um_action'] == 'edit');

if ( ! $is_editing ) {
    um_fetch_user($profile_id);
    
    $first_name = um_user('first_name');
    $last_name  = um_user('last_name');
    
    $user_meta = get_userdata($profile_id);
    $user_roles = $user_meta->roles;
    $slug = !empty($user_roles) ? $user_roles[0] : 'um_custom_role_2';

    $role_map = [
        'administrator'    => 'مدیر کل',
        'um_custom_role_3' => 'سردبیر',
        'um_custom_role_1' => 'خبرنگار',
        'um_custom_role_2' => 'کاربر عادی',
        'editor'           => 'سردبیر',
        'author'           => 'خبرنگار',
        'subscriber'       => 'کاربر عادی'
    ];

    $role_name = isset($role_map[$slug]) ? $role_map[$slug] : um_user('role_name');

    $mobile = um_user('mobile_number');
    if(!$mobile) $mobile = get_user_meta($profile_id, 'mobile_number', true);
    if(!$mobile) $mobile = get_user_meta($profile_id, 'billing_phone', true);
    $mobile_display = ($is_owner) ? ($mobile ? sharji_to_persian_num($mobile) : '---') : '*******';

    $birth_date_raw = um_user('birth_date'); 
    if(!$birth_date_raw) $birth_date_raw = get_user_meta($profile_id, 'birth_date', true);

    $birth_date_display = '-';
    if ($birth_date_raw) {
        $timestamp = strtotime($birth_date_raw);
        if (function_exists('jdate')) {
            $date_str = jdate('Y/m/d', $timestamp);
        } elseif (function_exists('parsidate')) {
            $date_str = parsidate('Y/m/d', $birth_date_raw, 'eng');
        } else {
            $date_str = $birth_date_raw; 
        }
        $birth_date_display = sharji_to_persian_num($date_str);
    }
    
    $profile_id_persian = sharji_to_persian_num($profile_id);
}
?>

<style>
    .user-main-wrapper {
        max-width: 1920px; margin: 0 auto; padding: 40px !important;
        direction: rtl; box-sizing: border-box; background-color: #f8fafc; min-height: 80vh;
    }

    .um-editing-box {
        background: #fff; padding: 40px; border-radius: 16px;
        border: 1px solid #e2e8f0; box-shadow: 0 4px 15px rgba(0,0,0,0.05);
    }
    .um-editing-box .um-field-label { text-align: right; }

    .sharji-id-card {
        width: 100%; max-width: 650px; height: 380px; margin: 0 auto;
        background: #fff; border-radius: 20px; box-shadow: 0 20px 40px rgba(0, 86, 179, 0.15);
        overflow: hidden; position: relative; border: 1px solid #cbd5e1;
        display: flex; direction: rtl;
    }

    .id-card-info {
        width: 62%; padding: 30px 40px; position: relative;
        display: flex; flex-direction: column; z-index: 20;
    }

    .id-card-visual {
        width: 38%;
        background: linear-gradient(135deg, #0056b3 0%, #003366 100%);
        position: relative; display: flex; flex-direction: column;
        align-items: center; justify-content: center; padding: 20px;
        color: white; text-align: center; border-right: 1px solid rgba(255,255,255,0.1);
    }
    .id-card-visual::before {
        content: 'SHARJI'; position: absolute; top: 50%; left: 50%;
        transform: translate(-50%, -50%) rotate(-90deg);
        font-family: 'Diba', sans-serif; font-size: 90px;
        color: rgba(255,255,255,0.05); font-weight: bold; white-space: nowrap; pointer-events: none;
    }

    .id-avatar-img {
        width: 130px !important; height: 130px !important;
        border-radius: 50% !important; border: 5px solid rgba(255,255,255,0.3) !important;
        box-shadow: 0 8px 25px rgba(0,0,0,0.3) !important;
        object-fit: cover !important; margin-bottom: 25px;
        position: relative; z-index: 10; background: #fff;
    }

    .id-role-badge-large {
        background: #e31e24; color: #fff; padding: 6px 20px;
        border-radius: 8px; font-size: 15px; font-family: 'Diba', sans-serif;
        box-shadow: 0 4px 10px rgba(0,0,0,0.2); border: 1px solid rgba(255,255,255,0.2);
        z-index: 10; display: inline-block; min-width: 100px;
    }

    .id-header {
        display: flex; justify-content: space-between; align-items: center;
        border-bottom: 2px solid #f1f5f9; padding-bottom: 15px; margin-bottom: 25px;
    }
    .id-brand-title { font-family: 'Diba', sans-serif; font-size: 22px; color: #0056b3; }
    .edit-btn { color: #94a3b8; font-size: 18px; padding: 5px; transition: 0.2s; text-decoration: none; }
    .edit-btn:hover { color: #0056b3; transform: rotate(90deg); display: inline-block; }

    .id-grid { display: flex; flex-direction: column; gap: 15px; }
    .id-row { display: flex; justify-content: space-between; align-items: center; border-bottom: 1px dashed #e2e8f0; padding-bottom: 5px; }
    .id-label { font-size: 12px; color: #94a3b8; font-family: 'Vazirmatn', sans-serif; display: flex; align-items: center; gap: 5px; }
    .id-value { font-size: 16px; color: #1e293b; font-weight: bold; font-family: 'Diba', sans-serif; }
    .id-value.blue { color: #2563eb; }
    .id-value.vazir { font-family: 'Vazirmatn', sans-serif; letter-spacing: 1px; }

    .id-barcode {
        margin-top: auto; font-family: 'Courier New', monospace; font-size: 12px;
        color: #94a3b8; display: flex; align-items: center; gap: 10px; direction: ltr;
    }
    .id-barcode-lines {
        height: 25px; flex-grow: 1; opacity: 0.6;
        background: repeating-linear-gradient(90deg, #333, #333 1px, #fff 1px, #fff 3px);
    }

    /* سایدبار */
    .sidebar-ad-container { width: 100%; margin-bottom: 25px; display: flex; justify-content: center; }
    .sidebar-ad-container .widget, .sidebar-ad-container div { margin: 0 !important; padding: 0 !important; border: none !important; background: transparent !important; width: 100%; }
    .sidebar-ad-container img { width: 100% !important; height: auto !important; border-radius: 12px !important; box-shadow: 0 4px 10px rgba(0,0,0,0.06); display: block; margin: 0 auto; }

    /* Tailwind Replacements */
    .flex { display: flex; }
    .flex-col { flex-direction: column; }
    .items-center { align-items: center; }
    .items-start { align-items: flex-start; }
    .justify-center { justify-content: center; }
    .justify-between { justify-content: space-between; }
    .gap-3 { gap: 12px; }
    .gap-6 { gap: 24px; }
    .gap-10 { gap: 40px; }
    .w-full { width: 100%; }
    .h-32 { height: 128px; }
    .h-full { height: 100%; }
    .object-cover { object-fit: cover; }
    .overflow-hidden { overflow: hidden; }
    .sticky { position: sticky; top: 32px; }
    .rounded-lg { border-radius: 8px; }
    .rounded-2xl { border-radius: 16px; }
    .border { border: 1px solid #e2e8f0; }
    .border-b { border-bottom: 1px solid #f8fafc; }
    .border-slate-50 { border-color: #f8fafc; }
    .border-slate-200 { border-color: #e2e8f0; }
    .bg-white { background-color: #fff; }
    .bg-\[\#0056b3\] { background-color: #0056b3; }
    .bg-slate-100 { background-color: #f1f5f9; }
    .text-white { color: #fff; }
    .text-slate-800 { color: #1e293b; }
    .text-yellow-400 { color: #facc15; }
    .font-bold { font-weight: bold; }
    .text-sm { font-size: 14px; }
    .text-xl { font-size: 20px; }
    .text-\[13px\] { font-size: 13px; }
    .leading-6 { line-height: 1.5rem; }
    .mb-4 { margin-bottom: 16px; }
    .mb-6 { margin-bottom: 24px; }
    .p-4 { padding: 16px; }
    .pb-4 { padding-bottom: 16px; }
    .py-10 { padding-top: 40px; padding-bottom: 40px; }
    .shadow-sm { box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05); }
    .transition { transition: all 0.3s; }
    .transition-all { transition: all 0.3s; }
    .transition-colors { transition: color 0.3s; }
    .transition-transform { transition: transform 0.5s; }
    .hover\:bg-slate-50:hover { background-color: #f8fafc; }
    .hover\:text-red-700:hover { color: #b91c1c; }
    .group:hover .group-hover\:scale-105 { transform: scale(1.05); }
    .group:hover .group-hover\:text-red-700 { color: #b91c1c; }
    .font-diba { font-family: 'Diba', sans-serif; }
    .text-blue-800 { color: #1e40af; }
    .text-red-500 { color: #ef4444; }
    .hover\:text-red-700:hover { color: #b91c1c; }
    .text-blue-600 { color: #2563eb; }

    @media (max-width: 768px) {
        .user-main-wrapper { padding: 20px !important; }
        .sharji-id-card { flex-direction: column-reverse; height: auto; max-width: 350px; }
        .id-card-visual { width: 100%; padding: 30px; border-right: none; border-top: 5px solid #e31e24; }
        .id-card-info { width: 100%; padding: 25px; }
    }

    @media (min-width: 1025px) {
        .lg\:w-\[75\%\] { width: 75%; }
        .lg\:w-\[25\%\] { width: 25%; }
        .lg\:flex-row { flex-direction: row; }
    }
</style>

<div class="user-main-wrapper">
    <div class="flex flex-col lg:flex-row gap-10 items-start">
        
        <div class="w-full lg:w-[75%]">
            <?php if ( $is_editing ) : ?>
                <div class="um-editing-box">
                    <div class="flex justify-between items-center border-b pb-4 mb-6">
                        <h3 class="font-diba text-xl text-blue-800">ویرایش پروفایل</h3>
                        <a href="<?php echo um_get_core_page('user'); ?>" class="text-sm text-red-500 hover:text-red-700 font-bold"><i class="fas fa-times"></i> انصراف</a>
                    </div>
                    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); the_content(); endwhile; endif; ?>
                </div>
            <?php else : ?>
                <div class="flex justify-center py-10">
                    <div class="sharji-id-card">
                        <div class="id-card-info">
                            <div class="id-header">
                                <span class="id-brand-title">کارت عضویت شرجی</span>
                                <?php if ($is_owner): ?>
                                    <a href="?um_action=edit" class="edit-btn" title="ویرایش اطلاعات"><i class="fas fa-cog"></i></a>
                                <?php endif; ?>
                            </div>
                            <div class="id-grid">
                                <div class="id-row"><span class="id-label">نام و نام خانوادگی</span><span class="id-value"><?php echo $first_name . ' ' . $last_name; ?></span></div>
                                <div class="id-row"><span class="id-label">شماره پرونده</span><span class="id-value blue">#<?php echo $profile_id_persian; ?></span></div>
                                <div class="id-row"><span class="id-label">شماره تماس</span><span class="id-value vazir"><?php echo $mobile_display; ?></span></div>
                                <div class="id-row"><span class="id-label">تاریخ تولد</span><span class="id-value"><?php echo $birth_date_display; ?></span></div>
                            </div>
                            <div class="id-barcode"><span><?php echo sharji_to_persian_num(date('Y')); ?></span><div class="id-barcode-lines"></div></div>
                        </div>
                        <div class="id-card-visual">
                            <?php echo get_avatar($profile_id, 150, '', 'Avatar', ['class' => 'id-avatar-img']); ?>
                            <div class="id-role-badge-large"><?php echo $role_name; ?></div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <div class="w-full lg:w-[25%]">
            <div class="sticky flex flex-col gap-6">
                <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-sm">
                    <div class="bg-[#0056b3] text-white p-4 font-bold text-sm flex justify-between items-center"><span>پیشنهاد شرجی</span><i class="fas fa-star text-yellow-400"></i></div>
                    <?php 
                    $editor_cache = wp_cache_get('editor_picks_sidebar', 'sidebar');
                    if (false === $editor_cache) {
                        $sticky = get_option('sticky_posts');
                        $args = !empty($sticky) ? ['posts_per_page' => 3, 'post__in' => $sticky, 'ignore_sticky_posts' => 1] : ['posts_per_page' => 3, 'orderby' => 'rand'];
                        $editor_query = new WP_Query($args);
                        $editor_cache = $editor_query->posts;
                        wp_cache_set('editor_picks_sidebar', $editor_cache, 'sidebar', 2 * HOUR_IN_SECONDS);
                    }
                    if ($editor_cache) :
                        foreach ($editor_cache as $post) : setup_postdata($post); ?>
                            <a href="<?php the_permalink(); ?>" class="flex flex-col gap-3 p-4 border-b border-slate-50 hover:bg-slate-50 transition-all group">
                                <div class="w-full h-32 overflow-hidden rounded-lg bg-slate-100"><?php if (has_post_thumbnail()) : the_post_thumbnail('medium', ['class' => 'w-full h-full object-cover group-hover:scale-105 transition-transform']); endif; ?></div>
                                <h4 class="text-[13px] font-bold text-slate-800 leading-6 group-hover:text-red-700 transition-colors"><?php the_title(); ?></h4>
                            </a>
                        <?php endforeach; wp_reset_postdata(); 
                    endif; ?>
                </div>
                <?php if ( is_active_sidebar( 'single-sidebar' ) ) : ?><div class="sidebar-ad-container"><?php dynamic_sidebar( 'single-sidebar' ); ?></div><?php endif; ?>
                <?php if ( is_active_sidebar( 'single-sidebar-2' ) ) : ?><div class="sidebar-ad-container"><?php dynamic_sidebar( 'single-sidebar-2' ); ?></div><?php endif; ?>
            </div>
        </div>

    </div>
</div>

<?php get_footer(); ?>