<?php

if ( post_password_required() ) {
    return;
}

$is_logged_in = is_user_logged_in();
$comments_count = get_comments_number();
?>

<style>
    .comments-area.sharji-comments-clean {
        margin: 36px 50px 50px !important;
        background:
            radial-gradient(circle at top right, rgba(0, 86, 179, 0.07), transparent 34%),
            #ffffff !important;
        border: 1px solid #e2e8f0 !important;
        border-radius: 26px !important;
        padding: 0 !important;
        overflow: hidden !important;
        box-shadow: 0 22px 50px rgba(15, 23, 42, 0.075) !important;
        direction: rtl;
    }

    .sharji-comments-clean .sharji-comments-head {
        background: linear-gradient(135deg, #0f172a 0%, #0056b3 58%, #0b66c3 100%);
        color: #fff;
        padding: 20px 24px;
        display: flex;
        align-items: center;
        gap: 14px;
        position: relative;
        overflow: hidden;
    }

    .sharji-comments-clean .sharji-comments-head::before {
        content: "";
        position: absolute;
        left: -50px;
        top: -60px;
        width: 165px;
        height: 165px;
        border-radius: 999px;
        background: rgba(255,255,255,0.10);
        pointer-events: none;
    }

    .sharji-comments-clean .sharji-comments-icon {
        position: relative;
        z-index: 2;
        width: 46px;
        height: 46px;
        border-radius: 16px;
        background: rgba(255,255,255,0.16);
        border: 1px solid rgba(255,255,255,0.22);
        color: #facc15;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .sharji-comments-clean .sharji-comments-title-wrap {
        position: relative;
        z-index: 2;
    }

    .sharji-comments-clean .sharji-comments-title {
        font-family: 'Diba', 'Vazirmatn', sans-serif !important;
        margin: 0;
        color: #fff;
        font-size: 25px;
        line-height: 1.3;
    }

    .sharji-comments-clean .sharji-comments-subtitle {
        color: #dbeafe;
        font-size: 12px;
        font-weight: 700;
        margin-top: 5px;
    }

    .sharji-comments-clean .sharji-comments-body {
        padding: 26px;
    }

    .sharji-comments-clean .comment-list {
        list-style: none !important;
        padding: 0 !important;
        margin: 0 !important;
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .sharji-comments-clean .comment-list li {
        list-style: none !important;
        margin: 0 !important;
    }

    .sharji-comments-clean .comment-body {
        background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%) !important;
        border: 1px solid #e2e8f0 !important;
        border-radius: 20px !important;
        padding: 18px 18px 16px !important;
        box-shadow: 0 12px 30px rgba(15, 23, 42, 0.045) !important;
        transition: all 0.25s ease;
    }

    .sharji-comments-clean .comment-body:hover {
        transform: translateY(-2px);
        border-color: rgba(0, 86, 179, 0.22) !important;
        box-shadow: 0 18px 38px rgba(15, 23, 42, 0.075) !important;
    }

    .sharji-comments-clean .comment-body img.avatar,
    .sharji-comments-clean .comment-body .avatar img {
        border-radius: 50% !important;
    }

    .sharji-comments-clean .comment-body h5,
    .sharji-comments-clean .comment-author,
    .sharji-comments-clean .fn {
        color: #1e293b !important;
        font-weight: 900 !important;
    }

    .sharji-comments-clean .comment-body p {
        color: #334155 !important;
        font-size: 14px !important;
        line-height: 2.05 !important;
        text-align: justify;
    }

    .sharji-comments-clean .comment-reply-link {
        display: inline-flex !important;
        align-items: center;
        gap: 7px;
        background: #eff6ff !important;
        color: #0056b3 !important;
        border: 1px solid #bfdbfe !important;
        border-radius: 999px !important;
        padding: 7px 14px !important;
        font-size: 12px !important;
        font-weight: 900 !important;
        text-decoration: none !important;
        transition: all 0.25s ease;
    }

    .sharji-comments-clean .comment-reply-link:hover {
        background: #0056b3 !important;
        color: #fff !important;
        border-color: #0056b3 !important;
        transform: translateY(-2px);
    }

    .sharji-comments-clean .sharji-no-comments {
        background: #f8fafc;
        border: 1px dashed #cbd5e1;
        color: #64748b;
        text-align: center;
        padding: 22px;
        border-radius: 16px;
        font-size: 14px;
        margin: 0;
    }

    .sharji-comments-clean .sharji-comment-navigation {
        margin-top: 24px;
        display: flex;
        justify-content: space-between;
        gap: 12px;
    }

    .sharji-comments-clean .sharji-comment-navigation a {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 38px;
        padding: 0 14px;
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 999px;
        color: #64748b;
        font-size: 12px;
        font-weight: 700;
        text-decoration: none;
    }

    .sharji-comments-clean .sharji-comment-navigation a:hover {
        background: #0056b3;
        border-color: #0056b3;
        color: #fff;
    }

    .sharji-comments-clean .sharji-comment-form-wrap {
        margin-top: 28px;
        padding-top: 24px;
        border-top: 1px solid #e2e8f0;
    }

    .sharji-comments-clean .sharji-comment-form-wrap.no-separate-top {
        margin-top: 0;
        padding-top: 0;
        border-top: none;
    }

    .sharji-comments-clean .sharji-comment-form-title {
        font-family: 'Diba', 'Vazirmatn', sans-serif !important;
        font-size: 20px;
        color: #1e293b;
        margin: 0 0 16px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .sharji-comments-clean .sharji-comment-form-title::before {
        content: "";
        width: 5px;
        height: 22px;
        background: #0056b3;
        border-radius: 999px;
        display: inline-block;
    }

    .sharji-comments-clean .sharji-comment-form {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .sharji-comments-clean .sharji-comment-user-row {
        display: flex;
        align-items: center;
        gap: 10px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 10px 12px;
        color: #64748b;
        font-size: 12px;
    }

    .sharji-comments-clean .sharji-comment-user-avatar {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        overflow: hidden;
        border: 2px solid #fff;
        box-shadow: 0 2px 8px rgba(15, 23, 42, 0.12);
        flex-shrink: 0;
    }

    .sharji-comments-clean .sharji-comment-user-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .sharji-comments-clean .sharji-comment-user-row strong {
        color: #1e293b;
    }

    .sharji-comments-clean .sharji-comment-logout {
        color: #e31e24 !important;
        font-size: 12px;
        font-weight: 700;
        margin-right: auto;
        text-decoration: none;
    }

    .sharji-comments-clean .sharji-comment-textarea {
        width: 100%;
        min-height: 145px;
        background: #fff;
        border: 1px solid #cbd5e1;
        border-radius: 18px;
        padding: 16px;
        color: #1e293b;
        font-size: 14px;
        line-height: 2;
        resize: vertical;
        outline: none;
        transition: all 0.25s ease;
        box-shadow: inset 0 1px 2px rgba(15, 23, 42, 0.035);
        font-family: 'Vazirmatn', sans-serif;
    }

    .sharji-comments-clean .sharji-comment-textarea:focus {
        border-color: #0056b3;
        box-shadow:
            0 0 0 4px rgba(0, 86, 179, 0.08),
            inset 0 1px 2px rgba(15, 23, 42, 0.035);
    }

    .sharji-comments-clean .sharji-comment-submit-row {
        text-align: left;
    }

    .sharji-comments-clean .sharji-comment-submit {
        min-width: 150px;
        height: 44px;
        border: none;
        border-radius: 14px;
        background: linear-gradient(135deg, #0056b3, #0b66c3);
        color: #fff;
        padding: 0 24px;
        font-size: 14px;
        font-weight: 800;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        box-shadow: 0 10px 22px rgba(0, 86, 179, 0.22);
        transition: all 0.25s ease;
        font-family: 'Vazirmatn', sans-serif;
        cursor: pointer;
    }

    .sharji-comments-clean .sharji-comment-submit:hover {
        background: linear-gradient(135deg, #004494, #0056b3);
        transform: translateY(-2px);
    }

    .sharji-comments-clean .sharji-comment-login-box {
        background:
            radial-gradient(circle at top right, rgba(0, 86, 179, 0.08), transparent 35%),
            linear-gradient(135deg, #eff6ff, #fff);
        border: 1px solid #bfdbfe;
        border-radius: 18px;
        padding: 28px 24px;
        text-align: center;
    }

    .sharji-comments-clean .sharji-comment-login-icon {
        width: 46px;
        height: 46px;
        margin: 0 auto 12px;
        border-radius: 16px;
        background: #0056b3;
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 10px 22px rgba(0, 86, 179, 0.22);
    }

    .sharji-comments-clean .sharji-comment-login-box p {
        color: #475569;
        font-size: 14px;
        font-weight: 600;
        margin: 0 0 8px;
        line-height: 2;
    }

    .sharji-comments-clean .sharji-comment-login-note {
        color: #64748b;
        font-size: 12px;
        margin-bottom: 18px;
        line-height: 1.9;
    }

    .sharji-comments-clean .sharji-comment-login-actions {
        display: flex;
        justify-content: center;
        gap: 12px;
        flex-wrap: wrap;
    }

    .sharji-comments-clean .sharji-comment-login-btn,
    .sharji-comments-clean .sharji-comment-register-btn {
        min-width: 120px;
        height: 40px;
        border-radius: 12px;
        padding: 0 18px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 13px;
        font-weight: 800;
        text-decoration: none;
    }

    .sharji-comments-clean .sharji-comment-login-btn {
        background: #0056b3;
        color: #fff !important;
        border: 1px solid #0056b3;
    }

    .sharji-comments-clean .sharji-comment-register-btn {
        background: #fff;
        color: #0056b3 !important;
        border: 1px solid #bfdbfe;
    }

    @media (max-width: 1024px) {
        .comments-area.sharji-comments-clean {
            margin: 28px 18px 36px !important;
        }
    }

    @media (max-width: 768px) {
        .comments-area.sharji-comments-clean {
            margin: 24px 15px 34px !important;
            border-radius: 20px !important;
        }

        .sharji-comments-clean .sharji-comments-head,
        .sharji-comments-clean .sharji-comments-body {
            padding: 16px;
        }

        .sharji-comments-clean .sharji-comments-title {
            font-size: 22px;
        }

        .sharji-comments-clean .sharji-comment-user-row {
            align-items: flex-start;
            flex-wrap: wrap;
        }

        .sharji-comments-clean .sharji-comment-logout {
            margin-right: 48px;
        }

        .sharji-comments-clean .sharji-comment-submit {
            width: 100%;
        }

        .sharji-comments-clean .sharji-comment-login-actions {
            flex-direction: column;
        }

        .sharji-comments-clean .sharji-comment-login-btn,
        .sharji-comments-clean .sharji-comment-register-btn {
            width: 100%;
        }
    }
</style>

<div id="comments" class="comments-area sharji-comments-clean">

    <div class="sharji-comments-head">
        <div class="sharji-comments-icon">
            <i class="fas fa-comments"></i>
        </div>

        <div class="sharji-comments-title-wrap">
            <h2 class="sharji-comments-title">دیدگاه کاربران</h2>
            <div class="sharji-comments-subtitle">نظر شما درباره این خبر برای ما ارزشمند است</div>
        </div>
    </div>

    <div class="sharji-comments-body">

        <?php if ( have_comments() ) : ?>

            <ul class="comment-list">
                <?php
                wp_list_comments( array(
                    'style'       => 'ul',
                    'short_ping'  => true,
                    'avatar_size' => 50,
                    'callback'    => 'sharji_main_comment_callback',
                ) );
                ?>
            </ul>

            <?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
                <nav class="sharji-comment-navigation" aria-label="ناوبری دیدگاه‌ها">
                    <div class="nav-previous">
                        <?php previous_comments_link( '&larr; نظرات قدیمی‌تر' ); ?>
                    </div>

                    <div class="nav-next">
                        <?php next_comments_link( 'نظرات جدیدتر &rarr;' ); ?>
                    </div>
                </nav>
            <?php endif; ?>

        <?php else : ?>

            <?php if ( ! comments_open() ) : ?>
                <p class="sharji-no-comments">بخش نظرات بسته شده است.</p>
            <?php elseif ( $is_logged_in ) : ?>
                <p class="sharji-no-comments">هنوز دیدگاهی ثبت نشده است. شما اولین نفر باشید!</p>
            <?php endif; ?>

        <?php endif; ?>

        <div class="sharji-comment-form-wrap <?php echo ! $is_logged_in ? 'no-separate-top' : ''; ?>">
            <?php if ( comments_open() ) : ?>

                <?php if ( $is_logged_in ) : ?>
                    <?php $current_user = wp_get_current_user(); ?>

                    <h4 class="sharji-comment-form-title">
                        دیدگاه خود را بنویسید
                    </h4>

                    <form action="<?php echo esc_url( site_url( '/wp-comments-post.php' ) ); ?>" method="post" id="commentform" class="sharji-comment-form">

                        <div class="sharji-comment-user-row">
                            <div class="sharji-comment-user-avatar">
                                <?php echo get_avatar( $current_user->ID, 38 ); ?>
                            </div>

                            <span>
                                نام کاربری:
                                <strong><?php echo esc_html( $current_user->display_name ); ?></strong>
                            </span>

                            <a href="<?php echo esc_url( wp_logout_url( get_permalink() ) ); ?>" class="sharji-comment-logout">
                                خروج
                            </a>
                        </div>

                        <textarea
                            name="comment"
                            id="comment"
                            rows="5"
                            class="sharji-comment-textarea"
                            placeholder="متن نظر شما..."
                            required
                        ></textarea>

                        <div class="sharji-comment-submit-row">
                            <button type="submit" class="sharji-comment-submit">
                                ارسال دیدگاه
                                <i class="fas fa-paper-plane"></i>
                            </button>
                        </div>

                        <?php comment_id_fields(); ?>
                        <?php do_action( 'comment_form', get_the_ID() ); ?>
                    </form>

                <?php else : ?>

                    <div class="sharji-comment-login-box">
                        <div class="sharji-comment-login-icon">
                            <i class="fas fa-user-lock"></i>
                        </div>

                        <p>
                            برای ثبت نظر، لطفاً وارد حساب کاربری خود شوید.
                        </p>

                        <?php if ( ! have_comments() ) : ?>
                            <div class="sharji-comment-login-note">
                                هنوز دیدگاهی ثبت نشده است. شما می‌توانید اولین نفر باشید.
                            </div>
                        <?php else : ?>
                            <div class="sharji-comment-login-note">
                                برای مشارکت در گفت‌وگو و ارسال دیدگاه، ورود به حساب کاربری لازم است.
                            </div>
                        <?php endif; ?>

                        <div class="sharji-comment-login-actions">
                            <a href="<?php echo esc_url( wp_login_url( get_permalink() ) ); ?>" class="sharji-comment-login-btn">
                                ورود به سایت
                            </a>

                            <a href="<?php echo esc_url( wp_registration_url() ); ?>" class="sharji-comment-register-btn">
                                ثبت نام
                            </a>
                        </div>
                    </div>

                <?php endif; ?>

            <?php endif; ?>
        </div>

    </div>
</div>