<?php
/* Template Name: Prayer Times (اوقات شرعی) */
get_header(); 

date_default_timezone_set('Asia/Tehran');

/*
|--------------------------------------------------------------------------
| شهرهای قابل نمایش
|--------------------------------------------------------------------------
| چون APIهای شهر‌یابی و پشتیبان قطع هستند، فعلاً شهرها از این لیست داخلی خوانده می‌شوند.
*/
$favorite_cities = [
    'آبادان'     => 'آبادان',
    'اهواز'      => 'اهواز',
    'خرمشهر'     => 'خرمشهر',
    'ماهشهر'     => 'ماهشهر',
    'دزفول'      => 'دزفول',
    'تهران'      => 'تهران',
    'اصفهان'     => 'اصفهان',
    'شیراز'      => 'شیراز',
    'مشهد'       => 'مشهد',
    'تبریز'      => 'تبریز',
];

/*
|--------------------------------------------------------------------------
| مختصات شهرها برای محاسبه داخلی اوقات
|--------------------------------------------------------------------------
*/
$city_coords = [
    'آبادان'  => ['lat' => 30.3392, 'lon' => 48.3043],
    'اهواز'   => ['lat' => 31.3183, 'lon' => 48.6706],
    'خرمشهر'  => ['lat' => 30.4397, 'lon' => 48.1664],
    'ماهشهر'  => ['lat' => 30.5589, 'lon' => 49.1981],
    'دزفول'   => ['lat' => 32.3831, 'lon' => 48.4236],
    'تهران'   => ['lat' => 35.6892, 'lon' => 51.3890],
    'اصفهان'  => ['lat' => 32.6546, 'lon' => 51.6680],
    'شیراز'   => ['lat' => 29.5918, 'lon' => 52.5837],
    'مشهد'    => ['lat' => 36.2605, 'lon' => 59.6168],
    'تبریز'   => ['lat' => 38.0962, 'lon' => 46.2738],
];

$city_query = isset($_GET['city_name']) ? sanitize_text_field($_GET['city_name']) : 'آبادان';

if (!array_key_exists($city_query, $favorite_cities)) {
    $city_query = 'آبادان';
}

$display_city = $city_query;
$lat = $city_coords[$display_city]['lat'];
$lon = $city_coords[$display_city]['lon'];

/*
|--------------------------------------------------------------------------
| ابزارهای کمکی برای تمیز کردن زمان
|--------------------------------------------------------------------------
*/
if (!function_exists('sharji_clean_prayer_time')) {
    function sharji_clean_prayer_time($time) {
        if (empty($time)) return '';

        $time = to_english_digits($time);
        $time = trim((string)$time);

        // حذف متن‌های اضافه مثل timezone یا توضیحات داخل پرانتز
        $time = preg_replace('/\s*\(.*?\)\s*/', '', $time);

        // گرفتن فقط HH:MM
        if (preg_match('/(\d{1,2})\s*:\s*(\d{2})/', $time, $m)) {
            $h = str_pad((int)$m[1], 2, '0', STR_PAD_LEFT);
            $i = str_pad((int)$m[2], 2, '0', STR_PAD_LEFT);
            return $h . ':' . $i;
        }

        return '';
    }
}

if (!function_exists('sharji_valid_prayer_time')) {
    function sharji_valid_prayer_time($time) {
        $time = sharji_clean_prayer_time($time);
        return !empty($time) && $time !== '00:00' && $time !== '--:--';
    }
}

if (!function_exists('sharji_get_any_key')) {
    function sharji_get_any_key($array, $keys) {
        if (!is_array($array)) return '';

        foreach ($keys as $key) {
            if (isset($array[$key]) && sharji_valid_prayer_time($array[$key])) {
                return sharji_clean_prayer_time($array[$key]);
            }
        }

        return '';
    }
}

/*
|--------------------------------------------------------------------------
| محاسبه داخلی اوقات شرعی با مختصات شهر
|--------------------------------------------------------------------------
| این بخش باعث می‌شود اگر API ناقص بود، طلوع، ظهر، غروب و نیمه‌شب خالی نماند.
*/
if (!function_exists('sharji_local_prayer_times')) {
    function sharji_local_prayer_times($lat, $lon) {
        $today_noon = strtotime(date('Y-m-d') . ' 12:00:00');
        $tomorrow_noon = strtotime('+1 day', $today_noon);

        $sun = date_sun_info($today_noon, $lat, $lon);
        $sun_tomorrow = date_sun_info($tomorrow_noon, $lat, $lon);

        $sunrise = !empty($sun['sunrise']) ? $sun['sunrise'] : null;
        $sunset  = !empty($sun['sunset']) ? $sun['sunset'] : null;
        $dhuhr   = !empty($sun['transit']) ? $sun['transit'] : null;

        // اذان صبح تقریبی بر اساس شروع شفق نجومی
        $fajr = !empty($sun['astronomical_twilight_begin']) ? $sun['astronomical_twilight_begin'] : null;

        if (!$fajr && $sunrise) {
            $fajr = $sunrise - (90 * 60);
        }

        // در ایران اذان مغرب معمولاً چند دقیقه بعد از غروب آفتاب است
        $maghrib = $sunset ? ($sunset + (18 * 60)) : null;

        // نیمه شب شرعی: میانه فاصله غروب تا اذان صبح فردا
        $tomorrow_fajr = !empty($sun_tomorrow['astronomical_twilight_begin']) ? $sun_tomorrow['astronomical_twilight_begin'] : null;

        if (!$tomorrow_fajr && !empty($sun_tomorrow['sunrise'])) {
            $tomorrow_fajr = $sun_tomorrow['sunrise'] - (90 * 60);
        }

        $midnight = null;
        if ($sunset && $tomorrow_fajr) {
            $midnight = $sunset + (($tomorrow_fajr - $sunset) / 2);
        }

        return [
            'اذان صبح'   => $fajr ? date('H:i', $fajr) : '',
            'طلوع آفتاب' => $sunrise ? date('H:i', $sunrise) : '',
            'اذان ظهر'   => $dhuhr ? date('H:i', $dhuhr) : '',
            'غروب آفتاب' => $sunset ? date('H:i', $sunset) : '',
            'اذان مغرب'  => $maghrib ? date('H:i', $maghrib) : '',
            'نیمه شب'    => $midnight ? date('H:i', $midnight) : '',
        ];
    }
}

$local_times = sharji_local_prayer_times($lat, $lon);

/*
|--------------------------------------------------------------------------
| تلاش برای گرفتن داده از API اصلی
|--------------------------------------------------------------------------
| اگر فقط بعضی زمان‌ها را داد، باقی زمان‌ها از محاسبه داخلی پر می‌شوند.
*/
$res = [];

$token = "993200:698267a3a1cb3";
$url = "https://one-api.ir/owghat/?token={$token}&city=" . urlencode($display_city);
$response = wp_remote_get($url, ['timeout' => 12]);

if (!is_wp_error($response)) {
    $body = json_decode(wp_remote_retrieve_body($response), true);

    if (isset($body['result']) && is_array($body['result'])) {
        $res = $body['result'];
    }
}

/*
|--------------------------------------------------------------------------
| یکپارچه‌سازی خروجی API و محاسبه داخلی
|--------------------------------------------------------------------------
*/
$api_times = [
    'اذان صبح' => sharji_get_any_key($res, [
        'azan_sobh', 'fajr', 'Fajr', 'اذان صبح', 'azan_sobh_time'
    ]),

    'طلوع آفتاب' => sharji_get_any_key($res, [
        'toloo_aftab', 'sunrise', 'Sunrise', 'طلوع آفتاب', 'tolu_aftab'
    ]),

    'اذان ظهر' => sharji_get_any_key($res, [
        'azan_zohr', 'dhuhr', 'Dhuhr', 'ظهر', 'اذان ظهر', 'zohr'
    ]),

    'غروب آفتاب' => sharji_get_any_key($res, [
        'ghoroob_aftab', 'sunset', 'Sunset', 'غروب آفتاب', 'ghoroub_aftab'
    ]),

    'اذان مغرب' => sharji_get_any_key($res, [
        'azan_maghreb', 'maghrib', 'Maghrib', 'اذان مغرب'
    ]),

    'نیمه شب' => sharji_get_any_key($res, [
        'nime_shabe_shari', 'midnight', 'Midnight', 'نیمه شب', 'nime_shab'
    ]),
];

$times = [];

foreach ($local_times as $label => $local_time) {
    if (!empty($api_times[$label]) && sharji_valid_prayer_time($api_times[$label])) {
        $times[$label] = $api_times[$label];
    } elseif (!empty($local_time) && sharji_valid_prayer_time($local_time)) {
        $times[$label] = $local_time;
    } else {
        $times[$label] = '--:--';
    }
}

/*
|--------------------------------------------------------------------------
| ذکر روز
|--------------------------------------------------------------------------
*/
$zekr_map = [
    'Saturday'  => 'یا رب العالمین',
    'Sunday'    => 'یا ذاالجلال و الاکرام',
    'Monday'    => 'یا قاضی الحاجات',
    'Tuesday'   => 'یا ارحم الراحمین',
    'Wednesday' => 'یا حی یا قیوم',
    'Thursday'  => 'لا اله الا الله الملک الحق المبین',
    'Friday'    => 'اللهم صل علی محمد و آل محمد'
];

$current_zekr = $zekr_map[date('l')] ?? '';
$full_date = date_i18n('l j F Y');

?>
<div class="prayer-page-wrapper">
    <main style="padding: 32px 0;">
        <div class="prayer-layout">
            
            <!-- سایدبار راست -->
            <aside class="city-sidebar">
                <div class="sidebar-label">جستجوی شهر</div>
                <form action="" method="GET" class="search-area">
                    <input type="text" id="citySearch" name="city_name" placeholder="نام شهر را بنویسید..." value="<?php echo esc_attr($city_query); ?>">
                    <button type="submit"><i class="fas fa-search"></i></button>
                </form>
                <div class="sidebar-sub-label">شهرهای برگزیده</div>
                <div class="city-list-scroll" id="cityList">
                    <?php foreach ($favorite_cities as $name): ?>
                        <a href="?city_name=<?php echo urlencode($name); ?>" class="city-link <?php echo ($display_city === $name) ? 'active' : ''; ?>">
                            <span><?php echo $name; ?></span>
                        </a>
                    <?php endforeach; ?>
                </div>
            </aside>

            <!-- مرکز -->
            <div class="prayer-main-content">
                <div class="sh-wrap">
                    <div class="sh-head">
                        <div class="date-badge">
                            <?php echo function_exists('to_farsi') ? to_farsi($full_date) : $full_date; ?>
                        </div>
                        <div class="zekr-text">ذکر امروز: <?php echo $current_zekr; ?></div>
                        <h1>اوقات شرعی <?php echo esc_html($display_city); ?></h1>
                        
                        <?php
                        // بررسی سلامت داده‌ها
                        $has_valid_data = false;
                        foreach ($times as $time) {
                            if ($time !== '--:--' && $time !== '00:00' && $time !== '۰۰:۰۰') {
                                $has_valid_data = true;
                                break;
                            }
                        }
                        
                        if (!$has_valid_data): ?>
                            <div class="error-message" style="margin-top: 15px;">
                                <i class="fas fa-exclamation-triangle"></i> 
                                خطا در دریافت اطلاعات اوقات شرعی. لطفاً شهر دیگری را امتحان کنید یا دقایقی دیگر تلاش نمایید.
                            </div>
                        <?php else: ?>
                            <div class="countdown-container" id="countdown-box" style="display: none;">
                                <span id="next-event-label" class="timer-label">در حال محاسبه...</span>
                                <div class="timer-val" id="next-event-timer">۰۰:۰۰:۰۰</div>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="sh-grid">
                        <?php foreach($times as $label => $time): 
                            $isValid = ($time !== '--:--' && $time !== '00:00' && $time !== '۰۰:۰۰');
                            $display_time = $isValid ? (function_exists('to_farsi') ? to_farsi($time) : $time) : '--:--';
                        ?>
                            <div class="sh-box <?php echo !$isValid ? 'no-data' : ''; ?>" data-label="<?php echo $label; ?>" data-time="<?php echo $isValid ? $time : '--:--'; ?>">
                                <span class="box-label"><?php echo $label; ?></span>
                                <strong class="box-time"><?php echo $display_time; ?></strong>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="footer-note">
                        شرجی پرس | نمایش دقیق اوقات شرعی به افق <?php echo esc_html($display_city); ?>
                    </div>
                </div>
            </div>

            <!-- سایدبار چپ -->
            <aside class="sidebar-left">
                <div class="suggestion-card">
                    <div class="suggestion-header">
                        <span>پیشنهاد شرجی</span><i class="fas fa-star text-yellow-400"></i>
                    </div>
                    <?php 
                    $sticky = get_option('sticky_posts');
                    $args = !empty($sticky) ? ['posts_per_page' => 3, 'post__in' => $sticky, 'ignore_sticky_posts' => 1] : ['posts_per_page' => 3, 'orderby' => 'rand'];
                    $editor_query = new WP_Query($args);
                    while($editor_query->have_posts()) : $editor_query->the_post(); ?>
                        <a href="<?php the_permalink(); ?>" class="suggestion-item">
                            <div class="suggestion-thumb">
                                <?php the_post_thumbnail('medium', ['class' => 'w-full h-full object-cover']); ?>
                            </div>
                            <h4 class="suggestion-title"><?php the_title(); ?></h4>
                            <p class="suggestion-excerpt"><?php echo wp_trim_words(get_the_excerpt(), 18, '...'); ?></p>
                        </a>
                    <?php endwhile; wp_reset_postdata(); ?>
                </div>
            </aside>

        </div>
    </main>
</div>

<?php get_footer(); ?>
