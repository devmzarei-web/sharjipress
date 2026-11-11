<?php
/* Template Name: Frontend News Editor */

// ⚠️ CRITICAL: ACF form head must load before get_header() or any HTML is output!
acf_form_head();
get_header(); 
?>

<div class="single-main-wrapper" style="margin-top: 50px; margin-bottom: 50px;">
    <main class="frontend-editor-shell">
        
        <?php
        if ( is_user_logged_in() ) {
            acf_form(array(
                'post_id'       => 'new_post',
                'new_post'      => array(
                    'post_type'   => 'post',
                    'post_status' => 'draft'
                ),
                'post_title'    => true,  
                'post_content'  => true,  
                'field_groups'  => array('group_sharji_frontend_news'),
                'submit_value'  => 'ذخیره خبر',
                'updated_message' => '<div style="background:#dcfce7; color:#16a34a; padding:15px; border-radius:12px; margin-bottom:30px; font-weight:bold; font-size: 16px;">خبر شما با موفقیت ذخیره شد.</div>',
            ));
        } else {
            echo '<div style="text-align: center; padding: 40px; color: #e31e24; font-family: Diba, sans-serif; font-size: 24px;">برای نوشتن خبر باید وارد حساب کاربری خود شوید.</div>';
        }
        ?>

    </main>
</div>

<?php get_footer(); ?>
