<!DOCTYPE html>
<html <?php language_attributes(); ?> dir="rtl">
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<!-- ======================== -->
<!-- پنل کشویی موبایل -->
<!-- ======================== -->
<div class="sharji-mob-overlay" id="sharjiOverlay" onclick="sharjiToggleMenu()"></div>

<div class="sharji-mob-panel" id="sharjiPanel">
    <div class="sharji-mob-panel-head">
        <span>منوی اصلی</span>
        <i class="fa fa-times" onclick="sharjiToggleMenu()" aria-label="بستن منو"></i>
    </div>
    
    <div class="sharji-mob-menu">
        <?php if ( is_user_logged_in() ) : ?>
            <a href="<?php echo esc_url( wp_logout_url( home_url() ) ); ?>" style="color:#e31e24 !important;">
                <i class="fa fa-sign-out-alt"></i> خروج از حساب
            </a>
            <?php if ( function_exists('um_get_core_page') ) : ?>
                <a href="<?php echo esc_url( um_get_core_page('user') ); ?>">
                    <i class="fa fa-user-circle"></i> پروفایل من
                </a>
            <?php endif; ?>
        <?php else: ?>
            <a href="<?php echo function_exists('um_get_core_page') ? esc_url( um_get_core_page('login') ) : esc_url( home_url('/login') ); ?>" style="color:#0056b3 !important;">
                <i class="fa fa-sign-in-alt"></i> ورود / عضویت
            </a>
        <?php endif; ?>

        <div class="sharji-mob-menu-divider"></div>

        <a href="<?php echo esc_url( home_url() ); ?>">
            <i class="fa fa-home"></i> صفحه نخست
        </a>

        <a href="<?php echo esc_url( home_url('/category/news') ); ?>">
            <i class="fa fa-newspaper"></i> آخرین اخبار
        </a>

        <div class="sharji-mob-section-title">دسته‌بندی‌ها</div>

        <a href="<?php echo esc_url( home_url('/category/khuzestan') ); ?>">
            <i class="fa fa-map-marker-alt"></i> اخبار خوزستان
        </a>

        <a href="<?php echo esc_url( home_url('/category/social') ); ?>">
            <i class="fa fa-users"></i> اجتماعی
        </a>

        <a href="<?php echo esc_url( home_url('/category/tahlil') ); ?>">
            <i class="fa fa-chart-line"></i> تحلیل روز
        </a>

        <a href="<?php echo esc_url( home_url('/category/interviews') ); ?>">
            <i class="fa fa-microphone"></i> گفت‌وگو
        </a>

        <a href="<?php echo esc_url( home_url('/category/multimedia') ); ?>">
            <i class="fa fa-photo-video"></i> چندرسانه‌ای
        </a>

        <div class="sharji-mob-menu-divider"></div>

        <a href="<?php echo esc_url( home_url('/category/sport') ); ?>" style="color:#e31e24 !important;">
            <i class="fa fa-futbol"></i> شرجی اسپورت
        </a>

        <a href="https://www.varzesh3.com/livescore" target="_blank" rel="noopener noreferrer">
            <span class="sharji-dot"></span> نتایج زنده
        </a>

        <?php if ( current_user_can('um_custom_role_1') || current_user_can('administrator') || current_user_can('um_custom_role_3') ) : ?>
            <a href="<?php echo esc_url( home_url('/submit-news') ); ?>" style="color:#16a34a !important;">
                <i class="fa fa-paper-plane"></i> ارسال خبر
            </a>
        <?php endif; ?>

        <div class="sharji-mob-menu-divider"></div>

        <a href="<?php echo esc_url( home_url('/contact') ); ?>">
            <i class="fa fa-phone"></i> تماس با ما
        </a>

        <a href="<?php echo esc_url( home_url('/about-us') ); ?>">
            <i class="fa fa-info-circle"></i> درباره ما
        </a>

        <?php if ( current_user_can('administrator') || current_user_can('um_custom_role_3') ) : ?>
            <div class="sharji-mob-menu-divider"></div>
            <a href="<?php echo esc_url( admin_url() ); ?>" style="color:#16a34a !important;">
                <i class="fa fa-user-shield"></i> پنل مدیریت
            </a>
        <?php endif; ?>
    </div>
</div>

<!-- ======================== -->
<!-- هدر موبایل -->
<!-- ======================== -->
<div class="sharji-mob-bar">
    <div class="sharji-mob-icon" onclick="sharjiToggleMenu()" aria-label="باز کردن منو">
        <i class="fa fa-bars"></i>
    </div>

    <a href="<?php echo esc_url( home_url() ); ?>">
        <img src="<?php echo esc_url( home_url('/wp-content/uploads/2026/01/logosharjiback.webp') ); ?>" class="sharji-mob-logo" alt="شرجی پرس">
    </a>

    <div onclick="<?php echo is_user_logged_in() ? 'sharjiToggleMenu()' : "window.location.href='" . ( function_exists('um_get_core_page') ? esc_url( um_get_core_page('login') ) : esc_url( home_url('/login') ) ) . "'"; ?>" class="sharji-mob-icon" aria-label="حساب کاربری">
        <i class="fa fa-user-circle"></i>
    </div>
</div>

<!-- ======================== -->
<!-- هدر دسکتاپ -->
<!-- ======================== -->

<!-- نوار بالا -->
<div class="sharji-top-bar">
    <div class="sharji-wrapper">
        <div class="sharji-top-inner">
            <div class="sharji-top-group">
                <a href="<?php echo esc_url( home_url('/e-mag') ); ?>" class="sharji-top-btn">
                    <i class="fa fa-book"></i> مجله الکترونیکی
                </a>
                <a href="<?php echo esc_url( home_url('/prayer-times') ); ?>" class="sharji-top-btn">
                    <i class="fa fa-mosque"></i> اوقات شرعی
                </a>
                <a href="<?php echo esc_url( home_url('/weather') ); ?>" class="sharji-top-btn">
                    <i class="fa fa-cloud-sun"></i> هواشناسی
                </a>
            </div>
            
            <div class="sharji-top-group">
                <a href="<?php echo esc_url( home_url('/about-us') ); ?>" class="sharji-top-btn">درباره ما</a>
                <a href="<?php echo esc_url( home_url('/contact') ); ?>" class="sharji-top-btn">تماس با ما</a>
                
                <?php if ( is_user_logged_in() && function_exists('um_user') ) : ?>
                    <div class="sharji-dropdown">
                        <button class="sharji-top-btn" type="button">
                            <i class="fa fa-user-circle"></i>
                            <?php echo esc_html( um_user('display_name') ); ?>
                        </button>
                        <div class="sharji-drop-menu">
                            <?php if ( current_user_can('administrator') || current_user_can('um_custom_role_3') ) : ?>
                                <a href="<?php echo esc_url( admin_url() ); ?>" class="sharji-admin-link">
                                    <i class="fa fa-user-shield"></i> پنل مدیریت
                                </a>
                            <?php endif; ?>

                            <?php if ( function_exists('um_get_core_page') ) : ?>
                                <a href="https://sharjipress.ir/submit-news/"> 
                                <i class="fa fa-paper-plane"></i> ارسال خبر
                                </a>
                                <a href="<?php echo esc_url( um_get_core_page('user') ); ?>">
                                    <i class="fa fa-user"></i> پروفایل
                                </a>
                                <a href="<?php echo esc_url( um_get_core_page('account') ); ?>">
                                    <i class="fa fa-cog"></i> تنظیمات
                                </a>
                            <?php endif; ?>

                            <a href="<?php echo esc_url( wp_logout_url( home_url() ) ); ?>" class="sharji-logout-link">
                                <i class="fa fa-sign-out-alt"></i> خروج
                            </a>
                        </div>
                    </div>
                <?php else : ?>
                    <a href="<?php echo function_exists('um_get_core_page') ? esc_url( um_get_core_page('login') ) : esc_url( home_url('/login') ); ?>" class="sharji-top-btn">
                        ورود / عضویت
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- لوگو و بنر -->
<div class="sharji-logo-section">
    <div class="sharji-wrapper">
        <div class="sharji-logo-inner">
            <div class="sharji-banner">
                <?php if ( is_active_sidebar('header_ad_right') ) : dynamic_sidebar('header_ad_right'); endif; ?>
            </div>
            
            <a href="<?php echo esc_url( home_url() ); ?>" class="sharji-logo-wrap">
                <img src="<?php echo esc_url( home_url('/wp-content/uploads/2026/01/logosharjiok.png') ); ?>" class="sharji-logo" alt="شرجی پرس" width="340" height="180">
            </a>
            
            <div class="sharji-banner">
                <?php if ( is_active_sidebar('header_ad_left') ) : dynamic_sidebar('header_ad_left'); endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- نوار ناوبری + سرچ + شبکه‌های اجتماعی -->
<div class="sharji-navbar">
    <div class="sharji-wrapper">
        <div class="sharji-nav-inner">
            <div class="sharji-nav-links">
                <a href="<?php echo esc_url( home_url() ); ?>" class="sharji-nav-link">
                    <i class="fa fa-home" style="margin-left:6px;"></i> صفحه نخست
                </a>

                <a href="<?php echo esc_url( home_url('/category/news') ); ?>" class="sharji-nav-link">
                    آخرین اخبار
                </a>

                <div class="sharji-nav-cats">
                    <button type="button" class="sharji-nav-dd-btn">
                        دسته‌بندی
                        <i class="fa fa-chevron-down" style="font-size:10px;"></i>
                    </button>

                    <div class="sharji-nav-cat-menu">
                        <a href="<?php echo esc_url( home_url('/category/khuzestan') ); ?>">
                            <i class="fa fa-map-marker-alt"></i> اخبار خوزستان
                        </a>

                        <a href="<?php echo esc_url( home_url('/category/social') ); ?>">
                            <i class="fa fa-users"></i> اجتماعی
                        </a>

                        <a href="<?php echo esc_url( home_url('/category/tahlil') ); ?>">
                            <i class="fa fa-chart-line"></i> تحلیل روز
                        </a>

                        <a href="<?php echo esc_url( home_url('/category/interviews') ); ?>">
                            <i class="fa fa-microphone"></i> گفت‌وگو
                        </a>

                        <a href="<?php echo esc_url( home_url('/category/multimedia') ); ?>">
                            <i class="fa fa-photo-video"></i> چندرسانه‌ای
                        </a>
                    </div>
                </div>

                <a href="https://www.varzesh3.com/livescore" target="_blank" rel="noopener noreferrer" class="sharji-nav-link">
                    <span class="sharji-dot"></span> نتایج زنده
                </a>
                
                <a href="<?php echo esc_url( home_url('/category/sport') ); ?>" class="sharji-nav-link red">
                    <i class="fa fa-futbol" style="margin-left:6px;"></i> شرجی اسپورت
                </a>



                <?php if ( current_user_can('um_custom_role_1') || current_user_can('administrator') || current_user_can('um_custom_role_3') ) : ?>
                    <a href="<?php echo esc_url( home_url('/submit-news') ); ?>" class="sharji-nav-link red">
                        <i class="fa fa-paper-plane" style="margin-left:6px;"></i> ارسال خبر
                    </a>
                <?php endif; ?>
            </div>

            <div class="sharji-actions">
                <div class="sharji-socials">
                    <a href="https://t.me/sharjipress" target="_blank" rel="noopener noreferrer" class="sharji-soc-icon" title="تلگرام">
                        <img src="<?php echo esc_url( home_url('/wp-content/uploads/2026/01/telegram.png') ); ?>" alt="telegram">
                    </a>
                    <a href="https://www.instagram.com/sharjipress" target="_blank" rel="noopener noreferrer" class="sharji-soc-icon" title="اینستاگرام">
                        <img src="<?php echo esc_url( home_url('/wp-content/uploads/2026/01/instagram.png') ); ?>" alt="instagram">
                    </a>
                    <a href="https://chat.whatsapp.com/E85l09DTbdSJadirLy3YKw" target="_blank" rel="noopener noreferrer" class="sharji-soc-icon" title="واتساپ">
                        <img src="<?php echo esc_url( home_url('/wp-content/uploads/2026/01/whatsapp.png') ); ?>" alt="whatsapp">
                    </a>
                    <a href="https://ble.ir/sharjipress" target="_blank" rel="noopener noreferrer" class="sharji-soc-icon" title="بله">
                        <img src="<?php echo esc_url( home_url('/wp-content/uploads/2026/01/bale.png') ); ?>" alt="bale">
                    </a>
                    <a href="#" class="sharji-soc-icon" title="ایتا" onclick="return false;">
                        <img src="<?php echo esc_url( home_url('/wp-content/uploads/2026/01/Eitaa.png') ); ?>" alt="eitaa">
                    </a>
                </div>

                <form role="search" method="get" action="<?php echo esc_url( home_url('/') ); ?>" class="sharji-search">
                    <input type="text" id="sharjiSearchInput" name="s" placeholder="جستجو..." autocomplete="off">
                    <button type="submit" aria-label="جستجو">
                        <i class="fa fa-search"></i>
                    </button>
                    <div id="sharjiLiveResults" class="sharji-live-drop"></div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- تیکر -->
<div class="sharji-ticker">
    <div class="sharji-wrapper">
        <div class="sharji-ticker-inner">
            <div class="sharji-ticker-tag">
                <i class="fa fa-bolt"></i>
                خبر فوری
            </div>

            <div class="sharji-ticker-track">
                <div class="sharji-ticker-move">
                    <?php 
                    $recent = wp_get_recent_posts([
                        'numberposts' => 7,
                        'post_status' => 'publish'
                    ]);

                    foreach($recent as $post_item) { 
                        echo '<a href="' . esc_url( get_permalink($post_item['ID']) ) . '">' . esc_html( $post_item['post_title'] ) . '</a>'; 
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
