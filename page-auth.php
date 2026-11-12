<?php
/**
 * Template Name: Sharji Auth Final V6
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<div class="auth-container">
    
    <div class="auth-info">
        <div class="logo-box">
            <img src="<?php echo esc_url( home_url('/wp-content/uploads/2026/01/logosharjiback.webp') ); ?>" alt="شرجی پرس">
        </div>
        <h1>خوش آمدید</h1>
        <p>به پایگاه خبری شرجی پرس خوش آمدید. جهت استفاده از سرویس خبرنگار مردمی، لطفاً وارد شوید.</p>
        <a href="<?php echo home_url(); ?>" class="btn-back-home">بازگشت به سایت</a>
    </div>

    <div class="auth-form">
        <div class="sharji-auth-wrapper">
            <?php while ( have_posts() ) : the_post(); the_content(); endwhile; ?>
            
            <div class="custom-alt-btn-wrapper">
                <?php 
                $current_url = $_SERVER['REQUEST_URI'];
                $is_reg = (strpos($current_url, 'register') !== false || strpos($current_url, 'ثبت-نام') !== false);
                echo '<a href="'.home_url($is_reg ? '/login' : '/register').'" class="custom-alt-btn">';
                echo $is_reg ? 'قبلاً ثبت‌نام کرده‌اید؟ وارد شوید.' : 'حساب ندارید؟ ثبت‌نام کنید';
                echo '</a>';
                ?>
            </div>
        </div>
    </div>

</div>
<?php wp_footer(); ?>
</body>
</html>
