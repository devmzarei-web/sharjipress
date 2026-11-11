<?php
/**
 * Template for Sport Comments (Dark Mode & Gamified)
 */

if ( post_password_required() ) {
    return;
}
?>

<style>
    .sport-comments-area.sharji-sport-comments-clean {
        margin-top: 48px !important;
        background:
            radial-gradient(circle at top right, rgba(37, 99, 235, 0.16), transparent 36%),
            #0f172a !important;
        border: 1px solid #1f2937 !important;
        border-radius: 18px !important;
        padding: 0 !important;
        overflow: hidden !important;
        box-shadow: 0 25px 55px rgba(0, 0, 0, 0.30) !important;
        direction: rtl;
    }

    .sharji-sport-comments-clean .sport-comments-head {
        background: linear-gradient(135deg, #1e3a8a, #2563eb) !important;
        color: #fff !important;
        padding: 18px 22px !important;
        margin: 0 !important;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .sharji-sport-comments-clean .sport-comments-title {
        font-family: 'Diba', 'Vazirmatn', sans-serif !important;
        color: #fff !important;
        font-size: 21px !important;
        line-height: 1.5 !important;
        margin: 0 !important;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .sharji-sport-comments-clean .sport-comments-title .indicator {
        width: 6px;
        height: 26px;
        background: #60a5fa;
        border-radius: 999px;
        box-shadow: 0 0 16px rgba(96, 165, 250, 0.65);
        flex-shrink: 0;
    }

    .sharji-sport-comments-clean .sport-comments-count {
        color: rgba(255,255,255,0.78) !important;
        font-family: 'Vazirmatn', sans-serif !important;
        font-size: 12px !important;
        font-weight: 500 !important;
        margin-right: 6px;
    }

    .sharji-sport-comments-clean .sport-comments-body {
        padding: 24px !important;
    }

    .sharji-sport-comments-clean .sport-comment-list {
        list-style: none !important;
        padding: 0 !important;
        margin: 0 !important;
        display: flex;
        flex-direction: column;
        gap: 18px;
    }

    .sharji-sport-comments-clean .sport-comment-list li {
        list-style: none !important;
        margin: 0 !important;
    }

    /* استایل خروجی callback فعلی functions.php */
    .sharji-sport-comments-clean .comment-body {
        background: #1e293b !important;
        border: 1px solid #334155 !important;
        border-radius: 16px !important;
        padding: 16px !important;
        box-shadow: 0 10px 24px rgba(0, 0, 0, 0.18) !important;
        transition: all 0.25s ease !important;
    }

    .sharji-sport-comments-clean .comment-body:hover {
        border-color: rgba(96, 165, 250, 0.45) !important;
        box-shadow: 0 14px 30px rgba(0, 0, 0, 0.26) !important;
        transform: translateY(-2px);
    }

    .sharji-sport-comments-clean .comment-body img.avatar,
    .sharji-sport-comments-clean .comment-body .avatar img {
        border-radius: 50% !important;
    }

    .sharji-sport-comments-clean .comment-body h5,
    .sharji-sport-comments-clean .comment-author,
    .sharji-sport-comments-clean .fn {
        color: #fff !important;
        font-weight: 800 !important;
    }

    .sharji-sport-comments-clean .comment-body p {
        color: #d1d5db !important;
        font-size: 14px !important;
        line-height: 2 !important;
    }

    .sharji-sport-comments-clean .comment-body span,
    .sharji-sport-comments-clean .comment-body time {
        color: #9ca3af;
    }

    .sharji-sport-comments-clean .comment-reply-link {
        display: inline-flex !important;
        align-items: center;
        gap: 6px;
        background: #0f172a !important;
        border: 1px solid #334155 !important;
        color: #60a5fa !important;
        border-radius: 999px !important;
        padding: 5px 12px !important;
        font-size: 11px !important;
        font-weight: 700 !important;
        text-decoration: none !important;
    }

    .sharji-sport-comments-clean .comment-reply-link:hover {
        background: #2563eb !important;
        border-color: #2563eb !important;
        color: #fff !important;
    }

    .sharji-sport-comments-clean .sport-no-comments {
        background: #111827;
        border: 1px dashed #334155;
        color: #9ca3af;
        text-align: center;
        padding: 22px;
        border-radius: 16px;
        font-size: 14px;
        margin: 0;
    }

    .sharji-sport-comments-clean .sport-comment-nav {
        margin-top: 24px;
        display: flex;
        justify-content: space-between;
        gap: 12px;
    }

    .sharji-sport-comments-clean .sport-comment-nav a {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 38px;
        padding: 0 14px;
        background: #111827;
        border: 1px solid #334155;
        border-radius: 999px;
        color: #60a5fa;
        font-size: 12px;
        font-weight: 700;
        text-decoration: none;
    }

    .sharji-sport-comments-clean .sport-comment-nav a:hover {
        background: #2563eb;
        border-color: #2563eb;
        color: #fff;
    }

    .sharji-sport-comments-clean .sport-comment-form-section {
        margin-top: 28px;
        padding-top: 24px;
        border-top: 1px solid #1f2937;
    }

    .sharji-sport-comments-clean .sport-form-title {
        font-family: 'Diba', 'Vazirmatn', sans-serif !important;
        font-size: 20px;
        color: #e5e7eb;
        margin: 0 0 16px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .sharji-sport-comments-clean .sport-form-title::before {
        content: "";
        width: 5px;
        height: 22px;
        background: #3b82f6;
        border-radius: 999px;
        display: inline-block;
    }

    .sharji-sport-comments-clean .sport-form-title i {
        color: #60a5fa;
    }

    .sharji-sport-comments-clean .sport-comment-form {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .sharji-sport-comments-clean .sport-user-badge {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        background: #111827;
        border: 1px solid #334155;
        border-radius: 16px;
        padding: 10px 12px;
        color: #9ca3af;
        font-size: 12px;
        width: fit-content;
        max-width: 100%;
    }

    .sharji-sport-comments-clean .sport-user-avatar {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        overflow: hidden;
        border: 2px solid #1e293b;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.22);
        flex-shrink: 0;
    }

    .sharji-sport-comments-clean .sport-user-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .sharji-sport-comments-clean .sport-user-info {
        display: flex;
        flex-direction: column;
        gap: 2px;
        min-width: 0;
    }

    .sharji-sport-comments-clean .sport-user-name {
        color: #fff;
        font-weight: 800;
        font-size: 12px;
    }

    .sharji-sport-comments-clean .sport-user-rank {
        font-size: 10px;
        font-weight: 800;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    .sharji-sport-comments-clean .sport-user-logout {
        color: #f87171 !important;
        font-size: 12px;
        font-weight: 700;
        margin-right: 8px;
        padding-right: 10px;
        border-right: 1px solid #334155;
        text-decoration: none;
        white-space: nowrap;
    }

    .sharji-sport-comments-clean .sport-user-logout:hover {
        color: #fca5a5 !important;
    }

    .sharji-sport-comments-clean .sport-comment-textarea {
        width: 100%;
        min-height: 145px;
        background: #1e293b;
        border: 1px solid #334155;
        border-radius: 18px;
        padding: 16px;
        color: #e5e7eb;
        font-size: 14px;
        line-height: 2;
        resize: vertical;
        outline: none;
        transition: all 0.25s ease;
        box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.18);
        font-family: 'Vazirmatn', sans-serif;
    }

    .sharji-sport-comments-clean .sport-comment-textarea::placeholder {
        color: #64748b;
    }

    .sharji-sport-comments-clean .sport-comment-textarea:focus {
        border-color: #3b82f6;
        background: #0f172a;
        box-shadow:
            0 0 0 4px rgba(59, 130, 246, 0.12),
            inset 0 1px 2px rgba(0, 0, 0, 0.18);
    }

    .sharji-sport-comments-clean .sport-comment-submit-row {
        text-align: left;
    }

    .sharji-sport-comments-clean .sport-submit-btn {
        min-width: 150px;
        height: 44px;
        border: none;
        border-radius: 14px;
        background: linear-gradient(135deg, #2563eb, #1d4ed8);
        color: #fff;
        padding: 0 24px;
        font-size: 14px;
        font-weight: 800;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        box-shadow: 0 10px 22px rgba(37, 99, 235, 0.24);
        transition: all 0.25s ease;
        font-family: 'Vazirmatn', sans-serif;
        cursor: pointer;
    }

    .sharji-sport-comments-clean .sport-submit-btn:hover {
        background: linear-gradient(135deg, #3b82f6, #2563eb);
        transform: translateY(-2px);
        box-shadow: 0 14px 28px rgba(37, 99, 235, 0.32);
    }

    .sharji-sport-comments-clean .sport-login-box {
        background:
            radial-gradient(circle at top right, rgba(37, 99, 235, 0.14), transparent 35%),
            #111827;
        border: 1px solid #334155;
        border-radius: 18px;
        padding: 24px;
        text-align: center;
    }

    .sharji-sport-comments-clean .sport-login-icon {
        display: block;
        color: #3b82f6;
        font-size: 26px;
        margin-bottom: 10px;
    }

    .sharji-sport-comments-clean .sport-login-text {
        color: #cbd5e1;
        font-size: 14px;
        font-weight: 600;
        margin-bottom: 16px;
        display: block;
    }

    .sharji-sport-comments-clean .sport-login-actions {
        display: flex;
        justify-content: center;
        gap: 12px;
        flex-wrap: wrap;
    }

    .sharji-sport-comments-clean .sport-login-btn,
    .sharji-sport-comments-clean .sport-register-btn {
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

    .sharji-sport-comments-clean .sport-login-btn {
        background: #2563eb;
        color: #fff !important;
        border: 1px solid #2563eb;
    }

    .sharji-sport-comments-clean .sport-login-btn:hover {
        background: #1d4ed8;
        border-color: #1d4ed8;
    }

    .sharji-sport-comments-clean .sport-register-btn {
        background: transparent;
        color: #60a5fa !important;
        border: 1px solid rgba(96, 165, 250, 0.35);
    }

    .sharji-sport-comments-clean .sport-register-btn:hover {
        background: rgba(37, 99, 235, 0.14);
    }

    @media (max-width: 768px) {
        .sport-comments-area.sharji-sport-comments-clean {
            margin-top: 32px !important;
            border-radius: 14px !important;
        }

        .sharji-sport-comments-clean .sport-comments-head,
        .sharji-sport-comments-clean .sport-comments-body {
            padding: 16px !important;
        }

        .sharji-sport-comments-clean .sport-comments-title {
            font-size: 19px !important;
            flex-wrap: wrap;
        }

        .sharji-sport-comments-clean .sport-user-badge {
            width: 100%;
            align-items: flex-start;
            flex-wrap: wrap;
        }

        .sharji-sport-comments-clean .sport-user-logout {
            margin-right: 48px;
        }

        .sharji-sport-comments-clean .sport-submit-btn {
            width: 100%;
        }

        .sharji-sport-comments-clean .sport-login-actions {
            flex-direction: column;
        }

        .sharji-sport-comments-clean .sport-login-btn,
        .sharji-sport-comments-clean .sport-register-btn {
            width: 100%;
        }
    }
</style>

<div id="comments" class="sport-comments-area sharji-sport-comments-clean">

    <div class="sport-comments-head">
        <h3 class="sport-comments-title">
            <span class="indicator"></span>
            دیدگاه هواداران
            <span class="sport-comments-count">
                (<?php echo esc_html( get_comments_number() ); ?> دیدگاه)
            </span>
        </h3>
    </div>

    <div class="sport-comments-body">

        <?php if ( have_comments() ) : ?>

            <ul class="sport-comment-list">
                <?php
                wp_list_comments( array(
                    'style'       => 'ul',
                    'short_ping'  => true,
                    'avatar_size' => 60,
                    'callback'    => 'sharji_sport_comment_callback',
                ) );
                ?>
            </ul>

            <?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
                <nav class="sport-comment-nav" aria-label="ناوبری دیدگاه‌های ورزشی">
                    <div class="nav-previous">
                        <?php previous_comments_link( '&larr; قدیمی‌تر' ); ?>
                    </div>

                    <div class="nav-next">
                        <?php next_comments_link( 'جدیدتر &rarr;' ); ?>
                    </div>
                </nav>
            <?php endif; ?>

        <?php else : ?>

            <?php if ( ! comments_open() ) : ?>
                <p class="sport-no-comments closed">نظرات بسته شده است.</p>
            <?php else : ?>
                <p class="sport-no-comments empty">دیدگاهی موجود نیست! اولین نفر باشید.</p>
            <?php endif; ?>

        <?php endif; ?>

        <div class="sport-comment-form-section">
            <?php if ( comments_open() ) : ?>

                <?php if ( is_user_logged_in() ) : ?>
                    <?php
                    $current_user = wp_get_current_user();

                    if ( function_exists( 'get_sharji_user_rank' ) ) {
                        $rank = get_sharji_user_rank( $current_user->ID );
                    } else {
                        $rank = array(
                            'title' => 'هوادار',
                            'color' => '#60a5fa',
                            'icon'  => 'fa-user',
                        );
                    }
                    ?>

                    <h4 class="sport-form-title">
                        <i class="far fa-comment-dots"></i>
                        دیدگاه خود را بنویسید
                    </h4>

                    <form action="<?php echo esc_url( site_url( '/wp-comments-post.php' ) ); ?>" method="post" id="commentform" class="sport-comment-form">

                        <div class="sport-user-badge">
                            <div class="sport-user-avatar">
                                <?php echo get_avatar( $current_user->ID, 38 ); ?>
                            </div>

                            <div class="sport-user-info">
                                <span class="sport-user-name">
                                    <?php echo esc_html( $current_user->display_name ); ?>
                                </span>

                                <span class="sport-user-rank" style="color: <?php echo esc_attr( $rank['color'] ); ?>;">
                                    <i class="fas <?php echo esc_attr( $rank['icon'] ); ?>"></i>
                                    <?php echo esc_html( $rank['title'] ); ?>
                                </span>
                            </div>

                            <a href="<?php echo esc_url( wp_logout_url( get_permalink() ) ); ?>" class="sport-user-logout">
                                خروج
                            </a>
                        </div>

                        <textarea
                            name="comment"
                            id="comment"
                            rows="5"
                            class="sport-comment-textarea"
                            placeholder="نظر خود را بنویسید..."
                            required
                        ></textarea>

                        <div class="sport-comment-submit-row">
                            <button type="submit" class="sport-submit-btn">
                                ارسال دیدگاه
                                <i class="fas fa-paper-plane"></i>
                            </button>
                        </div>

                        <?php comment_id_fields(); ?>
                        <?php do_action( 'comment_form', get_the_ID() ); ?>
                    </form>

                <?php else : ?>

                    <div class="sport-login-box">
                        <i class="fas fa-lock sport-login-icon"></i>

                        <span class="sport-login-text">
                            برای شرکت در بحث و دریافت لقب، باید وارد شوید.
                        </span>

                        <div class="sport-login-actions">
                            <a href="<?php echo esc_url( wp_login_url( get_permalink() ) ); ?>" class="sport-login-btn">
                                ورود
                            </a>

                            <a href="<?php echo esc_url( wp_registration_url() ); ?>" class="sport-register-btn">
                                ثبت نام
                            </a>
                        </div>
                    </div>

                <?php endif; ?>

            <?php endif; ?>
        </div>

    </div>
</div>