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
    
    <!-- Font Awesome - Local -->
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/fontawesome.min.css" />
    
    <style>
        /* ایزوله‌سازی مطلق */
        header, footer, .site-header, .site-footer, #header, #footer { display: none !important; }
        
        /* فونت وزیرمتن */
        @font-face { 
            font-family: 'Vazirmatn'; 
            src: url('<?php echo get_template_directory_uri(); ?>/assets/fonts/webfonts/Vazirmatn-Regular.woff2') format('woff2');
            font-weight: 400;
        }
        @font-face { 
            font-family: 'Vazirmatn'; 
            src: url('<?php echo get_template_directory_uri(); ?>/assets/fonts/webfonts/Vazirmatn-Bold.woff2') format('woff2');
            font-weight: 700;
        }
        
        body { 
            background: #f0f2f5; margin: 0; padding: 0; 
            font-family: 'Vazirmatn', sans-serif !important; 
            direction: rtl; display: flex; align-items: center; justify-content: center; min-height: 100vh;
        }

        .auth-container {
            width: 95%; max-width: 1000px; background: #fff;
            border-radius: 25px; box-shadow: 0 15px 40px rgba(0,0,0,0.08);
            display: flex; overflow: hidden; min-height: 460px;
        }

        /* بخش سمت راست (دسکتاپ): آبی */
        .auth-info {
            flex: 0 0 35%; background: #0071b3;
            padding: 30px 20px; display: flex; flex-direction: column; align-items: center; justify-content: center; text-align: center;
        }

        /* باکس لوگو */
        .logo-box {
            background: transparent;
            padding: 0; 
            border-radius: 0;
            box-shadow: none;
            margin-bottom: 20px;
        }
        .logo-box img { width: 180px; height: auto; display: block; filter: none !important; max-width: 100%; }
        
        .auth-info h1 { font-size: 22px; color: #fff; margin-bottom: 10px; font-weight: bold; font-family: 'Vazirmatn', sans-serif; }
        .auth-info p { font-size: 14px; color: rgba(255,255,255,0.85); line-height: 1.6; margin-bottom: 20px; }

        .btn-back-home {
            padding: 8px 15px; border-radius: 10px; border: 1px solid rgba(255,255,255,0.25);
            color: #fff; text-decoration: none; font-size: 12px; transition: 0.3s; display: inline-block;
        }
        .btn-back-home:hover { background: rgba(255,255,255,0.1); }

        /* بخش فرم */
        .auth-form { flex: 1; padding: 25px 40px; display: flex; align-items: center; }
        .sharji-auth-wrapper { width: 100%; }

        /* --- استایل فیلدهای Ultimate Member --- */
        .um-form input[type=text], 
        .um-form input[type=password], 
        .um-form input[type=email] {
            border-radius: 50px !important;
            border: 1px solid #ddd !important;
            padding: 0 20px !important;
            height: 46px !important;
            background: #f9f9f9 !important;
            font-family: 'Vazirmatn', sans-serif !important;
        }
        
        /* دکمه اصلی */
        .um-button, input[type=submit].um-button {
            border-radius: 50px !important;
            height: 46px !important;
            background: #0071b3 !important;
            font-weight: bold !important;
            font-family: 'Vazirmatn', sans-serif !important;
        }

        .custom-alt-btn-wrapper { margin-top: 20px; text-align: center; }
        .custom-alt-btn { 
            color: #0056b3; text-decoration: none; font-size: 13px; font-weight: bold; 
            transition: color 0.3s;
        }
        .custom-alt-btn:hover { color: #003d80; }

        /* ریسپانسیو */
        @media (max-width: 850px) {
            .auth-container { flex-direction: column; max-width: 450px; margin: 20px; }
            .auth-info { order: 1; padding: 30px; flex: 0 0 auto; }
            .auth-form { order: 2; padding: 30px 20px; }
            .logo-box img { width: 150px; }
        }
    </style>
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