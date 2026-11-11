<?php 
/* Template Name: Sharji User Profile */
get_header(); 

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