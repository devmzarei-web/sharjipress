<!DOCTYPE html>
<html <?php language_attributes(); ?> dir="rtl">
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>شرجی اسپورت | <?php wp_title('', true); ?></title>
    
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<?php
if (!function_exists('to_farsi_local')) {
    function to_farsi_local($number) {
        $persian_digits = array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹');
        $english_digits = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
        return str_replace($english_digits, $persian_digits, (string)$number);
    }
}

if (!function_exists('sharji_gregorian_to_jalali')) {
    function sharji_gregorian_to_jalali($gy, $gm, $gd) {
        $g_d_m = [0, 31, 59, 90, 120, 151, 181, 212, 243, 273, 304, 334];

        if ($gy > 1600) {
            $jy = 979;
            $gy -= 1600;
        } else {
            $jy = 0;
            $gy -= 621;
        }

        $gy2 = ($gm > 2) ? ($gy + 1) : $gy;

        $days = (365 * $gy)
            + intval(($gy2 + 3) / 4)
            - intval(($gy2 + 99) / 100)
            + intval(($gy2 + 399) / 400)
            - 80
            + $gd
            + $g_d_m[$gm - 1];

        $jy += 33 * intval($days / 12053);
        $days %= 12053;

        $jy += 4 * intval($days / 1461);
        $days %= 1461;

        if ($days > 365) {
            $jy += intval(($days - 1) / 365);
            $days = ($days - 1) % 365;
        }

        if ($days < 186) {
            $jm = 1 + intval($days / 31);
            $jd = 1 + ($days % 31);
        } else {
            $jm = 7 + intval(($days - 186) / 30);
            $jd = 1 + (($days - 186) % 30);
        }

        return [$jy, $jm, $jd];
    }
}

if (!function_exists('sharji_sport_jalali_date')) {
    function sharji_sport_jalali_date() {
        $timestamp = current_time('timestamp');

        $gy = (int) date('Y', $timestamp);
        $gm = (int) date('n', $timestamp);
        $gd = (int) date('j', $timestamp);
        $weekday_index = (int) date('w', $timestamp);

        [$jy, $jm, $jd] = sharji_gregorian_to_jalali($gy, $gm, $gd);

        $weekdays = [
            'یکشنبه',
            'دوشنبه',
            'سه‌شنبه',
            'چهارشنبه',
            'پنجشنبه',
            'جمعه',
            'شنبه',
        ];

        $months = [
            1  => 'فروردین',
            2  => 'اردیبهشت',
            3  => 'خرداد',
            4  => 'تیر',
            5  => 'مرداد',
            6  => 'شهریور',
            7  => 'مهر',
            8  => 'آبان',
            9  => 'آذر',
            10 => 'دی',
            11 => 'بهمن',
            12 => 'اسفند',
        ];

        return to_farsi_local($weekdays[$weekday_index] . ' ' . $jd . ' ' . $months[$jm] . ' ' . $jy);
    }
}
?>

<!-- Overlay موبایل -->
<div class="mobile-overlay" id="mobileOverlay" onclick="toggleSportMenu()"></div>

<!-- پنل موبایل -->
<div class="mobile-panel" id="mobilePanel">
    <div class="mobile-panel-head">
        <span>منوی دسترسی</span>
        <button onclick="toggleSportMenu()" aria-label="بستن منو"><i class="fas fa-times"></i></button>
    </div>

    <div class="mobile-panel-body">
        <a href="<?php echo esc_url( home_url('/category/sport') ); ?>">
            <span class="font-sport" style="font-size: 24px; color: #fff;">شرجی <span style="color: #3b82f6;">اسپورت</span></span>
        </a>
        <a href="https://sharjipress.ir">شرجی پرس</a
        <a href="<?php echo esc_url( home_url('/league-table') ); ?>">جدول لیگ برتر</a>
        <a href="#">جام حذفی</a>
        <a href="#">چند رسانه ای</a>
        <a href="<?php echo esc_url( home_url('/newspapers') ); ?>">روزنامه</a>
        <a href="#">جام جهانی</a>
        <a href="https://www.anten.ir/" target="_blank" style="color: #60a5fa;">
            <span style="display: inline-block; width: 6px; height: 6px; background: #3b82f6; border-radius: 50%; margin-left: 8px; animation: pulse 2s infinite;"></span> پخش زنده
        </a>
        <a href="<?php echo esc_url( home_url('/wlivescores') ); ?>" style="margin-top: 16px; border: 1px solid rgba(37, 99, 235, 0.3); color: #60a5fa; text-align: center; font-weight: bold;">
            <i class="far fa-futbol" style="margin-left: 4px;"></i> نتایج زنده جهان
        </a>
    </div>
</div>

<!-- ==================== هدر ==================== -->
<header class="sport-header">

    <!-- نوار تاریخ و بازگشت -->
    <div class="sport-top-strip">
        <div class="sport-top-strip-inner">
            <span class="sport-date-pill">
                <i class="far fa-calendar-alt"></i>
                <?php echo esc_html( sharji_sport_jalali_date() ); ?>
            </span>

            <a href="<?php echo esc_url( home_url() ); ?>" class="sport-back-btn">
                <span>بازگشت به سایت اصلی</span>
                <i class="fas fa-arrow-left"></i>
            </a>
        </div>
    </div>

    <!-- بخش اصلی -->
    <div class="sport-header-inner">
        <div style="display: flex; align-items: center; gap: 16px;">
            <button class="sport-mobile-toggle" onclick="toggleSportMenu()" aria-label="باز کردن منو">
                <i class="fas fa-bars"></i>
            </button>

            <a href="<?php echo esc_url( home_url('/category/sport') ); ?>" class="sport-logo">
                <div class="sport-logo-icon">S</div>
                <div class="sport-logo-text">
                    <h1>شرجی <span>اسپورت</span></h1>
                </div>
            </a>

            <nav class="sport-nav">
                <a href="https://sharjipress.ir">شرجی پرس</a>
                <a href="<?php echo esc_url( home_url('/league-table') ); ?>">جدول لیگ برتر</a>
                <a href="#">جام حذفی</a>
                <a href="#">چند رسانه ای</a>
                <a href="<?php echo esc_url( home_url('/newspapers') ); ?>">روزنامه</a>
                <a href="#">جام جهانی</a>
                <a href="https://www.anten.ir/" target="_blank" class="live-link">
                    <span style="display: inline-block; width: 6px; height: 6px; background: #3b82f6; border-radius: 50%; animation: pulse 2s infinite;"></span>
                    پخش زنده
                </a>
            </nav>
        </div>

        <div style="display: flex; align-items: center; gap: 16px;">
            <a href="<?php echo esc_url( home_url('/wlivescores') ); ?>" class="sport-live-btn">
                <i class="far fa-futbol"></i> نتایج زنده جهان
            </a>
            <button class="sport-search-btn" aria-label="جستجو"><i class="fas fa-search"></i></button>
        </div>
    </div>

    <!-- نوار بازی‌ها -->
    <div class="fixture-strip">
        <div class="fixture-fade-left"></div>

        <div class="fixture-strip-inner">
            <div class="fixture-label">
                <span></span>
                <span>بازی‌های مهم:</span>
            </div>

            <div class="fixture-swiper-wrap">
                <div class="swiper fixture-swiper" style="height: 100%;">
                    <div class="swiper-wrapper">
                        <?php
                        $fixtures_query = new WP_Query([
                            'post_type'      => 'fixtures',
                            'posts_per_page' => 20,
                            'orderby'        => 'menu_order', 
                            'order'          => 'ASC'
                        ]);

                        if($fixtures_query->have_posts()):
                            while($fixtures_query->have_posts()): $fixtures_query->the_post();
                                $host     = get_post_meta(get_the_ID(), '_fixture_host', true);
                                $guest    = get_post_meta(get_the_ID(), '_fixture_guest', true);
                                $time_val = get_post_meta(get_the_ID(), '_fixture_time', true);
                                $date_val = get_post_meta(get_the_ID(), '_fixture_date', true);
                                $status   = get_post_meta(get_the_ID(), '_fixture_status', true);
                                $link     = get_post_meta(get_the_ID(), '_fixture_link', true);
                                
                                $time_val = to_farsi_local($time_val);
                                $date_val = to_farsi_local($date_val);

                                $status_class = 'text-gray-400';
                                $time_class   = 'upcoming';
                                
                                if($status === 'live') {
                                    $status_class = 'text-green-400 font-bold';
                                    $time_class = 'live';
                                    $date_val = 'در جریان';
                                } elseif($status === 'end') {
                                    $status_class = 'text-gray-500';
                                    $time_class = 'end';
                                }
                        ?>
                            <div class="swiper-slide" style="width: auto;">
                                <a href="<?php echo $link ? esc_url($link) : '#'; ?>" class="fixture-item" <?php echo !$link ? 'style="cursor: default;"' : ''; ?>>
                                    <div style="display: flex; flex-direction: column; align-items: center; margin-left: 16px; min-width: 45px;">
                                        <span class="time-badge <?php echo esc_attr($time_class); ?>"><?php echo esc_html($time_val); ?></span>
                                        <span style="font-size: 11px; color: #9ca3af; font-weight: 500;"><?php echo esc_html($date_val); ?></span>
                                    </div>

                                    <div style="display: flex; align-items: center; gap: 12px;" class="<?php echo esc_attr($status_class); ?>">
                                        <span><?php echo esc_html($host); ?></span>
                                        <span style="font-size: 10px; color: #4b5563; font-weight: bold;">VS</span>
                                        <span><?php echo esc_html($guest); ?></span>
                                    </div>
                                </a>
                            </div>
                        <?php 
                            endwhile; 
                            wp_reset_postdata();
                        else: 
                        ?>
                            <div class="swiper-slide" style="font-size: 12px; color: #6b7280; padding: 16px 8px;">بازی مهمی تعریف نشده است.</div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
