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
