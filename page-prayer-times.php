<?php
/* Template Name: Prayer Times (اوقات شرعی) */
get_header(); 

if (!function_exists('to_farsi')) {
    function to_farsi($string) {
        $persian_num = array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹');
        $latin_num   = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
        return str_replace($latin_num, $persian_num, (string)$string);
    }
}

if (!function_exists('to_english_digits')) {
    function to_english_digits($string) {
        $persian_num = array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹');
        $latin_num   = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
        return str_replace($persian_num, $latin_num, (string)$string);
    }
}

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
<style>
    .prayer-page-wrapper {
        max-width: 1920px !important; margin: 0 auto !important; width: 100% !important;
        padding: 0 40px !important; direction: rtl !important; background: #f8fafc;
    }

    .prayer-layout { display: flex; flex-direction: column; gap: 32px; align-items: flex-start; }

    /* سایدبار راست - جستجوی شهر */
    .city-sidebar { 
        background: #fff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 15px; 
        position: sticky; top: 20px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); width: 100%;
    }
    .sidebar-label { font-weight: bold; color: #1e293b; margin-bottom: 12px; border-bottom: 1px solid #e2e8f0; padding-bottom: 8px; }
    .search-area { position: relative; margin-bottom: 15px; }
    .search-area input { width: 100%; border: 1px solid #e2e8f0; border-radius: 10px; padding: 10px 12px 10px 35px; font-size: 13px; outline: none; font-family: 'Vazirmatn', sans-serif; box-sizing: border-box; }
    .search-area button { position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: #0056b3; background: none; border: none; cursor: pointer; }
    .sidebar-sub-label { font-size: 12px; color: #94a3b8; margin-bottom: 8px; }
    .city-list-scroll { max-height: 400px; overflow-y: auto; scrollbar-width: thin; }
    .city-link { display: flex; justify-content: space-between; align-items: center; padding: 10px; margin-bottom: 4px; border-radius: 8px; color: #64748b; font-size: 14px; text-decoration: none; transition: 0.2s; border: 1px solid transparent; }
    .city-link:hover { background: #f8fafc; color: #0056b3; }
    .city-link.active { background: #0056b3; color: #fff; font-weight: bold; border-color: #0056b3; }

    /* مرکز */
    .prayer-main-content { flex: 1; min-width: 0; width: 100%; }
    .sh-wrap { background: rgba(255, 255, 255, 0.85); backdrop-filter: blur(15px); border: 1px solid rgba(255, 255, 255, 0.6); border-radius: 24px; overflow: hidden; box-shadow: 0 20px 40px -15px rgba(0, 86, 179, 0.15); }
    .sh-head { background: linear-gradient(135deg, #004494 0%, #002d5e 100%); color: #fff; padding: 25px 20px; text-align: center; position: relative; }
    .sh-head h1 { font-family: 'Diba', sans-serif !important; font-size: 30px !important; margin: 5px 0 !important; color: #fff !important; text-shadow: 0 2px 10px rgba(0,0,0,0.2); }
    .sh-head .date-badge { font-size: 12px; opacity: 0.9; margin-bottom: 8px; background: rgba(255,255,255,0.2); display: inline-block; padding: 4px 12px; border-radius: 9999px; }
    .sh-head .zekr-text { color: #fde047; font-weight: bold; margin-bottom: 12px; font-size: 18px; }
    
    .countdown-container { 
        background: rgba(255,255,255,0.15); border: 1px solid rgba(255,255,255,0.25); 
        border-radius: 12px; padding: 8px 20px; margin-top: 15px; display: inline-block; 
        box-shadow: 0 8px 32px rgba(0,0,0,0.1); 
    }
    .timer-val { font-family: 'Diba', sans-serif; font-size: 26px; direction: ltr; color: #fff; }
    .timer-label { display: block; font-size: 11px; margin-bottom: 4px; opacity: 0.9; color: #fff; font-weight: bold; }

    .sh-grid { 
        display: grid; 
        grid-template-columns: repeat(3, 1fr); 
        gap: 10px;
        padding: 15px;
    }
    .sh-box { 
        background: #fff; border: 1px solid #edf2f7; border-radius: 18px; 
        padding: 15px 5px; display: flex; flex-direction: column; align-items: center; 
        transition: 0.3s; position: relative; 
    }
    .sh-box .box-label { font-size: 12px; color: #94a3b8; font-weight: bold; margin-bottom: 8px; }
    .sh-box .box-time { font-size: 30px; color: #1e293b; font-weight: 900; }
    .sh-box.no-data { opacity: 0.4; }
    .sh-box.no-data .box-time { color: #94a3b8; font-size: 16px; }
    
    @keyframes pulse-green {
        0% { box-shadow: 0 0 0 0 rgba(34, 197, 94, 0.4); }
        70% { box-shadow: 0 0 0 15px rgba(34, 197, 94, 0); }
        100% { box-shadow: 0 0 0 0 rgba(34, 197, 94, 0); }
    }
    .sh-box.active { 
        border: 2px solid #22c55e; background: #f0fdf4; 
        transform: translateY(-5px); animation: pulse-green 2s infinite; z-index: 10;
    }
    .sh-box.active::after {
        content: 'رویداد بعدی'; position: absolute; top: -12px; 
        background: #22c55e; color: #fff; font-size: 10px; 
        padding: 3px 12px; border-radius: 20px; font-weight: bold;
    }

    /* سایدبار چپ */
    .sidebar-left { width: 100%; }
    .suggestion-card { background: #fff; border: 1px solid #e2e8f0; border-radius: 16px; overflow: hidden; position: sticky; top: 20px; }
    .suggestion-header { background: #0056b3; color: white; padding: 12px 15px; font-family: 'Diba', sans-serif; font-size: 14px; display: flex; justify-content: space-between; align-items: center; }
    .suggestion-item {
        display: flex; flex-direction: column; gap: 12px; padding: 16px;
        border-bottom: 1px solid #f8fafc; transition: background 0.3s; text-decoration: none;
    }
    .suggestion-item:hover { background: #f8fafc; }
    .suggestion-thumb {
        width: 100%; height: 96px; overflow: hidden; border-radius: 8px; background: #f1f5f9;
    }
    .suggestion-thumb img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.3s; }
    .suggestion-item:hover .suggestion-thumb img { transform: scale(1.05); }
    .suggestion-title {
        font-size: 14px; font-weight: bold; color: #1e293b; line-height: 1.5;
        font-family: 'Diba', sans-serif;
    }
    .suggestion-item:hover .suggestion-title { color: #b91c1c; }
    .suggestion-excerpt { font-size: 12px; color: #64748b; line-height: 1.25rem; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }

    .footer-note { padding: 12px; text-align: center; color: #94a3b8; font-size: 10px; border-top: 1px solid #f1f5f9; background: #f8fafc; font-style: italic; }
    
    .error-message {
        background: #fef2f2; border: 1px solid #fecaca; color: #991b1b;
        padding: 8px 16px; border-radius: 8px; font-size: 13px; margin-bottom: 15px;
        text-align: center;
    }

    @media (max-width: 1024px) {
        .prayer-page-wrapper { padding: 0 15px !important; }
        .sh-grid { grid-template-columns: 1fr 1fr; padding: 15px; }
        .city-list-scroll { display: flex; gap: 8px; overflow-x: auto; max-height: none; }
        .city-link { min-width: max-content; margin-bottom: 0; }
    }

    @media (min-width: 1025px) {
        .prayer-layout { flex-direction: row; }
        .city-sidebar { width: 256px; flex-shrink: 0; }
        .sidebar-left { width: 25%; flex-shrink: 0; }
    }
</style>

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

<script>
document.getElementById('citySearch').addEventListener('keyup', function() {
    let input = this.value.toLowerCase();
    let links = document.getElementById('cityList').getElementsByTagName('a');
    for (let i = 0; i < links.length; i++) {
        let span = links[i].getElementsByTagName("span")[0];
        if (span.innerHTML.toLowerCase().indexOf(input) > -1) { links[i].style.display = "flex"; } else { links[i].style.display = "none"; }
    }
});

(function() {
    function toFarsiJS(str) { return str.toString().replace(/\d/g, d => "۰۱۲۳۴۵۶۷۸۹"[d]); }
    function toEnglishDigits(str) {
        return str.toString().replace(/[۰-۹]/g, d => "۰۱۲۳۴۵۶۷۸۹".indexOf(d));
    }

    function updateTimer() {
        const boxes = document.querySelectorAll('.sh-box');
        const now = new Date();
        const tehranTime = new Intl.DateTimeFormat('en-US', {
            timeZone: 'Asia/Tehran',
            hour: 'numeric', minute: 'numeric', second: 'numeric',
            hour12: false
        });
        
        const parts = tehranTime.formatToParts(now);
        const h = parseInt(parts.find(p => p.type === 'hour').value);
        const m = parseInt(parts.find(p => p.type === 'minute').value);
        const s = parseInt(parts.find(p => p.type === 'second').value);
        const curSeconds = h * 3600 + m * 60 + s;
        
        let nextEvent = null;
        let minDiff = Infinity; 
        let firstEventOfDay = null;

        boxes.forEach((box, index) => {
            let rawTime = box.getAttribute('data-time');
            // رد کردن مقادیر نامعتبر
            if (!rawTime || rawTime === '--:--' || rawTime === '00:00' || rawTime === '۰۰:۰۰') return;
            
            let timeStr = toEnglishDigits(rawTime);
            let [th, tm] = timeStr.split(':').map(Number);
            
            if (isNaN(th) || isNaN(tm)) return;
            
            if (index === 5 && th < 4) { th += 24; }
            const eventSeconds = th * 3600 + tm * 60;
            
            if (index === 0) { 
                firstEventOfDay = { el: box, label: box.getAttribute('data-label'), seconds: eventSeconds }; 
            }
            
            let diff = eventSeconds - curSeconds;
            if (diff > 0 && diff < minDiff) {
                minDiff = diff;
                nextEvent = { el: box, label: box.getAttribute('data-label'), diff: diff };
            }
        });

        if (!nextEvent && firstEventOfDay) {
            let tomorrowDiff = (firstEventOfDay.seconds + 86400) - curSeconds;
            nextEvent = { el: firstEventOfDay.el, label: firstEventOfDay.label, diff: tomorrowDiff };
        }

        const countdownBox = document.getElementById('countdown-box');
        const labelEl = document.getElementById('next-event-label');
        const timerEl = document.getElementById('next-event-timer');
        
        boxes.forEach(b => b.classList.remove('active'));

        // فقط اگه دیتای معتبر داریم
        if (nextEvent && countdownBox && labelEl && timerEl) {
            nextEvent.el.classList.add('active');
            countdownBox.style.display = 'inline-block';
            labelEl.innerText = 'مانده تا ' + nextEvent.label;
            
            let hours = Math.floor(nextEvent.diff / 3600);
            let minutes = Math.floor((nextEvent.diff % 3600) / 60);
            let seconds = Math.floor(nextEvent.diff % 60);
            
            let timeString = hours.toString().padStart(2, '0') + ':' + minutes.toString().padStart(2, '0') + ':' + seconds.toString().padStart(2, '0');
            timerEl.innerText = toFarsiJS(timeString);
        } else if (countdownBox) {
            countdownBox.style.display = 'none';
        }
    }

    // فقط اگه دیتای معتبر داریم تایمر رو اجرا کن
    let hasData = false;
    document.querySelectorAll('.sh-box').forEach(box => {
        let time = box.getAttribute('data-time');
        if (time && time !== '--:--' && time !== '00:00' && time !== '۰۰:۰۰') {
            hasData = true;
        }
    });

    if (hasData) {
        setInterval(updateTimer, 1000);
        updateTimer();
    }
})();
</script>

<?php get_footer(); ?>