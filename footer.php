<footer class="site-footer">
    
    <img 
        class="footer-bg-img-tag" 
        src="<?php echo esc_url( home_url('/wp-content/uploads/2026/01/footer3.webp') ); ?>" 
        alt="Sharji Background"
    >

    <div class="footer-content-wrapper">
        <div class="footer-grid">
            
            <div class="footer-col">
                <div class="footer-brand">
                    <div class="footer-brand-mark">
                        <img 
                            src="<?php echo esc_url( home_url('/wp-content/uploads/2026/01/logosharjiback.webp') ); ?>" 
                            alt="شرجی پرس"
                        >
                    </div>

                    <div class="footer-brand-text">
                        <span class="footer-brand-title">شرجی <span>پرس</span></span>
                        <span class="footer-brand-subtitle">صدای جنوب غرب کشور</span>
                    </div>
                </div>

                <p class="footer-desc">
                    پایگاه خبری تحلیلی شرجی پرس، صدای رسای مردم جنوب غرب کشور.
                    ما با تکیه بر صداقت، سرعت و نگاه منطقه‌ای، رویدادهای آبادان، خوزستان و ایران را به صورت تخصصی پوشش می‌دهیم.
                </p>
                
                <div class="social-row md:justify-start">
                    <a href="https://t.me/sharjipress" target="_blank" rel="noopener noreferrer" class="social-btn" title="تلگرام">
                        <img src="<?php echo esc_url( home_url('/wp-content/uploads/2026/01/telegram.png') ); ?>" alt="telegram">
                    </a>

                    <a href="https://www.instagram.com/sharjipress" target="_blank" rel="noopener noreferrer" class="social-btn" title="اینستاگرام">
                        <img src="<?php echo esc_url( home_url('/wp-content/uploads/2026/01/instagram.png') ); ?>" alt="instagram">
                    </a>

                    <a href="https://chat.whatsapp.com/E85l09DTbdSJadirLy3YKw" target="_blank" rel="noopener noreferrer" class="social-btn" title="واتساپ">
                        <img src="<?php echo esc_url( home_url('/wp-content/uploads/2026/01/whatsapp.png') ); ?>" alt="whatsapp">
                    </a>

                    <a href="https://ble.ir/sharjipress" target="_blank" rel="noopener noreferrer" class="social-btn" title="بله">
                        <img src="<?php echo esc_url( home_url('/wp-content/uploads/2026/01/bale.png') ); ?>" alt="bale">
                    </a>

                    <a href="#" onclick="return false;" class="social-btn" title="ایتا">
                        <img src="<?php echo esc_url( home_url('/wp-content/uploads/2026/01/Eitaa.png') ); ?>" alt="eitaa">
                    </a>
                </div>
            </div>

            <div class="footer-col">
                <h4 class="footer-card-title">دسترسی سریع</h4>
                <nav>
                    <a href="<?php echo esc_url( home_url() ); ?>" class="footer-list-link">
                        <i class="fas fa-chevron-left"></i> صفحه اصلی
                    </a>

                    <a href="<?php echo esc_url( home_url('/category/news') ); ?>" class="footer-list-link">
                        <i class="fas fa-chevron-left"></i> آخرین اخبار
                    </a>

                    <a href="<?php echo esc_url( home_url('/about-us') ); ?>" class="footer-list-link">
                        <i class="fas fa-chevron-left"></i> درباره ما
                    </a>

                    <a href="<?php echo esc_url( home_url('/contact') ); ?>" class="footer-list-link">
                        <i class="fas fa-chevron-left"></i> تماس با ما
                    </a>
                </nav>
            </div>

            <div class="footer-col">
                <?php 
                $user = wp_get_current_user();

                if ( in_array( 'um_custom_role_1', (array) $user->roles ) ) : 
                ?>
                    <h4 class="footer-card-title" style="border-color: #ef4444;">پنل خبرنگاران</h4>
                    <nav>
                        <a href="<?php echo esc_url( home_url('/submit-news') ); ?>" class="footer-list-link footer-reporter-link">
                            <i class="fas fa-pen-nib"></i> ارسال خبر جدید
                        </a>

                        <?php if ( function_exists('um_get_core_page') ) : ?>
                            <a href="<?php echo esc_url( um_get_core_page('user') ); ?>" class="footer-list-link">
                                <i class="fas fa-user-circle"></i> پروفایل من
                            </a>
                        <?php endif; ?>

                        <a href="<?php echo esc_url( home_url('/publishing-guide') ); ?>" class="footer-list-link">
                            <i class="fas fa-book"></i> راهنمای نگارش
                        </a>
                    </nav>
                <?php else: ?>
                    <h4 class="footer-card-title">موضوعات پربازدید</h4>
                    <nav>
                        <a href="<?php echo esc_url( home_url('/category/khuzestan') ); ?>" class="footer-list-link">
                            <i class="fas fa-chevron-left"></i> اخبار خوزستان
                        </a>

                        <a href="<?php echo esc_url( home_url('/category/sport') ); ?>" class="footer-list-link">
                            <i class="fas fa-chevron-left"></i> شرجی اسپورت
                        </a>

                        <a href="<?php echo esc_url( home_url('/category/tahlil') ); ?>" class="footer-list-link">
                            <i class="fas fa-chevron-left"></i> تحلیل روز
                        </a>

                        <a href="<?php echo esc_url( home_url('/category/multimedia') ); ?>" class="footer-list-link">
                            <i class="fas fa-chevron-left"></i> چندرسانه‌ای
                        </a>
                    </nav>
                <?php endif; ?>
            </div>

            <div class="footer-col">
                <h4 class="footer-card-title">ارتباط با ما</h4>

                <div class="footer-contact-list">
                    <div class="contact-row">
                        <i class="fa fa-envelope"></i>
                        <span class="contact-ltr">sharjipress@gmail.com</span>
                    </div>

                    <div class="contact-row">
                        <i class="fa fa-phone"></i>
                        <span class="font-bold tracking-wider contact-ltr">0916 929 8505</span>
                    </div>

                    <div class="contact-row items-start">
                        <i class="fa fa-map-marker-alt mt-1"></i>
                        <span class="leading-7">آبادان، خیابان امیری، جنب پاساژ پارمیدا، دفتر شرجی پرس</span>
                    </div>
                </div>

                <?php
                if ( function_exists( 'sharji_render_erasaneh_trust_box' ) ) {
                    sharji_render_erasaneh_trust_box( 'erasaneh-trust-box' );
                }
                ?>
            </div>

        </div>

        <div class="copyright-bar">
            <p>
                تمامی حقوق محفوظ است © ۲۰۲۶ | <strong>شرجی پرس</strong>
                <span class="hidden md:inline mx-2">|</span>
                <br class="md:hidden">
                توسعه و اجرا:
                <a href="http://devzarei.ir/fa.html" target="_blank" rel="noopener noreferrer" class="footer-credit-link transition">
                    محمدعلی زارعی
                </a>
            </p>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
