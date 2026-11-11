<?php
/**
 * Template Name: Sharji Sport - World Live Scores (Modular & Blue)
 * File Name: page-wlivescores.php
 */

get_header('sport'); 
?>

<style>
    .livescore-wrapper {
        max-width: 1100px;
        margin: 0 auto;
        padding: 0 16px 40px;
        text-align: right;
    }
    
    .livescore-header {
        text-align: center;
        margin-bottom: 32px;
    }
    .livescore-header h2 {
        font-family: 'Diba', sans-serif;
        font-size: 36px;
        color: #fff;
        margin-bottom: 12px;
        letter-spacing: -0.5px;
    }
    .livescore-header h2 span { color: #3b82f6; }
    .livescore-header p {
        color: #6b7280;
        font-size: 14px;
        max-width: 448px;
        margin: 0 auto;
        line-height: 1.5rem;
    }

    .livescore-container {
        position: relative;
        background: #111827;
        border-radius: 16px;
        overflow: hidden;
        border: 1px solid #374151;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
    }

    /* فیلتر برای تیره کردن آی‌فریم سفید */
    .dark-iframe-wrapper {
        filter: invert(90%) hue-rotate(180deg) brightness(105%) contrast(105%);
        background: #fff;
    }

    iframe {
        width: 100%;
        min-height: 900px;
        border: none;
        display: block;
    }
    
    /* باکس‌های اطلاعات */
    .livescore-info-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 16px;
        margin-top: 32px;
        text-align: center;
    }
    
    .livescore-info-card {
        padding: 16px;
        background: rgba(30, 41, 59, 0.3);
        border-radius: 12px;
        border: 1px solid #1f2937;
        transition: border-color 0.3s;
    }
    .livescore-info-card:hover { border-color: rgba(30, 58, 138, 0.5); }
    .livescore-info-card i { font-size: 20px; margin-bottom: 8px; }
    .livescore-info-card .info-label {
        font-size: 10px;
        color: #9ca3af;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        margin-bottom: 4px;
    }
    .livescore-info-card .info-value {
        color: #fff;
        font-weight: bold;
        font-size: 14px;
    }
    .livescore-info-card i.blue { color: #3b82f6; }
    .livescore-info-card i.light-blue { color: #60a5fa; }
    .livescore-info-card i.yellow { color: #eab308; }
    
    @media (min-width: 769px) {
        .livescore-info-grid {
            grid-template-columns: repeat(3, 1fr);
        }
    }
</style>

<div class="livescore-wrapper">
    
    <div class="livescore-header">
        <h2>نتایج زنده <span>ایران و جهان</span></h2>
        <p>پوشش لحظه‌ای لیگ برتر ایران و معتبرترین رقابت‌های فوتبالی جهان با به‌روزرسانی خودکار</p>
    </div>

    <div class="livescore-container">
        <div class="dark-iframe-wrapper">
            <iframe 
                src="https://www.livescore.bz/en/football/league/119/results/" 
                loading="lazy"
                title="نتایج زنده فوتبال">
            </iframe>
        </div>
    </div>
    
    <div class="livescore-info-grid">
        
        <div class="livescore-info-card">
            <i class="fas fa-clock blue"></i>
            <p class="info-label">سرعت بروزرسانی</p>
            <p class="info-value">هر ۳۰ ثانیه یکبار</p>
        </div>

        <div class="livescore-info-card">
            <i class="fas fa-globe light-blue"></i>
            <p class="info-label">محدوده پوشش</p>
            <p class="info-value">تمامی لیگ‌های معتبر</p>
        </div>

        <div class="livescore-info-card">
            <i class="fas fa-bolt yellow"></i>
            <p class="info-label">نوع همگام‌سازی</p>
            <p class="info-value">اتصال مستقیم جهانی</p>
        </div>

    </div>
</div>

<?php get_footer('sport'); ?>