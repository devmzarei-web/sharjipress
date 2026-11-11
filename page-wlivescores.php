<?php
/**
 * Template Name: Sharji Sport - World Live Scores (Modular & Blue)
 * File Name: page-wlivescores.php
 */

get_header('sport'); 
?>

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