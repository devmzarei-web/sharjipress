<?php
/*
 * Template Name: Single Sport Dark (Full Features + Polls)
 * Template Post Type: post
 */

get_header('sport');
?>


<div class="sport-single-wrapper">
    <div class="sport-single-layout">

        <!-- سایدبار -->
        <aside class="sport-single-sidebar">
            <div class="sport-single-sidebar-inner">
                
                <!-- آخرین اخبار -->
                <div class="sport-sidebar-card">
                    <div class="sport-sidebar-card-header">
                        <button>آخرین اخبار</button>
                    </div>
                    <div class="sport-sidebar-card-body">
                        <?php 
                        $sidebar_news = new WP_Query(['category_name' => 'sport', 'posts_per_page' => 10, 'post__not_in' => [get_the_ID()]]);
                        if($sidebar_news->have_posts()): while($sidebar_news->have_posts()): $sidebar_news->the_post(); 
                        ?>
                        <a href="<?php echo add_query_arg('theme', 'sport', get_permalink()); ?>" class="timeline-item" style="padding: 12px 0; margin-right: -16px; padding-right: 36px; padding-left: 8px;">
                            <span style="font-size: 10px; color: #60a5fa; display: block; margin-bottom: 4px; font-weight: bold;"><?php echo to_farsi_local(get_the_time('H:i')); ?></span>
                            <h3 style="font-size: 13px; line-height: 1.5rem; color: #d1d5db; font-weight: 500; text-align: justify; padding-left: 8px; margin: 0;"><?php the_title(); ?></h3>
                        </a>
                        <?php endwhile; endif; wp_reset_postdata(); ?>
                    </div>
                </div>

                <!-- جدول لیگ -->
                <div class="sport-sidebar-card">
                    <div class="sport-table-header">
                        <span>جدول لیگ برتر</span>
                        <a href="<?php echo home_url('/league-table'); ?>">جدول کامل <i class="fas fa-angle-left"></i></a>
                    </div>
                    <div style="padding: 0;">
                        <?php 
                        $teams_query = new WP_Query(['post_type' => 'league_team', 'posts_per_page' => -1]);
                        $table_data = [];
                        if($teams_query->have_posts()) {
                            while($teams_query->have_posts()) {
                                $teams_query->the_post();
                                if (!function_exists('get_field')) continue;
                                $played = (int)get_field('played'); $won = (int)get_field('won'); $drawn = (int)get_field('drawn');
                                $lost = (int)get_field('lost'); $deducted = (int)get_field('deducted'); $gf = (int)get_field('gf'); $ga = (int)get_field('ga');
                                $points = ($won * 3) + $drawn - $deducted; $diff = $gf - $ga;
                                $table_data[] = ['name' => get_the_title(), 'logo' => get_the_post_thumbnail_url(get_the_ID(), 'thumbnail'), 'played' => $played, 'won' => $won, 'drawn' => $drawn, 'lost' => $lost, 'points' => $points, 'diff' => $diff];
                            }
                            wp_reset_postdata();
                            usort($table_data, function($a, $b) { if ($a['points'] != $b['points']) return $b['points'] - $a['points']; return $b['diff'] - $a['diff']; });
                            $top_teams = array_slice($table_data, 0, 5);
                        }
                        ?>
                        <table class="mini-table">
                            <thead>
                                <tr><th style="width: 16px;">#</th><th style="text-align: right;">تیم</th><th style="color: #9ca3af;">بازی</th><th style="color: rgba(34, 197, 94, 0.8);">برد</th><th style="color: #9ca3af;">مساوی</th><th style="color: rgba(239, 68, 68, 0.8);">باخت</th><th style="color: #d1d5db;">تفاضل</th><th style="color: #fff; font-weight: bold; width: 32px;">امتیاز</th></tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($top_teams)): $rank = 1; foreach($top_teams as $team): 
                                    $diff_color = ($team['diff'] >= 0) ? 'color: #4ade80;' : 'color: #f87171;'; $diff_sign = ($team['diff'] > 0) ? '+' : ''; ?>
                                <tr>
                                    <td style="color: #6b7280; font-weight: bold;"><?php echo to_farsi_local($rank++); ?></td>
                                    <td style="text-align: right;"><div style="display: flex; align-items: center; gap: 6px;"><?php if($team['logo']): ?><img src="<?php echo esc_url($team['logo']); ?>" style="width: 16px; height: 16px; object-fit: contain;"><?php endif; ?><span style="color: #e5e7eb; font-weight: 500; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; max-width: 60px; display: block;"><?php echo esc_html($team['name']); ?></span></div></td>
                                    <td style="color: #9ca3af;"><?php echo to_farsi_local($team['played']); ?></td>
                                    <td style="color: #d1d5db;"><?php echo to_farsi_local($team['won']); ?></td>
                                    <td style="color: #9ca3af;"><?php echo to_farsi_local($team['drawn']); ?></td>
                                    <td style="color: #9ca3af;"><?php echo to_farsi_local($team['lost']); ?></td>
                                    <td style="<?php echo $diff_color; ?>"><?php echo to_farsi_local($diff_sign . $team['diff']); ?></td>
                                    <td style="font-weight: 900; color: #fff; background: rgba(255,255,255,0.05);"><?php echo to_farsi_local($team['points']); ?></td>
                                </tr>
                                <?php endforeach; else: ?><tr><td colspan="8" style="text-align: center; padding: 16px; color: #6b7280;">جدول خالی است</td></tr><?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <?php if ( is_active_sidebar( 'sport-sidebar' ) ) : ?>
                    <div id="sport-sidebar-area"><?php dynamic_sidebar( 'sport-sidebar' ); ?></div>
                <?php endif; ?>

                <?php if ( is_active_sidebar( 'sport-ad-sidebar' ) ) : ?>
                    <div id="sport-ad-area"><?php dynamic_sidebar( 'sport-ad-sidebar' ); ?></div>
                <?php else: ?>
                    <div class="sport-ad-placeholder">
                        <span style="border: 1px solid rgba(59, 130, 246, 0.3); padding: 4px 12px; border-radius: 4px;">جایگاه تبلیغات</span>
                    </div>
                <?php endif; ?>

            </div>
        </aside>

        <!-- محتوای اصلی -->
        <main class="sport-single-main">
            <?php if (have_posts()) : while (have_posts()) : the_post(); $current_post_id = get_the_ID(); ?>
            
            <article class="sport-article-card">
                <div class="sport-article-meta">
                    <div class="categories">
                        <?php $categories = get_the_category(); if ( $categories ) { foreach ( $categories as $category ) { echo '<a href="' . esc_url( get_category_link( $category->term_id ) ) . '">' . esc_html( $category->name ) . '</a>'; } } ?>
                    </div>
                    <span><i class="far fa-calendar" style="margin-left: 4px;"></i> <?php echo to_farsi_local(get_the_date()); ?></span>
                    <span><i class="far fa-clock" style="margin-left: 4px;"></i> <?php echo to_farsi_local(get_the_time('H:i')); ?></span>
                    <div class="sport-font-size-controls">
                        <button type="button" onclick="adjustFont(1)"><i class="fas fa-plus"></i></button>
                        <div class="divider"></div>
                        <button type="button" onclick="adjustFont(-1)"><i class="fas fa-minus"></i></button>
                    </div>
                </div>

                <h1 class="sport-article-title"><?php the_title(); ?></h1>
                
                <div class="entry-content" id="mainContent">
                    <div class="sport-article-featured">
                        <?php if (has_post_thumbnail()) : ?>
                        <div class="image-wrap"><?php the_post_thumbnail('large', ['class' => 'w-full h-auto object-cover']); ?></div>
                        <?php endif; ?>
                        <div class="sport-article-excerpt">
                            <div class="sport-article-excerpt-inner">
                                <span class="label">چکیده خبر</span>
                                <div class="text">
                                    <?php if (has_excerpt()) { echo get_the_excerpt(); } else { echo wp_trim_words(get_the_content(), 55, '...'); } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="sport-article-content"><?php the_content(); ?></div>
                </div>

                <?php $tags = get_the_tags(); if ($tags) : ?>
                <div class="sport-article-tags">
                    <span class="tags-label">برچسب‌ها:</span>
                    <?php foreach($tags as $tag) : ?><a href="<?php echo get_tag_link($tag->term_id); ?>"># <?php echo $tag->name; ?></a><?php endforeach; ?>
                </div>
                <?php endif; ?>

                <?php
                $sport_post_url       = get_permalink();
                $sport_post_title     = get_the_title();
                $sport_shortlink      = wp_get_shortlink();

                if ( empty( $sport_shortlink ) ) {
                    $sport_shortlink = home_url( '?p=' . get_the_ID() );
                }

                $sport_encoded_short  = rawurlencode( $sport_shortlink );
                $sport_encoded_title  = rawurlencode( $sport_post_title );
                $sport_share_text     = rawurlencode( $sport_post_title . "\n" . $sport_shortlink );
                ?>

                <div class="sport-share-box">
                    <div class="sport-share-header">
                        <div class="sport-share-title-wrap">
                            <div class="sport-share-icon">
                                <i class="fas fa-share-alt"></i>
                            </div>
                            <div>
                                <div class="sport-share-title">اشتراک‌گذاری خبر ورزشی</div>
                                <div class="sport-share-subtitle">این خبر را ارسال کنید یا لینک کوتاه آن را کپی کنید.</div>
                            </div>
                        </div>
                    </div>

                    <div class="sport-share-grid">
                        <a 
                            href="https://t.me/share/url?url=<?php echo esc_attr( $sport_encoded_short ); ?>&text=<?php echo esc_attr( $sport_encoded_title ); ?>" 
                            target="_blank" 
                            rel="noopener noreferrer"
                            class="sport-share-btn telegram"
                            title="اشتراک‌گذاری در تلگرام"
                        >
                            <i class="fab fa-telegram-plane"></i>
                            <span>تلگرام</span>
                        </a>

                        <a 
                            href="https://wa.me/?text=<?php echo esc_attr( $sport_share_text ); ?>" 
                            target="_blank" 
                            rel="noopener noreferrer"
                            class="sport-share-btn whatsapp"
                            title="اشتراک‌گذاری در واتساپ"
                        >
                            <i class="fab fa-whatsapp"></i>
                            <span>واتساپ</span>
                        </a>

                        <a 
                            href="https://twitter.com/intent/tweet?url=<?php echo esc_attr( $sport_encoded_short ); ?>&text=<?php echo esc_attr( $sport_encoded_title ); ?>" 
                            target="_blank" 
                            rel="noopener noreferrer"
                            class="sport-share-btn x-twitter"
                            title="اشتراک‌گذاری در ایکس"
                        >
                            <i class="fab fa-x-twitter"></i>
                            <span>ایکس</span>
                        </a>

                        <a 
                            href="https://www.facebook.com/sharer/sharer.php?u=<?php echo esc_attr( $sport_encoded_short ); ?>" 
                            target="_blank" 
                            rel="noopener noreferrer"
                            class="sport-share-btn facebook"
                            title="اشتراک‌گذاری در فیسبوک"
                        >
                            <i class="fab fa-facebook-f"></i>
                            <span>فیسبوک</span>
                        </a>

                        <button 
                            type="button"
                            class="sport-share-btn native-share"
                            onclick="sportNativeShare('<?php echo esc_js( $sport_post_title ); ?>', '<?php echo esc_js( $sport_shortlink ); ?>')"
                            title="اشتراک‌گذاری با موبایل"
                        >
                            <i class="fas fa-share-nodes"></i>
                            <span>اشتراک</span>
                        </button>

                        <button 
                            type="button"
                            class="sport-share-btn copy"
                            onclick="sportCopyText('<?php echo esc_js( $sport_shortlink ); ?>')"
                            title="کپی لینک کوتاه"
                        >
                            <i class="fas fa-link"></i>
                            <span>کپی لینک</span>
                        </button>
                    </div>

                    <div class="sport-shortlink-row">
                        <input 
                            id="sportShortlinkInput"
                            class="sport-shortlink-input"
                            type="text" 
                            value="<?php echo esc_url( $sport_shortlink ); ?>" 
                            readonly
                            aria-label="لینک کوتاه خبر"
                        >

                        <button 
                            type="button" 
                            class="sport-copy-shortlink"
                            onclick="sportCopyShortlink()"
                        >
                            کپی لینک کوتاه
                        </button>

                        <span id="sportCopyStatus" class="sport-copy-status">کپی شد</span>
                    </div>
                </div>
            </article>
            
            <?php
            $tags = wp_get_post_tags($current_post_id);
            if ($tags) {
                $tag_ids = array_column($tags, 'term_id');
                $related_query = new WP_Query([
                    'category_name' => 'sport',
                    'tag__in' => $tag_ids,
                    'post__not_in' => [$current_post_id],
                    'posts_per_page' => 3,
                    'ignore_sticky_posts' => 1
                ]);
                if (!$related_query->have_posts()) { $related_query = new WP_Query(['category_name' => 'sport', 'post__not_in' => [$current_post_id], 'posts_per_page' => 3]); }
                if ($related_query->have_posts()) : ?>
                <div class="sport-related-section">
                    <h3 class="sport-related-title">اخبار مرتبط ورزشی</h3>
                    <div class="sport-related-grid">
                        <?php while ($related_query->have_posts()) : $related_query->the_post(); ?>
                        <article class="sport-related-card">
                            <a href="<?php echo add_query_arg('theme', 'sport', get_permalink()); ?>" style="text-decoration: none;">
                                <div class="thumb"><?php the_post_thumbnail('medium', ['class' => 'w-full h-full object-cover']); ?></div>
                                <div class="info"><h3><?php the_title(); ?></h3></div>
                            </a>
                        </article>
                        <?php endwhile; wp_reset_postdata(); ?>
                    </div>
                </div>
                <?php endif; 
            }
            ?>

            <div class="sport-comments-section">
                <?php if ( comments_open() || get_comments_number() ) : comments_template('/comments-sport.php'); endif; ?>
            </div>

            <?php endwhile; endif; ?>
        </main>
    </div>
</div>


<?php get_footer('sport'); ?>
