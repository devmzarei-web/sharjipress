<?php get_header(); ?>




<div class="single-main-wrapper">
    <main class="single-page-shell">
        <div class="single-layout">

            <div class="single-content-col">
                <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                    <?php $current_post_id = get_the_ID(); ?>

                    <?php
                    $schema_image = has_post_thumbnail()
                        ? get_the_post_thumbnail_url(get_the_ID(), 'full')
                        : '';

                    $schema_data = [
                        '@context' => 'https://schema.org',
                        '@type' => 'NewsArticle',
                        'mainEntityOfPage' => [
                            '@type' => 'WebPage',
                            '@id' => get_permalink(),
                        ],
                        'headline' => wp_strip_all_tags(get_the_title()),
                        'description' => function_exists('sharji_get_news_lead')
                            ? wp_strip_all_tags(sharji_get_news_lead(get_the_ID()))
                            : (
                                has_excerpt()
                                    ? wp_strip_all_tags(get_the_excerpt())
                                    : wp_strip_all_tags(wp_trim_words(get_the_content(), 35, ''))
                            ),
                        'datePublished' => get_the_date('c'),
                        'dateModified' => get_the_modified_date('c'),
                        'author' => ( function_exists( 'sharji_should_show_post_author' ) && sharji_should_show_post_author( get_the_ID() ) )
                            ? [
                                '@type' => 'Person',
                                'name'  => get_the_author(),
                            ]
                            : [
                                '@type' => 'Organization',
                                'name'  => get_bloginfo('name'),
                            ],
                        'publisher' => [
                            '@type' => 'Organization',
                            'name' => get_bloginfo('name'),
                            'logo' => [
                                '@type' => 'ImageObject',
                                'url' => esc_url(home_url('/wp-content/uploads/2026/01/logosharjiok.png')),
                            ],
                        ],
                    ];

                    if (!empty($schema_image)) {
                        $schema_data['image'] = [$schema_image];
                    }
                    ?>

                    <script type="application/ld+json">
                    <?php echo wp_json_encode($schema_data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT); ?>
                    </script>

                    <article class="article-container">

                        <div class="meta-bar">
                            <div class="meta-item">
                                <i class="far fa-calendar-alt"></i>
                                <?php echo esc_html(sharji_jalali_post_date()); ?>
                            </div>

                            <div class="meta-item">
                                <i class="far fa-clock"></i>
                                <?php echo esc_html(sharji_to_farsi_digits(get_the_time('H:i'))); ?>
                            </div>

                            <div class="font-tools">
                                <button type="button" onclick="adjustFont(1)" title="افزایش سایز">
                                    <i class="fas fa-plus text-xs"></i>
                                </button>
                                <button type="button" onclick="adjustFont(-1)" title="کاهش سایز">
                                    <i class="fas fa-minus text-xs"></i>
                                </button>
                            </div>

                            <div class="meta-item">
                                کد خبر: <?php echo esc_html(sharji_to_farsi_digits(get_the_ID())); ?>
                            </div>

                            <div class="meta-cats">
                                <?php
                                $categories = get_the_category();
                                if ($categories) {
                                    foreach ($categories as $cat) {
                                        echo '<a href="' . esc_url(get_category_link($cat->term_id)) . '">' . esc_html($cat->name) . '</a>';
                                    }
                                }
                                ?>
                            </div>
                        </div>

                        <div class="content-area">
                            <h1 class="entry-title"><?php the_title(); ?></h1>

                            <div class="entry-content" id="mainContent">

                                <div class="article-intro-grid">
                                    <?php if (has_post_thumbnail()) : ?>
                                        <div class="featured-image-card">
                                            <?php the_post_thumbnail('large'); ?>
                                        </div>
                                    <?php endif; ?>

                                    <div class="article-summary-card">
                                        <div class="summary-label">
                                            <span></span>
                                            چکیده خبر
                                        </div>

                                        <div class="summary-text">
                                            <?php
                                            if (function_exists('sharji_get_news_lead')) {
                                                echo esc_html(sharji_get_news_lead(get_the_ID()));
                                            } elseif (has_excerpt()) {
                                                echo esc_html(get_the_excerpt());
                                            } else {
                                                echo esc_html(wp_trim_words(get_the_content(), 55, '...'));
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="full-text">
                                    <?php the_content(); ?>
                                </div>

                                <div class="clear-both"></div>
                            </div>

                            <div class="after-content-area">

                                <?php $tags = get_the_tags(); ?>
                                <?php if ($tags) : ?>
                                    <div class="tag-row">
                                        <span class="tag-row-label">برچسب‌ها:</span>

                                        <?php foreach ($tags as $tag) : ?>
                                            <a href="<?php echo esc_url(get_tag_link($tag->term_id)); ?>" class="tag-link">
                                                <i class="fas fa-hashtag"></i>
                                                <?php echo esc_html($tag->name); ?>
                                            </a>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>

                                <!-- Author Profile Box -->
                                <?php if ( function_exists( 'sharji_should_show_post_author' ) && sharji_should_show_post_author( $current_post_id ) ) : ?>
<div class="sharji-author-box">
    <div class="author-avatar">
        <?php 
        $author_id = get_the_author_meta('ID');
        // Check for the custom admin URL first
        $custom_admin_avatar = get_user_meta($author_id, 'sharji_override_avatar', true);
        
        if (!empty($custom_admin_avatar)) {
            // Force the custom image if the admin provided one
            echo '<img src="' . esc_url($custom_admin_avatar) . '" alt="' . esc_attr(get_the_author()) . '">';
        } else {
            // Fallback to Ultimate Member / Default Gravatar
            echo get_avatar($author_id, 80, '', get_the_author()); 
        }
        ?>
    </div>
    <div class="author-info">
        <span class="author-label">نویسنده مطلب</span>
        <h3 class="author-name">
            <a href="<?php echo esc_url(get_author_posts_url($author_id)); ?>" title="مشاهده تمامی مطالب <?php the_author(); ?>">
                <?php the_author(); ?>
            </a>
        </h3>
        <?php if (get_the_author_meta('description')) : ?>
            <p class="author-bio">
                <?php echo esc_html(get_the_author_meta('description')); ?>
            </p>
        <?php endif; ?>
    </div>
</div>
                                <?php endif; ?>
                                <!-- End Author Profile Box -->

                                <?php
                                $sharji_post_title = get_the_title();
                                $sharji_shortlink = wp_get_shortlink();

                                if (empty($sharji_shortlink)) {
                                    $sharji_shortlink = home_url('?p=' . get_the_ID());
                                }

                                $sharji_encoded_short = rawurlencode($sharji_shortlink);
                                $sharji_encoded_title = rawurlencode($sharji_post_title);
                                $sharji_share_text = rawurlencode($sharji_post_title . "\n" . $sharji_shortlink);
                                ?>

                                <div class="sharji-share-box">
                                    <div class="sharji-share-header">
                                        <div>
                                            <div class="sharji-share-title">
                                                <i class="fas fa-share-alt"></i>
                                                <span>اشتراک‌گذاری خبر</span>
                                            </div>
                                            <div class="sharji-share-subtitle">
                                                این خبر را برای دیگران ارسال کنید.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="sharji-share-grid">
                                        <a href="https://t.me/share/url?url=<?php echo esc_attr($sharji_encoded_short); ?>&text=<?php echo esc_attr($sharji_encoded_title); ?>" target="_blank" rel="noopener noreferrer" class="sharji-share-btn telegram" title="اشتراک‌گذاری در تلگرام">
                                            <img src="<?php echo esc_url(home_url('/wp-content/uploads/2026/01/telegram.png')); ?>" alt="telegram">
                                            <span>تلگرام</span>
                                        </a>

                                        <a href="https://wa.me/?text=<?php echo esc_attr($sharji_share_text); ?>" target="_blank" rel="noopener noreferrer" class="sharji-share-btn whatsapp" title="اشتراک‌گذاری در واتساپ">
                                            <img src="<?php echo esc_url(home_url('/wp-content/uploads/2026/01/whatsapp.png')); ?>" alt="whatsapp">
                                            <span>واتساپ</span>
                                        </a>

                                        <a href="https://twitter.com/intent/tweet?url=<?php echo esc_attr($sharji_encoded_short); ?>&text=<?php echo esc_attr($sharji_encoded_title); ?>" target="_blank" rel="noopener noreferrer" class="sharji-share-btn x-twitter" title="اشتراک‌گذاری در ایکس">
                                            <i class="fab fa-x-twitter"></i>
                                            <span>ایکس</span>
                                        </a>

                                        <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo esc_attr($sharji_encoded_short); ?>" target="_blank" rel="noopener noreferrer" class="sharji-share-btn facebook" title="اشتراک‌گذاری در فیسبوک">
                                            <i class="fab fa-facebook-f"></i>
                                            <span>فیسبوک</span>
                                        </a>

                                        <button type="button" class="sharji-share-btn native-share" onclick="sharjiNativeShare('<?php echo esc_js($sharji_post_title); ?>', '<?php echo esc_js($sharji_shortlink); ?>')" title="اشتراک‌گذاری با موبایل">
                                            <i class="fas fa-share-nodes"></i>
                                            <span>اشتراک</span>
                                        </button>

                                        <button type="button" class="sharji-share-btn copy" onclick="sharjiCopyText('<?php echo esc_js($sharji_shortlink); ?>')" title="کپی لینک کوتاه">
                                            <i class="fas fa-link"></i>
                                            <span>کپی لینک</span>
                                        </button>
                                    </div>

                                    <div class="sharji-shortlink-row">
                                        <input id="sharjiShortlinkInput" class="sharji-shortlink-input" type="text" value="<?php echo esc_url($sharji_shortlink); ?>" readonly aria-label="لینک کوتاه خبر">

                                        <button type="button" class="sharji-copy-shortlink" onclick="sharjiCopyShortlink()">
                                            کپی لینک کوتاه
                                        </button>

                                        <span id="sharjiCopyStatus" class="sharji-copy-status">کپی شد</span>
                                    </div>
                                </div>

                                <?php
                                $rel_cache_key = 'related_posts_' . $current_post_id;
                                $related_posts = wp_cache_get($rel_cache_key, 'single_page');

                                if (false === $related_posts) {
                                    $related_posts = [];

                                    $tags_data = wp_get_post_tags($current_post_id);

                                    if ($tags_data) {
                                        $tag_ids = array_map(function($t) {
                                            return $t->term_id;
                                        }, $tags_data);

                                        $related_query = new WP_Query([
                                            'tag__in' => $tag_ids,
                                            'post__not_in' => [$current_post_id],
                                            'posts_per_page' => 9,
                                            'ignore_sticky_posts' => 1,
                                            'no_found_rows' => true,
                                        ]);

                                        $related_posts = $related_query->posts;
                                        wp_reset_postdata();
                                    }

                                    if (empty($related_posts)) {
                                        $cat_ids = wp_get_post_categories($current_post_id);

                                        if (!empty($cat_ids)) {
                                            $related_query = new WP_Query([
                                                'category__in' => $cat_ids,
                                                'post__not_in' => [$current_post_id],
                                                'posts_per_page' => 9,
                                                'ignore_sticky_posts' => 1,
                                                'no_found_rows' => true,
                                            ]);

                                            $related_posts = $related_query->posts;
                                            wp_reset_postdata();
                                        }
                                    }

                                    wp_cache_set($rel_cache_key, $related_posts, 'single_page', HOUR_IN_SECONDS);
                                }
                                ?>

                                <?php if ($related_posts) : ?>
                                    <div class="related-premium-box">
                                        <div class="related-premium-head">
                                            <div class="related-premium-title-wrap">
                                                <div class="related-premium-icon">
                                                    <i class="fas fa-newspaper"></i>
                                                </div>

                                                <div>
                                                    <h2 class="related-premium-title">اخبار مرتبط</h2>
                                                    <div class="related-premium-subtitle">مطالبی که با این خبر ارتباط بیشتری دارند</div>
                                                </div>
                                            </div>

                                            <div class="related-premium-navs">
                                                <button class="rel-prev related-nav" type="button" aria-label="خبر قبلی">
                                                    <i class="fas fa-chevron-right"></i>
                                                </button>
                                                <button class="rel-next related-nav" type="button" aria-label="خبر بعدی">
                                                    <i class="fas fa-chevron-left"></i>
                                                </button>
                                            </div>
                                        </div>

                                        <div class="related-premium-body">
                                            <div class="swiper related-swiper">
                                                <div class="swiper-wrapper">
                                                    <?php foreach ($related_posts as $post) : setup_postdata($post); ?>
                                                        <div class="swiper-slide">
                                                            <a href="<?php the_permalink(); ?>" class="related-card-premium">
                                                                <div class="related-thumb-premium">
                                                                    <?php if (has_post_thumbnail()) : ?>
                                                                        <?php the_post_thumbnail('medium'); ?>
                                                                    <?php endif; ?>
                                                                </div>

                                                                <div class="related-card-content">
                                                                    <h4><?php the_title(); ?></h4>

                                                                    <div class="related-card-meta">
                                                                        <i class="far fa-clock"></i>
                                                                        <span><?php echo esc_html(sharji_to_farsi_digits(get_the_time('H:i'))); ?></span>
                                                                    </div>
                                                                </div>
                                                            </a>
                                                        </div>
                                                    <?php endforeach; wp_reset_postdata(); ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>

                            </div>
                        </div>

<?php
if (comments_open() || get_comments_number()) :
    comments_template();
endif;
?>

                    </article>
                <?php endwhile; endif; ?>
            </div>

            <aside class="single-sidebar-col">
                <div class="sidebar-sticky-original">

                    <div class="sidebar-news-box">
                        <div class="sidebar-news-head">
                            <span>پیشنهاد شرجی</span>
                            <i class="fas fa-star text-yellow-400"></i>
                        </div>

                        <?php
                        $editor_cache = wp_cache_get('editor_picks_sidebar', 'sidebar');

                        if (false === $editor_cache) {
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
                            $editor_cache = $editor_query->posts;
                            wp_reset_postdata();

                            wp_cache_set('editor_picks_sidebar', $editor_cache, 'sidebar', 2 * HOUR_IN_SECONDS);
                        }

                        if ($editor_cache) :
                            foreach ($editor_cache as $post) : setup_postdata($post);
                        ?>
                                <a href="<?php the_permalink(); ?>" class="sidebar-news-item">
                                    <div class="sidebar-news-thumb">
                                        <?php if (has_post_thumbnail()) : ?>
                                            <?php the_post_thumbnail('medium'); ?>
                                        <?php endif; ?>
                                    </div>

                                    <h3 class="sidebar-news-title"><?php the_title(); ?></h3>

                                    <p class="sidebar-news-excerpt">
                                        <?php echo esc_html(wp_trim_words(get_the_excerpt(), 18, '...')); ?>
                                    </p>
                                </a>
                        <?php
                            endforeach;
                            wp_reset_postdata();
                        endif;
                        ?>
                    </div>

                    <?php if (is_active_sidebar('single-sidebar')) : ?>
                        <div id="sidebar-ads" class="dynamic-widgets-container">
                            <?php dynamic_sidebar('single-sidebar'); ?>
                        </div>
                    <?php endif; ?>

                    <?php if (is_active_sidebar('single-sidebar-2')) : ?>
                        <div id="sidebar-ads-2" class="dynamic-widgets-container">
                            <?php dynamic_sidebar('single-sidebar-2'); ?>
                        </div>
                    <?php endif; ?>

                </div>
            </aside>

        </div>
    </main>
</div>


<?php get_footer(); ?>
