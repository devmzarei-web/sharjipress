<?php
/* Template Name: Weather Page */
get_header(); 

date_default_timezone_set('Asia/Tehran');

$favorite_cities = [
    'abadan'      => ['name' => 'آبادان',      'lat' => 30.33, 'lon' => 48.30],
    'ahvaz'       => ['name' => 'اهواز',       'lat' => 31.31, 'lon' => 48.67],
    'khorramshahr'=> ['name' => 'خرمشهر',      'lat' => 30.43, 'lon' => 48.16],
    'mahshahr'    => ['name' => 'ماهشهـر',     'lat' => 30.56, 'lon' => 49.18],
    'dezful'      => ['name' => 'دزفول',       'lat' => 32.38, 'lon' => 48.40],
    'tehran'      => ['name' => 'تهران',       'lat' => 35.68, 'lon' => 51.38],
    'isfahan'     => ['name' => 'اصفهان',      'lat' => 32.65, 'lon' => 51.66],
    'shiraz'      => ['name' => 'شیراز',       'lat' => 29.59, 'lon' => 52.58],
    'mashhad'     => ['name' => 'مشهد',        'lat' => 36.31, 'lon' => 59.56],
    'tabriz'      => ['name' => 'تبریز',       'lat' => 38.08, 'lon' => 46.29],
    'bandarabbas' => ['name' => 'بندرعباس',    'lat' => 27.18, 'lon' => 56.26],
];

$search_query = isset($_GET['city']) ? sanitize_text_field($_GET['city']) : 'abadan';
$active_city_data = [];

if (array_key_exists($search_query, $favorite_cities)) {
    $active_city_data = $favorite_cities[$search_query];
} else {
    $encoded_city = urlencode($search_query);
    $geo_url = "https://geocoding-api.open-meteo.com/v1/search?name={$encoded_city}&count=1&language=fa&format=json";
    
    $geo_response = wp_remote_get($geo_url);
    if (!is_wp_error($geo_response)) {
        $geo_body = json_decode(wp_remote_retrieve_body($geo_response), true);
        if (isset($geo_body['results'][0])) {
            $result = $geo_body['results'][0];
            $active_city_data = [
                'name' => $result['name'],
                'lat'  => $result['latitude'],
                'lon'  => $result['longitude']
            ];
        }
    }
}

if (empty($active_city_data)) {
    $active_city_data = $favorite_cities['abadan'];
    $search_query = 'abadan';
}

$lat = $active_city_data['lat'];
$lon = $active_city_data['lon'];
$weather_url = "https://api.open-meteo.com/v1/forecast?latitude={$lat}&longitude={$lon}&current=temperature_2m,relative_humidity_2m,apparent_temperature,weather_code,wind_speed_10m&hourly=temperature_2m,weather_code&daily=weather_code,temperature_2m_max,temperature_2m_min,sunrise,sunset&timezone=Asia%2FTehran";

$response = wp_remote_get($weather_url);
$data = (!is_wp_error($response)) ? json_decode(wp_remote_retrieve_body($response), true) : [];

function get_weather_desc($code) {
    $codes = [
        0 => 'آسمان صاف', 1 => 'عمدتاً صاف', 2 => 'نیمه ابری', 3 => 'ابری کامل',
        45 => 'مه‌آلود', 51 => 'نم‌نم باران', 61 => 'باران ملایم', 80 => 'رگبار باران',
        95 => 'رعد و برق', 96 => 'تگرگ', 99 => 'تگرگ شدید'
    ];
    return $codes[$code] ?? 'شرایط متغیر';
}
?>

<div class="weather-page-wrapper">
    
    <aside class="city-sidebar">
        <form action="" method="get" class="search-box">
            <input type="text" name="city" class="search-input" placeholder="جستجوی شهر..." value="<?php echo isset($_GET['city']) ? esc_attr($_GET['city']) : ''; ?>">
            <button type="submit" class="search-btn-icon"><i class="fas fa-search"></i></button>
        </form>

        <div class="sidebar-label">دسترسی سریع</div>
        
        <div class="cities-list-container">
            <?php foreach ($favorite_cities as $slug => $info): ?>
                <a href="?city=<?php echo $slug; ?>" 
                   class="city-link <?php echo ($search_query === $slug) ? 'active' : ''; ?>">
                    <span><?php echo $info['name']; ?></span>
                    <?php if($search_query === $slug): ?><i class="fas fa-check text-xs"></i><?php endif; ?>
                </a>
            <?php endforeach; ?>
        </div>
    </aside>

    <main class="weather-main">
        <?php if ($data): ?>
            <div class="w-main-card">
                <span class="date"><?php echo to_farsi(date_i18n('l j F Y')); ?></span>
                <h1>وضعیت هوای <?php echo esc_html($active_city_data['name']); ?></h1>
                
                <span class="w-temp-now"><?php echo to_farsi(round($data['current']['temperature_2m'])); ?>°C</span>
                <span class="w-desc-now"><?php echo get_weather_desc($data['current']['weather_code']); ?></span>
                
                <div class="w-extra-info">
                    <div class="info-item">
                        <span><i class="fas fa-thermometer-half"></i> دمای احساسی</span>
                        <strong><?php echo to_farsi(round($data['current']['apparent_temperature'])); ?>°</strong>
                    </div>
                    <div class="info-item">
                        <span><i class="fas fa-tint"></i> رطوبت هوا</span>
                        <strong><?php echo to_farsi($data['current']['relative_humidity_2m']); ?>%</strong>
                    </div>
                    <div class="info-item">
                        <span><i class="fas fa-wind"></i> سرعت باد</span>
                        <strong><?php echo to_farsi($data['current']['wind_speed_10m']); ?> <span style="font-size:14px">km/h</span></strong>
                    </div>
                </div>
            </div>

            <div class="section-title">پیش‌بینی ۲۴ ساعت آینده</div>
            <div class="h-scroll">
                <?php for($i=0; $i<24; $i++): 
                    $time_str = $data['hourly']['time'][$i];
                    $time = date('H:i', strtotime($time_str));
                ?>
                    <div class="h-card">
                        <span><?php echo to_farsi($time); ?></span>
                        <strong><?php echo to_farsi(round($data['hourly']['temperature_2m'][$i])); ?>°</strong>
                    </div>
                <?php endfor; ?>
            </div>

            <div class="section-title">پیش‌بینی ۷ روز آینده</div>
            <div class="d-list">
                <?php for($i=0; $i<7; $i++): 
                    $d_name = ($i==0) ? 'امروز' : date_i18n('l', strtotime($data['daily']['time'][$i]));
                ?>
                    <div class="d-row">
                        <span class="d-name"><?php echo to_farsi($d_name); ?></span>
                        <span class="d-status"><?php echo get_weather_desc($data['daily']['weather_code'][$i]); ?></span>
                        <div>
                            <span class="t-max" title="حداکثر دما"><i class="fas fa-arrow-up text-xs ml-1"></i><?php echo to_farsi(round($data['daily']['temperature_2m_max'][$i])); ?>°</span>
                            <span class="t-min" title="حداقل دما"><i class="fas fa-arrow-down text-xs ml-1"></i><?php echo to_farsi(round($data['daily']['temperature_2m_min'][$i])); ?>°</span>
                        </div>
                    </div>
                <?php endfor; ?>
            </div>

        <?php else: ?>
            <div class="weather-error-card">
                <i class="fas fa-cloud-showers-heavy"></i>
                <h3>اطلاعات یافت نشد</h3>
                <p>متاسفانه اطلاعات آب‌وهوایی پیدا نشد. لطفا دوباره تلاش کنید.</p>
                <a href="?city=abadan">بازگشت</a>
            </div>
        <?php endif; ?>
    </main>
</div>

<?php get_footer(); ?>