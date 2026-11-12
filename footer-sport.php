<footer class="sport-footer">

    <div class="sport-footer-bg-icon">
        <i class="far fa-futbol"></i>
    </div>

    <div class="sport-footer-inner">
        <div class="sport-footer-grid">
            
            <div class="sport-footer-col">
                <div class="sport-footer-logo">
                    <div class="sport-footer-logo-icon">S</div>

                    <div class="sport-footer-logo-text">
                        <span class="main">شرجی <span>اسپورت</span></span>
                        <span class="sub">نبض ورزش جنوب</span>
                    </div>
                </div>

                <p class="sport-footer-desc">
                    پوشش تخصصی اخبار ورزشی ایران و جهان، نتایج زنده، تحلیل‌های فنی و حواشی جذاب فوتبال. شرجی اسپورت، همراه لحظه‌به‌لحظه هواداران.
                </p>
                
                <div class="sport-footer-socials">
                    <a href="https://t.me/sharjipress" target="_blank" rel="noopener noreferrer" title="تلگرام">
                        <img src="<?php echo esc_url( home_url('/wp-content/uploads/2026/01/telegram.png') ); ?>" alt="Telegram">
                    </a>

                    <a href="https://www.instagram.com/sharjipress" target="_blank" rel="noopener noreferrer" title="اینستاگرام">
                        <img src="<?php echo esc_url( home_url('/wp-content/uploads/2026/01/instagram.png') ); ?>" alt="Instagram">
                    </a>

                    <a href="https://chat.whatsapp.com/E85l09DTbdSJadirLy3YKw?mode=gi_t" target="_blank" rel="noopener noreferrer" title="واتساپ">
                        <img src="<?php echo esc_url( home_url('/wp-content/uploads/2026/01/whatsapp.png') ); ?>" alt="Whatsapp">
                    </a>

                    <a href="https://ble.ir/sharjipress" target="_blank" rel="noopener noreferrer" title="بله">
                        <img src="<?php echo esc_url( home_url('/wp-content/uploads/2026/01/bale.png') ); ?>" alt="Bale">
                    </a>

                    <a href="#" title="ایتا" onclick="return false;">
                        <img src="<?php echo esc_url( home_url('/wp-content/uploads/2026/01/Eitaa.png') ); ?>" alt="Eitaa">
                    </a>
                </div>
            </div>

            <div class="sport-footer-col">
                <h4 class="sport-footer-title">دسترسی سریع</h4>

                <ul class="sport-footer-list">
                    <li>
                        <a href="<?php echo esc_url( home_url('/league-table') ); ?>">
                            <i class="fas fa-angle-left"></i> جدول لیگ برتر
                        </a>
                    </li>

                    <li>
                        <a href="<?php echo esc_url( home_url('/wlivescores') ); ?>">
                            <i class="fas fa-angle-left"></i> نتایج زنده <span class="sport-live-badge">LIVE</span>
                        </a>
                    </li>

                    <li>
                        <a href="#">
                            <i class="fas fa-angle-left"></i> برنامه بازی‌ها
                        </a>
                    </li>

                    <li>
                        <a href="#">
                            <i class="fas fa-angle-left"></i> ویدیوهای ورزشی
                        </a>
                    </li>
                </ul>
            </div>

            <div class="sport-footer-col">
                <h4 class="sport-footer-title">شرجی اسپورت</h4>

                <ul class="sport-footer-list">
                    <li>
                        <a href="<?php echo esc_url( home_url('/about-us') ); ?>">
                            <i class="fas fa-angle-left"></i> درباره ما
                        </a>
                    </li>

                    <li>
                        <a href="<?php echo esc_url( home_url('/contact') ); ?>">
                            <i class="fas fa-angle-left"></i> تماس با ما
                        </a>
                    </li>

                    <li>
                        <a href="#">
                            <i class="fas fa-angle-left"></i> تبلیغات در ورزش
                        </a>
                    </li>
                </ul>
            </div>

            <div class="sport-footer-col">
                <h4 class="sport-footer-title">پل‌های ارتباطی</h4>
                
                <div class="sport-contact-card">
                    <i class="fas fa-phone"></i>

                    <div style="display: flex; flex-direction: column;">
                        <span class="label">شماره تماس</span>
                        <span class="value" dir="ltr" style="letter-spacing: 0.05em; font-weight: bold;">0916 929 8505</span>
                    </div>
                </div>
                
                <div class="sport-contact-card">
                    <i class="fas fa-envelope"></i>

                    <div style="display: flex; flex-direction: column;">
                        <span class="label">پست الکترونیک</span>
                        <span class="value mono">sharjipress@gmail.com</span>
                    </div>
                </div>
                
                <div class="sport-contact-address">
                    <i class="fas fa-map-marker-alt"></i>
                    <p style="margin: 0;">آبادان، خیابان امیری، جنب پاساژ پارمیدا، دفتر شرجی پرس</p>
                </div>

                <?php
                if ( function_exists( 'sharji_render_erasaneh_trust_box' ) ) {
                    sharji_render_erasaneh_trust_box( 'sport-erasaneh-trust-box' );
                }
                ?>
            </div>

        </div>

        <div class="sport-footer-bottom">
            <p class="copyright">
                © ۲۰۲۶ تمامی حقوق مادی و معنوی این سایت متعلق به <strong>شرجی اسپورت</strong> می‌باشد.
            </p>

            <div class="credit">
                <span>توسعه و اجرا:</span>

                <a href="http://devzarei.ir/fa.html" target="_blank" rel="noopener noreferrer">
                    محمدعلی زارعی <i class="fas fa-code" style="font-size: 10px;"></i>
                </a>
            </div>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
