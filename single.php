<?php get_header(); ?>

<?php
if (!function_exists('sharji_to_farsi_digits')) {
    function sharji_to_farsi_digits($string) {
        $persian = ['۰','۱','۲','۳','۴','۵','۶','۷','۸','۹'];
        $english = ['0','1','2','3','4','5','6','7','8','9'];
        return str_replace($english, $persian, (string) $string);
    }
}

if (!function_exists('sharji_gregorian_to_jalali')) {
    function sharji_gregorian_to_jalali($gy, $gm, $gd) {
        $g_d_m = [0,31,59,90,120,151,181,212,243,273,304,334];

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

if (!function_exists('sharji_jalali_post_date')) {
    function sharji_jalali_post_date($timestamp = null) {
        if (!$timestamp) {
            $timestamp = get_the_time('U');
        }

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

        return sharji_to_farsi_digits($weekdays[$weekday_index] . ' ' . $jd . ' ' . $months[$jm] . ' ' . $jy);
    }
}
?>

<link rel="stylesheet" href="<?php echo esc_url(get_template_directory_uri()); ?>/assets/css/swiper-bundle.min.css" />

<style>
    @font-face {
        font-family: 'Diba';
        src: url('<?php echo esc_url(get_template_directory_uri()); ?>/fonts/Diba.woff2') format('woff2');
        font-weight: bold;
        font-style: normal;
        font-display: swap;
    }

    :root {
        --sharji-blue: #0056b3;
        --sharji-blue-dark: #004494;
        --sharji-red: #e31e24;
        --sharji-slate: #0f172a;
        --sharji-text: #1e293b;
        --sharji-muted: #64748b;
        --sharji-border: #e2e8f0;
        --sharji-bg: #f8fafc;
    }

    body {
        background:
            radial-gradient(circle at top right, rgba(0, 86, 179, 0.08), transparent 34%),
            radial-gradient(circle at bottom left, rgba(227, 30, 36, 0.045), transparent 30%),
            #f8fafc !important;
    }

    .font-diba,
    .entry-title,
    .related-premium-title,
    .comments-premium-title,
    .sidebar-news-title,
    .suggestion-title {
        font-family: 'Diba', 'Vazirmatn', sans-serif !important;
    }

    .single-main-wrapper {
        max-width: 1920px !important;
        margin: 0 auto !important;
        width: 100% !important;
        padding: 0 40px !important;
        direction: rtl !important;
        background: transparent;
        font-family: 'Vazirmatn', sans-serif !important;
    }

    .single-page-shell {
        padding: 44px 0 56px;
    }

    .single-layout {
        display: flex;
        flex-direction: column;
        gap: 32px;
    }

    .single-content-col {
        width: 100%;
    }

    .single-sidebar-col {
        width: 100%;
    }

    .article-container {
        background: rgba(255, 255, 255, 0.96);
        border-radius: 28px;
        border: 1px solid rgba(226, 232, 240, 0.95);
        overflow: hidden;
        box-shadow: 0 24px 65px rgba(15, 23, 42, 0.08);
        backdrop-filter: blur(10px);
    }

    .meta-bar {
        background:
            linear-gradient(135deg, #ffffff 0%, #f8fafc 58%, #eff6ff 100%);
        border-bottom: 1px solid var(--sharji-border);
        padding: 15px 24px;
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 12px;
        color: #64748b;
        font-size: 13px;
        font-weight: 700;
    }

    .meta-item {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 999px;
        padding: 7px 12px;
        line-height: 1;
    }

    .meta-item i {
        color: var(--sharji-red);
        font-size: 12px;
    }

    .font-tools {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 999px;
        padding: 4px;
    }

    .font-tools button {
        width: 30px;
        height: 30px;
        border: none;
        border-radius: 999px;
        background: transparent;
        color: #475569;
        cursor: pointer;
        transition: 0.25s;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .font-tools button:hover {
        background: #eff6ff;
        color: var(--sharji-blue);
    }

    .meta-cats {
        margin-right: auto;
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }

    .meta-cats a {
        background: #0f172a;
        color: #fff !important;
        padding: 7px 14px;
        border-radius: 999px;
        font-size: 11px;
        font-weight: 900;
        text-decoration: none !important;
        transition: 0.25s;
    }

    .meta-cats a:hover {
        background: var(--sharji-red);
        transform: translateY(-2px);
    }

    .content-area {
        padding: 42px 50px 50px;
    }

    .entry-title {
        color: var(--sharji-blue);
        font-size: 42px;
        line-height: 1.45;
        margin: 0 0 28px;
        letter-spacing: -0.03em;
        position: relative;
        padding-bottom: 22px;
    }

    .entry-title::after {
        content: "";
        position: absolute;
        right: 0;
        bottom: 0;
        width: 86px;
        height: 5px;
        border-radius: 999px;
        background:
            linear-gradient(90deg, var(--sharji-red), var(--sharji-blue));
    }

    .article-intro-grid {
        display: grid;
        grid-template-columns: minmax(0, 1fr) minmax(0, 1fr);
        gap: 26px;
        align-items: stretch;
        margin-bottom: 40px;
    }

    .featured-image-card {
        position: relative;
        min-height: 330px;
        border-radius: 24px;
        overflow: hidden;
        border: 1px solid #e2e8f0;
        box-shadow: 0 18px 38px rgba(15, 23, 42, 0.10);
        background: #f1f5f9;
    }

    .featured-image-card img {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: 0.7s ease;
    }

    .featured-image-card:hover img {
        transform: scale(1.045);
    }

    .article-summary-card {
        background:
            radial-gradient(circle at top right, rgba(0, 86, 179, 0.10), transparent 36%),
            linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);
        border: 1px solid #e2e8f0;
        border-right: 5px solid var(--sharji-blue);
        border-radius: 24px;
        padding: 28px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        position: relative;
        overflow: hidden;
    }

    .summary-label {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        width: fit-content;
        color: var(--sharji-blue);
        font-size: 14px;
        font-weight: 900;
        margin-bottom: 16px;
    }

    .summary-label span {
        width: 8px;
        height: 8px;
        border-radius: 999px;
        background: var(--sharji-blue);
    }

    .summary-text {
        color: #334155;
        font-size: 16px;
        line-height: 2.05;
        font-weight: 700;
        text-align: justify;
    }

    .entry-content {
        font-family: 'Vazirmatn', sans-serif !important;
        font-size: 18px;
        line-height: 2.25;
        color: #334155;
        text-align: justify;
    }

    .entry-content p {
        margin-bottom: 1.55rem;
    }

    .entry-content a {
        color: #2563eb;
        text-decoration: underline;
        text-underline-offset: 4px;
    }

    .entry-content img {
        max-width: 100%;
        height: auto;
        border-radius: 16px;
    }

    .full-text {
        border-top: 1px solid #f1f5f9;
        padding-top: 30px;
    }

    .after-content-area {
        margin-top: 58px;
        padding-top: 34px;
        border-top: 1px solid #e2e8f0;
        display: flex;
        flex-direction: column;
        gap: 28px;
    }

    .tag-row {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 10px;
    }

    .tag-row-label {
        color: #64748b;
        font-size: 14px;
        font-weight: 900;
        margin-left: 6px;
    }

    .tag-link {
        background: #f8fafc;
        color: #475569;
        border: 1px solid #e2e8f0;
        padding: 8px 14px;
        border-radius: 12px;
        font-size: 13px;
        font-weight: 800;
        text-decoration: none !important;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: 0.25s;
    }

    .tag-link i {
        font-size: 10px;
        color: #94a3b8;
    }

    .tag-link:hover {
        background: var(--sharji-red);
        border-color: var(--sharji-red);
        color: #fff !important;
        transform: translateY(-2px);
    }

    .tag-link:hover i {
        color: #fff;
    }

    /* Share Box */
    .sharji-share-box {
        background:
            radial-gradient(circle at top right, rgba(0, 86, 179, 0.10), transparent 32%),
            linear-gradient(135deg, #f8fafc 0%, #ffffff 58%, #eff6ff 100%);
        border: 1px solid #dbe4f0;
        border-radius: 22px;
        padding: 24px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 14px 32px rgba(15, 23, 42, 0.045);
    }

    .sharji-share-box::before {
        content: "";
        position: absolute;
        top: 0;
        right: 0;
        width: 6px;
        height: 100%;
        background:
            linear-gradient(180deg, var(--sharji-blue), var(--sharji-red));
    }

    .sharji-share-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        margin-bottom: 18px;
        position: relative;
        z-index: 2;
    }

    .sharji-share-title {
        display: flex;
        align-items: center;
        gap: 11px;
        color: #1e293b;
        font-weight: 900;
        font-size: 16px;
    }

    .sharji-share-title i {
        width: 42px;
        height: 42px;
        background:
            linear-gradient(135deg, var(--sharji-blue), #0b66c3);
        color: #fff;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 12px 24px rgba(0, 86, 179, 0.18);
    }

    .sharji-share-subtitle {
        color: #64748b;
        font-size: 13px;
        margin-top: 5px;
        line-height: 1.8;
    }

    .sharji-share-grid {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        position: relative;
        z-index: 2;
    }

    .sharji-share-btn {
        min-width: 46px;
        height: 46px;
        padding: 0 15px;
        border-radius: 14px;
        background: #fff;
        border: 1px solid #e2e8f0;
        color: #334155;
        text-decoration: none !important;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 9px;
        font-size: 13px;
        font-weight: 900;
        transition: all 0.25s ease;
        cursor: pointer;
        font-family: 'Vazirmatn', sans-serif !important;
    }

    .sharji-share-btn i {
        font-size: 18px;
    }

    .sharji-share-btn img {
        width: 22px;
        height: 22px;
        object-fit: contain;
    }

    .sharji-share-btn:hover {
        transform: translateY(-3px);
        color: #fff !important;
        border-color: transparent;
        box-shadow: 0 12px 22px rgba(15, 23, 42, 0.11);
    }

    .sharji-share-btn.telegram:hover { background: #229ed9; }
    .sharji-share-btn.whatsapp:hover { background: #22c55e; }
    .sharji-share-btn.x-twitter:hover { background: #111827; }
    .sharji-share-btn.facebook:hover { background: #1877f2; }
    .sharji-share-btn.native-share:hover { background: #7c3aed; }
    .sharji-share-btn.copy:hover { background: var(--sharji-blue); }

    .sharji-shortlink-row {
        margin-top: 17px;
        background: #fff;
        border: 1px dashed #cbd5e1;
        border-radius: 16px;
        padding: 10px;
        display: flex;
        align-items: center;
        gap: 10px;
        position: relative;
        z-index: 2;
        direction: ltr;
    }

    .sharji-shortlink-input {
        flex: 1;
        border: none;
        outline: none;
        background: transparent;
        color: #475569;
        font-size: 13px;
        font-family: Arial, sans-serif;
        min-width: 0;
    }

    .sharji-copy-shortlink {
        border: none;
        background:
            linear-gradient(135deg, var(--sharji-blue), #0b66c3);
        color: #fff;
        height: 38px;
        padding: 0 15px;
        border-radius: 12px;
        font-size: 12px;
        font-weight: 900;
        cursor: pointer;
        transition: all 0.25s ease;
        white-space: nowrap;
        font-family: 'Vazirmatn', sans-serif !important;
    }

    .sharji-copy-shortlink:hover {
        background:
            linear-gradient(135deg, var(--sharji-red), #ef4444);
    }

    .sharji-copy-status {
        font-size: 12px;
        color: #16a34a;
        font-weight: 900;
        display: none;
        direction: rtl;
        white-space: nowrap;
    }

    /* Author Box */
    .sharji-author-box {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 22px;
        padding: 24px;
        display: flex;
        align-items: center;
        gap: 20px;
        margin-top: 4px;
        transition: all 0.3s ease;
    }

    .sharji-author-box:hover {
        border-color: #cbd5e1;
        box-shadow: 0 10px 25px rgba(15, 23, 42, 0.04);
    }

    .author-avatar {
        flex-shrink: 0;
        width: 80px;
        height: 80px;
        border-radius: 50%;
        overflow: hidden;
        border: 3px solid #fff;
        box-shadow: 0 8px 16px rgba(15, 23, 42, 0.08);
    }

    .author-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .author-info {
        flex: 1;
    }

    .author-label {
        color: #64748b;
        font-size: 11px;
        font-weight: 900;
        display: block;
        margin-bottom: 4px;
    }

    .author-name {
        margin: 0 0 6px 0;
        font-size: 18px;
        font-family: 'Diba', 'Vazirmatn', sans-serif !important;
    }

    .author-name a {
        color: var(--sharji-blue);
        text-decoration: none;
        transition: color 0.3s;
    }

    .author-name a:hover {
        color: var(--sharji-red);
    }

    .author-bio {
        color: #475569;
        font-size: 13px;
        line-height: 1.8;
        margin: 0;
        text-align: justify;
    }

    /* Related News - Premium Box */
    .related-premium-box {
        margin-top: 42px;
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 24px;
        overflow: hidden;
        box-shadow: 0 18px 42px rgba(15, 23, 42, 0.07);
    }

    .related-premium-head {
        background:
            linear-gradient(135deg, #0f172a 0%, #0056b3 58%, #0b66c3 100%);
        padding: 18px 22px;
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 14px;
        position: relative;
        overflow: hidden;
    }

    .related-premium-head::before {
        content: "";
        position: absolute;
        top: -55px;
        left: -45px;
        width: 150px;
        height: 150px;
        border-radius: 999px;
        background: rgba(255,255,255,0.10);
        pointer-events: none;
    }

    .related-premium-title-wrap {
        position: relative;
        z-index: 2;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .related-premium-icon {
        width: 42px;
        height: 42px;
        border-radius: 14px;
        background: rgba(255,255,255,0.16);
        border: 1px solid rgba(255,255,255,0.20);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #facc15;
        flex-shrink: 0;
    }

    .related-premium-title {
        font-family: 'Diba', 'Vazirmatn', sans-serif !important;
        font-size: 24px;
        line-height: 1.3;
        margin: 0;
        color: #fff;
    }

    .related-premium-subtitle {
        font-size: 12px;
        color: #dbeafe;
        margin-top: 3px;
        font-weight: 700;
    }

    .related-premium-navs {
        position: relative;
        z-index: 2;
        display: flex;
        gap: 8px;
    }

    .related-nav {
        width: 38px;
        height: 38px;
        border-radius: 999px;
        border: 1px solid rgba(255,255,255,0.25);
        background: rgba(255,255,255,0.13);
        color: #fff;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.25s ease;
    }

    .related-nav:hover {
        background: #fff;
        color: var(--sharji-blue);
        transform: translateY(-2px);
    }

    .related-premium-body {
        padding: 22px;
        background:
            radial-gradient(circle at top right, rgba(0, 86, 179, 0.06), transparent 32%),
            #fff;
    }

    .related-card-premium {
        display: block;
        text-decoration: none !important;
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 18px;
        overflow: hidden;
        transition: all 0.28s ease;
        height: 100%;
    }

    .related-card-premium:hover {
        transform: translateY(-5px);
        box-shadow: 0 18px 34px rgba(15, 23, 42, 0.11);
        border-color: rgba(0, 86, 179, 0.25);
    }

    .related-thumb-premium {
        position: relative;
        aspect-ratio: 16 / 9;
        overflow: hidden;
        background: #f1f5f9;
    }

    .related-thumb-premium img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.55s ease;
    }

    .related-card-premium:hover .related-thumb-premium img {
        transform: scale(1.09);
    }

    .related-thumb-premium::after {
        content: "";
        position: absolute;
        inset: 0;
        background: linear-gradient(to top, rgba(15,23,42,0.38), transparent 55%);
        opacity: 0;
        transition: opacity 0.28s ease;
    }

    .related-card-premium:hover .related-thumb-premium::after {
        opacity: 1;
    }

    .related-card-content {
        padding: 14px 14px 16px;
    }

    .related-card-premium h4 {
        font-family: 'Diba', 'Vazirmatn', sans-serif !important;
        font-size: 16px;
        line-height: 1.75;
        color: #1e293b;
        font-weight: 900;
        margin: 0 0 10px;
        transition: color 0.25s ease;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .related-card-premium:hover h4 {
        color: var(--sharji-blue);
    }

    .related-card-meta {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 11px;
        color: #94a3b8;
        font-weight: 800;
    }

    .related-card-meta i {
        color: var(--sharji-red);
    }

    /* Comments - Sharji Premium News Style */
    .comments-premium-box {
        margin: 36px 50px 50px;
        background:
            radial-gradient(circle at top right, rgba(0, 86, 179, 0.07), transparent 34%),
            #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 26px;
        overflow: hidden;
        box-shadow: 0 22px 50px rgba(15, 23, 42, 0.075);
    }

    .comments-premium-head {
        background:
            linear-gradient(135deg, #0f172a 0%, #0056b3 58%, #0b66c3 100%);
        padding: 20px 24px;
        color: #fff;
        display: flex;
        align-items: center;
        gap: 14px;
        position: relative;
        overflow: hidden;
    }

    .comments-premium-head::before {
        content: "";
        position: absolute;
        left: -50px;
        top: -60px;
        width: 165px;
        height: 165px;
        border-radius: 999px;
        background: rgba(255,255,255,0.10);
        pointer-events: none;
    }

    .comments-premium-icon {
        position: relative;
        z-index: 2;
        width: 46px;
        height: 46px;
        border-radius: 16px;
        background: rgba(255,255,255,0.16);
        border: 1px solid rgba(255,255,255,0.22);
        color: #facc15;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .comments-premium-title-wrap {
        position: relative;
        z-index: 2;
    }

    .comments-premium-title {
        font-family: 'Diba', 'Vazirmatn', sans-serif !important;
        margin: 0;
        color: #fff;
        font-size: 25px;
        line-height: 1.3;
    }

    .comments-premium-subtitle {
        color: #dbeafe;
        font-size: 12px;
        font-weight: 700;
        margin-top: 5px;
    }

    .comments-premium-body {
        padding: 26px;
    }

    .comments-premium-body #comments,
    .comments-premium-body .comments-area,
    .comments-premium-body .comment-respond {
        background: transparent !important;
        border: none !important;
        padding: 0 !important;
        margin: 0 !important;
    }

    .comments-premium-body .comments-title,
    .comments-premium-body .comment-reply-title {
        font-family: 'Diba', 'Vazirmatn', sans-serif !important;
        color: #1e293b !important;
        font-size: 22px !important;
        line-height: 1.5 !important;
        margin: 0 0 20px !important;
        padding-right: 13px;
        border-right: 5px solid var(--sharji-red);
    }

    .comments-premium-body .comment-list,
    .comments-premium-body ol.comment-list,
    .comments-premium-body ul.comment-list {
        list-style: none !important;
        padding: 0 !important;
        margin: 0 0 28px !important;
    }

    .comments-premium-body .comment-list li {
        list-style: none !important;
    }

    .comments-premium-body .comment {
        margin: 0 0 16px !important;
    }

    .comments-premium-body .children {
        list-style: none !important;
        margin: 14px 34px 0 0 !important;
        padding: 0 18px 0 0 !important;
        border-right: 2px dashed #cbd5e1;
    }

    .comments-premium-body .comment-body {
        background:
            linear-gradient(135deg, #ffffff 0%, #f8fafc 100%) !important;
        border: 1px solid #e2e8f0 !important;
        border-radius: 20px !important;
        padding: 18px 18px 16px !important;
        box-shadow: 0 12px 30px rgba(15, 23, 42, 0.045) !important;
        transition: all 0.25s ease;
        position: relative;
    }

    .comments-premium-body .comment-body:hover {
        transform: translateY(-2px);
        border-color: rgba(0, 86, 179, 0.22) !important;
        box-shadow: 0 18px 38px rgba(15, 23, 42, 0.075) !important;
    }

    .comments-premium-body .comment-author {
        display: flex;
        align-items: center;
        gap: 10px;
        color: #1e293b;
        font-weight: 900;
        font-size: 14px;
        margin-bottom: 8px;
    }

    .comments-premium-body .comment-author .avatar {
        width: 46px !important;
        height: 46px !important;
        border-radius: 16px !important;
        object-fit: cover;
        border: 2px solid #e2e8f0;
        box-shadow: 0 8px 18px rgba(15, 23, 42, 0.08);
    }

    .comments-premium-body .comment-author .fn {
        font-style: normal !important;
        color: #1e293b;
    }

    .comments-premium-body .comment-author .says {
        display: none;
    }

    .comments-premium-body .comment-meta,
    .comments-premium-body .comment-metadata {
        font-size: 11px !important;
        color: #94a3b8 !important;
        margin: -4px 58px 12px 0 !important;
    }

    .comments-premium-body .comment-meta a,
    .comments-premium-body .comment-metadata a {
        color: #94a3b8 !important;
        text-decoration: none !important;
    }

    .comments-premium-body .comment-content,
    .comments-premium-body .comment-body p {
        color: #334155 !important;
        font-size: 14px !important;
        line-height: 2.05 !important;
        text-align: justify;
    }

    .comments-premium-body .comment-body p {
        margin: 10px 0 0 !important;
    }

    .comments-premium-body .reply {
        margin-top: 14px;
        text-align: left;
    }

    .comments-premium-body .comment-reply-link {
        display: inline-flex !important;
        align-items: center;
        gap: 7px;
        background: #eff6ff;
        color: var(--sharji-blue) !important;
        border: 1px solid #bfdbfe;
        border-radius: 999px;
        padding: 7px 14px;
        font-size: 12px;
        font-weight: 900;
        text-decoration: none !important;
        transition: all 0.25s ease;
    }

    .comments-premium-body .comment-reply-link:hover {
        background: var(--sharji-blue);
        color: #fff !important;
        border-color: var(--sharji-blue);
        transform: translateY(-2px);
    }

    .comments-premium-body #respond {
        background:
            radial-gradient(circle at top right, rgba(0, 86, 179, 0.08), transparent 36%),
            linear-gradient(135deg, #f8fafc 0%, #ffffff 100%) !important;
        border: 1px solid #e2e8f0 !important;
        border-radius: 22px !important;
        padding: 22px !important;
        margin-top: 24px !important;
    }

    .comments-premium-body #reply-title {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .comments-premium-body #reply-title::before {
        content: "\f4ad";
        font-family: "Font Awesome 5 Free";
        font-weight: 900;
        width: 38px;
        height: 38px;
        border-radius: 14px;
        background: linear-gradient(135deg, var(--sharji-blue), #0b66c3);
        color: #fff;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        border-right: none;
        flex-shrink: 0;
    }

    .comments-premium-body .comment-notes,
    .comments-premium-body .logged-in-as,
    .comments-premium-body .form-allowed-tags {
        color: #64748b !important;
        font-size: 12px !important;
        line-height: 1.9 !important;
    }

    .comments-premium-body .comment-form {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 14px;
    }

    .comments-premium-body .comment-form-comment,
    .comments-premium-body .comment-form-cookies-consent,
    .comments-premium-body .form-submit,
    .comments-premium-body .comment-notes,
    .comments-premium-body .logged-in-as {
        grid-column: 1 / -1;
    }

    .comments-premium-body .comment-form label {
        display: block;
        color: #1e293b;
        font-size: 13px;
        font-weight: 900;
        margin-bottom: 7px;
    }

    .comments-premium-body .comment-form input[type="text"],
    .comments-premium-body .comment-form input[type="email"],
    .comments-premium-body .comment-form input[type="url"],
    .comments-premium-body .comment-form textarea {
        width: 100% !important;
        border: 1px solid #cbd5e1 !important;
        border-radius: 14px !important;
        background: #fff !important;
        color: #1e293b !important;
        padding: 12px 14px !important;
        font-family: 'Vazirmatn', sans-serif !important;
        font-size: 14px !important;
        outline: none !important;
        box-shadow: none !important;
        transition: all 0.25s ease;
        box-sizing: border-box;
    }

    .comments-premium-body .comment-form textarea {
        min-height: 145px;
        resize: vertical;
        line-height: 2;
    }

    .comments-premium-body .comment-form input:focus,
    .comments-premium-body .comment-form textarea:focus {
        border-color: var(--sharji-blue) !important;
        box-shadow: 0 0 0 4px rgba(0, 86, 179, 0.08) !important;
    }

    .comments-premium-body .comment-form-cookies-consent {
        display: flex;
        align-items: center;
        gap: 8px;
        color: #64748b;
        font-size: 12px;
    }

    .comments-premium-body .comment-form-cookies-consent label {
        margin: 0;
        font-weight: 700;
        color: #64748b;
    }

    .comments-premium-body .form-submit {
        margin: 4px 0 0 !important;
        text-align: left;
    }

    .comments-premium-body .submit {
        background:
            linear-gradient(135deg, var(--sharji-blue), #0b66c3) !important;
        color: #fff !important;
        border: none !important;
        border-radius: 14px !important;
        padding: 12px 26px !important;
        font-family: 'Vazirmatn', sans-serif !important;
        font-size: 13px !important;
        font-weight: 900 !important;
        cursor: pointer;
        box-shadow: 0 12px 24px rgba(0, 86, 179, 0.18);
        transition: all 0.25s ease;
    }

    .comments-premium-body .submit:hover {
        background:
            linear-gradient(135deg, var(--sharji-red), #ef4444) !important;
        transform: translateY(-2px);
    }

    .comments-premium-body .comment-awaiting-moderation {
        display: block;
        background: #fff7ed;
        color: #c2410c;
        border: 1px solid #fed7aa;
        border-radius: 14px;
        padding: 10px 12px;
        margin-top: 10px;
        font-size: 12px;
        font-style: normal;
        font-weight: 800;
    }

    /* Sidebar */
    .sidebar-sticky-original {
        position: sticky;
        top: 92px;
        display: flex;
        flex-direction: column;
        gap: 28px;
    }

    .sidebar-news-box {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 24px;
        overflow: hidden;
        box-shadow: 0 18px 42px rgba(15, 23, 42, 0.075);
    }

    .sidebar-news-head {
        background:
            linear-gradient(135deg, var(--sharji-blue), #0b66c3);
        color: #fff;
        padding: 16px 18px;
        font-weight: 900;
        font-size: 14px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .sidebar-news-head span {
        font-family: 'Diba', 'Vazirmatn', sans-serif !important;
        font-size: 19px;
    }

    .sidebar-news-item {
        display: flex;
        flex-direction: column;
        gap: 12px;
        padding: 16px;
        border-bottom: 1px solid #f1f5f9;
        text-decoration: none !important;
        transition: all 0.25s ease;
        position: relative;
    }

    .sidebar-news-item:last-child {
        border-bottom: none;
    }

    .sidebar-news-item:hover {
        background: #f8fafc;
    }

    .sidebar-news-thumb {
        width: 100%;
        height: 138px;
        overflow: hidden;
        border-radius: 14px;
        background: #f1f5f9;
        position: relative;
    }

    .sidebar-news-thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.45s ease;
    }

    .sidebar-news-item:hover .sidebar-news-thumb img {
        transform: scale(1.07);
    }

    .sidebar-news-title {
        font-family: 'Diba', 'Vazirmatn', sans-serif !important;
        font-size: 16px;
        color: #1e293b;
        font-weight: 900;
        line-height: 1.75;
        margin: 0;
        transition: color 0.25s ease;
    }

    .sidebar-news-item:hover .sidebar-news-title {
        color: var(--sharji-blue);
    }

    .sidebar-news-excerpt {
        font-size: 12px;
        color: #64748b;
        line-height: 1.8;
        margin: 0;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .dynamic-widgets-container {
        width: 100%;
        display: flex;
        flex-direction: column;
        gap: 25px;
    }

    .dynamic-widgets-container .widget,
    .dynamic-widgets-container aside {
        background: transparent !important;
        border: none !important;
        padding: 0 !important;
        margin: 0 !important;
        box-shadow: none !important;
        display: block !important;
    }

    .dynamic-widgets-container img {
        width: 100% !important;
        height: auto !important;
        display: block !important;
        border-radius: 18px;
        transition: all 0.3s ease;
        box-shadow: 0 14px 32px rgba(15, 23, 42, 0.08);
    }

    .dynamic-widgets-container img:hover {
        transform: translateY(-4px);
        filter: brightness(1.05);
    }

    .text-yellow-400 {
        color: #facc15;
    }

    @media (min-width: 1025px) {
        .single-layout {
            flex-direction: row;
            align-items: flex-start;
        }

        .single-content-col {
            width: 75%;
        }

        .single-sidebar-col {
            width: 25%;
        }
    }

    @media (max-width: 1024px) {
        .single-main-wrapper {
            padding: 0 15px !important;
        }

        .single-page-shell {
            padding: 24px 0 36px;
        }

        .article-container {
            border-radius: 22px;
        }

        .content-area {
            padding: 26px 18px 34px;
        }

        .entry-title {
            font-size: 30px !important;
            line-height: 1.65 !important;
        }

        .article-intro-grid {
            grid-template-columns: 1fr;
        }

        .featured-image-card {
            min-height: 260px;
        }

        .sidebar-sticky-original {
            position: static;
        }

        .comments-premium-box {
            margin: 28px 18px 36px;
        }
    }

    @media (max-width: 768px) {
        .single-main-wrapper {
            padding: 0 !important;
        }

        .single-page-shell {
            padding: 0 0 28px;
        }

        .article-container {
            border-radius: 0;
            border-right: none;
            border-left: none;
        }

        .meta-bar {
            padding: 14px 15px;
        }

        .meta-cats {
            width: 100%;
            margin-right: 0;
        }

        .content-area {
            padding: 24px 15px 32px;
        }

        .entry-title {
            font-size: 25px !important;
            margin-bottom: 24px;
            padding-bottom: 18px;
        }

        .summary-text {
            font-size: 15.5px;
        }

        .entry-content {
            font-size: 16px;
            line-height: 2.15;
        }

        .sharji-share-box {
            padding: 20px 18px;
            border-radius: 20px;
        }

        .sharji-share-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 10px;
        }

        .sharji-share-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
        }

        .sharji-share-btn {
            width: 100%;
            padding: 0 10px;
        }

        .sharji-shortlink-row {
            flex-wrap: wrap;
        }

        .sharji-shortlink-input {
            width: 100%;
            flex-basis: 100%;
        }

        .sharji-author-box {
            flex-direction: column;
            text-align: center;
            padding: 20px;
            gap: 14px;
            border-radius: 20px;
        }

        .author-bio {
            text-align: center;
        }

        .related-premium-box {
            border-radius: 20px;
        }

        .related-premium-head {
            flex-direction: column;
            align-items: flex-start;
        }

        .related-premium-navs {
            align-self: flex-end;
        }

        .related-premium-body {
            padding: 16px;
        }

        .comments-premium-box {
            margin: 24px 15px 34px;
            border-radius: 20px;
        }

        .comments-premium-head {
            padding: 16px;
        }

        .comments-premium-body {
            padding: 16px;
        }

        .comments-premium-body .comment-form {
            grid-template-columns: 1fr;
        }

        .comments-premium-body .children {
            margin-right: 12px !important;
            padding-right: 12px !important;
        }

        .comments-premium-title {
            font-size: 22px;
        }

        .single-sidebar-col {
            padding: 0 15px;
        }
    }

    @media (max-width: 480px) {
        .sharji-share-grid {
            grid-template-columns: 1fr;
        }

        .featured-image-card {
            min-height: 220px;
            border-radius: 18px;
        }

        .article-summary-card {
            padding: 22px 18px;
            border-radius: 18px;
        }

        .comments-premium-head {
            align-items: flex-start;
        }
    }
    .article-container > .comments-area.sharji-comments-clean {
    margin: 36px 50px 50px !important;
}

@media (max-width: 1024px) {
    .article-container > .comments-area.sharji-comments-clean {
        margin: 28px 18px 36px !important;
    }
}

@media (max-width: 768px) {
    .article-container > .comments-area.sharji-comments-clean {
        margin: 24px 15px 34px !important;
    }
}
</style>

<div class="single-main-wrapper">
    <main class="single-page-shell">
        <div class="single-layout">

            <div class="single-content-col">
                <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                    <?php $current_post_id = get_the_ID(); ?>

                    <?php
                    $schema_image = has_post_thumbnail()
                        ? get_the_post_thumbnail_url(get_the_ID(), 'full')
                        : '';

                    $schema_data = [
                        '@context' => 'https://schema.org',
                        '@type' => 'NewsArticle',
                        'mainEntityOfPage' => [
                            '@type' => 'WebPage',
                            '@id' => get_permalink(),
                        ],
                        'headline' => wp_strip_all_tags(get_the_title()),
                        'description' => function_exists('sharji_get_news_lead')
                            ? wp_strip_all_tags(sharji_get_news_lead(get_the_ID()))
                            : (
                                has_excerpt()
                                    ? wp_strip_all_tags(get_the_excerpt())
                                    : wp_strip_all_tags(wp_trim_words(get_the_content(), 35, ''))
                            ),
                        'datePublished' => get_the_date('c'),
                        'dateModified' => get_the_modified_date('c'),
                        'author' => [
                            '@type' => 'Person',
                            'name' => get_the_author(),
                        ],
                        'publisher' => [
                            '@type' => 'Organization',
                            'name' => get_bloginfo('name'),
                            'logo' => [
                                '@type' => 'ImageObject',
                                'url' => esc_url(home_url('/wp-content/uploads/2026/01/logosharjiok.png')),
                            ],
                        ],
                    ];

                    if (!empty($schema_image)) {
                        $schema_data['image'] = [$schema_image];
                    }
                    ?>

                    <script type="application/ld+json">
                    <?php echo wp_json_encode($schema_data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT); ?>
                    </script>

                    <article class="article-container">

                        <div class="meta-bar">
                            <div class="meta-item">
                                <i class="far fa-calendar-alt"></i>
                                <?php echo esc_html(sharji_jalali_post_date()); ?>
                            </div>

                            <div class="meta-item">
                                <i class="far fa-clock"></i>
                                <?php echo esc_html(sharji_to_farsi_digits(get_the_time('H:i'))); ?>
                            </div>

                            <div class="font-tools">
                                <button type="button" onclick="adjustFont(1)" title="افزایش سایز">
                                    <i class="fas fa-plus text-xs"></i>
                                </button>
                                <button type="button" onclick="adjustFont(-1)" title="کاهش سایز">
                                    <i class="fas fa-minus text-xs"></i>
                                </button>
                            </div>

                            <div class="meta-item">
                                کد خبر: <?php echo esc_html(sharji_to_farsi_digits(get_the_ID())); ?>
                            </div>

                            <div class="meta-cats">
                                <?php
                                $categories = get_the_category();
                                if ($categories) {
                                    foreach ($categories as $cat) {
                                        echo '<a href="' . esc_url(get_category_link($cat->term_id)) . '">' . esc_html($cat->name) . '</a>';
                                    }
                                }
                                ?>
                            </div>
                        </div>

                        <div class="content-area">
                            <h1 class="entry-title"><?php the_title(); ?></h1>

                            <div class="entry-content" id="mainContent">

                                <div class="article-intro-grid">
                                    <?php if (has_post_thumbnail()) : ?>
                                        <div class="featured-image-card">
                                            <?php the_post_thumbnail('large'); ?>
                                        </div>
                                    <?php endif; ?>

                                    <div class="article-summary-card">
                                        <div class="summary-label">
                                            <span></span>
                                            چکیده خبر
                                        </div>

                                        <div class="summary-text">
                                            <?php
                                            if (function_exists('sharji_get_news_lead')) {
                                                echo esc_html(sharji_get_news_lead(get_the_ID()));
                                            } elseif (has_excerpt()) {
                                                echo esc_html(get_the_excerpt());
                                            } else {
                                                echo esc_html(wp_trim_words(get_the_content(), 55, '...'));
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="full-text">
                                    <?php the_content(); ?>
                                </div>

                                <div class="clear-both"></div>
                            </div>

                            <div class="after-content-area">

                                <?php $tags = get_the_tags(); ?>
                                <?php if ($tags) : ?>
                                    <div class="tag-row">
                                        <span class="tag-row-label">برچسب‌ها:</span>

                                        <?php foreach ($tags as $tag) : ?>
                                            <a href="<?php echo esc_url(get_tag_link($tag->term_id)); ?>" class="tag-link">
                                                <i class="fas fa-hashtag"></i>
                                                <?php echo esc_html($tag->name); ?>
                                            </a>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>

                                <!-- Author Profile Box -->
<div class="sharji-author-box">
    <div class="author-avatar">
        <?php 
        $author_id = get_the_author_meta('ID');
        // Check for the custom admin URL first
        $custom_admin_avatar = get_user_meta($author_id, 'sharji_override_avatar', true);
        
        if (!empty($custom_admin_avatar)) {
            // Force the custom image if the admin provided one
            echo '<img src="' . esc_url($custom_admin_avatar) . '" alt="' . esc_attr(get_the_author()) . '">';
        } else {
            // Fallback to Ultimate Member / Default Gravatar
            echo get_avatar($author_id, 80, '', get_the_author()); 
        }
        ?>
    </div>
    <div class="author-info">
        <span class="author-label">نویسنده مطلب</span>
        <h3 class="author-name">
            <a href="<?php echo esc_url(get_author_posts_url($author_id)); ?>" title="مشاهده تمامی مطالب <?php the_author(); ?>">
                <?php the_author(); ?>
            </a>
        </h3>
        <?php if (get_the_author_meta('description')) : ?>
            <p class="author-bio">
                <?php echo esc_html(get_the_author_meta('description')); ?>
            </p>
        <?php endif; ?>
    </div>
</div>
                                <!-- End Author Profile Box -->

                                <?php
                                $sharji_post_title = get_the_title();
                                $sharji_shortlink = wp_get_shortlink();

                                if (empty($sharji_shortlink)) {
                                    $sharji_shortlink = home_url('?p=' . get_the_ID());
                                }

                                $sharji_encoded_short = rawurlencode($sharji_shortlink);
                                $sharji_encoded_title = rawurlencode($sharji_post_title);
                                $sharji_share_text = rawurlencode($sharji_post_title . "\n" . $sharji_shortlink);
                                ?>

                                <div class="sharji-share-box">
                                    <div class="sharji-share-header">
                                        <div>
                                            <div class="sharji-share-title">
                                                <i class="fas fa-share-alt"></i>
                                                <span>اشتراک‌گذاری خبر</span>
                                            </div>
                                            <div class="sharji-share-subtitle">
                                                این خبر را برای دیگران ارسال کنید.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="sharji-share-grid">
                                        <a href="https://t.me/share/url?url=<?php echo esc_attr($sharji_encoded_short); ?>&text=<?php echo esc_attr($sharji_encoded_title); ?>" target="_blank" rel="noopener noreferrer" class="sharji-share-btn telegram" title="اشتراک‌گذاری در تلگرام">
                                            <img src="<?php echo esc_url(home_url('/wp-content/uploads/2026/01/telegram.png')); ?>" alt="telegram">
                                            <span>تلگرام</span>
                                        </a>

                                        <a href="https://wa.me/?text=<?php echo esc_attr($sharji_share_text); ?>" target="_blank" rel="noopener noreferrer" class="sharji-share-btn whatsapp" title="اشتراک‌گذاری در واتساپ">
                                            <img src="<?php echo esc_url(home_url('/wp-content/uploads/2026/01/whatsapp.png')); ?>" alt="whatsapp">
                                            <span>واتساپ</span>
                                        </a>

                                        <a href="https://twitter.com/intent/tweet?url=<?php echo esc_attr($sharji_encoded_short); ?>&text=<?php echo esc_attr($sharji_encoded_title); ?>" target="_blank" rel="noopener noreferrer" class="sharji-share-btn x-twitter" title="اشتراک‌گذاری در ایکس">
                                            <i class="fab fa-x-twitter"></i>
                                            <span>ایکس</span>
                                        </a>

                                        <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo esc_attr($sharji_encoded_short); ?>" target="_blank" rel="noopener noreferrer" class="sharji-share-btn facebook" title="اشتراک‌گذاری در فیسبوک">
                                            <i class="fab fa-facebook-f"></i>
                                            <span>فیسبوک</span>
                                        </a>

                                        <button type="button" class="sharji-share-btn native-share" onclick="sharjiNativeShare('<?php echo esc_js($sharji_post_title); ?>', '<?php echo esc_js($sharji_shortlink); ?>')" title="اشتراک‌گذاری با موبایل">
                                            <i class="fas fa-share-nodes"></i>
                                            <span>اشتراک</span>
                                        </button>

                                        <button type="button" class="sharji-share-btn copy" onclick="sharjiCopyText('<?php echo esc_js($sharji_shortlink); ?>')" title="کپی لینک کوتاه">
                                            <i class="fas fa-link"></i>
                                            <span>کپی لینک</span>
                                        </button>
                                    </div>

                                    <div class="sharji-shortlink-row">
                                        <input id="sharjiShortlinkInput" class="sharji-shortlink-input" type="text" value="<?php echo esc_url($sharji_shortlink); ?>" readonly aria-label="لینک کوتاه خبر">

                                        <button type="button" class="sharji-copy-shortlink" onclick="sharjiCopyShortlink()">
                                            کپی لینک کوتاه
                                        </button>

                                        <span id="sharjiCopyStatus" class="sharji-copy-status">کپی شد</span>
                                    </div>
                                </div>

                                <?php
                                $rel_cache_key = 'related_posts_' . $current_post_id;
                                $related_posts = wp_cache_get($rel_cache_key, 'single_page');

                                if (false === $related_posts) {
                                    $related_posts = [];

                                    $tags_data = wp_get_post_tags($current_post_id);

                                    if ($tags_data) {
                                        $tag_ids = array_map(function($t) {
                                            return $t->term_id;
                                        }, $tags_data);

                                        $related_query = new WP_Query([
                                            'tag__in' => $tag_ids,
                                            'post__not_in' => [$current_post_id],
                                            'posts_per_page' => 9,
                                            'ignore_sticky_posts' => 1,
                                            'no_found_rows' => true,
                                        ]);

                                        $related_posts = $related_query->posts;
                                        wp_reset_postdata();
                                    }

                                    if (empty($related_posts)) {
                                        $cat_ids = wp_get_post_categories($current_post_id);

                                        if (!empty($cat_ids)) {
                                            $related_query = new WP_Query([
                                                'category__in' => $cat_ids,
                                                'post__not_in' => [$current_post_id],
                                                'posts_per_page' => 9,
                                                'ignore_sticky_posts' => 1,
                                                'no_found_rows' => true,
                                            ]);

                                            $related_posts = $related_query->posts;
                                            wp_reset_postdata();
                                        }
                                    }

                                    wp_cache_set($rel_cache_key, $related_posts, 'single_page', HOUR_IN_SECONDS);
                                }
                                ?>

                                <?php if ($related_posts) : ?>
                                    <div class="related-premium-box">
                                        <div class="related-premium-head">
                                            <div class="related-premium-title-wrap">
                                                <div class="related-premium-icon">
                                                    <i class="fas fa-newspaper"></i>
                                                </div>

                                                <div>
                                                    <h2 class="related-premium-title">اخبار مرتبط</h2>
                                                    <div class="related-premium-subtitle">مطالبی که با این خبر ارتباط بیشتری دارند</div>
                                                </div>
                                            </div>

                                            <div class="related-premium-navs">
                                                <button class="rel-prev related-nav" type="button" aria-label="خبر قبلی">
                                                    <i class="fas fa-chevron-right"></i>
                                                </button>
                                                <button class="rel-next related-nav" type="button" aria-label="خبر بعدی">
                                                    <i class="fas fa-chevron-left"></i>
                                                </button>
                                            </div>
                                        </div>

                                        <div class="related-premium-body">
                                            <div class="swiper related-swiper">
                                                <div class="swiper-wrapper">
                                                    <?php foreach ($related_posts as $post) : setup_postdata($post); ?>
                                                        <div class="swiper-slide">
                                                            <a href="<?php the_permalink(); ?>" class="related-card-premium">
                                                                <div class="related-thumb-premium">
                                                                    <?php if (has_post_thumbnail()) : ?>
                                                                        <?php the_post_thumbnail('medium'); ?>
                                                                    <?php endif; ?>
                                                                </div>

                                                                <div class="related-card-content">
                                                                    <h4><?php the_title(); ?></h4>

                                                                    <div class="related-card-meta">
                                                                        <i class="far fa-clock"></i>
                                                                        <span><?php echo esc_html(sharji_to_farsi_digits(get_the_time('H:i'))); ?></span>
                                                                    </div>
                                                                </div>
                                                            </a>
                                                        </div>
                                                    <?php endforeach; wp_reset_postdata(); ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>

                            </div>
                        </div>

<?php
if (comments_open() || get_comments_number()) :
    comments_template();
endif;
?>

                    </article>
                <?php endwhile; endif; ?>
            </div>

            <aside class="single-sidebar-col">
                <div class="sidebar-sticky-original">

                    <div class="sidebar-news-box">
                        <div class="sidebar-news-head">
                            <span>پیشنهاد شرجی</span>
                            <i class="fas fa-star text-yellow-400"></i>
                        </div>

                        <?php
                        $editor_cache = wp_cache_get('editor_picks_sidebar', 'sidebar');

                        if (false === $editor_cache) {
                            $sticky = get_option('sticky_posts');

                            if (!empty($sticky)) {
                                $args = [
                                    'posts_per_page'      => 3,
                                    'post__in'            => $sticky,
                                    'ignore_sticky_posts' => 1,
                                ];
                            } else {
                                $args = [
                                    'posts_per_page' => 3,
                                    'orderby'        => 'rand',
                                ];
                            }

                            $editor_query = new WP_Query($args);
                            $editor_cache = $editor_query->posts;
                            wp_reset_postdata();

                            wp_cache_set('editor_picks_sidebar', $editor_cache, 'sidebar', 2 * HOUR_IN_SECONDS);
                        }

                        if ($editor_cache) :
                            foreach ($editor_cache as $post) : setup_postdata($post);
                        ?>
                                <a href="<?php the_permalink(); ?>" class="sidebar-news-item">
                                    <div class="sidebar-news-thumb">
                                        <?php if (has_post_thumbnail()) : ?>
                                            <?php the_post_thumbnail('medium'); ?>
                                        <?php endif; ?>
                                    </div>

                                    <h3 class="sidebar-news-title"><?php the_title(); ?></h3>

                                    <p class="sidebar-news-excerpt">
                                        <?php echo esc_html(wp_trim_words(get_the_excerpt(), 18, '...')); ?>
                                    </p>
                                </a>
                        <?php
                            endforeach;
                            wp_reset_postdata();
                        endif;
                        ?>
                    </div>

                    <?php if (is_active_sidebar('single-sidebar')) : ?>
                        <div id="sidebar-ads" class="dynamic-widgets-container">
                            <?php dynamic_sidebar('single-sidebar'); ?>
                        </div>
                    <?php endif; ?>

                    <?php if (is_active_sidebar('single-sidebar-2')) : ?>
                        <div id="sidebar-ads-2" class="dynamic-widgets-container">
                            <?php dynamic_sidebar('single-sidebar-2'); ?>
                        </div>
                    <?php endif; ?>

                </div>
            </aside>

        </div>
    </main>
</div>

<script src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/js/swiper-bundle.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof Swiper !== 'undefined') {
            new Swiper('.related-swiper', {
                slidesPerView: 1,
                spaceBetween: 20,
                rtl: true,
                navigation: {
                    nextEl: '.rel-next',
                    prevEl: '.rel-prev'
                },
                breakpoints: {
                    640: {
                        slidesPerView: 2
                    },
                    1024: {
                        slidesPerView: 3
                    }
                }
            });
        }
    });

    function adjustFont(amount) {
        var content = document.getElementById('mainContent');
        if (!content) return;

        var currentSize = parseFloat(window.getComputedStyle(content, null).getPropertyValue('font-size'));
        var newSize = currentSize + amount;

        if (newSize >= 14 && newSize <= 30) {
            content.style.fontSize = newSize + 'px';
            content.style.lineHeight = (newSize * 1.85) + 'px';
        }
    }

    function sharjiCopyText(text) {
        if (navigator.clipboard && window.isSecureContext) {
            navigator.clipboard.writeText(text).then(function() {
                sharjiShowCopyStatus();
            }).catch(function() {
                sharjiFallbackCopy(text);
            });
        } else {
            sharjiFallbackCopy(text);
        }
    }

    function sharjiFallbackCopy(text) {
        var tempInput = document.createElement('input');
        tempInput.value = text;
        document.body.appendChild(tempInput);
        tempInput.select();
        document.execCommand('copy');
        document.body.removeChild(tempInput);
        sharjiShowCopyStatus();
    }

    function sharjiCopyShortlink() {
        var input = document.getElementById('sharjiShortlinkInput');
        if (!input) return;

        sharjiCopyText(input.value);
    }

    function sharjiShowCopyStatus() {
        var status = document.getElementById('sharjiCopyStatus');
        if (!status) return;

        status.style.display = 'inline-block';

        setTimeout(function() {
            status.style.display = 'none';
        }, 1800);
    }

    function sharjiNativeShare(title, url) {
        if (navigator.share) {
            navigator.share({
                title: title,
                text: title,
                url: url
            }).catch(function() {});
        } else {
            sharjiCopyText(url);
        }
    }
</script>

<?php get_footer(); ?>