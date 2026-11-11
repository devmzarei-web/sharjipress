<style>
    @font-face {
        font-family: 'Diba';
        src: url('<?php echo esc_url( get_template_directory_uri() ); ?>/fonts/Diba.woff2') format('woff2');
        font-weight: bold;
        font-style: normal;
        font-display: swap;
    }

    .site-footer {
        font-family: 'Vazirmatn', sans-serif !important;
        background:
            radial-gradient(circle at top right, rgba(59, 130, 246, 0.16), transparent 34%),
            radial-gradient(circle at bottom left, rgba(14, 165, 233, 0.08), transparent 30%),
            linear-gradient(180deg, #0f172a 0%, #07111f 100%) !important;
        position: relative;
        width: 100%;
        margin-top: 80px;
        padding-top: 76px;
        padding-bottom: 34px;
        overflow: hidden;
        direction: rtl;
        border-top: 4px solid #3b82f6;
        color: #94a3b8;
        box-shadow: 0 -22px 70px rgba(15, 23, 42, 0.18);
    }

    .footer-bg-img-tag {
        position: absolute;
        top: 0 !important;
        bottom: auto !important;
        left: 0 !important;
        width: 100% !important;
        height: auto !important;
        min-height: 220px;
        object-fit: cover !important;
        object-position: top center !important;
        z-index: 0 !important;
        pointer-events: none;
        filter: brightness(0) invert(1) !important;
        opacity: 0.09 !important;
    }

    .footer-content-wrapper {
        position: relative;
        z-index: 10 !important;
        max-width: 1920px;
        margin: 0 auto;
        padding: 0 40px;
        width: 100%;
    }

    .footer-grid {
        display: grid;
        grid-template-columns: 1.35fr 0.85fr 0.95fr 1.15fr;
        gap: 42px;
        text-align: right;
        align-items: start;
    }

    .footer-col {
        position: relative;
    }

    .footer-brand {
        display: flex;
        align-items: center;
        gap: 14px;
        margin-bottom: 22px;
    }

    .footer-brand-mark {
        width: 60px;
        height: 60px;
        border-radius: 16px;
        background:
            radial-gradient(circle at top right, rgba(255,255,255,0.24), transparent 38%),
            linear-gradient(135deg, #2563eb, #0b66c3);
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 16px 32px rgba(37, 99, 235, 0.23);
        border: 1px solid rgba(147, 197, 253, 0.22);
        flex-shrink: 0;
        overflow: hidden;
        padding: 3px;
    }

    .footer-brand-mark img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        display: block;
    }

    .footer-brand-text {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .footer-brand-title {
        font-family: 'Diba', 'Vazirmatn', sans-serif !important;
        font-size: 2rem;
        color: #fff;
        line-height: 1;
        letter-spacing: -0.03em;
    }

    .footer-brand-title span {
        color: #3b82f6;
    }

    .footer-brand-subtitle {
        color: #64748b;
        font-size: 12px;
        font-weight: 700;
    }

    .footer-card-title {
        font-family: 'Diba', 'Vazirmatn', sans-serif !important;
        color: #fff !important;
        font-size: 1.3rem;
        margin-bottom: 26px;
        border-right: 4px solid #3b82f6;
        padding-right: 12px;
        display: inline-block;
        line-height: 1.25;
        position: relative;
    }

    .footer-card-title::after {
        content: "";
        position: absolute;
        right: 12px;
        bottom: -10px;
        width: 44px;
        height: 2px;
        border-radius: 999px;
        background: rgba(59, 130, 246, 0.55);
    }

    .footer-desc {
        color: #cbd5e1;
        font-size: 0.92rem;
        line-height: 2.05;
        text-align: justify;
        margin-bottom: 24px;
        opacity: 0.92;
    }

    .footer-list-link {
        display: flex;
        align-items: center;
        width: fit-content;
        color: #94a3b8;
        margin-bottom: 13px;
        font-size: 0.95rem;
        font-weight: 700;
        text-decoration: none !important;
        transition: all 0.25s ease;
    }

    .footer-list-link:hover {
        color: #60a5fa !important;
        transform: translateX(-5px);
    }

    .footer-list-link i {
        font-size: 0.72rem;
        margin-left: 9px;
        opacity: 0.9;
        color: #3b82f6;
    }

    .footer-reporter-link {
        color: #f87171 !important;
        font-weight: 900;
    }

    .footer-reporter-link:hover {
        color: #ef4444 !important;
    }

    .social-row {
        display: flex;
        gap: 12px;
        margin-top: 22px;
        flex-wrap: wrap;
    }

    .social-btn {
        width: 44px;
        height: 44px;
        background: rgba(30, 41, 59, 0.82);
        border: 1px solid rgba(148, 163, 184, 0.14);
        border-radius: 13px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.28s ease;
        text-decoration: none !important;
    }

    .social-btn:hover {
        background: #3b82f6;
        border-color: #60a5fa;
        transform: translateY(-4px);
        box-shadow: 0 14px 28px rgba(37, 99, 235, 0.22);
    }

    .social-btn img {
        width: 24px;
        height: 24px;
        object-fit: contain;
        transition: 0.28s;
    }

    .social-btn:hover img {
        transform: scale(1.12);
    }

    .footer-contact-list {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .contact-row {
        display: flex;
        align-items: center;
        justify-content: flex-start;
        gap: 12px;
        color: #cbd5e1;
        font-size: 0.9rem;
        margin-bottom: 0;
        direction: rtl;
        background: rgba(30, 41, 59, 0.76);
        border: 1px solid rgba(148, 163, 184, 0.13);
        border-radius: 14px;
        padding: 13px;
        transition: all 0.28s ease;
    }

    .contact-row:hover {
        border-color: rgba(96, 165, 250, 0.42);
        background: rgba(30, 41, 59, 0.96);
        transform: translateY(-2px);
    }

    .contact-row i {
        color: #3b82f6;
        width: 24px;
        text-align: center;
        font-size: 1.1rem;
        flex-shrink: 0;
    }

    .contact-row span {
        direction: rtl;
        line-height: 1.8;
    }

    .contact-row .contact-ltr {
        direction: ltr;
        display: inline-block;
        letter-spacing: 0.03em;
    }

    .erasaneh-trust-box {
        margin-top: 14px;
        background: rgba(30, 41, 59, 0.76);
        border: 1px solid rgba(148, 163, 184, 0.13);
        border-radius: 14px;
        padding: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 82px;
        overflow: hidden;
    }

    .erasaneh-trust-box:hover {
        border-color: rgba(96, 165, 250, 0.42);
        background: rgba(30, 41, 59, 0.96);
    }

    .erasaneh-trust-box iframe,
    .erasaneh-trust-box img {
        max-width: 100% !important;
        height: auto !important;
    }

    .copyright-bar {
        border-top: 1px solid rgba(255, 255, 255, 0.07);
        margin-top: 58px;
        padding-top: 26px;
        text-align: center;
        font-size: 0.85rem;
        color: #64748b;
    }

    .copyright-bar p {
        margin: 0;
        line-height: 2;
    }

    .copyright-bar strong {
        color: #cbd5e1;
    }

    .footer-credit-link {
        color: #3b82f6 !important;
        font-weight: 900;
        text-decoration: none !important;
        transition: color 0.25s ease;
    }

    .footer-credit-link:hover {
        color: #60a5fa !important;
    }

    .text-3xl { font-size: 1.875rem; }
    .text-white { color: #fff; }
    .text-blue-500 { color: #3b82f6; }
    .text-gray-400 { color: #9ca3af; }
    .text-red-400 { color: #f87171; }
    .font-bold { font-weight: bold; }
    .mb-5 { margin-bottom: 20px; }
    .mt-1 { margin-top: 4px; }
    .mt-4 { margin-top: 16px; }
    .items-start { align-items: flex-start; }
    .tracking-wider { letter-spacing: 0.05em; }
    .leading-7 { line-height: 1.75rem; }
    .transition { transition: all 0.3s; }
    .hidden { display: none; }
    .mx-2 { margin-left: 8px; margin-right: 8px; }

    @media (max-width: 1024px) {
        .footer-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 38px;
        }
    }

    @media (max-width: 768px) {
        .site-footer {
            margin-top: 56px;
            padding-top: 56px;
            padding-bottom: 28px;
        }

        .footer-content-wrapper {
            padding: 0 16px;
        }

        .footer-grid {
            grid-template-columns: 1fr;
            text-align: center !important;
            gap: 0;
        }

        .footer-bg-img-tag {
            opacity: 0.07 !important;
            top: 20px !important;
        }

        .footer-col {
            text-align: center !important;
            margin-bottom: 42px;
        }

        .footer-brand {
            justify-content: center;
            flex-direction: column;
            gap: 12px;
        }

        .footer-brand-text {
            align-items: center;
        }

        .footer-brand-title {
            font-size: 2rem;
        }

        .footer-desc {
            text-align: center;
            max-width: 520px;
            margin-right: auto;
            margin-left: auto;
        }

        .footer-card-title {
            border-right: none;
            border-bottom: 3px solid #3b82f6;
            padding-right: 0;
            padding-bottom: 9px;
            margin-bottom: 24px;
        }

        .footer-card-title::after {
            display: none;
        }

        .footer-list-link {
            justify-content: center;
            margin-right: auto;
            margin-left: auto;
        }

        .social-row {
            justify-content: center;
        }

        .contact-row {
            justify-content: center;
            text-align: center;
            flex-direction: column;
            gap: 8px;
        }

        .contact-row span {
            text-align: center;
        }

        .copyright-bar {
            margin-top: 24px;
            padding-top: 22px;
        }

        .md\:hidden {
            display: block;
        }
    }

    @media (min-width: 769px) {
        .md\:inline { display: inline; }
        .md\:justify-start { justify-content: flex-start; }
    }
</style>

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

                <div class="erasaneh-trust-box">
                    <div id="div_eRasanehTrustseal_83702"></div>
                    <script src="https://trustseal.e-rasaneh.ir/trustseal.js"></script>
                    <script>eRasaneh_Trustseal(83702, true);</script>
                </div>
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