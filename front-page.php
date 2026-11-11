<?php get_header(); ?>

<!-- Swiper CSS - Local -->
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/swiper-bundle.min.css" />

<?php
$bargozideh_cat = get_category_by_slug('bargozideh');
$bargozideh_link = $bargozideh_cat ? get_category_link($bargozideh_cat->term_id) : home_url('/category/bargozideh');
?>

<style>
    /* =========================================================
       FONT LOADING (LOCAL)
    ========================================================= */
    @font-face { 
        font-family: 'Diba'; 
        src: url('<?php echo get_template_directory_uri(); ?>/fonts/Diba.woff2') format('woff2'); 
        font-weight: bold; font-style: normal; font-display: swap;
    }
    @font-face { 
        font-family: 'Vazirmatn'; 
        src: url('<?php echo get_template_directory_uri(); ?>/fonts/Vazirmatn.woff2') format('woff2'); 
        font-weight: normal; font-style: normal; font-display: swap;
    }
    @font-face { 
        font-family: 'Vazirmatn'; 
        src: url('<?php echo get_template_directory_uri(); ?>/fonts/Vazirmatn-Bold.woff2') format('woff2'); 
        font-weight: bold; font-style: normal; font-display: swap;
    }

    :root {
        --primary-blue: #0056b3;
        --primary-blue-dark: #004494;
        --primary-blue-soft: #eff6ff;
        --accent-red: #ef4444;
        --accent-red-dark: #dc2626;
        --page-bg: #f1f5f9;
        --card-bg: #ffffff;
        --text-main: #1e293b;
        --text-muted: #64748b;
        --border-soft: #e2e8f0;
    }

    /* فونت پیش‌فرض بدنه سایت */
    body {
        font-family: 'Vazirmatn', sans-serif !important;
        background:
            radial-gradient(circle at top right, rgba(0, 86, 179, 0.10), transparent 32%),
            radial-gradient(circle at bottom left, rgba(239, 68, 68, 0.07), transparent 30%),
            var(--page-bg) !important;
        color: var(--text-main);
    }

    /* =========================================================
       ۱. عناوین اخبار و عناوین بخش‌ها (Desktop & Mobile) -> Diba
    ========================================================= */
    .slider-caption-box h2,
    .side-title,
    .special-row h4,
    .m-row-title,
    .swiper-mobile h2,
    .font-diba,
    .home-section-header span,
    .home-section-header a {
        font-family: 'Diba', sans-serif !important;
        letter-spacing: -0.01em;
    }

    /* =========================================================
       ۲. چکیده‌ها و ساختارهای فرعی غیر از تیتر -> Vazirmatn
    ========================================================= */
    .side-excerpt,
    .slider-excerpt-force,
    .m-row-excerpt,
    .m-tab-btn,
    #global-load-more,
    .m-load-btn-style,
    .read-more,
    .view-badge,
    .mobile-home-ad-label,
    .home-section-header .text-xs {
        font-family: 'Vazirmatn', sans-serif !important;
        letter-spacing: normal;
    }

    a {
        text-decoration: none;
    }

    .blue-title {
        color: var(--primary-blue) !important;
        transition: 0.3s;
    }

    .blue-title:hover {
        color: var(--primary-blue) !important;
    }

    .home-top-shell {
        margin-top: 18px;
        border-radius: 22px;
        overflow: hidden;
        box-shadow: 0 24px 60px rgba(15, 23, 42, 0.13);
        border: 1px solid rgba(226, 232, 240, 0.9);
        background: #fff;
    }

    .home-section-header {
        background:
            linear-gradient(135deg, var(--primary-blue) 0%, #0b66c3 55%, #0f172a 100%);
        position: relative;
        overflow: hidden;
    }

    .home-section-header::before {
        content: "";
        position: absolute;
        top: -70px;
        left: -80px;
        width: 210px;
        height: 210px;
        background: rgba(255,255,255,0.10);
        border-radius: 999px;
    }

    .home-section-header::after {
        content: "";
        position: absolute;
        right: -50px;
        bottom: -80px;
        width: 170px;
        height: 170px;
        background: rgba(239,68,68,0.16);
        border-radius: 999px;
    }

    .home-section-header a,
    .home-section-header div {
        position: relative;
        z-index: 2;
    }

    .home-header-link {
        transition: none;
    }

    .home-header-link:hover,
    .home-section-header a:hover,
    .home-section-header .home-header-link:hover {
        background-color: #0056b3 !important;
        color: #fff !important;
    }

    .news-grid {
        display: grid;
        grid-template-columns: 24% 52% 24%;
        gap: 2px;
        background: #e2e8f0;
        position: relative;
    }

    .n-box { 
        background: #fff !important; 
        display: flex; 
        gap: 10px; 
        padding: 10px 12px; 
        min-height: 100px;
        height: auto; 
        align-items: flex-start; 
        border-bottom: 1px solid #f1f5f9; 
        text-decoration: none !important; 
        transition: all 0.25s ease; 
        position: relative;
        overflow: hidden;
    }

    .n-box::before {
        content: "";
        position: absolute;
        top: 0;
        right: 0;
        width: 3px;
        height: 0;
        background: var(--primary-blue);
        transition: height 0.25s ease;
    }

    .n-box:hover {
        background: linear-gradient(90deg, #ffffff 0%, #f8fafc 100%) !important;
    }

    .n-box:hover::before {
        height: 100%;
    }

    .n-box .overflow-hidden img,
    .slider-img-frame img,
    #latest-news-center-list img {
        transition: transform 0.5s ease, filter 0.5s ease;
        will-change: transform;
    }

    /* Edge-to-Edge Slider Fix */
    .slider-img-frame img {
        position: absolute !important;
        top: 0;
        left: 0;
        width: 100% !important;
        height: 100% !important;
        min-width: 100% !important;
        min-height: 100% !important;
        object-fit: cover !important;
    }

    .n-box:hover img {
        transform: scale(1.1);
        filter: brightness(1.05);
    }

    .slider-img-frame:hover img {
        transform: scale(1.035);
        filter: brightness(1.05);
    }

    #latest-news-center-list a:hover img {
        transform: scale(1.05);
        filter: brightness(1.05);
    }

    .side-title {
        font-size: 13.5px !important;
        line-height: 1.65;
        font-weight: bold;
        margin-bottom: 4px;
    }

    .side-excerpt { 
        color: #64748b; 
        font-size: 10px; 
        line-height: 1.7; 
        display: -webkit-box; 
        -webkit-line-clamp: 3; 
        -webkit-box-orient: vertical; 
        overflow: hidden; 
        text-align: justify; 
    }

    .side-column {
        height: 620px;
        display: flex;
        flex-direction: column;
        background: #fff;
    }

    .side-column-long {
        height: auto;
        display: flex;
        flex-direction: column;
        background: #fff;
        position: relative;
    }

    .slider-container {
        position: relative;
        overflow: hidden;
        background: #fff;
        height: 620px;
    }

    .slider-container::before {
        content: "";
        position: absolute;
        inset: 0;
        z-index: 4;
        pointer-events: none;
        background: linear-gradient(to top, rgba(15,23,42,0.12), transparent 42%);
    }

    .slider-img-frame {
        height: 450px;
        width: 100%;
        overflow: hidden;
        position: relative;
    }

    .slider-img-frame::after {
        content: "";
        position: absolute;
        inset: 0;
        background: linear-gradient(to top, rgba(15,23,42,0.18), transparent 48%);
        pointer-events: none;
    }

    .slider-caption-box {
        height: 170px;
        padding: 18px 22px;
        background:
            linear-gradient(135deg, #ffffff 0%, #f8fafc 60%, #eff6ff 100%);
        border-top: 5px solid var(--primary-blue);
        box-sizing: border-box;
        position: relative;
    }

    .slider-caption-box::before {
        content: "";
        position: absolute;
        top: -5px;
        right: 0;
        width: 130px;
        height: 5px;
        background: var(--accent-red);
    }

    .slider-excerpt-force {
        display: -webkit-box;
        -webkit-line-clamp: 4;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-align: justify;
        font-size: 14px;
        line-height: 1.85;
        color: #4b5563;
        margin-bottom: 4px;
    }

    .read-more {
        color: var(--accent-red);
        font-weight: bold;
        font-size: 11px;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        margin-top: auto;
        transition: all 0.25s ease;
    }

    .read-more:hover {
        color: var(--accent-red);
        transform: none;
    }

    .view-badge { 
        font-size: 9px; 
        color: #94a3b8; 
        display: flex; 
        align-items: center; 
        gap: 4px;
        margin-top: 6px; 
    }

    .load-more-global-wrapper {
        background:
            linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
        padding: 24px;
        text-align: center;
        border-top: 2px solid #e2e8f0;
        margin-bottom: 40px;
        border-radius: 0 0 22px 22px;
    }

    #global-load-more {
        background: linear-gradient(135deg, var(--primary-blue), #0b66c3);
        color: #fff;
        padding: 12px 44px;
        border-radius: 999px;
        font-weight: bold;
        transition: 0.3s;
        cursor: pointer;
        font-size: 15px;
        border: none;
        box-shadow: 0 12px 26px rgba(0,86,179,0.22);
    }

    #global-load-more:hover {
        background: linear-gradient(135deg, #004494, #0056b3);
        transform: translateY(-3px);
        box-shadow: 0 16px 35px rgba(0,86,179,0.30);
    }

    .slider-nav {
        position: absolute;
        top: 205px;
        width: 100%;
        display: flex;
        justify-content: space-between;
        padding: 0 14px;
        z-index: 10;
        pointer-events: none;
    }

    .nav-btn {
        background: rgba(15,23,42,0.58);
        backdrop-filter: blur(6px);
        color: #fff;
        width: 38px;
        height: 38px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        pointer-events: auto;
        transition: 0.3s;
        border: 1px solid rgba(255,255,255,0.18);
    }

    .nav-btn:hover {
        background: var(--primary-blue);
        transform: scale(1.1);
    }

    .special-row {
        height: 142px; 
        display: flex;
        gap: 15px;
        padding: 12px;
        border-bottom: 1px solid #f1f5f9;
        text-decoration: none !important;
        align-items: center;
        position: relative;
        overflow: hidden;
        transition: all 0.25s ease;
    }

    .special-row::before {
        content: "";
        position: absolute;
        right: 0;
        top: 20%;
        width: 4px;
        height: 60%;
        background: transparent;
        border-radius: 999px;
        transition: background 0.25s ease;
    }

    .special-row:hover {
        background: linear-gradient(90deg, #fff 0%, #f8fafc 100%);
    }

    .special-row:hover::before {
        background: var(--accent-red);
    }

    .mobile-home-ad-box {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        overflow: hidden;
        margin: 16px 0 24px;
        box-shadow: 0 10px 24px rgba(15, 23, 42, 0.08);
    }

    .mobile-home-ad-label {
        background: linear-gradient(135deg, #f8fafc, #eff6ff);
        color: #64748b;
        font-size: 11px;
        font-weight: bold;
        padding: 8px 12px;
        border-bottom: 1px solid #e2e8f0;
    }

    .mobile-home-ad-content {
        padding: 10px;
    }

    .mobile-home-ad-content img,
    .mobile-home-ad-widget img {
        width: 100% !important;
        height: auto !important;
        display: block;
        border-radius: 10px;
    }

    /* === INTERVIEW FIX === */
    #interviews-list .n-box {
        flex-direction: row !important;
        align-items: center !important;
    }

    #interviews-list .w-20 {
        flex-shrink: 0 !important;
        width: 80px !important;
        height: 80px !important;
    }

    /* جایگزین‌های Tailwind */
    .hidden { display: none; }
    .lg\:block { display: none; }
    .lg\:hidden { display: block; }
    .lg\:col-start-2 { grid-column-start: 2; }
    .flex { display: flex; }
    .flex-col { flex-direction: column; }
    .items-center { align-items: center; }
    .justify-center { justify-content: center; }
    .justify-between { justify-content: space-between; }
    .flex-1 { flex: 1 1 0%; }
    .flex-shrink-0 { flex-shrink: 0; }
    .w-full { width: 100%; }
    .h-full { height: 100%; }
    .h-auto { height: auto; }
    .w-24 { width: 96px; }
    .h-16 { height: 64px; }
    .w-20 { width: 80px; }
    .object-cover { object-fit: cover; }
    .overflow-hidden { overflow: hidden; }
    .rounded { border-radius: 4px; }
    .rounded-t-lg { border-top-left-radius: 8px; border-top-right-radius: 8px; }
    .rounded-b-lg { border-bottom-left-radius: 8px; border-bottom-right-radius: 8px; }
    .rounded-xl { border-radius: 12px; }
    .rounded-full { border-radius: 9999px; }
    .relative { position: relative; }
    .absolute { position: absolute; }
    .inset-0 { top: 0; right: 0; bottom: 0; left: 0; }
    .text-white { color: #fff; }
    .text-xs { font-size: 12px; }
    .text-sm { font-size: 14px; }
    .text-lg { font-size: 18px; }
    .text-xl { font-size: 20px; }
    .text-2xl { font-size: 24px; }
    .text-\[10px\] { font-size: 10px; }
    .font-bold { font-weight: bold; }
    .leading-tight { line-height: 1.25; }
    .leading-relaxed { line-height: 1.625; }
    .no-underline { text-decoration: none; }
    .mb-1 { margin-bottom: 4px; }
    .mb-2 { margin-bottom: 8px; }
    .mb-4 { margin-bottom: 16px; }
    .mb-6 { margin-between: 24px; }
    .mb-10 { margin-bottom: 40px; }
    .mt-1 { margin-top: 4px; }
    .mt-4 { margin-top: 16px; }
    .ml-1 { margin-left: 4px; }
    .ml-2 { margin-left: 8px; }
    .p-4 { padding: 16px; }
    .px-2 { padding-left: 8px; padding-right: 8px; }
    .px-5 { padding-left: 20px; padding-right: 20px; }
    .px-6 { padding-left: 24px; padding-right: 24px; }
    .py-0\.5 { padding-top: 2px; padding-bottom: 2px; }
    .py-3 { padding-top: 12px; padding-bottom: 12px; }
    .gap-2 { gap: 8px; }
    .bg-white { background-color: #fff; }
    .bg-\[\#0056b3\] { background-color: #0056b3; }
    .bg-\[\#e31e24\] { background-color: #e31e24; }
    .bg-black\/20 { background-color: rgba(0,0,0,0.2); }
    .bg-black\/30 { background-color: rgba(0,0,0,0.3); }
    .text-gray-600 { color: #4b5563; }
    .text-blue-600 { color: #2563eb; }
    .text-yellow-400 { color: #facc15; }
    .bg-blue-50 { background-color: #eff6ff; }
    .border-t { border-top: 1px solid #f3f4f6; }
    .border-b { border-bottom: 1px solid #e5e7eb; }
    .border-x { border-left: 1px solid #e5e7eb; border-right: 1px solid #e5e7eb; }
    .border-l { border-left: 1px solid #e5e7eb; }
    .border-r { border-right: 1px solid #e5e7eb; }
    .border-white\/40 { border-color: rgba(255,255,255,0.4); }
    .drop-shadow-md { filter: drop-shadow(0 4px 3px rgba(0, 0, 0, 0.07)); }
    .drop-shadow-sm { filter: drop-shadow(0 1px 1px rgba(0,0,0,0.05)); }
    .shadow { box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px -1px rgba(0, 0, 0, 0.1); }
    .shadow-lg { box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -4px rgba(0, 0, 0, 0.1); }
    .shadow-md { box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -2px rgba(0, 0, 0, 0.1); }
    .shadow-sm { box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05); }
    .inline-block { display: inline-block; }
    .inline-flex { display: inline-flex; }
    .transition { transition: all 0.3s; }
    .transition-colors { transition: color 0.3s, background-color 0.3s; }
    .cursor-pointer { cursor: pointer; }
    .hover\:bg-\[\#004494\]:hover { background-color: #0056b3 !important; }
    .hover\:text-gray-200:hover { color: #fff !important; }
    .bg-gradient-to-t { background-image: linear-gradient(to top, var(--tw-gradient-stops)); }
    .from-black\/90 { --tw-gradient-from: rgba(0,0,0,0.9); --tw-gradient-stops: var(--tw-gradient-from), var(--tw-gradient-to); }
    .via-black\/20 { --tw-gradient-to: rgba(0,0,0,0); --tw-gradient-stops: var(--tw-gradient-from), rgba(0,0,0,0.2), var(--tw-gradient-to); }
    .to-transparent { --tw-gradient-to: transparent; }
    .bottom-0 { bottom: 0; }
    .right-0 { right: 0; }
    .line-clamp-3 { display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; }
    .mx-auto { margin-left: auto; margin-right: auto; }
    .text-justify { text-align: justify; }
    .min-w-full { min-width: 100%; }
    .h-\[55px\] { height: 55px; }
    .h-\[240px\] { height: 240px; }
    .w-\[180px\] { width: 180px; }
    .h-\[120px\] { height: 120px; }
    .block { display: block; }
    .text-center { text-align: center; }
    .duration-700 { transition-duration: 700ms; }

    @media (max-width: 1024px) {
        .main-site-container { padding: 0 10px; }
        .lg\:block { display: none !important; }
        .lg\:hidden { display: block; }

        .m-tab-btn {
            flex: 1;
            padding: 13px 10px;
            text-align: center;
            background: #fff;
            color: #64748b;
            font-family: 'Diba', sans-serif !important;
            font-size: 14px;
            cursor: pointer;
            border-bottom: 3px solid transparent;
            transition: 0.3s;
        }

        .m-tab-btn.active {
            color: var(--primary-blue) !important;
            border-bottom: 3px solid var(--accent-red) !important;
            font-weight: bold;
            background: linear-gradient(135deg, #ffffff, #f8fafc);
        }

        .m-news-row {
            display: flex;
            gap: 12px;
            padding: 15px 12px;
            background: #fff;
            border-bottom: 1px solid #f1f5f9;
            align-items: flex-start;
            text-decoration: none !important;
            transition: all 0.25s ease;
        }

        .m-news-row:hover {
            background: #f8fafc;
        }

        .m-row-thumb {
            width: 95px;
            height: 95px;
            flex-shrink: 0;
            border-radius: 10px;
            overflow: hidden;
            background: #eee;
            border: 1px solid #e2e8f0;
            position: relative;
        }

        .m-row-thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .m-row-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            height: 95px;
            justify-content: space-between;
        }

        .m-row-title {
            font-family: 'Diba', sans-serif !important;
            font-size: 14.5px;
            font-weight: bold;
            color: #1e293b;
            line-height: 1.55;
            margin-bottom: 4px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .m-row-excerpt {
            font-size: 11px;
            color: #64748b;
            line-height: 1.6;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-align: justify;
            margin-bottom: 4px;
        }

        .m-row-meta {
            font-size: 10px;
            color: #94a3b8;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .swiper-mobile {
            width: 100%;
            border-radius: 16px;
            overflow: hidden;
            margin-top: 15px;
            box-shadow: 0 16px 36px rgba(15, 23, 42, 0.18);
        }

        .swiper-mobile h2 {
            font-size: 20px !important;
            line-height: 1.55 !important;
        }

        .m-load-btn-style {
            background: linear-gradient(135deg, var(--primary-blue), #0b66c3);
            color: white;
            border: none;
            box-shadow: 0 8px 20px rgba(0, 86, 179, 0.24);
        }

        .m-load-btn-style:disabled {
            background: #cbd5e1;
            color: #64748b;
            box-shadow: none;
            cursor: not-allowed;
        }
    }

    @media (min-width: 1025px) {
        .lg\:block { display: block !important; }
        .lg\:hidden { display: none !important; }
    }
</style>

<div class="hidden lg:block">
    <div class="main-site-container">

        <div class="home-top-shell">
            <header class="news-grid desktop-only h-[55px] text-white home-section-header">
                <a href="/category/tahlil" class="home-header-link flex justify-between items-center px-5 bg-[#0056b3] no-underline text-white">
                    <span class="font-diba text-lg">تحلیل روز</span>
                    <i class="fas fa-chart-line"></i>
                </a>

                <div class="flex items-center justify-between px-6 bg-[#0056b3]">
                    <a href="<?php echo esc_url($bargozideh_link); ?>" class="font-diba text-2xl text-white no-underline">
                        <i class="fas fa tv text-yellow-400"></i> اخبار برگزیده
                    </a>
                    <a href="/category/news" class="text-xs border-b border-white/40 text-white no-underline">آرشیو</a>
                </div>

                <a href="/category/multimedia" class="home-header-link flex justify-between items-center px-5 bg-[#0056b3] text-white no-underline">
                    <span class="font-diba text-lg">چند رسانه‌ای</span>
                    <i class="fas fa-photo-video"></i>
                </a>
            </header>

            <div class="news-grid bg-white overflow-hidden border-b">
                <div class="side-column border-l">
                    <?php $t_q = new WP_Query(['category_name' => 'tahlil', 'posts_per_page' => 5, 'ignore_sticky_posts' => 1]); 
                    if($t_q->have_posts()): while($t_q->have_posts()): $t_q->the_post(); ?>
                    <a href="<?php the_permalink(); ?>" class="n-box">
                        <div class="w-24 h-16 flex-shrink-0 overflow-hidden rounded">
                            <?php the_post_thumbnail('medium', ['class' => 'w-full h-full object-cover']); ?>
                        </div>
                        <div class="flex-1 flex flex-col justify-between">
                            <div>
                                <h4 class="font-diba blue-title side-title"><?php the_title(); ?></h4>
                                <div class="side-excerpt"><?php echo get_the_excerpt(); ?></div>
                            </div>
                        </div>
                    </a>
                    <?php endwhile; wp_reset_postdata(); endif; ?>

                    <div class="ads-box" style="flex-grow:1; background:#f8fafc; overflow:hidden;">
                        <?php if ( is_active_sidebar( 'ads-video-sidebar' ) ) : dynamic_sidebar( 'ads-video-sidebar' ); endif; ?>
                    </div>
                </div>

                <div class="slider-container lg:col-start-2">
                    <div class="slider-nav">
                        <div class="nav-btn" onclick="prevSlide()"><i class="fas fa-chevron-right"></i></div>
                        <div class="nav-btn" onclick="nextSlide()"><i class="fas fa-chevron-left"></i></div>
                    </div>

                    <div id="main-slider" class="flex h-full transition-transform duration-700">
                        <?php $s_q = new WP_Query(['category_name' => 'bargozideh', 'posts_per_page' => 5, 'ignore_sticky_posts' => 1]); 
                        if($s_q->have_posts()): while($s_q->have_posts()): $s_q->the_post(); ?>
                        <div class="min-w-full flex flex-col h-full">
                            <a href="<?php the_permalink(); ?>" class="slider-img-frame block overflow-hidden">
                                <?php the_post_thumbnail('full', ['class' => 'w-full h-full object-cover']); ?>
                            </a>

                            <div class="slider-caption-box">
                                <a href="<?php the_permalink(); ?>" class="no-underline">
                                    <h2 class="font-diba blue-title text-2xl mb-1 leading-tight"><?php the_title(); ?></h2>
                                </a>
                                <div class="slider-excerpt-force"><?php echo get_the_excerpt(); ?></div>
                                <a href="<?php the_permalink(); ?>" class="read-more no-underline">
                                    ادامه خبر <i class="fas fa-angle-double-left"></i>
                                </a>
                            </div>
                        </div>
                        <?php endwhile; wp_reset_postdata(); endif; ?>
                    </div>
                </div>

                <div class="side-column border-r">
                    <?php 
                    $args_multi = [
                        'posts_per_page' => 5,
                        'ignore_sticky_posts' => 1,
                        'tax_query' => [
                            'relation' => 'OR',
                            ['taxonomy' => 'category', 'field' => 'slug', 'terms' => 'video'],
                            ['taxonomy' => 'category', 'field' => 'slug', 'terms' => 'image'],
                            ['taxonomy' => 'category', 'field' => 'slug', 'terms' => 'multimedia']
                        ]
                    ];
                    $i_q = new WP_Query($args_multi); 

                    if($i_q->have_posts()): while($i_q->have_posts()): $i_q->the_post(); 
                        $icon_class = 'fa-camera'; 
                        if (has_category('video')) $icon_class = 'fa-play';

                        $video_preview = get_post_meta(get_the_ID(), 'video_preview_url', true);
                        $has_valid_video = (!empty($video_preview) && filter_var($video_preview, FILTER_VALIDATE_URL));
                    ?>
                    <a href="<?php the_permalink(); ?>" class="n-box">
                        <div class="w-24 h-16 flex-shrink-0 relative overflow-hidden rounded <?php if($has_valid_video) echo 'bg-black'; ?>">
                            <?php if ($has_valid_video) : ?>
                                <video src="<?php echo esc_url($video_preview); ?>" loop muted playsinline class="w-full h-full object-cover" style="object-fit:cover!important; opacity:0.8;"></video>
                            <?php else : ?>
                                <?php the_post_thumbnail('medium', ['class' => 'w-full h-full object-cover']); ?>
                            <?php endif; ?>
                            <div class="absolute inset-0 bg-black/20 flex items-center justify-center">
                                <i class="fas <?php echo $icon_class; ?> text-white text-sm drop-shadow-md"></i>
                            </div>
                        </div>
                        <div class="flex-1 flex flex-col justify-between">
                            <div>
                                <h4 class="font-diba blue-title side-title"><?php the_title(); ?></h4>
                                <div class="side-excerpt"><?php echo get_the_excerpt(); ?></div>
                            </div>
                        </div>
                    </a>
                    <?php endwhile; wp_reset_postdata(); endif; ?>

                    <div class="ads-box" style="flex-grow:1; background:#f8fafc; overflow:hidden;">
                        <?php if ( is_active_sidebar( 'ads-image-sidebar' ) ) : dynamic_sidebar( 'ads-image-sidebar' ); endif; ?>
                    </div>
                </div>
            </div>

            <header class="news-grid desktop-only mt-1 h-[55px] text-white home-section-header">
                <a href="#" class="home-header-link flex justify-center items-center bg-[#0056b3] text-white no-underline transition-colors">
                    <span class="font-diba text-lg">پربازدیدترین‌ها</span>
                </a>

                <a href="/category/news" class="home-header-link flex justify-center items-center bg-[#0056b3] text-white no-underline transition-colors">
                    <span class="font-diba text-2xl">آخرین اخبار</span>
                </a>

                <a href="/category/interviews" class="home-header-link flex justify-center items-center bg-[#0056b3] text-white no-underline transition-colors">
                    <span class="font-diba text-lg">گفت‌وگوی ویژه</span>
                </a>
            </header>

            <div class="news-grid bg-white border-b">
                <div id="most-viewed-list" class="side-column-long border-l">
                    <?php 
                    $args_mv = [
                        'posts_per_page' => 8,
                        'ignore_sticky_posts' => 1,
                        'suppress_filters' => false,
                        'orderby' => 'post_views',
                        'order' => 'DESC'
                    ];
                    $q1 = new WP_Query($args_mv);
                    if (!$q1->have_posts()) {
                        $args_mv['suppress_filters'] = true; 
                        $args_mv['orderby'] = 'meta_value_num';
                        $args_mv['meta_key'] = 'views';
                        $q1 = new WP_Query($args_mv);
                    }
                    if (!$q1->have_posts()) {
                         unset($args_mv['meta_key']);
                         unset($args_mv['orderby']);
                         $q1 = new WP_Query($args_mv);
                    }
                    while($q1->have_posts()): $q1->the_post(); ?>
                    <a href="<?php the_permalink(); ?>" class="n-box">
                        <div class="w-20 h-16 flex-shrink-0 overflow-hidden rounded">
                            <?php the_post_thumbnail('thumbnail', ['class'=>'rounded object-cover w-full h-full']); ?>
                        </div>
                        <div class="flex-1 flex flex-col justify-between">
                            <div>
                                <h4 class="font-diba blue-title side-title"><?php the_title(); ?></h4>
                                <div class="side-excerpt"><?php echo get_the_excerpt(); ?></div>
                            </div>
                            <div class="view-badge">
                                <i class="fas fa-eye text-xs"></i>
                                <span class="live-view-count" data-id="<?php the_ID(); ?>"><?php if(function_exists('get_post_views')) echo get_post_views(get_the_ID()); ?></span>
                            </div>
                        </div>
                    </a>
                    <?php endwhile; wp_reset_postdata(); ?>
                </div>

                <div id="latest-news-center-list" class="lg:col-start-2 bg-white border-x flex flex-col h-auto">
                     <?php $q2 = new WP_Query(['category_name'=>'news', 'posts_per_page'=>6, 'ignore_sticky_posts' => 1]); 
                     if($q2->have_posts()): while($q2->have_posts()): $q2->the_post(); ?>
                    <a href="<?php the_permalink(); ?>" class="special-row">
                        <div class="w-[180px] h-[120px] overflow-hidden rounded flex-shrink-0">
                            <?php the_post_thumbnail('large', ['class'=>'w-full h-full object-cover']); ?>
                        </div>
                        <div class="flex-1 flex flex-col justify-center h-full">
                            <h4 class="font-diba text-xl blue-title mb-2 leading-tight"><?php the_title(); ?></h4>
                            <div class="text-gray-600 text-xs line-clamp-3 leading-relaxed text-justify"><?php echo get_the_excerpt(); ?></div>
                            <div class="read-more">ادامه خبر <i class="fas fa-angle-double-left"></i></div>
                        </div>
                    </a>
                    <?php endwhile; wp_reset_postdata(); endif; ?>
                </div>

                <div id="interviews-list" class="side-column-long border-r">
                    <?php $q3 = new WP_Query(['category_name' => 'interviews', 'posts_per_page' => 8, 'ignore_sticky_posts' => 1]); 
                    if($q3->have_posts()): while($q3->have_posts()): $q3->the_post(); ?>
                    <a href="<?php the_permalink(); ?>" class="n-box flex-col md:flex-row">
                        <div class="w-20 h-16 flex-shrink-0 relative overflow-hidden rounded">
                            <?php the_post_thumbnail('thumbnail', ['class'=>'rounded w-full h-full object-cover']); ?>
                        </div>
                        <div class="flex-1 flex flex-col justify-between">
                            <div>
                                <h4 class="font-diba blue-title side-title"><?php the_title(); ?></h4>
                                <div class="side-excerpt"><?php echo get_the_excerpt(); ?></div>
                            </div>
                            <span class="view-badge"><i class="far fa-clock"></i> <?php echo get_the_time('H:i'); ?></span>
                        </div>
                    </a>
                    <?php endwhile; wp_reset_postdata(); endif; ?>
                </div>
            </div>

            <div class="load-more-global-wrapper">
                <button id="global-load-more" class="font-diba flex items-center mx-auto gap-2">
                    <i class="fas fa-plus-circle"></i> مشاهده اخبار بیشتر
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Mobile View -->
<div class="lg:hidden main-site-container">
    <div class="swiper swiper-mobile shadow-lg mb-4">
        <div class="swiper-wrapper">
            <?php $m_s = new WP_Query(['category_name' => 'bargozideh', 'posts_per_page' => 5, 'ignore_sticky_posts' => 1]);
            if($m_s->have_posts()): while($m_s->have_posts()): $m_s->the_post(); ?>
            <div class="swiper-slide relative">
                <a href="<?php the_permalink(); ?>" class="block relative h-[240px]">
                    <?php the_post_thumbnail('large', ['class'=>'w-full h-full object-cover']); ?>
                    <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/20 to-transparent"></div>
                    <div class="absolute bottom-0 right-0 p-4 w-full text-white">
                        <span class="bg-[#e31e24] text-white text-[10px] px-2 py-0.5 rounded mb-2 inline-block shadow-sm">برگزیده</span>
                        <h2 class="font-diba text-white text-lg leading-tight drop-shadow-md"><?php the_title(); ?></h2>
                    </div>
                </a>
            </div>
            <?php endwhile; wp_reset_postdata(); endif; ?>
        </div>
        <div class="swiper-pagination"></div>
    </div>

    <?php if ( is_active_sidebar( 'home-mobile-ad' ) ) : ?>
        <div class="mobile-home-ad-box">
            <div class="mobile-home-ad-label">تبلیغات</div>
            <div class="mobile-home-ad-content">
                <?php dynamic_sidebar( 'home-mobile-ad' ); ?>
            </div>
        </div>
    <?php endif; ?>

    <div class="flex w-full rounded-t-lg overflow-hidden shadow border-b border-gray-200 bg-white">
        <div class="m-tab-btn active group-1-tab" onclick="toggleTabs(event, 'group1', 'm-news')" data-slug="news" data-btn="btn-load-1">آخرین اخبار</div>
        <div class="m-tab-btn group-1-tab" onclick="toggleTabs(event, 'group1', 'm-tahlil')" data-slug="tahlil" data-btn="btn-load-1">تحلیل روز</div>
    </div>

    <div class="bg-white shadow-md mb-6 rounded-b-lg">
        <div id="m-news" class="m-content group1-content">
            <div id="list-news">
                <?php $mq1 = new WP_Query(['category_name'=>'news', 'posts_per_page'=>5, 'ignore_sticky_posts' => 1]);
                while($mq1->have_posts()): $mq1->the_post(); ?>
                    <a href="<?php the_permalink(); ?>" class="m-news-row">
                        <div class="m-row-thumb">
                            <?php the_post_thumbnail('thumbnail', ['class'=>'w-full h-full object-cover']); ?>
                        </div>
                        <div class="m-row-content">
                            <h4 class="m-row-title"><?php the_title(); ?></h4>
                            <div class="m-row-excerpt"><?php echo wp_trim_words(get_the_excerpt(), 20, '...'); ?></div>
                            <div class="m-row-meta"><i class="far fa-clock"></i> <?php echo get_the_date('j F Y'); ?></div>
                        </div>
                    </a>
                <?php endwhile; wp_reset_postdata(); ?>
            </div>
        </div>

        <div id="m-tahlil" class="m-content group1-content hidden">
            <div id="list-tahlil">
                <?php $mq2 = new WP_Query(['category_name'=>'tahlil', 'posts_per_page'=>5, 'ignore_sticky_posts' => 1]);
                while($mq2->have_posts()): $mq2->the_post(); ?>
                    <a href="<?php the_permalink(); ?>" class="m-news-row">
                        <div class="m-row-thumb">
                            <?php the_post_thumbnail('thumbnail', ['class'=>'w-full h-full object-cover']); ?>
                        </div>
                        <div class="m-row-content">
                            <h4 class="m-row-title"><?php the_title(); ?></h4>
                            <div class="m-row-excerpt"><?php echo wp_trim_words(get_the_excerpt(), 20, '...'); ?></div>
                            <div class="m-row-meta"><i class="far fa-clock"></i> <?php echo get_the_date('j F Y'); ?></div>
                        </div>
                    </a>
                <?php endwhile; wp_reset_postdata(); ?>
            </div>
        </div>

        <div class="p-4 text-center border-t">
            <button id="btn-load-1" onclick="loadMoreMobile('btn-load-1', 'group1')" class="w-full py-3 rounded-xl m-load-btn-style font-diba text-sm transition flex justify-center items-center gap-2">
                <i class="fas fa-plus-circle"></i> مشاهده اخبار بیشتر
            </button>
        </div>
    </div>

    <div class="flex w-full mt-4 rounded-t-lg overflow-hidden shadow text-sm border-b border-gray-200 bg-white">
        <div class="m-tab-btn active group-2-tab" onclick="toggleTabs(event, 'group2', 'm-most')" data-slug="most_viewed" data-btn="btn-load-2">پربازدید</div>
        <div class="m-tab-btn group-2-tab" onclick="toggleTabs(event, 'group2', 'm-video')" data-slug="video" data-btn="btn-load-2">چندرسانه‌ای</div>
        <div class="m-tab-btn group-2-tab" onclick="toggleTabs(event, 'group2', 'm-interviews')" data-slug="interviews" data-btn="btn-load-2">گفت‌وگو</div>
    </div>

    <div class="bg-white shadow-md mb-10 rounded-b-lg">
        <div id="m-most" class="m-content group2-content">
            <div id="list-most_viewed">
                <?php
                $args_mv_mob = [
                    'posts_per_page' => 5,
                    'suppress_filters' => false,
                    'orderby' => 'post_views',
                    'order' => 'DESC'
                ];
                $mq3 = new WP_Query($args_mv_mob);
                if (!$mq3->have_posts()) {
                    $args_mv_mob['suppress_filters'] = true;
                    $args_mv_mob['orderby'] = 'meta_value_num';
                    $args_mv_mob['meta_key'] = 'views';
                    $mq3 = new WP_Query($args_mv_mob);
                }
                if (!$mq3->have_posts()) {
                    unset($args_mv_mob['meta_key']);
                    unset($args_mv_mob['orderby']);
                    $mq3 = new WP_Query($args_mv_mob);
                }
                while($mq3->have_posts()): $mq3->the_post(); ?>
                    <a href="<?php the_permalink(); ?>" class="m-news-row">
                        <div class="m-row-thumb">
                            <?php the_post_thumbnail('thumbnail', ['class'=>'w-full h-full object-cover']); ?>
                        </div>
                        <div class="m-row-content">
                            <h4 class="m-row-title"><?php the_title(); ?></h4>
                            <div class="m-row-excerpt"><?php echo wp_trim_words(get_the_excerpt(), 20, '...'); ?></div>
                            <div class="m-row-meta">
                                <span class="text-xs text-blue-600 bg-blue-50 px-2 rounded-full ml-2"><?php echo $mq3->current_post + 1; ?>#</span>
                                <i class="far fa-eye ml-1"></i>
                                <span class="live-view-count" data-id="<?php the_ID(); ?>"><?php if(function_exists('get_post_views')) echo get_post_views(get_the_ID()); ?></span>
                            </div>
                        </div>
                    </a>
                <?php endwhile; wp_reset_postdata(); ?>
            </div>
        </div>

        <div id="m-video" class="m-content group2-content hidden">
            <div id="list-video">
                <?php
                $mq4 = new WP_Query([
                    'tax_query' => [
                        'relation' => 'OR',
                        ['taxonomy'=>'category', 'field'=>'slug', 'terms'=>'video'],
                        ['taxonomy'=>'category', 'field'=>'slug', 'terms'=>'image'],
                        ['taxonomy'=>'category', 'field'=>'slug', 'terms'=>'multimedia']
                    ],
                    'posts_per_page'=>5,
                    'ignore_sticky_posts' => 1
                ]);
                if($mq4->have_posts()): while($mq4->have_posts()): $mq4->the_post();
                $m_icon = has_category('video') ? 'fa-play' : 'fa-camera';
                
                // Video Preview Setup
                $m_video_preview = get_post_meta(get_the_ID(), 'video_preview_url', true);
                $m_has_valid_video = (!empty($m_video_preview) && filter_var($m_video_preview, FILTER_VALIDATE_URL));
                $thumb_bg = $m_has_valid_video ? 'bg-black' : '';
                ?>
                    <a href="<?php the_permalink(); ?>" class="m-news-row">
                        <div class="m-row-thumb relative <?php echo $thumb_bg; ?>">
                            <?php if ($m_has_valid_video) : ?>
                                <video src="<?php echo esc_url($m_video_preview); ?>" loop muted playsinline class="w-full h-full object-cover" style="object-fit:cover!important; opacity:0.8;"></video>
                            <?php elseif (has_post_thumbnail()) : ?>
                                <?php the_post_thumbnail('thumbnail', ['class'=>'w-full h-full object-cover']); ?>
                            <?php endif; ?>
                            <div class="absolute inset-0 bg-black/30 flex items-center justify-center text-white">
                                <i class="fas <?php echo $m_icon; ?>"></i>
                            </div>
                        </div>
                        <div class="m-row-content">
                            <h4 class="m-row-title"><?php the_title(); ?></h4>
                            <div class="m-row-excerpt"><?php echo wp_trim_words(get_the_excerpt(), 20, '...'); ?></div>
                            <span class="m-row-meta"><i class="far fa-clock"></i> <?php echo get_the_date(); ?></span>
                        </div>
                    </a>
                <?php endwhile; wp_reset_postdata(); endif; ?>
            </div>
        </div>

        <div id="m-interviews" class="m-content group2-content hidden">
            <div id="list-interviews">
                <?php $mq5 = new WP_Query(['category_name'=>'interviews', 'posts_per_page'=>5, 'ignore_sticky_posts' => 1]);
                if($mq5->have_posts()): while($mq5->have_posts()): $mq5->the_post(); ?>
                    <a href="<?php the_permalink(); ?>" class="m-news-row">
                        <div class="m-row-thumb">
                            <?php the_post_thumbnail('thumbnail', ['class'=>'w-full h-full object-cover']); ?>
                        </div>
                        <div class="m-row-content">
                            <h4 class="m-row-title"><?php the_title(); ?></h4>
                            <div class="m-row-excerpt"><?php echo wp_trim_words(get_the_excerpt(), 20, '...'); ?></div>
                            <span class="m-row-meta"><i class="far fa-clock"></i> <?php echo get_the_date(); ?></span>
                        </div>
                    </a>
                <?php endwhile; wp_reset_postdata(); endif; ?>
            </div>
        </div>

        <div class="p-4 text-center border-t">
            <button id="btn-load-2" onclick="loadMoreMobile('btn-load-2', 'group2')" class="w-full py-3 rounded-xl m-load-btn-style font-diba text-sm transition flex justify-center items-center gap-2">
                <i class="fas fa-plus-circle"></i> مشاهده اخبار بیشتر
            </button>
        </div>
    </div>
</div>

<script src="<?php echo get_template_directory_uri(); ?>/assets/js/swiper-bundle.min.js"></script>

<script>
const pageCounters = { 'news': 1, 'tahlil': 1, 'most_viewed': 1, 'video': 1, 'interviews': 1 };

function updateLiveViewCounts() {
    var elements = document.querySelectorAll('.live-view-count');
    if (elements.length === 0) return;
    
    var postIds = [];
    elements.forEach(function(el) {
        var id = el.getAttribute('data-id');
        if (id && postIds.indexOf(id) === -1) postIds.push(id);
    });
    
    if (postIds.length === 0) return;

    var formData = new FormData();
    formData.append('action', 'sharji_get_bulk_views');
    postIds.forEach(function(id) { 
        formData.append('post_ids[]', id); 
    });
    
    fetch('<?php echo admin_url('admin-ajax.php'); ?>', {
        method: 'POST',
        body: formData
    })
    .then(function(res) { return res.json(); })
    .then(function(data) {
        if (data.success && data.data) {
            elements.forEach(function(el) {
                var id = el.getAttribute('data-id');
                if (data.data[id] !== undefined) {
                    el.textContent = data.data[id];
                }
            });
        }
    }).catch(function(err) { console.error(err); });
}

function toggleTabs(evt, groupName, contentId) {
    let tabSelector = groupName === 'group1' ? '.group-1-tab' : '.group-2-tab';
    let contentSelector = groupName === 'group1' ? '.group1-content' : '.group2-content';

    document.querySelectorAll(tabSelector).forEach(btn => btn.classList.remove("active"));
    document.querySelectorAll(contentSelector).forEach(c => c.classList.add("hidden"));

    evt.currentTarget.classList.add("active");
    document.getElementById(contentId).classList.remove("hidden");

    let btn = document.getElementById(evt.currentTarget.getAttribute('data-btn'));
    if(btn) {
        btn.innerHTML = '<i class="fas fa-plus-circle"></i> مشاهده اخبار بیشتر';
        btn.disabled = false;
    }
}

let curr = 0;

function showSlide(index) {
    const slider = document.getElementById('main-slider');
    if(!slider) return;

    const slides = slider.children;
    if (index >= slides.length) curr = 0;
    else if (index < 0) curr = slides.length - 1;
    else curr = index;

    slider.style.transform = `translateX(${curr * 100}%)`;
}

function nextSlide() {
    showSlide(curr + 1);
}

// تصحیح گام حرکت دکمه اسلایدر هوم‌پيج
function prevSlide() {
    showSlide(curr - 1);
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initSharjiHome);
} else {
    initSharjiHome();
}

function initSharjiHome() {
    setInterval(nextSlide, 8000);
    updateLiveViewCounts();

    new Swiper('.swiper-mobile', {
        loop: true,
        autoplay: { delay: 5000 },
        pagination: { el: '.swiper-pagination', clickable: true }
    });

    let page = 1;
    const loadBtn = document.getElementById('global-load-more');

    if(loadBtn) {
        loadBtn.addEventListener('click', function() {
            loadBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> در حال بارگذاری...';

            const formData = new FormData();
            formData.append('action', 'load_more_home_action');
            formData.append('page', page);

            fetch('<?php echo admin_url('admin-ajax.php'); ?>', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    if (data.data.most_viewed) document.getElementById('most-viewed-list').insertAdjacentHTML('beforeend', data.data.most_viewed);
                    if (data.data.latest) document.getElementById('latest-news-center-list').insertAdjacentHTML('beforeend', data.data.latest);
                    if (data.data.interviews) document.getElementById('interviews-list').insertAdjacentHTML('beforeend', data.data.interviews);

                    page++;
                    loadBtn.innerHTML = '<i class="fas fa-plus-circle"></i> مشاهده اخبار بیشتر';
                    updateLiveViewCounts();
                }
            });
        });
    }
}

function loadMoreMobile(btnId, groupName) {
    const btn = document.getElementById(btnId);
    let tabSelector = groupName === 'group1' ? '.group-1-tab.active' : '.group-2-tab.active';
    const activeTab = document.querySelector(tabSelector);
    const slug = activeTab.getAttribute('data-slug');
    const listContainerId = 'list-' + slug;

    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> در حال دریافت...';

    let nextPage = pageCounters[slug] + 1;

    const formData = new FormData();
    formData.append('action', 'load_more_mobile_action');
    formData.append('page', nextPage);
    formData.append('type', slug);

    fetch('<?php echo admin_url('admin-ajax.php'); ?>', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            document.getElementById(listContainerId).insertAdjacentHTML('beforeend', data.data.html);
            pageCounters[slug]++;
            btn.innerHTML = '<i class="fas fa-plus-circle"></i> مشاهده اخبار بیشتر';
            updateLiveViewCounts();
        } else {
            btn.innerHTML = 'اخبار بیشتری نیست';
            btn.disabled = true;
        }
    })
    .catch(err => {
        console.error(err);
        btn.innerHTML = 'خطا در ارتباط';
    });
}

// Hover-to-Play Logic for Video Previews (Supports AJAX)
document.addEventListener('mouseover', function(e) {
    const card = e.target.closest('.n-box, .m-news-row, .special-row');
    if (card) {
        const vid = card.querySelector('video');
        if (vid && vid.paused) {
            vid.play().catch(err => {});
        }
    }
});

document.addEventListener('mouseout', function(e) {
    const card = e.target.closest('.n-box, .m-news-row, .special-row');
    if (card) {
        const vid = card.querySelector('video');
        if (vid && !card.contains(e.relatedTarget)) {
            vid.pause();
            vid.currentTime = 0;
        }
    }
});
</script>

<!-- Dual Corner Promotional Popups -->
<?php 
$popup_page = get_page_by_path('popup-settings');
$popup_id   = $popup_page ? $popup_page->ID : 0;

// Right Popup Data
$show_right  = get_field('enable_right_popup', $popup_id);
$img_right   = get_field('right_popup_image', $popup_id);
$url_right   = get_field('right_popup_link', $popup_id);

// Left Popup Data
$show_left   = get_field('enable_left_popup', $popup_id);
$img_left    = get_field('left_popup_image', $popup_id);
$url_left    = get_field('left_popup_link', $popup_id);
?>

<style>
    .sharji-corner-popup {
        position: fixed;
        bottom: 24px;
        width: 280px;
        height: 140px; /* تبدیل به مستطیل ظریف کشیده */
        z-index: 99999;
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 10px 35px rgba(15, 23, 42, 0.2);
        border: 1px solid #e2e8f0;
        overflow: hidden;
        direction: rtl;
        
        opacity: 0;
        pointer-events: none;
        transform: translateY(40px);
        transition: opacity 0.4s ease, transform 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }
    
    .sharji-corner-popup.popup-right { right: 24px; }
    .sharji-corner-popup.popup-left { left: 24px; }
    
    .sharji-corner-popup.is-active {
        opacity: 1;
        pointer-events: auto;
        transform: translateY(0);
    }
    .sharji-popup-link { display: block; width: 100%; height: 100%; line-height: 0; }
    .sharji-popup-link img { width: 100%; height: 100%; object-fit: cover; display: block; }
    
    .sharji-popup-close {
        position: absolute;
        top: 8px;
        left: 8px;
        width: 26px;
        height: 26px;
        background: rgba(15, 23, 42, 0.65);
        backdrop-filter: blur(4px);
        color: #fff;
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        cursor: pointer; transition: all 0.2s; z-index: 10;
        font-size: 12px;
    }
    .sharji-popup-close:hover { background: #ef4444; transform: scale(1.1); }

    @media (max-width: 768px) {
        .sharji-corner-popup { width: 240px; height: 120px; bottom: 12px; }
        .sharji-corner-popup.popup-right { right: 12px; }
        .sharji-corner-popup.popup-left { left: 12px; }
    }
</style>

<!-- Right Popup Layout -->
<?php if ( $show_right && $img_right && $url_right ) : ?>
<div id="popupRight" class="sharji-corner-popup popup-right">
    <button type="button" class="sharji-popup-close" onclick="closeCornerPopup('popupRight')"><i class="fas fa-times"></i></button>
    <a href="<?php echo esc_url($url_right); ?>" target="_blank" rel="noopener noreferrer" class="sharji-popup-link">
        <img src="<?php echo esc_url(wp_get_attachment_image_url($img_right, 'medium_large')); ?>" alt="تبلیغات">
    </a>
</div>
<?php endif; ?>

<!-- Left Popup Layout -->
<?php if ( $show_left && $img_left && $url_left ) : ?>
<div id="popupLeft" class="sharji-corner-popup popup-left">
    <button type="button" class="sharji-popup-close" onclick="closeCornerPopup('popupLeft')"><i class="fas fa-times"></i></button>
    <a href="<?php echo esc_url($url_left); ?>" target="_blank" rel="noopener noreferrer" class="sharji-popup-link">
        <img src="<?php echo esc_url(wp_get_attachment_image_url($img_left, 'medium_large')); ?>" alt="تبلیغات">
    </a>
</div>
<?php endif; ?>

<script>
document.addEventListener("DOMContentLoaded", function() {
    setupCornerPopup('popupRight');
    setupCornerPopup('popupLeft');
});

function setupCornerPopup(id) {
    var popup = document.getElementById(id);
    if (!popup) return;

    setTimeout(function() {
        popup.classList.add('is-active');
    }, 1500);
}

function closeCornerPopup(id) {
    var popup = document.getElementById(id);
    if (!popup) return;

    popup.classList.remove('is-active');
}
</script>

<?php get_footer(); ?>