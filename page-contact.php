<?php
/*
Template Name: Contact Us Page (تماس با ما)
*/

// --- لاجیک ارسال ایمیل ---
$message_status = '';

if (
    isset($_POST['submit_contact']) &&
    isset($_POST['sharji_contact_nonce']) &&
    wp_verify_nonce($_POST['sharji_contact_nonce'], 'sharji_contact_action')
) {
    $name    = isset($_POST['c_name']) ? sanitize_text_field($_POST['c_name']) : '';
    $phone   = isset($_POST['c_phone']) ? sanitize_text_field($_POST['c_phone']) : '';
    $subject = isset($_POST['c_subject']) ? sanitize_text_field($_POST['c_subject']) : '';
    $message = isset($_POST['c_message']) ? sanitize_textarea_field($_POST['c_message']) : '';

    $to = get_option('admin_email');

    $headers = [
        'Content-Type: text/html; charset=UTF-8',
        'Reply-To: ' . $name . ' <' . $to . '>',
    ];

    $email_subject = '📩 پیام جدید از سایت شرجی پرس: ' . $subject;

    $body = "
    <div dir='rtl' style='font-family: Tahoma, Arial, sans-serif; background-color: #f4f7fb; padding: 24px;'>
        <div style='max-width: 650px; margin: 0 auto; background-color: #ffffff; border-radius: 18px; overflow: hidden; border: 1px solid #dbe4f0; box-shadow: 0 15px 40px rgba(15, 23, 42, 0.08);'>
            <div style='background: linear-gradient(135deg, #0056b3, #0f172a); color: #ffffff; padding: 24px; text-align: center;'>
                <h2 style='margin: 0; font-size: 22px;'>پایگاه خبری شرجی پرس</h2>
                <p style='margin: 8px 0 0; opacity: 0.9;'>پیام جدید از فرم تماس با ما</p>
            </div>

            <div style='padding: 24px;'>
                <table style='width: 100%; border-collapse: collapse;'>
                    <tr>
                        <td style='padding: 12px; border-bottom: 1px solid #eef2f7; font-weight: bold; width: 32%; color: #334155;'>فرستنده:</td>
                        <td style='padding: 12px; border-bottom: 1px solid #eef2f7; color: #0f172a;'>" . esc_html($name) . "</td>
                    </tr>
                    <tr>
                        <td style='padding: 12px; border-bottom: 1px solid #eef2f7; font-weight: bold; color: #334155;'>شماره تماس:</td>
                        <td style='padding: 12px; border-bottom: 1px solid #eef2f7; direction: ltr; text-align: right; color: #0f172a;'>" . esc_html($phone) . "</td>
                    </tr>
                    <tr>
                        <td style='padding: 12px; border-bottom: 1px solid #eef2f7; font-weight: bold; color: #334155;'>موضوع:</td>
                        <td style='padding: 12px; border-bottom: 1px solid #eef2f7; color: #0f172a;'>" . esc_html($subject) . "</td>
                    </tr>
                </table>

                <div style='margin-top: 22px; padding: 18px; background-color: #f8fafc; border-radius: 14px; line-height: 1.9; color: #1e293b; border: 1px solid #e2e8f0;'>
                    <strong style='display: block; margin-bottom: 10px; color: #0056b3;'>متن پیام:</strong>
                    " . nl2br(esc_html($message)) . "
                </div>
            </div>

            <div style='background-color: #f1f5f9; padding: 12px; text-align: center; font-size: 12px; color: #64748b;'>
                این ایمیل به صورت خودکار از سیستم وردپرس شرجی پرس ارسال شده است.
            </div>
        </div>
    </div>";

    if (wp_mail($to, $email_subject, $body, $headers)) {
        $message_status = '<div class="contact-alert contact-alert-success"><i class="fas fa-check-circle"></i><span>پیام شما با موفقیت به تحریریه شرجی پرس ارسال شد.</span></div>';
    } else {
        $message_status = '<div class="contact-alert contact-alert-error"><i class="fas fa-exclamation-triangle"></i><span>ارسال پیام با خطا مواجه شد. لطفاً دوباره تلاش کنید.</span></div>';
    }
}

get_header();
?>

<style>
    @font-face {
        font-family: 'Diba';
        src: url('<?php echo esc_url(get_template_directory_uri()); ?>/fonts/Diba.woff2') format('woff2');
        font-weight: bold;
        font-style: normal;
        font-display: swap;
    }

    :root {
        --contact-blue: #0056b3;
        --contact-blue-dark: #004494;
        --contact-red: #e31e24;
        --contact-slate: #0f172a;
        --contact-text: #1e293b;
        --contact-muted: #64748b;
        --contact-border: #e2e8f0;
        --contact-bg: #f1f5f9;
    }

    .font-diba {
        font-family: 'Diba', 'Vazirmatn', sans-serif !important;
    }

    .site-main-wrapper {
        max-width: 1920px !important;
        margin: 0 auto !important;
        padding: 0 40px !important;
        direction: rtl !important;
        background:
            radial-gradient(circle at top right, rgba(0, 86, 179, 0.08), transparent 32%),
            radial-gradient(circle at bottom left, rgba(227, 30, 36, 0.05), transparent 30%),
            #f8fafc;
        font-family: 'Vazirmatn', sans-serif !important;
    }

    .contact-page-shell {
        padding: 44px 0;
    }

    .contact-layout {
        display: flex;
        flex-direction: column;
        gap: 28px;
    }

    .contact-main {
        width: 100%;
    }

    .contact-sidebar {
        width: 100%;
    }

    .main-card-container {
        background: rgba(255, 255, 255, 0.92);
        border-radius: 26px;
        border: 1px solid rgba(226, 232, 240, 0.9);
        overflow: hidden;
        box-shadow: 0 24px 55px rgba(15, 23, 42, 0.08);
        backdrop-filter: blur(10px);
    }

    .contact-hero {
        position: relative;
        overflow: hidden;
        background:
            linear-gradient(135deg, var(--contact-blue) 0%, #0b66c3 48%, #0f172a 100%);
        padding: 42px 36px;
        color: #fff;
        text-align: center;
    }

    .contact-hero::before {
        content: "";
        position: absolute;
        top: -90px;
        left: -90px;
        width: 230px;
        height: 230px;
        background: rgba(255, 255, 255, 0.10);
        border-radius: 999px;
        pointer-events: none;
    }

    .contact-hero::after {
        content: "";
        position: absolute;
        right: -80px;
        bottom: -110px;
        width: 250px;
        height: 250px;
        background: rgba(227, 30, 36, 0.16);
        border-radius: 999px;
        pointer-events: none;
    }

    .contact-hero-content {
        position: relative;
        z-index: 2;
    }

    .contact-kicker {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: rgba(255, 255, 255, 0.13);
        border: 1px solid rgba(255, 255, 255, 0.18);
        border-radius: 999px;
        padding: 7px 14px;
        font-size: 12px;
        font-weight: 800;
        margin-bottom: 14px;
    }

    .contact-kicker i {
        color: #facc15;
    }

    .contact-hero h1 {
        font-family: 'Diba', 'Vazirmatn', sans-serif !important;
        color: #fff !important;
        font-size: 40px !important;
        line-height: 1.35;
        margin: 0 0 10px !important;
    }

    .contact-hero h1 span {
        color: #93c5fd;
    }

    .contact-hero p {
        color: #dbeafe;
        font-size: 14px;
        line-height: 1.9;
        margin: 0;
    }

    .content-area {
        padding: 34px 38px 38px;
    }

    .contact-alert {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 14px 16px;
        margin-bottom: 22px;
        border-radius: 14px;
        font-size: 14px;
        font-weight: 800;
        animation: contactFadeIn 0.45s ease;
    }

    .contact-alert-success {
        background: #f0fdf4;
        border: 1px solid #bbf7d0;
        color: #166534;
    }

    .contact-alert-error {
        background: #fef2f2;
        border: 1px solid #fecaca;
        color: #991b1b;
    }

    @keyframes contactFadeIn {
        from {
            opacity: 0;
            transform: translateY(8px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .contact-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 16px;
        margin-bottom: 30px;
    }

    .contact-card {
        position: relative;
        background:
            linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);
        border: 1px solid var(--contact-border);
        border-radius: 18px;
        padding: 22px 16px;
        text-align: center;
        transition: all 0.3s ease;
        overflow: hidden;
    }

    .contact-card::before {
        content: "";
        position: absolute;
        inset: 0;
        background: linear-gradient(135deg, rgba(0, 86, 179, 0.08), transparent 45%);
        opacity: 0;
        transition: opacity 0.3s ease;
        pointer-events: none;
    }

    .contact-card:hover {
        transform: translateY(-6px);
        border-color: rgba(0, 86, 179, 0.36);
        box-shadow: 0 18px 36px rgba(0, 86, 179, 0.11);
    }

    .contact-card:hover::before {
        opacity: 1;
    }

    .card-icon-box {
        width: 48px;
        height: 48px;
        background: #eff6ff;
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 13px;
        color: var(--contact-blue);
        font-size: 19px;
        transition: 0.3s;
        position: relative;
        z-index: 2;
    }

    .contact-card:hover .card-icon-box {
        background: var(--contact-blue);
        color: #fff;
        transform: rotate(7deg) scale(1.05);
    }

    .card-title {
        font-size: 14px;
        font-weight: 900;
        color: var(--contact-text);
        margin: 0 0 7px;
        position: relative;
        z-index: 2;
    }

    .card-value {
        color: var(--contact-muted);
        font-size: 13px;
        line-height: 1.8;
        position: relative;
        z-index: 2;
    }

    .ltr {
        direction: ltr;
        display: inline-block;
    }

    .contact-section-title {
        display: flex;
        align-items: center;
        gap: 10px;
        margin: 30px 0 16px;
        color: var(--contact-text);
        font-family: 'Diba', 'Vazirmatn', sans-serif !important;
        font-size: 22px;
        line-height: 1.4;
    }

    .contact-section-title::before {
        content: "";
        width: 5px;
        height: 28px;
        background: var(--contact-blue);
        border-radius: 999px;
        display: inline-block;
        box-shadow: 0 0 14px rgba(0, 86, 179, 0.22);
    }

    .social-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 12px;
        margin-top: 16px;
    }

    .contact-social-btn {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 16px 8px;
        border-radius: 16px;
        border: 1px solid var(--contact-border);
        background: #fff;
        transition: all 0.28s ease;
        text-decoration: none !important;
        min-height: 96px;
    }

    .contact-social-btn:hover {
        transform: translateY(-5px);
        color: #fff !important;
        border-color: transparent;
        box-shadow: 0 15px 28px rgba(15, 23, 42, 0.14);
    }

    .contact-social-btn:hover * {
        color: #fff !important;
    }

    .social-icon {
        font-size: 26px;
        transition: 0.28s;
    }

    .contact-social-btn:hover .social-icon {
        transform: scale(1.1);
    }

    .social-text {
        font-size: 12px;
        font-weight: 900;
        color: var(--contact-muted);
    }

    .tg:hover { background: #229ED9; }
    .tg .social-icon { color: #229ED9; }

    .ig:hover {
        background: linear-gradient(45deg, #f09433, #e6683c, #dc2743, #cc2366, #bc1888);
    }
    .ig .social-icon { color: #E1306C; }

    .wa:hover { background: #25D366; }
    .wa .social-icon { color: #25D366; }

    .bl:hover { background: #2563eb; }
    .bl .social-icon { color: #2563eb; }

    .contact-form-shell {
        margin-top: 34px;
        padding: 26px;
        border-radius: 22px;
        border: 1px dashed #cbd5e1;
        background:
            radial-gradient(circle at top right, rgba(0, 86, 179, 0.08), transparent 34%),
            #f8fafc;
    }

    .contact-form-head {
        margin-bottom: 20px;
    }

    .contact-form-head h3 {
        font-family: 'Diba', 'Vazirmatn', sans-serif !important;
        font-size: 24px;
        color: var(--contact-text);
        margin: 0 0 6px;
    }

    .contact-form-head p {
        color: var(--contact-muted);
        font-size: 13px;
        margin: 0;
        line-height: 1.8;
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 15px;
        margin-bottom: 15px;
    }

    .form-field {
        position: relative;
    }

    .custom-input {
        width: 100%;
        padding: 13px 14px;
        background: #fff;
        border: 1px solid #cbd5e1;
        border-radius: 13px;
        font-size: 13px;
        outline: none;
        transition: 0.25s;
        font-family: 'Vazirmatn', sans-serif;
        box-sizing: border-box;
        color: #1e293b;
    }

    .custom-input:focus {
        border-color: rgba(0, 86, 179, 0.55);
        background: #fff;
        box-shadow: 0 0 0 4px rgba(0, 86, 179, 0.08);
    }

    textarea.custom-input {
        resize: vertical;
        min-height: 130px;
        line-height: 1.9;
    }

    .submit-row {
        display: flex;
        justify-content: flex-end;
        margin-top: 10px;
    }

    .submit-btn {
        background:
            linear-gradient(135deg, var(--contact-blue), #0b66c3);
        color: #fff;
        padding: 12px 34px;
        border-radius: 999px;
        font-weight: 900;
        font-size: 13px;
        transition: 0.3s;
        border: none;
        cursor: pointer;
        font-family: 'Vazirmatn', sans-serif;
        box-shadow: 0 12px 26px rgba(0, 86, 179, 0.22);
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .submit-btn:hover {
        background:
            linear-gradient(135deg, var(--contact-blue-dark), var(--contact-blue));
        transform: translateY(-2px);
        box-shadow: 0 16px 34px rgba(0, 86, 179, 0.30);
    }

    .sidebar-wrapper {
        position: sticky;
        top: 92px;
        display: flex;
        flex-direction: column;
        gap: 22px;
    }

    .sidebar-box {
        background: #fff;
        border: 1px solid var(--contact-border);
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 16px 34px rgba(15, 23, 42, 0.06);
    }

    .sidebar-box-head {
        background:
            linear-gradient(135deg, var(--contact-blue), #0b66c3);
        color: white;
        padding: 14px 16px;
        font-weight: 900;
        font-size: 13px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .sidebar-box-body {
        padding: 16px;
    }

    .suggestion-img-box {
        width: 100%;
        height: 150px;
        border-radius: 14px;
        overflow: hidden;
        margin-bottom: 12px;
        background: #f1f5f9;
    }

    .suggestion-img-box img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: 0.55s ease;
    }

    .sharji-suggestion-card {
        transition: 0.3s;
        display: block;
        border-bottom: 1px solid #f1f5f9;
        padding-bottom: 16px;
        margin-bottom: 16px;
        text-decoration: none !important;
    }

    .sharji-suggestion-card:last-child {
        border-bottom: none;
        padding-bottom: 0;
        margin-bottom: 0;
    }

    .sharji-suggestion-card:hover img {
        transform: scale(1.08);
    }

    .suggestion-title {
        font-family: 'Diba', 'Vazirmatn', sans-serif !important;
        font-weight: bold;
        color: #1e293b;
        font-size: 15px;
        line-height: 1.65;
        transition: color 0.3s;
        margin: 0 0 7px;
    }

    .sharji-suggestion-card:hover .suggestion-title {
        color: var(--contact-blue);
    }

    .suggestion-excerpt {
        font-size: 11px;
        color: #64748b;
        line-height: 1.8;
        text-align: justify;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .dynamic-widgets-container {
        width: 100%;
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .dynamic-widgets-container img {
        width: 100% !important;
        border-radius: 16px;
        transition: 0.3s;
        box-shadow: 0 12px 26px rgba(15, 23, 42, 0.08);
    }

    .dynamic-widgets-container img:hover {
        filter: brightness(1.05);
        transform: scale(1.015);
    }

    .w-full { width: 100%; }
    .text-yellow-400 { color: #facc15; }

    @media (min-width: 1025px) {
        .contact-layout {
            flex-direction: row;
        }

        .contact-main {
            width: 75%;
        }

        .contact-sidebar {
            width: 25%;
        }
    }

    @media (max-width: 1024px) {
        .site-main-wrapper {
            padding: 0 15px !important;
        }

        .contact-page-shell {
            padding: 24px 0;
        }

        .contact-grid {
            grid-template-columns: 1fr;
        }

        .social-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .form-row {
            grid-template-columns: 1fr;
        }

        .content-area {
            padding: 24px 16px;
        }

        .main-card-container {
            border-radius: 20px;
        }

        .contact-hero {
            padding: 32px 18px;
        }

        .contact-hero h1 {
            font-size: 30px !important;
        }

        .contact-form-shell {
            padding: 20px 16px;
        }

        .submit-row {
            justify-content: stretch;
        }

        .submit-btn {
            width: 100%;
            justify-content: center;
        }

        .sidebar-wrapper {
            position: static;
        }
    }

    @media (max-width: 480px) {
        .social-grid {
            grid-template-columns: 1fr;
        }

        .contact-social-btn {
            min-height: 82px;
        }
    }
</style>

<div class="site-main-wrapper">
    <main class="contact-page-shell">
        <div class="contact-layout">

            <div class="contact-main">
                <article class="main-card-container">

                    <header class="contact-hero">
                        <div class="contact-hero-content">
                            <div class="contact-kicker">
                                <i class="fas fa-satellite-dish"></i>
                                پل ارتباطی شرجی پرس
                            </div>

                            <h1>تماس با <span>شرجی پرس</span></h1>
                            <p>
                                برای ارسال خبر، پیشنهاد، انتقاد، تبلیغات یا ارتباط مستقیم با تحریریه، از راه‌های زیر با ما در ارتباط باشید.
                            </p>
                        </div>
                    </header>

                    <div class="content-area">

                        <?php echo $message_status; ?>

                        <div class="contact-grid">
                            <div class="contact-card">
                                <div class="card-icon-box">
                                    <i class="fas fa-phone-alt"></i>
                                </div>
                                <h3 class="card-title">تلفن تماس</h3>
                                <div class="card-value">
                                    <span class="ltr">0916 929 8505</span>
                                </div>
                            </div>

                            <div class="contact-card">
                                <div class="card-icon-box">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <h3 class="card-title">ایمیل</h3>
                                <div class="card-value">
                                    <span class="ltr">sharjipress@gmail.com</span>
                                </div>
                            </div>

                            <div class="contact-card">
                                <div class="card-icon-box">
                                    <i class="fas fa-map-marker-alt"></i>
                                </div>
                                <h3 class="card-title">دفتر شرجی پرس</h3>
                                <div class="card-value">
                                    آبادان، خیابان امیری، جنب پاساژ پارمیدا، دفتر شرجی پرس
                                </div>
                            </div>
                        </div>

                        <h2 class="contact-section-title">شبکه‌های اجتماعی</h2>

                        <div class="social-grid">
                            <a href="https://t.me/sharjipress" target="_blank" rel="noopener noreferrer" class="contact-social-btn tg">
                                <i class="fab fa-telegram-plane social-icon"></i>
                                <span class="social-text">تلگرام</span>
                            </a>

                            <a href="https://www.instagram.com/sharjipress" target="_blank" rel="noopener noreferrer" class="contact-social-btn ig">
                                <i class="fab fa-instagram social-icon"></i>
                                <span class="social-text">اینستاگرام</span>
                            </a>

                            <a href="https://chat.whatsapp.com/E85l09DTbdSJadirLy3YKw?mode=gi_t" target="_blank" rel="noopener noreferrer" class="contact-social-btn wa">
                                <i class="fab fa-whatsapp social-icon"></i>
                                <span class="social-text">واتساپ</span>
                            </a>

                            <a href="https://ble.ir/sharjipress" target="_blank" rel="noopener noreferrer" class="contact-social-btn bl">
                                <i class="fas fa-comments social-icon"></i>
                                <span class="social-text">بله</span>
                            </a>
                        </div>

                        <div class="contact-form-shell">
                            <div class="contact-form-head">
                                <h3>ارسال پیام مستقیم</h3>
                                <p>پیام شما پس از ارسال برای مدیریت سایت و تحریریه شرجی پرس ارسال خواهد شد.</p>
                            </div>

                            <form method="post">
                                <?php wp_nonce_field('sharji_contact_action', 'sharji_contact_nonce'); ?>

                                <div class="form-row">
                                    <div class="form-field">
                                        <input type="text" name="c_name" class="custom-input" required placeholder="نام و نام خانوادگی">
                                    </div>

                                    <div class="form-field">
                                        <input type="text" name="c_phone" class="custom-input" required placeholder="شماره تماس">
                                    </div>
                                </div>

                                <div class="form-field" style="margin-bottom: 15px;">
                                    <input type="text" name="c_subject" class="custom-input" required placeholder="موضوع پیام">
                                </div>

                                <div class="form-field">
                                    <textarea name="c_message" class="custom-input" rows="5" required placeholder="متن پیام شما..."></textarea>
                                </div>

                                <div class="submit-row">
                                    <button type="submit" name="submit_contact" class="submit-btn">
                                        ارسال پیام
                                        <i class="fas fa-paper-plane"></i>
                                    </button>
                                </div>
                            </form>
                        </div>

                    </div>
                </article>
            </div>

            <aside class="contact-sidebar">
                <div class="sidebar-wrapper">

                    <div class="sidebar-box">
                        <div class="sidebar-box-head">
                            <span>پیشنهاد شرجی</span>
                            <i class="fas fa-star text-yellow-400"></i>
                        </div>

                        <div class="sidebar-box-body">
                            <?php
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

                            if ($editor_query->have_posts()) :
                                while ($editor_query->have_posts()) : $editor_query->the_post();
                            ?>
                                    <a href="<?php the_permalink(); ?>" class="sharji-suggestion-card">
                                        <div class="suggestion-img-box">
                                            <?php
                                            if (has_post_thumbnail()) {
                                                the_post_thumbnail('medium');
                                            }
                                            ?>
                                        </div>

                                        <h4 class="suggestion-title"><?php the_title(); ?></h4>

                                        <div class="suggestion-excerpt">
                                            <?php echo wp_trim_words(get_the_excerpt(), 18, '...'); ?>
                                        </div>
                                    </a>
                            <?php
                                endwhile;
                                wp_reset_postdata();
                            endif;
                            ?>
                        </div>
                    </div>

                    <?php if (is_active_sidebar('single-sidebar')) : ?>
                        <div class="dynamic-widgets-container">
                            <?php dynamic_sidebar('single-sidebar'); ?>
                        </div>
                    <?php endif; ?>

                    <?php if (is_active_sidebar('single-sidebar-2')) : ?>
                        <div class="dynamic-widgets-container">
                            <?php dynamic_sidebar('single-sidebar-2'); ?>
                        </div>
                    <?php endif; ?>

                </div>
            </aside>

        </div>
    </main>
</div>

<?php get_footer(); ?>