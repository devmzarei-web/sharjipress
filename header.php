<!DOCTYPE html>
<html <?php language_attributes(); ?> dir="rtl">
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- فونت وزیرمتن - لوکال -->
    <link rel="stylesheet" href="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/css/vazirmatn.css" type="text/css" />
    
    <!-- Font Awesome - لوکال -->
    <link rel="stylesheet" href="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/css/fontawesome.min.css" />
    
    <?php wp_head(); ?>
    
<style>
    @font-face {
        font-family: 'Diba';
        src: url('<?php echo esc_url( get_template_directory_uri() ); ?>/fonts/Diba.woff2') format('woff2');
        font-weight: bold;
        font-style: normal;
        font-display: swap;
    }

    :root {
        --sharji-blue: #0056b3;
        --sharji-blue-dark: #004494;
        --sharji-blue-soft: #eff6ff;
        --sharji-red: #e31e24;
        --sharji-red-soft: #fff1f2;
        --sharji-slate: #0f172a;
        --sharji-text: #1e293b;
        --sharji-muted: #64748b;
        --sharji-border: #e2e8f0;
        --sharji-bg: #f1f5f9;
    }

    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }

    html {
        overflow-x: hidden;
    }

    body {
        font-family: 'Vazirmatn', sans-serif;
        background:
            radial-gradient(circle at top right, rgba(0, 86, 179, 0.07), transparent 32%),
            radial-gradient(circle at bottom left, rgba(227, 30, 36, 0.05), transparent 30%),
            #fff;
        color: var(--sharji-text);
        overflow-x: hidden;
    }

    body.no-scroll {
        overflow: hidden;
    }

    a {
        text-decoration: none;
        color: inherit;
    }

    button,
    input {
        font-family: 'Vazirmatn', sans-serif;
    }
    
    .font-diba {
        font-family: 'Diba', 'Vazirmatn', sans-serif !important;
    }

    .sharji-wrapper {
        max-width: 1920px;
        margin: 0 auto;
        padding: 0 40px;
        width: 100%;
    }

    /* ========== Desktop Top Bar ========== */
.sharji-top-bar {
    display: none;
    background:
        linear-gradient(135deg, var(--sharji-blue) 0%, #0b66c3 55%, #0f172a 100%);
    color: #fff;
    position: relative;
    overflow: visible;
    z-index: 9000;
    border-bottom: 1px solid rgba(255,255,255,0.12);
}

    .sharji-top-bar::before {
        content: "";
        position: absolute;
        top: -90px;
        left: -80px;
        width: 220px;
        height: 220px;
        background: rgba(255,255,255,0.10);
        border-radius: 999px;
        pointer-events: none;
    }

    .sharji-top-inner {
        position: relative;
        z-index: 2;
        min-height: 38px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        width: 100%;
    }

    .sharji-top-group {
        display: flex;
        align-items: center;
        gap: 7px;
        flex-wrap: wrap;
    }
    
    .sharji-top-btn {
        background: rgba(255,255,255,0.13);
        color: #fff !important;
        border-radius: 999px;
        padding: 6px 12px;
        font-size: 11px;
        font-weight: 800;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        white-space: nowrap;
        border: 1px solid rgba(255,255,255,0.16);
        cursor: pointer;
        transition: 0.25s;
        backdrop-filter: blur(6px);
    }

    .sharji-top-btn:hover {
        background: #fff;
        color: var(--sharji-blue) !important;
        transform: translateY(-1px);
    }

    .sharji-top-btn.red {
        background: rgba(227, 30, 36, 0.92);
        border-color: rgba(255,255,255,0.20);
    }

    .sharji-top-btn.red:hover {
        background: #fff;
        color: var(--sharji-red) !important;
    }
    
    /* Dropdown */
    .sharji-dropdown {
        position: relative;
        display: inline-flex;
    }

    .sharji-dropdown::after {
        content: "";
        position: absolute;
        left: 0;
        right: 0;
        top: 100%;
        height: 12px;
        background: transparent;
    }

    .sharji-drop-menu {
        display: block;
        position: absolute;
        top: calc(100% + 8px);
        left: 0;
        background: #fff;
        min-width: 205px;
        box-shadow: 0 18px 40px rgba(15, 23, 42, 0.18);
        z-index: 12000;
        border-radius: 14px;
        border: 1px solid var(--sharji-border);
        padding: 7px;
        overflow: hidden;
        opacity: 0;
        visibility: hidden;
        transform: translateY(8px);
        pointer-events: none;
        transition: all 0.2s ease;
    }

    .sharji-dropdown:hover .sharji-drop-menu {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
        pointer-events: auto;
    }

    .sharji-drop-menu a {
        color: #334155 !important;
        padding: 10px 12px;
        display: flex;
        align-items: center;
        gap: 9px;
        font-size: 12px;
        border-radius: 10px;
        font-weight: 700;
        transition: 0.25s;
        white-space: nowrap;
    }

    .sharji-drop-menu a:hover {
        background: #f8fafc;
        color: var(--sharji-blue) !important;
    }

    .sharji-drop-menu a.sharji-admin-link {
        color: #16a34a !important;
        background: #f0fdf4;
    }

    .sharji-drop-menu a.sharji-logout-link {
        color: var(--sharji-red) !important;
        background: #fff5f5;
    }
    
    /* ========== Logo + Ads ========== */
.sharji-logo-section {
    display: none;
    background:
        linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);
    border-bottom: 1px solid #edf2f7;
    position: relative;
    z-index: auto;
    overflow: visible;
}

    .sharji-logo-inner {
        display: grid;
        grid-template-columns: minmax(0, 1fr) auto minmax(0, 1fr);
        align-items: center;
        gap: 24px;
        padding: 10px 0 8px;
        width: 100%;
    }

.sharji-logo-wrap {
    display: flex;
    justify-content: center;
    align-items: center;
    position: relative;
    z-index: 9500;
}

.sharji-logo {
    height: 158px;
    width: auto;
    object-fit: contain;
    margin-top: -46px;
    margin-bottom: -34px;
    flex-shrink: 0;
    filter: drop-shadow(0 14px 22px rgba(0, 86, 179, 0.14));
    position: relative;
    z-index: 9500;
}

.sharji-banner {
    height: 112px;
    background:
        linear-gradient(135deg, #f8fafc 0%, #ffffff 60%, #eff6ff 100%);
    border: 1px solid var(--sharji-border);
    border-radius: 16px;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 12px 28px rgba(15, 23, 42, 0.05);
    position: relative;
    z-index: 1;
}

    .sharji-banner img,
    .sharji-banner div {
        width: 100% !important;
        height: 100% !important;
        object-fit: cover !important;
    }

    .sharji-banner:empty::before {
        content: "جایگاه تبلیغات";
        color: #94a3b8;
        font-size: 12px;
        font-weight: 800;
        border: 1px dashed #cbd5e1;
        padding: 8px 18px;
        border-radius: 999px;
    }
    
    /* ========== Main Navbar ========== */
    .sharji-navbar {
        display: none;
        background: #fff;
        border-bottom: 1px solid var(--sharji-border);
        position: sticky;
        top: 0;
        z-index: 1000;
        box-shadow: 0 12px 34px rgba(15, 23, 42, 0.08);
    }

    .sharji-nav-inner {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 18px;
        padding: 9px 0;
        width: 100%;
    }

    .sharji-nav-links {
        display: flex;
        align-items: center;
        gap: 7px;
        flex-wrap: wrap;
    }

    .sharji-nav-link,
    .sharji-nav-dd-btn {
        background:
            linear-gradient(135deg, var(--sharji-blue), #0b66c3);
        color: white !important;
        padding: 8px 15px;
        border-radius: 999px;
        font-size: 13px;
        font-weight: 900;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        min-height: 38px;
        white-space: nowrap;
        transition: all 0.25s ease;
        border: 1px solid rgba(255,255,255,0.20);
        box-shadow: 0 8px 18px rgba(0, 86, 179, 0.12);
        cursor: pointer;
    }

    .sharji-nav-link:hover,
    .sharji-nav-dd-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 28px rgba(0, 86, 179, 0.20);
        background:
            linear-gradient(135deg, var(--sharji-blue-dark), var(--sharji-blue));
    }

    .sharji-nav-link.red {
        background:
            linear-gradient(135deg, var(--sharji-red), #ef4444);
        box-shadow: 0 8px 18px rgba(227, 30, 36, 0.13);
    }

    .sharji-nav-link.red:hover {
        background:
            linear-gradient(135deg, #c41218, var(--sharji-red));
        box-shadow: 0 12px 28px rgba(227, 30, 36, 0.22);
    }

    .sharji-nav-cats {
        position: relative;
        display: inline-flex;
    }

    .sharji-nav-cats::after {
        content: "";
        position: absolute;
        top: 100%;
        right: 0;
        left: 0;
        height: 14px;
        background: transparent;
    }

    .sharji-nav-cat-menu {
        display: block;
        position: absolute;
        top: calc(100% + 9px);
        right: 0;
        min-width: 220px;
        background: #fff;
        border: 1px solid var(--sharji-border);
        border-radius: 16px;
        box-shadow: 0 20px 46px rgba(15, 23, 42, 0.17);
        padding: 8px;
        opacity: 0;
        visibility: hidden;
        transform: translateY(8px);
        pointer-events: none;
        transition: all 0.22s ease;
        z-index: 10001;
    }

    .sharji-nav-cats:hover .sharji-nav-cat-menu {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
        pointer-events: auto;
    }

    .sharji-nav-cat-menu a {
        display: flex;
        align-items: center;
        gap: 9px;
        color: #334155;
        font-size: 13px;
        font-weight: 800;
        padding: 11px 12px;
        border-radius: 11px;
        transition: all 0.22s ease;
    }

    .sharji-nav-cat-menu a i {
        color: var(--sharji-blue);
        width: 18px;
        text-align: center;
    }

    .sharji-nav-cat-menu a:hover {
        background: var(--sharji-blue-soft);
        color: var(--sharji-blue);
        transform: translateX(-3px);
    }
    
    .sharji-actions {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-shrink: 0;
    }
    
    /* Socials */
    .sharji-socials {
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .sharji-soc-icon {
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        background: #f8fafc;
        color: var(--sharji-blue);
        border: 1px solid var(--sharji-border);
        transition: all 0.25s ease;
    }

    .sharji-soc-icon img {
        width: 20px;
        height: 20px;
        object-fit: contain;
        transition: transform 0.25s ease;
    }

    .sharji-soc-icon:hover {
        background: var(--sharji-blue);
        border-color: var(--sharji-blue);
        transform: translateY(-2px);
        box-shadow: 0 10px 22px rgba(0, 86, 179, 0.18);
    }

    .sharji-soc-icon:hover img {
        transform: scale(1.08);
    }
    
    /* Search */
    .sharji-search {
        display: flex;
        align-items: center;
        border: 1px solid var(--sharji-border);
        border-radius: 999px;
        background: #f8fafc;
        height: 38px;
        position: relative;
        overflow: visible;
        transition: all 0.25s ease;
    }

    .sharji-search:focus-within {
        background: #fff;
        border-color: rgba(0, 86, 179, 0.40);
        box-shadow: 0 0 0 4px rgba(0, 86, 179, 0.08);
    }

    .sharji-search input {
        border: none;
        outline: none;
        padding: 0 14px 0 6px;
        height: 100%;
        width: 165px;
        background: transparent;
        font-size: 12px;
        color: #334155;
    }

    .sharji-search input::placeholder {
        color: #94a3b8;
    }

    .sharji-search button {
        border: none;
        background: var(--sharji-blue);
        cursor: pointer;
        color: #fff;
        width: 32px;
        height: 32px;
        border-radius: 999px;
        margin-left: 3px;
        font-size: 13px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: 0.25s;
    }

    .sharji-search button:hover {
        background: var(--sharji-red);
    }

    .sharji-live-drop {
        position: absolute;
        top: calc(100% + 8px);
        left: 0;
        width: 280px;
        background: white;
        border: 1px solid var(--sharji-border);
        border-radius: 14px;
        box-shadow: 0 18px 42px rgba(15,23,42,0.16);
        z-index: 10000;
        display: none;
        max-height: 320px;
        overflow-y: auto;
        padding: 7px;
    }

    .sharji-live-drop a {
        display: block;
        padding: 10px 11px;
        border-radius: 10px;
        color: #334155;
        font-size: 12px;
        line-height: 1.7;
        font-weight: 700;
        transition: 0.25s;
    }

    .sharji-live-drop a:hover {
        background: var(--sharji-blue-soft);
        color: var(--sharji-blue);
    }
    
    .sharji-dot {
        position: relative;
        display: inline-block;
        width: 7px;
        height: 7px;
        background: #22c55e;
        border-radius: 50%;
        margin-left: 7px;
        box-shadow: 0 0 0 4px rgba(34, 197, 94, 0.12);
    }

    .sharji-dot::after {
        content: "";
        position: absolute;
        inset: 0;
        border-radius: 999px;
        background: #22c55e;
        animation: sharji-pulse 2s infinite;
    }

    @keyframes sharji-pulse {
        0% { transform: scale(1); opacity: 0.8; }
        100% { transform: scale(3); opacity: 0; }
    }
    
    /* ========== Mobile Header ========== */
    .sharji-mob-bar {
        display: flex;
        background:
            linear-gradient(135deg, var(--sharji-blue) 0%, #0b66c3 58%, #0f172a 100%);
        padding: 6px 12px;
        align-items: center;
        justify-content: space-between;
        position: sticky;
        top: 0;
        z-index: 1000;
        height: 60px;
        box-shadow: 0 10px 26px rgba(15, 23, 42, 0.18);
        border-bottom: 1px solid rgba(255,255,255,0.12);
    }

    .sharji-mob-logo {
        height: 46px;
        width: auto;
        object-fit: contain;
        display: block;
        filter: drop-shadow(0 8px 14px rgba(0,0,0,0.18));
    }

    .sharji-mob-icon {
        color: #fff !important;
        font-size: 21px;
        cursor: pointer;
        width: 40px;
        height: 40px;
        border-radius: 999px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(255,255,255,0.11);
        border: 1px solid rgba(255,255,255,0.16);
    }
    
    /* Mobile Panel */
    .sharji-mob-panel {
        position: fixed;
        top: 0;
        right: -315px;
        width: 315px;
        max-width: 88vw;
        height: 100%;
        background: #fff;
        z-index: 2001;
        transition: 0.3s;
        padding: 0;
        overflow-y: auto;
        box-shadow: -20px 0 60px rgba(15, 23, 42, 0.20);
    }

    .sharji-mob-panel.open {
        right: 0;
    }

    .sharji-mob-overlay {
        position: fixed;
        inset: 0;
        background: rgba(15, 23, 42, 0.55);
        backdrop-filter: blur(3px);
        z-index: 2000;
        display: none;
    }

    .sharji-mob-overlay.show {
        display: block;
    }
    
    .sharji-mob-panel-head {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 18px 16px;
        margin-bottom: 0;
        background:
            linear-gradient(135deg, var(--sharji-blue), #0b66c3);
        color: #fff;
    }

    .sharji-mob-panel-head span {
        font-family: 'Diba', 'Vazirmatn', sans-serif;
        font-weight: 900;
        color: #fff;
        font-size: 20px;
    }

    .sharji-mob-panel-head i {
        font-size: 20px;
        cursor: pointer;
        color: #fff;
    }

    .sharji-mob-menu {
        padding: 10px 12px 18px;
    }
    
    .sharji-mob-menu a {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 12px 8px;
        border-bottom: 1px solid #f1f5f9;
        color: #334155;
        font-weight: 800;
        font-size: 13px;
        border-radius: 10px;
        transition: 0.25s;
    }

    .sharji-mob-menu a:hover {
        background: #f8fafc;
        color: var(--sharji-blue);
    }

    .sharji-mob-menu a i {
        width: 20px;
        color: var(--sharji-blue);
        text-align: center;
    }

    .sharji-mob-menu-divider {
        height: 1px;
        background: #e2e8f0;
        margin: 10px 0;
    }

    .sharji-mob-section-title {
        font-size: 11px;
        font-weight: 900;
        color: #94a3b8;
        padding: 12px 8px 6px;
    }
    
    /* ========== Ticker ========== */
    .sharji-ticker {
        background: #fff;
        border-top: 1px solid rgba(0, 86, 179, 0.18);
        border-bottom: 4px solid var(--sharji-blue);
        height: 42px;
        display: flex;
        align-items: center;
        overflow: hidden;
        box-shadow: 0 8px 20px rgba(15, 23, 42, 0.06);
        position: relative;
        z-index: 10;
    }

    .sharji-ticker-inner {
        display: flex;
        align-items: center;
        height: 100%;
        width: 100%;
        overflow: hidden;
    }

    .sharji-ticker-tag {
        background:
            linear-gradient(135deg, var(--sharji-red), #ef4444);
        color: white;
        font-weight: 900;
        padding: 0 20px;
        height: 100%;
        display: flex;
        align-items: center;
        font-size: 13px;
        white-space: nowrap;
        flex-shrink: 0;
        position: relative;
        z-index: 2;
    }

    .sharji-ticker-tag i {
        margin-left: 7px;
    }

    .sharji-ticker-track {
        flex-grow: 1;
        overflow: hidden;
        height: 100%;
        display: flex;
        align-items: center;
        background:
            linear-gradient(90deg, #ffffff 0%, #f8fafc 100%);
    }

    .sharji-ticker-move {
        display: flex;
        white-space: nowrap;
        animation: sharji-tick 38s linear infinite;
        will-change: transform;
    }

    .sharji-ticker-move:hover {
        animation-play-state: paused;
    }

    .sharji-ticker-move a {
        color: var(--sharji-blue);
        font-weight: 800;
        font-size: 13px;
        margin-left: 50px;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .sharji-ticker-move a::before {
        content: "";
        width: 6px;
        height: 6px;
        border-radius: 999px;
        background: var(--sharji-red);
        display: inline-block;
    }

    @keyframes sharji-tick {
        0% { transform: translateX(100%); }
        100% { transform: translateX(-100%); }
    }
    
    /* ========== Responsive ========== */
    @media (min-width: 1024px) {
        .sharji-mob-bar,
        .sharji-mob-panel,
        .sharji-mob-overlay {
            display: none !important;
        }

        .sharji-top-bar,
        .sharji-logo-section,
        .sharji-navbar {
            display: block;
        }

        .sharji-wrapper {
            padding: 0 40px;
        }
    }
    
    @media (max-width: 1280px) and (min-width: 1024px) {
        .sharji-nav-link,
        .sharji-nav-dd-btn {
            padding: 8px 11px;
            font-size: 12px;
        }

        .sharji-search input {
            width: 125px;
        }

        .sharji-socials {
            display: none;
        }

        .sharji-logo {
            height: 145px;
        }
    }

    @media (max-width: 1023px) {
        .sharji-wrapper {
            padding: 0 12px;
        }

        .sharji-ticker {
            height: 40px;
            border-bottom-width: 3px;
        }

        .sharji-ticker-tag {
            padding: 0 14px;
            font-size: 12px;
        }

        .sharji-ticker-move a {
            font-size: 12px;
            margin-left: 38px;
        }
    }

    @media (max-width: 480px) {
        .sharji-mob-logo {
            height: 42px;
        }

        .sharji-mob-bar {
            height: 58px;
            padding: 6px 10px;
        }

        .sharji-mob-icon {
            width: 38px;
            height: 38px;
            font-size: 19px;
        }
    }
</style>
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

<script>
function sharjiToggleMenu() {
    var panel = document.getElementById('sharjiPanel');
    var overlay = document.getElementById('sharjiOverlay');

    if (!panel || !overlay) return;

    panel.classList.toggle('open');
    overlay.classList.toggle('show');
    document.body.classList.toggle('no-scroll');
}

(function() {
    var input = document.getElementById('sharjiSearchInput');
    var results = document.getElementById('sharjiLiveResults');

    if (!input || !results) return;

    var debounceTimer = null;
    
    input.addEventListener('input', function(e) {
        var term = e.target.value.trim();

        clearTimeout(debounceTimer);

        if (term.length < 2) {
            results.innerHTML = '';
            results.style.display = 'none';
            return;
        }

        debounceTimer = setTimeout(async function() {
            try {
                var response = await fetch('<?php echo esc_url( home_url() ); ?>/wp-json/wp/v2/posts?search=' + encodeURIComponent(term) + '&per_page=5&_fields=id,title,link');
                var posts = await response.json();

                if (posts.length > 0) {
                    var html = '';

                    posts.forEach(function(post) {
                        html += '<a href="' + post.link + '">' + post.title.rendered + '</a>';
                    });

                    results.innerHTML = html;
                    results.style.display = 'block';
                } else {
                    results.innerHTML = '<div style="padding:12px; font-size:12px; color:#64748b;">موردی یافت نشد.</div>';
                    results.style.display = 'block';
                }
            } catch(err) {
                results.innerHTML = '<div style="padding:12px; font-size:12px; color:#e31e24;">خطا در جستجو</div>';
                results.style.display = 'block';
            }
        }, 260);
    });

    document.addEventListener('click', function(e) {
        if (!input.contains(e.target) && !results.contains(e.target)) {
            results.style.display = 'none';
        }
    });
})();
</script>