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

function to_farsi($string) {
    $persian_digits = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
    $english_digits = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
    return str_replace($english_digits, $persian_digits, $string);
}

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

<style>
    @keyframes weatherFadeInUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
    @keyframes weatherFloat { 0% { transform: translateY(0px); } 50% { transform: translateY(-5px); } 100% { transform: translateY(0px); } }
    @keyframes weatherShine { 0% { left: -100%; } 20% { left: 200%; } 100% { left: 200%; } }

    .weather-page-wrapper {
        max-width: 1400px; margin: 40px auto; padding: 0 40px;
        display: flex; gap: 40px; align-items: flex-start;
        font-family: 'Vazirmatn', sans-serif;
    }

    .city-sidebar {
        width: 340px; flex-shrink: 0; background: #fff;
        border: 1px solid #e2e8f0; border-radius: 20px; padding: 25px;
        position: sticky; top: 30px; max-height: 85vh; overflow-y: auto;
        display: flex; flex-direction: column; gap: 20px;
        box-shadow: 0 10px 30px -5px rgba(0,0,0,0.05);
        opacity: 0; animation: weatherFadeInUp 0.6s ease-out forwards;
    }

    .search-box { position: relative; width: 100%; }
    .search-input {
        width: 100%; padding: 14px 15px 14px 45px; border: 2px solid #e2e8f0;
        border-radius: 14px; font-family: inherit; font-size: 15px;
        transition: 0.3s; outline: none; background: #f8fafc; box-sizing: border-box;
    }
    .search-input:focus { border-color: #0056b3; background: #fff; }
    .search-btn-icon {
        position: absolute; left: 15px; top: 50%; transform: translateY(-50%);
        color: #94a3b8; font-size: 18px; border: none; background: none; cursor: pointer;
    }

    .sidebar-label { font-size: 14px; font-weight: 800; color: #1e293b; border-bottom: 2px solid #f1f5f9; padding-bottom: 10px; margin-bottom: 5px; }
    
    .cities-list-container { display: flex; flex-direction: column; gap: 8px; }
    .city-link {
        display: flex; justify-content: space-between; align-items: center;
        padding: 14px 18px; border-radius: 12px; color: #475569;
        font-size: 15px; text-decoration: none; transition: all 0.2s;
        background: #fff; border: 1px solid #f1f5f9;
    }
    .city-link:hover { background: #f0f9ff; color: #0056b3; border-color: #0056b3; transform: translateX(-5px); }
    .city-link.active {
        background: #0056b3; color: #fff; font-weight: bold; border-color: #0056b3;
        box-shadow: 0 8px 20px -5px rgba(0, 86, 179, 0.4); transform: scale(1.02);
    }

    .weather-main { flex: 1; width: 100%; min-width: 0; }

    .w-main-card {
        background: linear-gradient(135deg, #0056b3 0%, #002d5e 100%);
        color: #fff; border-radius: 30px; padding: 50px; text-align: center;
        box-shadow: 0 25px 50px -12px rgba(0, 86, 179, 0.5); margin-bottom: 40px; position: relative; overflow: hidden;
        opacity: 0; animation: weatherFadeInUp 0.6s ease-out 0.15s forwards;
    }
    .w-main-card::after {
        content: ''; position: absolute; top: 0; left: -100%; width: 50%; height: 100%;
        background: linear-gradient(to right, transparent, rgba(255,255,255,0.1), transparent);
        transform: skewX(-25deg); animation: weatherShine 6s infinite;
    }

    .w-main-card h1 { font-size: 42px !important; color: #fff !important; margin: 15px 0 5px !important; font-weight: 900; letter-spacing: -1px; }
    .w-main-card .date {
        font-size: 15px; background: rgba(255,255,255,0.15); padding: 6px 18px;
        border-radius: 50px; display: inline-block; margin-bottom: 10px;
        backdrop-filter: blur(5px); border: 1px solid rgba(255,255,255,0.2);
    }
    .w-temp-now { 
        font-size: 90px; font-weight: 900; display: block; margin: 10px 0;
        line-height: 1; letter-spacing: -3px; animation: weatherFloat 4s ease-in-out infinite; 
    }
    .w-desc-now { font-size: 26px; color: #fcd34d; font-weight: 800; display: block; margin-bottom: 40px; }

    .w-extra-info { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; border-top: 1px solid rgba(255,255,255,0.15); padding-top: 30px; }
    .info-item span { font-size: 14px; opacity: 0.8; display: block; margin-bottom: 8px; }
    .info-item strong { font-size: 24px; font-weight: 700; }

    .section-title { font-size: 20px; font-weight: 800; margin: 40px 0 20px; display: flex; align-items: center; gap: 12px; color: #1e293b; opacity: 0; animation: weatherFadeInUp 0.6s ease-out 0.3s forwards; }
    .section-title::before { content: ''; width: 5px; height: 28px; background: #0056b3; border-radius: 10px; display: block; }

    .h-scroll { display: flex; gap: 15px; overflow-x: auto; padding-bottom: 25px; scrollbar-width: none; opacity: 0; animation: weatherFadeInUp 0.6s ease-out 0.4s forwards; }
    .h-scroll::-webkit-scrollbar { display: none; }
    .h-card { background: #fff; min-width: 110px; padding: 25px 15px; border-radius: 20px; text-align: center; border: 1px solid #e2e8f0; transition: 0.3s; flex-shrink: 0; }
    .h-card:hover { transform: translateY(-8px); border-color: #0056b3; box-shadow: 0 15px 30px -5px rgba(0, 86, 179, 0.15); }
    .h-card strong { display: block; font-size: 22px; margin-top: 10px; color: #0f172a; font-weight: 800; }

    .d-list { background: #fff; border-radius: 24px; overflow: hidden; border: 1px solid #e2e8f0; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.02); opacity: 0; animation: weatherFadeInUp 0.6s ease-out 0.5s forwards; }
    .d-row { display: flex; justify-content: space-between; align-items: center; padding: 20px 30px; border-bottom: 1px solid #f1f5f9; transition: 0.2s; }
    .d-row:hover { background: #f8fafc; padding-right: 35px; }
    .d-row:last-child { border: none; }
    .d-name { color: #1e293b; font-weight: 600; }
    .d-status { color: #64748b; font-size: 14px; }
    .t-max { color: #ef4444; margin-left: 8px; font-weight: 900; font-size: 18px; }
    .t-min { color: #3b82f6; font-weight: 900; font-size: 18px; }

    .weather-error-card {
        background: #fff; border-radius: 16px; padding: 40px; text-align: center;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1); border: 1px solid #e2e8f0;
    }
    .weather-error-card i { color: #94a3b8; font-size: 60px; margin-bottom: 16px; display: block; }
    .weather-error-card h3 { font-size: 20px; font-weight: bold; color: #334155; margin-bottom: 8px; }
    .weather-error-card p { color: #64748b; margin-bottom: 16px; }
    .weather-error-card a {
        display: inline-block; margin-top: 16px; padding: 8px 24px;
        background: #2563eb; color: #fff; border-radius: 12px; text-decoration: none;
        transition: background 0.3s;
    }
    .weather-error-card a:hover { background: #1d4ed8; }

    @media (max-width: 1024px) {
        .weather-page-wrapper { flex-direction: column; padding: 0 20px; margin-top: 20px; gap: 20px; }
        .city-sidebar { 
            width: 100%; position: static; max-height: none; padding: 15px; 
            border: none; background: transparent; box-shadow: none; animation: none; opacity: 1;
        }
        .cities-list-container { flex-direction: row; overflow-x: auto; padding-bottom: 10px; gap: 10px; }
        .city-link { 
            min-width: 120px; justify-content: center; white-space: nowrap; 
            padding: 10px 20px; background: #fff; box-shadow: 0 2px 5px rgba(0,0,0,0.05); 
            flex-shrink: 0;
        }
        .sidebar-label { display: none; }
        .w-main-card { padding: 30px 20px; border-radius: 20px; animation: none; opacity: 1; }
        .w-main-card h1 { font-size: 28px !important; }
        .w-temp-now { font-size: 65px; }
        .w-extra-info { gap: 10px; grid-template-columns: repeat(3, 1fr); }
        .info-item strong { font-size: 18px; }
        .d-row { padding: 15px 20px; }
    }
</style>

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