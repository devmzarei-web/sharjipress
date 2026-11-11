<?php

if ( post_password_required() ) {
    return;
}

$is_logged_in = is_user_logged_in();
$comments_count = get_comments_number();
?>

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
