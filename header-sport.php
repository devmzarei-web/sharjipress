<!DOCTYPE html>
<html <?php language_attributes(); ?> dir="rtl">
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>شرجی اسپورت | <?php wp_title('', true); ?></title>
    
    <?php wp_head(); ?>
    
    <!-- Swiper CSS - Local -->
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/swiper-bundle.min.css" />
    
    <!-- Font Awesome - Local -->
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/fontawesome.min.css" />
    
    <style>
        @font-face {
            font-family: 'Diba';
            src: url('<?php echo get_template_directory_uri(); ?>/fonts/Diba.woff2') format('woff2');
            font-weight: bold;
            font-style: normal;
            font-display: swap;
        }

        @font-face {
            font-family: 'Vazirmatn';
            src: url('<?php echo get_template_directory_uri(); ?>/fonts/Vazirmatn.woff2') format('woff2');
            font-weight: normal;
            font-style: normal;
            font-display: swap;
        }
        
        :root {
            --bg-dark: #0f172a;
            --bg-card: #1e293b;
            --bg-soft: #111827;
            --accent: #3b82f6;
            --accent-dark: #2563eb;
            --accent-sky: #38bdf8;
            --border-dark: #334155;
            --text-main: #f3f4f6;
            --text-muted: #9ca3af;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            background:
                radial-gradient(circle at top right, rgba(37, 99, 235, 0.12), transparent 34%),
                radial-gradient(circle at bottom left, rgba(14, 165, 233, 0.08), transparent 30%),
                var(--bg-dark);
            color: var(--text-main);
            font-family: 'Vazirmatn', sans-serif;
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }

        .font-sport {
            font-family: 'Diba', 'Vazirmatn', sans-serif;
            letter-spacing: -0.5px;
        }
        
        a {
            text-decoration: none;
            color: inherit;
        }
        
        /* ========== هدر اصلی ========== */
        .sport-header {
            background:
                linear-gradient(180deg, rgba(15, 23, 42, 0.98), rgba(17, 24, 39, 0.96));
            border-bottom: 1px solid rgba(51, 65, 85, 0.85);
            position: sticky;
            top: 0;
            z-index: 50;
            box-shadow: 0 18px 45px rgba(0, 0, 0, 0.25);
            backdrop-filter: blur(12px);
        }
        
        /* نوار بالایی تاریخ و بازگشت */
        .sport-top-strip {
            background:
                radial-gradient(circle at left center, rgba(59, 130, 246, 0.18), transparent 34%),
                linear-gradient(135deg, #0b1120 0%, #111827 45%, #172554 100%);
            font-size: 12px;
            color: #cbd5e1;
            border-bottom: 1px solid rgba(51, 65, 85, 0.7);
        }

        .sport-top-strip-inner {
            max-width: 1600px;
            margin: 0 auto;
            padding: 8px 16px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
        }

        .sport-date-pill {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: #cbd5e1;
            white-space: nowrap;
        }

        .sport-date-pill i {
            color: #60a5fa;
            font-size: 13px;
        }

        .sport-back-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(59, 130, 246, 0.13);
            border: 1px solid rgba(96, 165, 250, 0.35);
            color: #fff;
            padding: 7px 13px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 800;
            box-shadow: 0 8px 22px rgba(37, 99, 235, 0.14);
            transition: all 0.25s ease;
            white-space: nowrap;
            direction: rtl;
        }

        .sport-back-btn i {
            font-size: 11px;
            color: #93c5fd;
            margin-right: 2px;
        }

        .sport-back-btn:hover {
            background: linear-gradient(135deg, #2563eb, #0ea5e9);
            border-color: rgba(147, 197, 253, 0.65);
            color: #fff;
            transform: translateY(-1px);
        }
        
        /* بخش اصلی هدر */
        .sport-header-inner {
            max-width: 1600px;
            margin: 0 auto;
            padding: 0 16px;
            height: 68px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        
        /* لوگو */
        .sport-logo {
            display: flex;
            align-items: center;
            gap: 12px;
            min-width: max-content;
        }

        .sport-logo-icon {
            width: 42px;
            height: 42px;
            display: flex;
            align-items: center;
            justify-content: center;
            background:
                radial-gradient(circle at top right, rgba(255,255,255,0.22), transparent 36%),
                linear-gradient(135deg, #2563eb, #1e40af);
            border-radius: 12px;
            color: #fff;
            font-weight: 900;
            font-size: 20px;
            flex-shrink: 0;
            box-shadow: 0 12px 26px rgba(37, 99, 235, 0.25);
            border: 1px solid rgba(147, 197, 253, 0.20);
        }

        .sport-logo-text {
            display: none;
            flex-direction: column;
        }

        .sport-logo-text h1 {
            font-family: 'Diba', 'Vazirmatn', sans-serif;
            font-size: 25px;
            color: #fff;
            line-height: 1;
            letter-spacing: -0.5px;
        }

        .sport-logo-text h1 span {
            color: #3b82f6;
        }
        
        /* منوی دسکتاپ */
        .sport-nav {
            display: none;
            gap: 20px;
            font-size: 13px;
            font-weight: 600;
            color: #9ca3af;
        }

        .sport-nav a {
            padding: 23px 0;
            transition: color 0.3s;
            white-space: nowrap;
            position: relative;
        }

        .sport-nav a::after {
            content: "";
            position: absolute;
            right: 0;
            bottom: 15px;
            width: 0;
            height: 2px;
            background: #3b82f6;
            border-radius: 999px;
            transition: width 0.25s ease;
        }

        .sport-nav a:hover {
            color: #fff;
        }

        .sport-nav a:hover::after {
            width: 100%;
        }

        .sport-nav a.live-link {
            color: #60a5fa;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }
        
        /* دکمه نتایج زنده */
        .sport-live-btn {
            display: none;
            align-items: center;
            gap: 8px;
            background: linear-gradient(135deg, #2563eb, #0ea5e9);
            color: #fff;
            font-size: 12px;
            padding: 9px 16px;
            border-radius: 9999px;
            font-weight: bold;
            transition: all 0.3s;
            white-space: nowrap;
            box-shadow: 0 10px 24px rgba(37, 99, 235, 0.24);
            border: 1px solid rgba(147, 197, 253, 0.20);
        }

        .sport-live-btn:hover {
            background: linear-gradient(135deg, #1d4ed8, #0284c7);
            transform: translateY(-1px);
        }
        
        /* دکمه جستجو */
        .sport-search-btn {
            color: #9ca3af;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s;
            background: rgba(255,255,255,0.04);
            border: 1px solid rgba(148, 163, 184, 0.16);
            width: 38px;
            height: 38px;
            border-radius: 999px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .sport-search-btn:hover {
            color: #fff;
            background: rgba(59, 130, 246, 0.18);
            border-color: rgba(96, 165, 250, 0.32);
        }
        
        /* دکمه موبایل */
        .sport-mobile-toggle {
            background: rgba(255,255,255,0.04);
            border: 1px solid rgba(148, 163, 184, 0.16);
            color: #fff;
            font-size: 18px;
            cursor: pointer;
            width: 38px;
            height: 38px;
            border-radius: 999px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        /* ========== نوار بازی‌ها ========== */
        .fixture-strip {
            background:
                linear-gradient(90deg, #1e293b 0%, #0f172a 100%);
            border-top: 1px solid rgba(51, 65, 85, 0.5);
            border-bottom: 1px solid #334155;
            height: 50px;
            position: relative;
            overflow: hidden;
        }

        .fixture-strip-inner {
            max-width: 1600px;
            margin: 0 auto;
            padding: 0 16px;
            display: flex;
            align-items: center;
            height: 100%;
            position: relative;
        }

        .fixture-label {
            display: flex;
            align-items: center;
            height: 100%;
            padding-left: 16px;
            margin-left: 8px;
            border-left: 1px solid rgba(55, 65, 81, 0.5);
            background: #111827;
            z-index: 30;
            position: relative;
            flex-shrink: 0;
        }

        .fixture-label span:first-child {
            width: 6px;
            height: 6px;
            background: #3b82f6;
            border-radius: 50%;
            margin-left: 8px;
            animation: pulse 2s infinite;
        }

        .fixture-label span:last-child {
            font-size: 12px;
            font-weight: bold;
            color: #fff;
            white-space: nowrap;
        }
        
        .fixture-swiper-wrap {
            flex: 1;
            height: 100%;
            overflow: hidden;
        }
        
        .fixture-item {
            display: inline-flex;
            align-items: center;
            padding: 0 20px;
            border-left: 1px solid rgba(255,255,255,0.05);
            transition: background 0.2s;
            font-size: 13px;
            height: 50px;
            text-decoration: none;
            color: inherit;
        }

        .fixture-item:hover {
            background: rgba(255,255,255,0.03);
        }

        .fixture-item .time-badge {
            font-size: 10px;
            font-weight: bold;
            padding: 2px 8px;
            border-radius: 4px;
            margin-bottom: 4px;
            display: inline-block;
        }

        .fixture-item .time-badge.upcoming {
            background: #374151;
            color: #d1d5db;
        }

        .fixture-item .time-badge.live {
            background: #dc2626;
            color: #fff;
            animation: pulse 2s infinite;
        }

        .fixture-item .time-badge.end {
            background: #1f2937;
            color: #4b5563;
        }
        
        .fixture-fade-left {
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 50px;
            background: linear-gradient(to right, #0f172a, transparent);
            z-index: 20;
            pointer-events: none;
        }
        
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }
        
        /* ========== منوی موبایل ========== */
        .mobile-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.8);
            z-index: 60;
            display: none;
            opacity: 0;
            transition: opacity 0.3s;
        }

        .mobile-overlay.show {
            display: block;
            opacity: 1;
        }
        
        .mobile-panel {
            position: fixed;
            top: 0;
            right: -280px;
            width: 280px;
            height: 100%;
            background: #111827;
            z-index: 70;
            transition: transform 0.3s;
            border-left: 1px solid #374151;
            display: flex;
            flex-direction: column;
        }

        .mobile-panel.open {
            transform: translateX(-280px);
        }

        .mobile-panel-head {
            padding: 20px;
            border-bottom: 1px solid #374151;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #0f172a;
        }

        .mobile-panel-head span {
            font-family: 'Diba', 'Vazirmatn', sans-serif;
            font-size: 20px;
            color: #fff;
        }

        .mobile-panel-head button {
            background: none;
            border: none;
            color: #9ca3af;
            font-size: 20px;
            cursor: pointer;
        }

        .mobile-panel-body {
            flex: 1;
            overflow-y: auto;
            padding: 16px;
        }

        .mobile-panel-body a {
            display: block;
            padding: 12px;
            border-radius: 8px;
            color: #d1d5db;
            transition: background 0.3s;
            margin-bottom: 4px;
        }

        .mobile-panel-body a:hover {
            background: #1f2937;
        }
        
        /* ========== رسپانسیو ========== */
        @media (max-width: 640px) {
            .sport-top-strip-inner {
                padding: 7px 10px;
            }

            .sport-date-pill {
                font-size: 10.5px;
                gap: 6px;
            }

            .sport-back-btn {
                padding: 6px 10px;
                font-size: 11px;
            }

            .sport-header-inner {
                height: 62px;
                padding: 0 10px;
            }

            .sport-logo-icon {
                width: 38px;
                height: 38px;
                border-radius: 10px;
            }

            .fixture-strip-inner {
                padding: 0 10px;
            }

            .fixture-item {
                padding: 0 14px;
            }
        }

        @media (min-width: 641px) {
            .sport-logo-text {
                display: flex;
            }
        }

        @media (min-width: 769px) {
            .sport-live-btn {
                display: inline-flex;
            }
        }

        @media (min-width: 1025px) {
            .sport-nav {
                display: flex;
            }

            .sport-mobile-toggle {
                display: none;
            }
        }
    </style>
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

<!-- Swiper JS - Local -->
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/swiper-bundle.min.js"></script>

<script>
    function toggleSportMenu() {
        document.getElementById('mobilePanel').classList.toggle('open');
        document.getElementById('mobileOverlay').classList.toggle('show');
        document.body.style.overflow = document.body.style.overflow === 'hidden' ? '' : 'hidden';
    }

    document.addEventListener('DOMContentLoaded', function () {
        new Swiper(".fixture-swiper", {
            slidesPerView: "auto",
            spaceBetween: 0,
            freeMode: true,
            grabCursor: true,
            loop: false,
            autoplay: {
                delay: 3000,
                disableOnInteraction: false,
                pauseOnMouseEnter: true,
            },
            speed: 800,
        });
    });
</script>