<?php
/**
 * Template Name: Sharji Sport (Final - With Polls)
 * File Name: category-sport.php
 */

if (!function_exists('to_farsi_local')) {
    function to_farsi_local($number) {
        $persian_digits = array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹');
        $english_digits = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
        return str_replace($english_digits, $persian_digits, (string)$number);
    }
}

get_header('sport'); 
?>

<!-- Swiper CSS - Local -->
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/swiper-bundle.min.css" />

<style>
    @font-face {
        font-family: 'Diba';
        src: url('<?php echo get_template_directory_uri(); ?>/fonts/Diba.woff2') format('woff2');
        font-weight: bold;
        font-style: normal;
        font-display: swap;
    }

    :root {
        --sport-bg: #0f172a;
        --sport-card: #1e293b;
        --sport-card-soft: rgba(30, 41, 59, 0.55);
        --sport-border: #374151;
        --sport-blue: #3b82f6;
        --sport-blue-dark: #2563eb;
        --sport-sky: #38bdf8;
        --sport-text: #e5e7eb;
        --sport-muted: #9ca3af;
        --sport-green: #4ade80;
        --sport-red: #f87171;
    }

    body {
        font-family: 'Vazirmatn', sans-serif !important;
        background:
            radial-gradient(circle at top right, rgba(37, 99, 235, 0.12), transparent 34%),
            radial-gradient(circle at bottom left, rgba(14, 165, 233, 0.08), transparent 30%),
            var(--sport-bg) !important;
    }

    .sport-page-shell {
        font-family: 'Vazirmatn', sans-serif !important;
        direction: rtl;
    }

    .font-diba,
    .sport-hero-title,
    .sport-card-title,
    .sport-section-heading,
    .sport-sidebar-heading,
    .sport-mini-title,
    .sport-mobile-title,
    .sport-mobile-tab,
    .sport-mobile-load-btn {
        font-family: 'Diba', 'Vazirmatn', sans-serif !important;
        letter-spacing: -0.01em;
    }

    a {
        text-decoration: none;
    }

    .timeline-item {
        position: relative;
        padding-right: 25px;
        border-right: 2px solid #334155;
        margin-bottom: 0;
        display: block;
        transition: 0.3s;
        text-decoration: none;
    }

    .timeline-item::before {
        content: '';
        position: absolute;
        right: -6px;
        top: 50%;
        transform: translateY(-50%);
        width: 10px;
        height: 10px;
        background: var(--sport-blue);
        border: 2px solid #1e293b;
        border-radius: 50%;
        transition: 0.3s;
        box-shadow: 0 0 0 1px var(--sport-blue);
    }

    .timeline-item:hover::before {
        background: #fff;
        box-shadow: 0 0 10px var(--sport-blue), 0 0 0 2px var(--sport-blue);
        transform: translateY(-50%) scale(1.3);
    }

    .timeline-item:hover {
        border-right-color: #60a5fa;
        background: rgba(59, 130, 246, 0.05);
    }

    .sport-sidebar-box {
        background:
            linear-gradient(180deg, rgba(30, 41, 59, 0.98), rgba(15, 23, 42, 0.94));
        border: 1px solid rgba(55, 65, 81, 0.65);
        box-shadow: 0 18px 45px rgba(0, 0, 0, 0.25);
    }

    .sport-sidebar-heading {
        color: #fff;
        font-size: 15px;
    }

    .mini-table th {
        font-size: 10px !important;
        padding: 8px 2px !important;
        letter-spacing: -0.5px;
        text-align: center !important;
    }

    .mini-table td {
        font-size: 11.5px !important;
        padding: 7px 2px !important;
        vertical-align: middle;
    }

    .hero-container {
        position: relative;
        height: 430px !important;
        overflow: hidden;
        border-radius: 20px;
        border: 1px solid rgba(59, 130, 246, 0.22);
        background:
            radial-gradient(circle at top right, rgba(59, 130, 246, 0.22), transparent 34%),
            #1e293b;
        box-shadow: 0 28px 60px rgba(0, 0, 0, 0.35);
    }

    .hero-swiper {
        width: 100%;
        height: 100%;
    }

    .swiper-slide {
        height: 100%;
        width: 100%;
    }

    .sport-hero-article {
        position: relative;
        overflow: hidden;
    }

    .sport-hero-image-wrap {
        position: relative;
    }

    .sport-hero-panel {
        position: relative;
        z-index: 5;
        background:
            linear-gradient(135deg, rgba(15, 23, 42, 0.96), rgba(30, 41, 59, 0.86));
        border-left: 1px solid rgba(59, 130, 246, 0.20);
    }

    .sport-hero-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        width: fit-content;
        color: #93c5fd;
        background: rgba(37, 99, 235, 0.12);
        border: 1px solid rgba(59, 130, 246, 0.25);
        border-radius: 999px;
        padding: 6px 12px;
        font-size: 12px;
        font-weight: 900;
        margin-bottom: 14px;
    }

    .sport-hero-badge span {
        width: 8px;
        height: 8px;
        background: var(--sport-blue);
        border-radius: 999px;
        box-shadow: 0 0 12px rgba(59, 130, 246, 0.9);
        animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }

    .sport-hero-title {
        font-size: 32px;
        color: #fff;
        line-height: 1.45;
        margin-bottom: 14px;
        transition: color 0.25s ease;
    }

    .sport-hero-title:hover {
        color: #93c5fd;
    }

    .sport-hero-excerpt {
        color: #cbd5e1;
        font-size: 14px;
        line-height: 2;
        text-align: justify;
        opacity: 0.92;
    }

    .sport-read-more {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: #60a5fa;
        font-size: 12px;
        font-weight: 900;
        transition: 0.25s;
    }

    .sport-read-more:hover {
        color: #fff;
        transform: translateX(-3px);
    }

    .sport-sub-card {
        background:
            linear-gradient(180deg, rgba(30, 41, 59, 0.96), rgba(15, 23, 42, 0.94));
        border: 1px solid rgba(55, 65, 81, 0.72);
        transition: all 0.3s ease;
    }

    .sport-sub-card:hover {
        border-color: rgba(96, 165, 250, 0.65);
        transform: translateY(-4px);
        box-shadow: 0 18px 36px rgba(0, 0, 0, 0.28);
    }

    .sport-card-title {
        color: #e5e7eb;
        font-size: 17px;
        line-height: 1.75;
        transition: color 0.25s ease;
    }

    .sport-sub-card:hover .sport-card-title {
        color: #93c5fd;
    }

    .sport-section-bar {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 18px;
        border-bottom: 1px solid rgba(55, 65, 81, 0.75);
        padding-bottom: 12px;
    }

    .sport-section-bar .mark {
        width: 6px;
        height: 28px;
        background: linear-gradient(180deg, #60a5fa, #2563eb);
        border-radius: 999px;
        box-shadow: 0 0 16px rgba(59, 130, 246, 0.40);
    }

    .sport-section-heading {
        color: #fff;
        font-size: 21px;
        margin: 0;
    }

    .sport-news-row {
        background: rgba(30, 41, 59, 0.48);
        border: 1px solid rgba(31, 41, 55, 0.95);
        transition: all 0.28s ease;
    }

    .sport-news-row:hover {
        background: rgba(30, 41, 59, 0.92);
        border-color: rgba(59, 130, 246, 0.35);
        transform: translateY(-2px);
    }

    .sport-mini-title {
        color: #d1d5db;
        font-size: 15px;
        line-height: 1.75;
        transition: color 0.25s ease;
    }

    .sport-news-row:hover .sport-mini-title {
        color: #fff;
    }

    .sport-time-text {
        color: #64748b;
        font-size: 10px;
    }

    .sport-mobile-shell {
        direction: rtl;
        padding: 0 10px 28px;
        max-width: 1600px;
        margin: 0 auto;
    }

    .sport-mobile-slider {
        width: 100%;
        border-radius: 16px;
        overflow: hidden;
        margin-top: 15px;
        margin-bottom: 16px;
        box-shadow: 0 16px 36px rgba(0, 0, 0, 0.35);
        border: 1px solid rgba(59, 130, 246, 0.25);
        background: #1e293b;
    }

    .sport-mobile-slide-link {
        display: block;
        position: relative;
        height: 250px;
        overflow: hidden;
    }

    .sport-mobile-slide-link img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .sport-mobile-slide-link::after {
        content: "";
        position: absolute;
        inset: 0;
        background: linear-gradient(to top, rgba(2,6,23,0.95), rgba(15,23,42,0.35), transparent);
    }

    .sport-mobile-caption {
        position: absolute;
        right: 0;
        bottom: 0;
        width: 100%;
        padding: 16px;
        z-index: 2;
    }

    .sport-mobile-badge {
        display: inline-block;
        background: #2563eb;
        color: #fff;
        font-size: 10px;
        font-weight: bold;
        padding: 3px 9px;
        border-radius: 999px;
        margin-bottom: 8px;
        box-shadow: 0 4px 12px rgba(37,99,235,0.32);
    }

    .sport-mobile-title {
        color: #fff;
        font-size: 19px;
        line-height: 1.6;
        text-shadow: 0 3px 12px rgba(0,0,0,0.45);
    }

    .sport-mobile-tabs {
        display: flex;
        width: 100%;
        border-radius: 12px 12px 0 0;
        overflow: hidden;
        border: 1px solid rgba(55, 65, 81, 0.72);
        border-bottom: none;
        background: #111827;
    }

    .sport-mobile-tab {
        flex: 1;
        padding: 12px 8px;
        text-align: center;
        background: #111827;
        color: #94a3b8;
        font-size: 13px;
        cursor: pointer;
        border-bottom: 3px solid transparent;
        transition: 0.25s;
    }

    .sport-mobile-tab.active {
        color: #fff;
        background: linear-gradient(135deg, #1e293b, #172554);
        border-bottom-color: #3b82f6;
    }

    .sport-mobile-panel {
        background: #1e293b;
        border: 1px solid rgba(55, 65, 81, 0.72);
        border-radius: 0 0 12px 12px;
        overflow: hidden;
        box-shadow: 0 18px 38px rgba(0,0,0,0.28);
        margin-bottom: 20px;
    }

    .sport-mobile-row {
        display: flex;
        gap: 12px;
        padding: 14px 12px;
        background: #1e293b;
        border-bottom: 1px solid rgba(55, 65, 81, 0.55);
        align-items: flex-start;
        text-decoration: none !important;
        transition: 0.25s;
    }

    .sport-mobile-row:hover {
        background: #172033;
    }

    .sport-mobile-thumb {
        width: 96px;
        height: 96px;
        flex-shrink: 0;
        border-radius: 10px;
        overflow: hidden;
        background: #0f172a;
        border: 1px solid rgba(55, 65, 81, 0.75);
        position: relative;
    }

    .sport-mobile-thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .sport-mobile-row-content {
        flex: 1;
        height: 96px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .sport-mobile-row-title {
        font-family: 'Diba', 'Vazirmatn', sans-serif !important;
        color: #e5e7eb;
        font-size: 14.5px;
        line-height: 1.65;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .sport-mobile-row-excerpt {
        color: #94a3b8;
        font-size: 11px;
        line-height: 1.65;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-align: justify;
    }

    .sport-mobile-row-meta {
        color: #64748b;
        font-size: 10px;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .sport-mobile-load-wrap {
        padding: 14px;
        background: #111827;
        border-top: 1px solid rgba(55, 65, 81, 0.6);
    }

    .sport-mobile-load-btn {
        width: 100%;
        border: none;
        border-radius: 12px;
        padding: 12px;
        color: #fff;
        background: linear-gradient(135deg, #2563eb, #0ea5e9);
        box-shadow: 0 10px 24px rgba(37, 99, 235, 0.22);
        cursor: pointer;
        font-size: 14px;
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 8px;
    }

    .sport-mobile-load-btn:disabled {
        background: #334155;
        color: #94a3b8;
        box-shadow: none;
        cursor: not-allowed;
    }

    .sport-mobile-ad {
        margin: 16px 0 22px;
        border-radius: 14px;
        overflow: hidden;
        border: 1px solid rgba(59, 130, 246, 0.25);
        background: #1e293b;
        box-shadow: 0 14px 34px rgba(0,0,0,0.25);
    }

    .sport-mobile-ad-label {
        padding: 8px 12px;
        color: #94a3b8;
        font-size: 11px;
        font-weight: bold;
        background: #111827;
        border-bottom: 1px solid rgba(55, 65, 81, 0.65);
    }

    .sport-mobile-ad-content {
        padding: 10px;
    }

    .sport-mobile-ad-content img {
        width: 100% !important;
        height: auto !important;
        display: block;
        border-radius: 10px;
    }

    .hidden { display: none; }
    .lg\:block { display: none; }
    .lg\:hidden { display: block; }
    .flex { display: flex; }
    .flex-col { flex-direction: column; }
    .flex-1 { flex: 1 1 0%; }
    .items-center { align-items: center; }
    .justify-center { justify-content: center; }
    .justify-between { justify-content: space-between; }
    .gap-1 { gap: 4px; }
    .gap-1\.5 { gap: 6px; }
    .gap-2 { gap: 8px; }
    .gap-4 { gap: 16px; }
    .gap-6 { gap: 24px; }
    .gap-x-6 { column-gap: 24px; }
    .gap-y-4 { row-gap: 16px; }
    .w-full { width: 100%; }
    .w-1\.5 { width: 6px; }
    .h-6 { height: 24px; }
    .h-48 { height: 192px; }
    .h-full { height: 100%; }
    .h-32 { height: 128px; }
    .w-24 { width: 96px; }
    .h-20 { height: 80px; }
    .w-2 { width: 8px; }
    .h-2 { height: 8px; }
    .w-5 { width: 20px; }
    .h-5 { height: 20px; }
    .w-6 { width: 24px; }
    .w-10 { width: 40px; }
    .max-h-\[400px\] { max-height: 400px; }
    .overflow-hidden { overflow: hidden; }
    .overflow-y-auto { overflow-y: auto; }
    .relative { position: relative; }
    .absolute { position: absolute; }
    .sticky { position: sticky; top: 96px; }
    .top-24 { top: 96px; }
    .bottom-0 { bottom: 0; }
    .right-0 { right: 0; }
    .z-10 { z-index: 10; }
    .order-1 { order: 1; }
    .order-2 { order: 2; }
    .rounded { border-radius: 4px; }
    .rounded-lg { border-radius: 8px; }
    .rounded-xl { border-radius: 12px; }
    .rounded-full { border-radius: 9999px; }
    .border { border: 1px solid #374151; }
    .border-t { border-top: 1px solid #374151; }
    .border-b { border-bottom: 1px solid #374151; }
    .border-b-2 { border-bottom-width: 2px; }
    .border-gray-700 { border-color: #374151; }
    .border-gray-700\/50 { border-color: rgba(55, 65, 81, 0.5); }
    .border-gray-800 { border-color: #1f2937; }
    .border-blue-600 { border-color: #2563eb; }
    .border-blue-700\/30 { border-color: rgba(29, 78, 216, 0.3); }
    .border-blue-500\/30 { border-color: rgba(59, 130, 246, 0.3); }
    .bg-\[\#1e293b\] { background-color: #1e293b; }
    .bg-\[\#1e293b\]\/50 { background-color: rgba(30, 41, 59, 0.5); }
    .bg-\[\#161f2f\] { background-color: #161f2f; }
    .bg-gray-800\/50 { background-color: rgba(31, 41, 55, 0.5); }
    .bg-blue-600 { background-color: #2563eb; }
    .bg-blue-500 { background-color: #3b82f6; }
    .bg-white\/5 { background-color: rgba(255, 255, 255, 0.05); }
    .bg-white\/10 { background-color: rgba(255, 255, 255, 0.1); }
    .text-white { color: #fff; }
    .text-gray-100 { color: #f3f4f6; }
    .text-gray-200 { color: #e5e7eb; }
    .text-gray-300 { color: #d1d5db; }
    .text-gray-400 { color: #9ca3af; }
    .text-gray-500 { color: #6b7280; }
    .text-blue-400 { color: #60a5fa; }
    .text-blue-500 { color: #3b82f6; }
    .text-green-400 { color: #4ade80; }
    .text-green-500\/80 { color: rgba(34, 197, 94, 0.8); }
    .text-red-400 { color: #f87171; }
    .text-red-500\/80 { color: rgba(239, 68, 68, 0.8); }
    .text-blue-300\/50 { color: rgba(147, 197, 253, 0.5); }
    .font-bold { font-weight: bold; }
    .font-medium { font-weight: 500; }
    .font-black { font-weight: 900; }
    .text-xs { font-size: 12px; }
    .text-sm { font-size: 14px; }
    .text-base { font-size: 16px; }
    .text-lg { font-size: 18px; }
    .text-2xl { font-size: 24px; }
    .text-\[10px\] { font-size: 10px; }
    .text-\[13px\] { font-size: 13px; }
    .leading-6 { line-height: 1.5rem; }
    .leading-7 { line-height: 1.75rem; }
    .leading-tight { line-height: 1.25; }
    .text-center { text-align: center; }
    .text-right { text-align: right; }
    .text-justify { text-align: justify; }
    .truncate { overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
    .max-w-\[60px\] { max-width: 60px; }
    .block { display: block; }
    .inline-flex { display: inline-flex; }
    .shrink-0 { flex-shrink: 0; }
    .flex-shrink-0 { flex-shrink: 0; }
    .object-cover { object-fit: cover; }
    .object-contain { object-fit: contain; }
    .mb-2 { margin-bottom: 8px; }
    .mb-3 { margin-bottom: 12px; }
    .mb-4 { margin-bottom: 16px; }
    .mt-4 { margin-top: 16px; }
    .ml-2 { margin-left: 8px; }
    .p-0 { padding: 0; }
    .p-0\.5 { padding: 2px; }
    .p-3 { padding: 12px; }
    .p-4 { padding: 16px; }
    .p-6 { padding: 24px; }
    .py-0\.5 { padding-top: 2px; padding-bottom: 2px; }
    .py-3 { padding-top: 12px; padding-bottom: 12px; }
    .py-4 { padding-top: 16px; padding-bottom: 16px; }
    .px-3 { padding-left: 12px; padding-right: 12px; }
    .px-4 { padding-left: 16px; padding-right: 16px; }
    .py-1 { padding-top: 4px; padding-bottom: 4px; }
    .pt-4 { padding-top: 16px; }
    .pb-2 { padding-bottom: 8px; }
    .pr-9 { padding-right: 36px; }
    .pl-2 { padding-left: 8px; }
    .-mr-4 { margin-right: -16px; }
    .shadow-lg { box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1); }
    .shadow-xl { box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1); }
    .shadow-2xl { box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25); }
    .transition { transition: all 0.3s; }
    .duration-500 { transition-duration: 500ms; }
    .duration-700 { transition-duration: 700ms; }
    .opacity-90 { opacity: 0.9; }
    .animate-pulse { animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite; }
    @keyframes pulse { 0%, 100% { opacity: 1; } 50% { opacity: 0.5; } }
    .line-clamp-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
    .hover\:bg-gray-800\/50:hover { background-color: rgba(31, 41, 55, 0.5); }
    .hover\:bg-\[\#1e293b\]:hover { background-color: #1e293b; }
    .hover\:text-white:hover { color: #fff; }
    .hover\:text-blue-400:hover { color: #60a5fa; }
    .hover\:border-gray-500:hover { border-color: #6b7280; }
    .group:hover .group-hover\:scale-105 { transform: scale(1.05); }
    .group:hover .group-hover\:scale-110 { transform: scale(1.10); }
    .group:hover .group-hover\:text-white { color: #fff; }
    .group:hover .group-hover\:text-blue-400 { color: #60a5fa; }
    .grid { display: grid; }
    .grid-cols-1 { grid-template-columns: repeat(1, 1fr); }

    @media (max-width: 1024px) {
        .lg\:block { display: none !important; }
        .lg\:hidden { display: block !important; }
    }

    @media (min-width: 769px) {
        .md\:w-2\/3 { width: 66.666667%; }
        .md\:w-1\/3 { width: 33.333333%; }
        .md\:flex-row { flex-direction: row; }
        .md\:static { position: static; }
        .md\:block { display: block; }
        .md\:hidden { display: none; }
        .md\:p-10 { padding: 40px; }
        .md\:text-3xl { font-size: 30px; }
        .md\:grid-cols-2 { grid-template-columns: repeat(2, 1fr); }
        .md\:grid-cols-3 { grid-template-columns: repeat(3, 1fr); }
        .md\:order-1 { order: 1; }
        .md\:order-2 { order: 2; }
    }

    @media (min-width: 1025px) {
        .lg\:block { display: block !important; }
        .lg\:hidden { display: none !important; }
        .lg\:w-\[25\%\] { width: 25%; }
        .lg\:w-\[75\%\] { width: 75%; }
        .lg\:flex-row { flex-direction: row; }
        .lg\:order-1 { order: 1; }
        .lg\:order-2 { order: 2; }
    }
</style>

<div class="sport-page-shell">

    <!-- Desktop View -->
    <div class="lg:block hidden">
        <div class="max-w-[1600px] mx-auto px-4 py-6">
            <div class="flex flex-col lg:flex-row gap-6">

                <aside class="w-full lg:w-[25%] order-2 lg:order-1">
                    <div class="sticky top-24 flex flex-col gap-4">
                        
                        <div class="sport-sidebar-box rounded-xl overflow-hidden">
                            <div class="flex border-b border-gray-700 bg-[#161f2f]">
                                <button class="flex-1 py-3 sport-sidebar-heading text-white border-b-2 border-blue-600 bg-gray-800/50">آخرین اخبار</button>
                            </div>
                            <div class="p-4 flex flex-col gap-0 max-h-[400px] overflow-y-auto custom-scrollbar">
                                <?php 
                                $sidebar_news = new WP_Query(['category_name' => 'sport', 'posts_per_page' => 10, 'post__not_in' => [get_the_ID()]]);
                                if($sidebar_news->have_posts()): while($sidebar_news->have_posts()): $sidebar_news->the_post(); 
                                ?>
                                <a href="<?php echo add_query_arg('theme', 'sport', get_permalink()); ?>" class="timeline-item py-4 group -mr-4 pr-9 pl-2 rounded-l-lg block">
                                    <h3 class="sport-mini-title group-hover:text-white transition text-justify pl-2"><?php the_title(); ?></h3>
                                </a>
                                <?php endwhile; endif; wp_reset_postdata(); ?>
                            </div>
                        </div>

                        <div class="sport-sidebar-box rounded-xl overflow-hidden">
                            <div class="flex justify-between items-center border-b border-gray-700 bg-[#161f2f] px-4 py-3">
                                <span class="sport-sidebar-heading">جدول لیگ برتر</span>
                                <a href="<?php echo home_url('/league-table'); ?>" class="text-[10px] text-blue-400 hover:text-white transition">جدول کامل <i class="fas fa-angle-left"></i></a>
                            </div>
                            <div class="p-0">
                                <?php 
                                $teams_query = new WP_Query(['post_type' => 'league_team', 'posts_per_page' => -1]);
                                $table_data = [];
                                if($teams_query->have_posts()) {
                                    while($teams_query->have_posts()) {
                                        $teams_query->the_post();
                                        if (!function_exists('get_field')) continue;
                                        $played = (int)get_field('played'); $won = (int)get_field('won'); $drawn = (int)get_field('drawn');
                                        $lost = (int)get_field('lost'); $deducted = (int)get_field('deducted'); $gf = (int)get_field('gf'); $ga = (int)get_field('ga');
                                        $points = ($won * 3) + $drawn - $deducted; $diff = $gf - $ga;
                                        $table_data[] = ['name' => get_the_title(), 'logo' => get_the_post_thumbnail_url(get_the_ID(), 'thumbnail'), 'played' => $played, 'won' => $won, 'drawn' => $drawn, 'lost' => $lost, 'points' => $points, 'diff' => $diff];
                                    }
                                    wp_reset_postdata();
                                    usort($table_data, function($a, $b) {
                                        if ($a['points'] != $b['points']) return $b['points'] - $a['points'];
                                        return $b['diff'] - $a['diff'];
                                    });
                                    $top_teams = array_slice($table_data, 0, 5);
                                }
                                ?>
                                <table class="w-full mini-table">
                                    <thead>
                                        <tr>
                                            <th class="w-6 text-center">#</th>
                                            <th class="text-right">تیم</th>
                                            <th class="text-gray-400 text-center">بازی</th>
                                            <th class="text-green-500/80 text-center">برد</th>
                                            <th class="text-gray-400 text-center">مساوی</th>
                                            <th class="text-red-500/80 text-center">باخت</th>
                                            <th class="text-gray-300 text-center">تفاضل</th>
                                            <th class="text-white font-bold w-10 text-center">امتیاز</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if(!empty($top_teams)): $rank = 1; foreach($top_teams as $team): $diff_color = ($team['diff'] >= 0) ? 'text-green-400' : 'text-red-400'; $diff_sign = ($team['diff'] > 0) ? '+' : ''; ?>
                                        <tr class="hover:bg-gray-800/50 transition">
                                            <td class="text-gray-500 font-bold text-center"><?php echo to_farsi_local($rank++); ?></td>
                                            <td class="text-right">
                                                <div class="flex items-center gap-1.5">
                                                    <?php if($team['logo']): ?>
                                                        <div class="w-5 h-5 bg-white/10 rounded-full p-0.5 flex items-center justify-center shrink-0">
                                                            <img src="<?php echo esc_url($team['logo']); ?>" class="w-full h-full object-contain">
                                                        </div>
                                                    <?php endif; ?>
                                                    <span class="text-gray-200 font-medium truncate max-w-[60px] block"><?php echo esc_html($team['name']); ?></span>
                                                </div>
                                            </td>
                                            <td class="text-gray-400 text-center"><?php echo to_farsi_local($team['played']); ?></td>
                                            <td class="text-gray-300 text-center"><?php echo to_farsi_local($team['won']); ?></td>
                                            <td class="text-gray-400 text-center"><?php echo to_farsi_local($team['drawn']); ?></td>
                                            <td class="text-gray-400 text-center"><?php echo to_farsi_local($team['lost']); ?></td>
                                            <td class="<?php echo $diff_color; ?> text-center"><?php echo to_farsi_local($diff_sign . $team['diff']); ?></td>
                                            <td class="font-black text-white bg-white/5 text-center"><?php echo to_farsi_local($team['points']); ?></td>
                                        </tr>
                                        <?php endforeach; else: ?>
                                            <tr><td colspan="8" class="text-center py-4 text-gray-500">جدول خالی است</td></tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <?php if ( is_active_sidebar( 'sport-sidebar' ) ) : ?>
                            <div id="sport-sidebar-area">
                                <?php dynamic_sidebar( 'sport-sidebar' ); ?>
                            </div>
                        <?php endif; ?>

                        <?php if ( is_active_sidebar( 'sport-ad-sidebar' ) ) : ?>
                            <div id="sport-ad-area">
                                <?php dynamic_sidebar( 'sport-ad-sidebar' ); ?>
                            </div>
                        <?php else: ?>
                            <div class="rounded-xl h-32 flex items-center justify-center text-blue-300/50 border border-blue-700/30" style="background: linear-gradient(135deg, #1e3a8a, #1e40af, #0f172a);">
                                <span class="text-sm font-bold border border-blue-500/30 px-3 py-1 rounded">تبلیغات</span>
                            </div>
                        <?php endif; ?>

                    </div>
                </aside>

                <main class="w-full lg:w-[75%] order-1 lg:order-2 flex flex-col gap-6">

                    <div class="hero-container shadow-2xl">
                        <div class="swiper hero-swiper">
                            <div class="swiper-wrapper">
                                <?php 
                                $hero = new WP_Query(['category_name' => 'sport', 'posts_per_page' => 2]);
                                if($hero->have_posts()): while($hero->have_posts()): $hero->the_post(); 
                                ?>
                                <div class="swiper-slide w-full h-full">
                                    <article class="sport-hero-article flex w-full h-full flex-col md:flex-row bg-[#1e293b] relative group">
                                        <div class="sport-hero-image-wrap w-full md:w-2/3 h-full relative overflow-hidden order-1 md:order-2">
                                            <a href="<?php echo add_query_arg('theme', 'sport', get_permalink()); ?>" class="block w-full h-full">
                                                <?php the_post_thumbnail('large', ['class' => 'w-full h-full object-cover group-hover:scale-105 transition duration-700']); ?>
                                            </a>
                                        </div>
                                        <div class="sport-hero-panel absolute bottom-0 right-0 w-full md:static md:w-1/3 p-6 md:p-10 flex flex-col justify-center order-2 md:order-1 z-10">
                                            <span class="sport-hero-badge"><span></span> تیتر یک ورزش</span>
                                            <h2 class="sport-hero-title">
                                                <a href="<?php echo add_query_arg('theme', 'sport', get_permalink()); ?>" style="color: inherit; text-decoration: none;"><?php the_title(); ?></a>
                                            </h2>
                                            <div class="sport-hero-excerpt hidden md:block"><?php echo get_the_excerpt(); ?></div>
                                            <div class="mt-4 pt-4 border-t border-gray-700 w-full">
                                                <a href="<?php echo add_query_arg('theme', 'sport', get_permalink()); ?>" class="sport-read-more">
                                                    ادامه مطلب <i class="fas fa-arrow-left"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </article>
                                </div>
                                <?php endwhile; endif; wp_reset_postdata(); ?>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <?php 
                        $sub_hero = new WP_Query(['category_name' => 'sport', 'posts_per_page' => 3, 'offset' => 2]);
                        while($sub_hero->have_posts()): $sub_hero->the_post(); 
                        ?>
                        <article class="sport-sub-card rounded-xl overflow-hidden group flex flex-col shadow-lg">
                            <a href="<?php echo add_query_arg('theme', 'sport', get_permalink()); ?>" class="block relative h-48 overflow-hidden">
                                <?php the_post_thumbnail('medium', ['class' => 'w-full h-full object-cover group-hover:scale-110 transition duration-500']); ?>
                            </a>
                            <div class="p-4 flex-1 flex flex-col">
                                <h3 class="sport-card-title line-clamp-2">
                                    <a href="<?php echo add_query_arg('theme', 'sport', get_permalink()); ?>" style="color: inherit; text-decoration: none;"><?php the_title(); ?></a>
                                </h3>
                            </div>
                        </article>
                        <?php endwhile; wp_reset_postdata(); ?>
                    </div>

                    <div class="mt-4">
                        <div class="sport-section-bar">
                            <span class="mark"></span>
                            <h3 class="sport-section-heading">سرخط خبرها</h3>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4">
                            <?php 
                            $main_list = new WP_Query(['category_name' => 'sport', 'posts_per_page' => 10]);
                            while($main_list->have_posts()): $main_list->the_post(); ?>
                            <article class="sport-news-row flex gap-4 p-3 rounded-xl group">
                                <div class="w-24 h-20 flex-shrink-0 rounded-lg overflow-hidden relative">
                                    <?php the_post_thumbnail('thumbnail', ['class' => 'w-full h-full object-cover group-hover:scale-110 transition']); ?>
                                </div>
                                <div class="flex flex-col justify-between py-0.5">
                                    <a href="<?php echo add_query_arg('theme', 'sport', get_permalink()); ?>">
                                        <h3 class="sport-mini-title line-clamp-2"><?php the_title(); ?></h3>
                                    </a>
                                    <span class="sport-time-text">
                                        <?php echo to_farsi_local(human_time_diff(get_the_time('U'), current_time('timestamp'))) . ' پیش'; ?>
                                    </span>
                                </div>
                            </article>
                            <?php endwhile; wp_reset_postdata(); ?>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </div>

    <!-- Mobile View -->
    <div class="lg:hidden sport-mobile-shell">

        <div class="swiper sport-mobile-slider">
            <div class="swiper-wrapper">
                <?php 
                $mobile_hero = new WP_Query(['category_name' => 'sport', 'posts_per_page' => 5, 'ignore_sticky_posts' => 1]);
                if($mobile_hero->have_posts()): while($mobile_hero->have_posts()): $mobile_hero->the_post(); 
                ?>
                <div class="swiper-slide">
                    <a href="<?php echo add_query_arg('theme', 'sport', get_permalink()); ?>" class="sport-mobile-slide-link">
                        <?php the_post_thumbnail('large', ['class' => 'w-full h-full object-cover']); ?>
                        <div class="sport-mobile-caption">
                            <span class="sport-mobile-badge">ورزش</span>
                            <h2 class="sport-mobile-title"><?php the_title(); ?></h2>
                        </div>
                    </a>
                </div>
                <?php endwhile; wp_reset_postdata(); endif; ?>
            </div>
            <div class="swiper-pagination"></div>
        </div>

        <?php if ( is_active_sidebar( 'sport-ad-sidebar' ) ) : ?>
            <div class="sport-mobile-ad">
                <div class="sport-mobile-ad-label">تبلیغات</div>
                <div class="sport-mobile-ad-content">
                    <?php dynamic_sidebar( 'sport-ad-sidebar' ); ?>
                </div>
            </div>
        <?php endif; ?>

        <div class="sport-mobile-tabs">
            <div class="sport-mobile-tab active sport-group-1-tab" onclick="toggleSportTabs(event, 'sport-group1', 'sport-m-latest')" data-slug="latest" data-btn="sport-btn-load-1">آخرین اخبار</div>
            <div class="sport-mobile-tab sport-group-1-tab" onclick="toggleSportTabs(event, 'sport-group1', 'sport-m-table')" data-slug="table" data-btn="sport-btn-load-1">جدول لیگ</div>
        </div>

        <div class="sport-mobile-panel">
            <div id="sport-m-latest" class="sport-mobile-content sport-group1-content">
                <div id="sport-list-latest">
                    <?php 
                    $sport_latest_mobile = new WP_Query(['category_name' => 'sport', 'posts_per_page' => 5, 'ignore_sticky_posts' => 1]);
                    if($sport_latest_mobile->have_posts()): while($sport_latest_mobile->have_posts()): $sport_latest_mobile->the_post(); 
                    ?>
                    <a href="<?php echo add_query_arg('theme', 'sport', get_permalink()); ?>" class="sport-mobile-row">
                        <div class="sport-mobile-thumb">
                            <?php the_post_thumbnail('thumbnail', ['class' => 'w-full h-full object-cover']); ?>
                        </div>
                        <div class="sport-mobile-row-content">
                            <h4 class="sport-mobile-row-title"><?php the_title(); ?></h4>
                            <div class="sport-mobile-row-excerpt"><?php echo wp_trim_words(get_the_excerpt(), 18, '...'); ?></div>
                            <div class="sport-mobile-row-meta"><i class="far fa-clock"></i> <?php echo to_farsi_local(get_the_date('j F Y')); ?></div>
                        </div>
                    </a>
                    <?php endwhile; wp_reset_postdata(); endif; ?>
                </div>
            </div>

            <div id="sport-m-table" class="sport-mobile-content sport-group1-content hidden">
                <div style="padding: 0;">
                    <?php 
                    $teams_query_mobile = new WP_Query(['post_type' => 'league_team', 'posts_per_page' => -1]);
                    $table_data_mobile = [];
                    if($teams_query_mobile->have_posts()) {
                        while($teams_query_mobile->have_posts()) {
                            $teams_query_mobile->the_post();
                            if (!function_exists('get_field')) continue;
                            $played = (int)get_field('played'); $won = (int)get_field('won'); $drawn = (int)get_field('drawn');
                            $lost = (int)get_field('lost'); $deducted = (int)get_field('deducted'); $gf = (int)get_field('gf'); $ga = (int)get_field('ga');
                            $points = ($won * 3) + $drawn - $deducted; $diff = $gf - $ga;
                            $table_data_mobile[] = ['name' => get_the_title(), 'logo' => get_the_post_thumbnail_url(get_the_ID(), 'thumbnail'), 'played' => $played, 'won' => $won, 'drawn' => $drawn, 'lost' => $lost, 'points' => $points, 'diff' => $diff];
                        }
                        wp_reset_postdata();
                        usort($table_data_mobile, function($a, $b) {
                            if ($a['points'] != $b['points']) return $b['points'] - $a['points'];
                            return $b['diff'] - $a['diff'];
                        });
                        $top_teams_mobile = array_slice($table_data_mobile, 0, 8);
                    }
                    ?>
                    <table class="w-full mini-table">
                        <thead>
                            <tr>
                                <th class="w-6 text-center">#</th>
                                <th class="text-right">تیم</th>
                                <th class="text-gray-400 text-center">بازی</th>
                                <th class="text-green-500/80 text-center">برد</th>
                                <th class="text-gray-400 text-center">مساوی</th>
                                <th class="text-red-500/80 text-center">باخت</th>
                                <th class="text-white font-bold w-10 text-center">امتیاز</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(!empty($top_teams_mobile)): $rank_mobile = 1; foreach($top_teams_mobile as $team): ?>
                            <tr>
                                <td class="text-gray-500 font-bold text-center"><?php echo to_farsi_local($rank_mobile++); ?></td>
                                <td class="text-right">
                                    <div class="flex items-center gap-1.5">
                                        <?php if($team['logo']): ?>
                                            <div class="w-5 h-5 bg-white/10 rounded-full p-0.5 flex items-center justify-center shrink-0">
                                                <img src="<?php echo esc_url($team['logo']); ?>" class="w-full h-full object-contain">
                                            </div>
                                        <?php endif; ?>
                                        <span class="text-gray-200 font-medium truncate max-w-[60px] block"><?php echo esc_html($team['name']); ?></span>
                                    </div>
                                </td>
                                <td class="text-gray-400 text-center"><?php echo to_farsi_local($team['played']); ?></td>
                                <td class="text-gray-300 text-center"><?php echo to_farsi_local($team['won']); ?></td>
                                <td class="text-gray-400 text-center"><?php echo to_farsi_local($team['drawn']); ?></td>
                                <td class="text-gray-400 text-center"><?php echo to_farsi_local($team['lost']); ?></td>
                                <td class="font-black text-white bg-white/5 text-center"><?php echo to_farsi_local($team['points']); ?></td>
                            </tr>
                            <?php endforeach; else: ?>
                                <tr><td colspan="7" class="text-center py-4 text-gray-500">جدول خالی است</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="sport-mobile-load-wrap">
                <button id="sport-btn-load-1" onclick="loadMoreSportMobile('sport-btn-load-1', 'sport-group1')" class="sport-mobile-load-btn">
                    <i class="fas fa-plus-circle"></i> مشاهده اخبار بیشتر
                </button>
            </div>
        </div>

        <div class="sport-mobile-tabs">
            <div class="sport-mobile-tab active sport-group-2-tab" onclick="toggleSportTabs(event, 'sport-group2', 'sport-m-headlines')" data-slug="headlines" data-btn="sport-btn-load-2">سرخط خبرها</div>
            <div class="sport-mobile-tab sport-group-2-tab" onclick="toggleSportTabs(event, 'sport-group2', 'sport-m-sidebar')" data-slug="sidebar" data-btn="sport-btn-load-2">خبرهای کوتاه</div>
        </div>

        <div class="sport-mobile-panel">
            <div id="sport-m-headlines" class="sport-mobile-content sport-group2-content">
                <div id="sport-list-headlines">
                    <?php 
                    $sport_headlines_mobile = new WP_Query(['category_name' => 'sport', 'posts_per_page' => 5, 'offset' => 5, 'ignore_sticky_posts' => 1]);
                    if($sport_headlines_mobile->have_posts()): while($sport_headlines_mobile->have_posts()): $sport_headlines_mobile->the_post(); 
                    ?>
                    <a href="<?php echo add_query_arg('theme', 'sport', get_permalink()); ?>" class="sport-mobile-row">
                        <div class="sport-mobile-thumb">
                            <?php the_post_thumbnail('thumbnail', ['class' => 'w-full h-full object-cover']); ?>
                        </div>
                        <div class="sport-mobile-row-content">
                            <h4 class="sport-mobile-row-title"><?php the_title(); ?></h4>
                            <div class="sport-mobile-row-excerpt"><?php echo wp_trim_words(get_the_excerpt(), 18, '...'); ?></div>
                            <div class="sport-mobile-row-meta"><i class="far fa-clock"></i> <?php echo to_farsi_local(get_the_date('j F Y')); ?></div>
                        </div>
                    </a>
                    <?php endwhile; wp_reset_postdata(); endif; ?>
                </div>
            </div>

            <div id="sport-m-sidebar" class="sport-mobile-content sport-group2-content hidden">
                <div id="sport-list-sidebar">
                    <?php 
                    $sport_sidebar_mobile = new WP_Query(['category_name' => 'sport', 'posts_per_page' => 5, 'offset' => 10, 'ignore_sticky_posts' => 1]);
                    if($sport_sidebar_mobile->have_posts()): while($sport_sidebar_mobile->have_posts()): $sport_sidebar_mobile->the_post(); 
                    ?>
                    <a href="<?php echo add_query_arg('theme', 'sport', get_permalink()); ?>" class="sport-mobile-row">
                        <div class="sport-mobile-thumb">
                            <?php the_post_thumbnail('thumbnail', ['class' => 'w-full h-full object-cover']); ?>
                        </div>
                        <div class="sport-mobile-row-content">
                            <h4 class="sport-mobile-row-title"><?php the_title(); ?></h4>
                            <div class="sport-mobile-row-excerpt"><?php echo wp_trim_words(get_the_excerpt(), 18, '...'); ?></div>
                            <div class="sport-mobile-row-meta"><i class="far fa-clock"></i> <?php echo to_farsi_local(get_the_date('j F Y')); ?></div>
                        </div>
                    </a>
                    <?php endwhile; wp_reset_postdata(); endif; ?>
                </div>
            </div>

            <div class="sport-mobile-load-wrap">
                <button id="sport-btn-load-2" onclick="loadMoreSportMobile('sport-btn-load-2', 'sport-group2')" class="sport-mobile-load-btn">
                    <i class="fas fa-plus-circle"></i> مشاهده اخبار بیشتر
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Swiper JS - Local -->
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/swiper-bundle.min.js"></script>

<script>
    const sportPageCounters = {
        latest: 1,
        headlines: 1,
        sidebar: 1
    };

    function toggleSportTabs(evt, groupName, contentId) {
        let tabSelector = groupName === 'sport-group1' ? '.sport-group-1-tab' : '.sport-group-2-tab';
        let contentSelector = groupName === 'sport-group1' ? '.sport-group1-content' : '.sport-group2-content';

        document.querySelectorAll(tabSelector).forEach(btn => btn.classList.remove('active'));
        document.querySelectorAll(contentSelector).forEach(c => c.classList.add('hidden'));

        evt.currentTarget.classList.add('active');
        document.getElementById(contentId).classList.remove('hidden');

        let btn = document.getElementById(evt.currentTarget.getAttribute('data-btn'));
        let slug = evt.currentTarget.getAttribute('data-slug');

        if (btn) {
            if (slug === 'table') {
                btn.style.display = 'none';
            } else {
                btn.style.display = 'flex';
                btn.innerHTML = '<i class="fas fa-plus-circle"></i> مشاهده اخبار بیشتر';
                btn.disabled = false;
            }
        }
    }

    function loadMoreSportMobile(btnId, groupName) {
        const btn = document.getElementById(btnId);
        let activeTab = document.querySelector(groupName === 'sport-group1' ? '.sport-group-1-tab.active' : '.sport-group-2-tab.active');
        if (!activeTab || !btn) return;

        const slug = activeTab.getAttribute('data-slug');

        if (slug === 'table') {
            btn.style.display = 'none';
            return;
        }

        const listContainerId = 'sport-list-' + slug;
        const listContainer = document.getElementById(listContainerId);

        if (!listContainer) return;

        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> در حال دریافت...';

        let nextPage = (sportPageCounters[slug] || 1) + 1;
        let offsetBase = 0;

        if (slug === 'latest') offsetBase = 0;
        if (slug === 'headlines') offsetBase = 5;
        if (slug === 'sidebar') offsetBase = 10;

        const formData = new FormData();
        formData.append('action', 'load_more_mobile_action');
        formData.append('page', nextPage);
        formData.append('type', 'sport');

        fetch('<?php echo admin_url('admin-ajax.php'); ?>', {
            method: 'POST',
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.success && data.data.html) {
                listContainer.insertAdjacentHTML('beforeend', data.data.html);
                sportPageCounters[slug] = nextPage;
                btn.innerHTML = '<i class="fas fa-plus-circle"></i> مشاهده اخبار بیشتر';
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

    document.addEventListener('DOMContentLoaded', function () {
        new Swiper(".hero-swiper", {
            direction: "vertical",
            slidesPerView: 1,
            spaceBetween: 0,
            speed: 800,
            loop: true,
            autoplay: {
                delay: 6000,
                disableOnInteraction: false,
            },
            allowTouchMove: false,
        });

        new Swiper(".sport-mobile-slider", {
            loop: true,
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
            },
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
        });
    });
</script>

<?php get_footer('sport'); ?>