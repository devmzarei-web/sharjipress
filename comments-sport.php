<?php
/**
 * Template for Sport Comments (Dark Mode & Gamified)
 */

if ( post_password_required() ) {
    return;
}
?>

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
