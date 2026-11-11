<footer class="sport-footer">
    
    <style>
        .sport-footer {
            position: relative;
            background:
                radial-gradient(circle at top right, rgba(37, 99, 235, 0.13), transparent 34%),
                radial-gradient(circle at bottom left, rgba(14, 165, 233, 0.09), transparent 30%),
                #0f172a;
            border-top: 4px solid #2563eb;
            color: #9ca3af;
            font-size: 14px;
            margin-top: 56px;
            padding-top: 72px;
            padding-bottom: 32px;
            overflow: hidden;
            font-family: 'Vazirmatn', sans-serif;
            box-shadow: 0 -20px 60px rgba(0, 0, 0, 0.20);
        }
        
        .sport-footer::before {
            content: "";
            position: absolute;
            top: -120px;
            right: -120px;
            width: 280px;
            height: 280px;
            background: rgba(37, 99, 235, 0.14);
            border-radius: 999px;
            filter: blur(2px);
            pointer-events: none;
        }

        .sport-footer::after {
            content: "";
            position: absolute;
            bottom: -160px;
            left: -120px;
            width: 340px;
            height: 340px;
            background: rgba(14, 165, 233, 0.08);
            border-radius: 999px;
            pointer-events: none;
        }
        
        .sport-footer-bg-icon {
            position: absolute;
            inset: 0;
            opacity: 0.045;
            pointer-events: none;
            z-index: 0;
        }

        .sport-footer-bg-icon i {
            position: absolute;
            bottom: -90px;
            left: -80px;
            font-size: 410px;
            color: #fff;
            transform: rotate(12deg);
        }
        
        .sport-footer-inner {
            max-width: 1600px;
            margin: 0 auto;
            padding: 0 24px;
            position: relative;
            z-index: 10;
        }
        
        .sport-footer-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 40px;
            margin-bottom: 48px;
            text-align: right;
        }
        
        .sport-footer-logo {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 22px;
        }

        .sport-footer-logo-icon {
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            background:
                radial-gradient(circle at top right, rgba(255,255,255,0.22), transparent 36%),
                linear-gradient(135deg, #2563eb, #1e3a8a);
            border-radius: 14px;
            color: #fff;
            font-weight: 900;
            font-size: 24px;
            flex-shrink: 0;
            border: 1px solid rgba(147, 197, 253, 0.20);
            box-shadow: 0 14px 30px rgba(37, 99, 235, 0.24);
        }

        .sport-footer-logo-text {
            display: flex;
            flex-direction: column;
        }

        .sport-footer-logo-text .main {
            font-family: 'Diba', sans-serif;
            font-size: 25px;
            color: #fff;
            letter-spacing: -0.5px;
            line-height: 1.2;
        }

        .sport-footer-logo-text .main span {
            color: #3b82f6;
        }

        .sport-footer-logo-text .sub {
            font-size: 11px;
            color: #64748b;
            margin-top: 3px;
        }
        
        .sport-footer-desc {
            line-height: 1.9rem;
            text-align: justify;
            opacity: 0.88;
            margin-bottom: 22px;
            color: #cbd5e1;
        }
        
        .sport-footer-socials {
            display: flex;
            align-items: center;
            gap: 12px;
            padding-top: 8px;
            flex-wrap: wrap;
        }

        .sport-footer-socials a {
            width: 42px;
            height: 42px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(30, 41, 59, 0.78);
            border-radius: 12px;
            border: 1px solid rgba(148, 163, 184, 0.12);
            transition: all 0.3s;
        }

        .sport-footer-socials a img {
            width: 22px;
            height: 22px;
            opacity: 0.78;
            transition: all 0.3s;
            object-fit: contain;
        }

        .sport-footer-socials a:hover img {
            opacity: 1;
            transform: scale(1.08);
        }

        .sport-footer-socials a:hover {
            background: #2563eb;
            border-color: #60a5fa;
            transform: translateY(-3px);
            box-shadow: 0 12px 24px rgba(37, 99, 235, 0.22);
        }
        
        .sport-footer-title {
            font-family: 'Diba', sans-serif;
            font-size: 19px;
            color: #fff;
            margin-bottom: 24px;
            border-right: 4px solid #2563eb;
            padding-right: 12px;
            margin-top: 0;
            line-height: 1.5;
            position: relative;
        }

        .sport-footer-title::after {
            content: "";
            position: absolute;
            right: 12px;
            bottom: -8px;
            width: 42px;
            height: 2px;
            border-radius: 999px;
            background: rgba(59, 130, 246, 0.55);
        }
        
        .sport-footer-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .sport-footer-list li {
            margin-bottom: 12px;
        }

        .sport-footer-list a {
            color: #9ca3af;
            transition: all 0.3s;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
            width: fit-content;
        }

        .sport-footer-list a:hover {
            color: #60a5fa;
            transform: translateX(-4px);
        }

        .sport-footer-list a i {
            font-size: 12px;
            color: #3b82f6;
            opacity: 0.8;
        }
        
        .sport-live-badge {
            font-size: 9px;
            background: #dc2626;
            color: #fff;
            padding: 2px 6px;
            border-radius: 4px;
            animation: sport-pulse 2s infinite;
        }

        @keyframes sport-pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }
        
        .sport-contact-card {
            display: flex;
            align-items: center;
            gap: 12px;
            background: rgba(30, 41, 59, 0.78);
            padding: 13px;
            border-radius: 14px;
            border: 1px solid rgba(148, 163, 184, 0.12);
            margin-bottom: 12px;
            transition: all 0.3s;
        }

        .sport-contact-card:hover {
            border-color: rgba(96, 165, 250, 0.42);
            transform: translateY(-2px);
            background: rgba(30, 41, 59, 0.96);
        }

        .sport-contact-card i {
            color: #3b82f6;
            font-size: 18px;
            width: 22px;
            text-align: center;
        }

        .sport-contact-card .label {
            font-size: 12px;
            color: #6b7280;
        }

        .sport-contact-card .value {
            color: #fff;
            font-size: 14px;
        }

        .sport-contact-card .value.mono {
            font-family: monospace;
            font-size: 12px;
        }
        
        .sport-contact-address {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            margin-top: 10px;
            font-size: 14px;
            line-height: 1.7rem;
            color: #cbd5e1;
        }

        .sport-contact-address i {
            color: #3b82f6;
            margin-top: 4px;
        }

        .sport-erasaneh-trust-box {
            margin-top: 14px;
            background: rgba(30, 41, 59, 0.78);
            border: 1px solid rgba(148, 163, 184, 0.12);
            border-radius: 14px;
            padding: 14px;
            min-height: 82px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            transition: all 0.3s;
        }

        .sport-erasaneh-trust-box:hover {
            border-color: rgba(96, 165, 250, 0.42);
            background: rgba(30, 41, 59, 0.96);
            transform: translateY(-2px);
        }

        .sport-erasaneh-trust-box iframe,
        .sport-erasaneh-trust-box img {
            max-width: 100% !important;
            height: auto !important;
        }
        
        .sport-footer-bottom {
            border-top: 1px solid rgba(55, 65, 81, 0.7);
            padding-top: 28px;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 16px;
            font-size: 12px;
        }

        .sport-footer-bottom .copyright {
            opacity: 0.76;
            text-align: center;
            line-height: 1.8;
        }

        .sport-footer-bottom .copyright strong {
            color: #fff;
        }

        .sport-footer-bottom .credit {
            display: flex;
            align-items: center;
            gap: 8px;
            background: rgba(30, 41, 59, 0.78);
            padding: 7px 16px;
            border-radius: 9999px;
            border: 1px solid rgba(148, 163, 184, 0.12);
            transition: all 0.3s;
        }

        .sport-footer-bottom .credit:hover {
            border-color: rgba(96, 165, 250, 0.42);
            transform: translateY(-1px);
        }

        .sport-footer-bottom .credit span {
            color: #6b7280;
        }

        .sport-footer-bottom .credit a {
            color: #60a5fa;
            font-weight: bold;
            transition: color 0.3s;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .sport-footer-bottom .credit a:hover {
            color: #93c5fd;
        }
        
        @media (max-width: 768px) {
            .sport-footer {
                padding-top: 54px;
                margin-top: 42px;
            }

            .sport-footer-grid {
                gap: 34px;
            }

            .sport-footer-logo {
                justify-content: center;
            }

            .sport-footer-desc {
                text-align: center;
            }

            .sport-footer-socials {
                justify-content: center;
            }

            .sport-footer-title {
                width: fit-content;
                margin-right: auto;
                margin-left: auto;
                border-right: none;
                border-bottom: 3px solid #2563eb;
                padding-right: 0;
                padding-bottom: 8px;
                text-align: center;
            }

            .sport-footer-title::after {
                display: none;
            }

            .sport-footer-list a {
                margin: 0 auto;
            }

            .sport-contact-card {
                justify-content: center;
            }

            .sport-contact-address {
                justify-content: center;
                text-align: center;
            }

            .sport-footer-bottom .credit {
                flex-wrap: wrap;
                justify-content: center;
            }
        }

        @media (min-width: 769px) {
            .sport-footer-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (min-width: 1025px) {
            .sport-footer-grid {
                grid-template-columns: repeat(4, 1fr);
            }

            .sport-footer-bottom {
                flex-direction: row;
                justify-content: space-between;
            }
        }
    </style>

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

                <div class="sport-erasaneh-trust-box">
                    <div id="div_eRasanehTrustseal_83702"></div>
                    <script src="https://trustseal.e-rasaneh.ir/trustseal.js"></script>
                    <script>eRasaneh_Trustseal(83702, true);</script>
                </div>
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

<script>
    function toggleMenu() {
        const menu = document.getElementById('mobile-menu');
        const overlay = document.getElementById('mobile-menu-overlay');

        if (!menu || !overlay) return;
        
        if (menu.classList.contains('translate-x-full')) {
            menu.classList.remove('translate-x-full');
            overlay.classList.remove('hidden');
            setTimeout(() => overlay.classList.remove('opacity-0'), 10);
        } else {
            menu.classList.add('translate-x-full');
            overlay.classList.add('opacity-0');
            setTimeout(() => overlay.classList.add('hidden'), 300);
        }
    }
</script>

<?php wp_footer(); ?>
</body>
</html>