<?php get_header(); ?>


<?php
$bargozideh_cat = get_category_by_slug('bargozideh');
$bargozideh_link = $bargozideh_cat ? get_category_link($bargozideh_cat->term_id) : home_url('/category/bargozideh');
?>


<div class="hidden lg:block">
    <div class="main-site-container">

        <div class="home-top-shell">
            <header class="news-grid desktop-only h-[55px] text-white home-section-header">
                <a href="/category/tahlil" class="home-header-link flex justify-between items-center px-5 bg-[#0056b3] no-underline text-white">
                    <span class="font-diba text-lg">تحلیل روز</span>
                    <i class="fas fa-chart-line"></i>
                </a>

                <div class="flex items-center justify-between px-6 bg-[#0056b3]">
                    <a href="<?php echo esc_url($bargozideh_link); ?>" class="font-diba text-2xl text-white no-underline">
                        <i class="fas fa tv text-yellow-400"></i> اخبار برگزیده
                    </a>
                    <a href="/category/news" class="text-xs border-b border-white/40 text-white no-underline">آرشیو</a>
                </div>

                <a href="/category/multimedia" class="home-header-link flex justify-between items-center px-5 bg-[#0056b3] text-white no-underline">
                    <span class="font-diba text-lg">چند رسانه‌ای</span>
                    <i class="fas fa-photo-video"></i>
                </a>
            </header>

            <div class="news-grid bg-white overflow-hidden border-b">
                <div class="side-column border-l">
                    <?php $t_q = new WP_Query(['category_name' => 'tahlil', 'posts_per_page' => 5, 'ignore_sticky_posts' => 1]); 
                    if($t_q->have_posts()): while($t_q->have_posts()): $t_q->the_post(); ?>
                    <a href="<?php the_permalink(); ?>" class="n-box">
                        <div class="w-24 h-16 flex-shrink-0 overflow-hidden rounded">
                            <?php the_post_thumbnail('medium', ['class' => 'w-full h-full object-cover']); ?>
                        </div>
                        <div class="flex-1 flex flex-col justify-between">
                            <div>
                                <h4 class="font-diba blue-title side-title"><?php the_title(); ?></h4>
                                <div class="side-excerpt"><?php echo get_the_excerpt(); ?></div>
                            </div>
                        </div>
                    </a>
                    <?php endwhile; wp_reset_postdata(); endif; ?>

                    <div class="ads-box" style="flex-grow:1; background:#f8fafc; overflow:hidden;">
                        <?php if ( is_active_sidebar( 'ads-video-sidebar' ) ) : dynamic_sidebar( 'ads-video-sidebar' ); endif; ?>
                    </div>
                </div>

                <div class="slider-container lg:col-start-2">
                    <div class="slider-nav">
                        <div class="nav-btn" onclick="prevSlide()"><i class="fas fa-chevron-right"></i></div>
                        <div class="nav-btn" onclick="nextSlide()"><i class="fas fa-chevron-left"></i></div>
                    </div>

                    <div id="main-slider" class="flex h-full transition-transform duration-700">
                        <?php $s_q = new WP_Query(['category_name' => 'bargozideh', 'posts_per_page' => 5, 'ignore_sticky_posts' => 1]); 
                        if($s_q->have_posts()): while($s_q->have_posts()): $s_q->the_post(); ?>
                        <div class="min-w-full flex flex-col h-full">
                            <a href="<?php the_permalink(); ?>" class="slider-img-frame block overflow-hidden">
                                <?php the_post_thumbnail('full', ['class' => 'w-full h-full object-cover']); ?>
                            </a>

                            <div class="slider-caption-box">
                                <a href="<?php the_permalink(); ?>" class="no-underline">
                                    <h2 class="font-diba blue-title text-2xl mb-1 leading-tight"><?php the_title(); ?></h2>
                                </a>
                                <div class="slider-excerpt-force"><?php echo get_the_excerpt(); ?></div>
                                <a href="<?php the_permalink(); ?>" class="read-more no-underline">
                                    ادامه خبر <i class="fas fa-angle-double-left"></i>
                                </a>
                            </div>
                        </div>
                        <?php endwhile; wp_reset_postdata(); endif; ?>
                    </div>
                </div>

                <div class="side-column border-r">
                    <?php 
                    $args_multi = [
                        'posts_per_page' => 5,
                        'ignore_sticky_posts' => 1,
                        'tax_query' => [
                            'relation' => 'OR',
                            ['taxonomy' => 'category', 'field' => 'slug', 'terms' => 'video'],
                            ['taxonomy' => 'category', 'field' => 'slug', 'terms' => 'image'],
                            ['taxonomy' => 'category', 'field' => 'slug', 'terms' => 'multimedia']
                        ]
                    ];
                    $i_q = new WP_Query($args_multi); 

                    if($i_q->have_posts()): while($i_q->have_posts()): $i_q->the_post(); 
                        $icon_class = 'fa-camera'; 
                        if (has_category('video')) $icon_class = 'fa-play';

                        $video_preview = get_post_meta(get_the_ID(), 'video_preview_url', true);
                        $has_valid_video = (!empty($video_preview) && filter_var($video_preview, FILTER_VALIDATE_URL));
                    ?>
                    <a href="<?php the_permalink(); ?>" class="n-box">
                        <div class="w-24 h-16 flex-shrink-0 relative overflow-hidden rounded <?php if($has_valid_video) echo 'bg-black'; ?>">
                            <?php if ($has_valid_video) : ?>
                                <video src="<?php echo esc_url($video_preview); ?>" loop muted playsinline class="w-full h-full object-cover" style="object-fit:cover!important; opacity:0.8;"></video>
                            <?php else : ?>
                                <?php the_post_thumbnail('medium', ['class' => 'w-full h-full object-cover']); ?>
                            <?php endif; ?>
                            <div class="absolute inset-0 bg-black/20 flex items-center justify-center">
                                <i class="fas <?php echo $icon_class; ?> text-white text-sm drop-shadow-md"></i>
                            </div>
                        </div>
                        <div class="flex-1 flex flex-col justify-between">
                            <div>
                                <h4 class="font-diba blue-title side-title"><?php the_title(); ?></h4>
                                <div class="side-excerpt"><?php echo get_the_excerpt(); ?></div>
                            </div>
                        </div>
                    </a>
                    <?php endwhile; wp_reset_postdata(); endif; ?>

                    <div class="ads-box" style="flex-grow:1; background:#f8fafc; overflow:hidden;">
                        <?php if ( is_active_sidebar( 'ads-image-sidebar' ) ) : dynamic_sidebar( 'ads-image-sidebar' ); endif; ?>
                    </div>
                </div>
            </div>

            <header class="news-grid desktop-only mt-1 h-[55px] text-white home-section-header">
                <a href="#" class="home-header-link flex justify-center items-center bg-[#0056b3] text-white no-underline transition-colors">
                    <span class="font-diba text-lg">پربازدیدترین‌ها</span>
                </a>

                <a href="/category/news" class="home-header-link flex justify-center items-center bg-[#0056b3] text-white no-underline transition-colors">
                    <span class="font-diba text-2xl">آخرین اخبار</span>
                </a>

                <a href="/category/interviews" class="home-header-link flex justify-center items-center bg-[#0056b3] text-white no-underline transition-colors">
                    <span class="font-diba text-lg">گفت‌وگوی ویژه</span>
                </a>
            </header>

            <div class="news-grid bg-white border-b">
                <div id="most-viewed-list" class="side-column-long border-l">
                    <?php 
                    $args_mv = [
                        'posts_per_page' => 8,
                        'ignore_sticky_posts' => 1,
                        'suppress_filters' => false,
                        'orderby' => 'post_views',
                        'order' => 'DESC'
                    ];
                    $q1 = new WP_Query($args_mv);
                    if (!$q1->have_posts()) {
                        $args_mv['suppress_filters'] = true; 
                        $args_mv['orderby'] = 'meta_value_num';
                        $args_mv['meta_key'] = 'views';
                        $q1 = new WP_Query($args_mv);
                    }
                    if (!$q1->have_posts()) {
                         unset($args_mv['meta_key']);
                         unset($args_mv['orderby']);
                         $q1 = new WP_Query($args_mv);
                    }
                    while($q1->have_posts()): $q1->the_post(); ?>
                    <a href="<?php the_permalink(); ?>" class="n-box">
                        <div class="w-20 h-16 flex-shrink-0 overflow-hidden rounded">
                            <?php the_post_thumbnail('thumbnail', ['class'=>'rounded object-cover w-full h-full']); ?>
                        </div>
                        <div class="flex-1 flex flex-col justify-between">
                            <div>
                                <h4 class="font-diba blue-title side-title"><?php the_title(); ?></h4>
                                <div class="side-excerpt"><?php echo get_the_excerpt(); ?></div>
                            </div>
                            <div class="view-badge">
                                <i class="fas fa-eye text-xs"></i>
                                <span class="live-view-count" data-id="<?php the_ID(); ?>"><?php if(function_exists('get_post_views')) echo get_post_views(get_the_ID()); ?></span>
                            </div>
                        </div>
                    </a>
                    <?php endwhile; wp_reset_postdata(); ?>
                </div>

                <div id="latest-news-center-list" class="lg:col-start-2 bg-white border-x flex flex-col h-auto">
                     <?php $q2 = new WP_Query(['category_name'=>'news', 'posts_per_page'=>6, 'ignore_sticky_posts' => 1]); 
                     if($q2->have_posts()): while($q2->have_posts()): $q2->the_post(); ?>
                    <a href="<?php the_permalink(); ?>" class="special-row">
                        <div class="w-[180px] h-[120px] overflow-hidden rounded flex-shrink-0">
                            <?php the_post_thumbnail('large', ['class'=>'w-full h-full object-cover']); ?>
                        </div>
                        <div class="flex-1 flex flex-col justify-center h-full">
                            <h4 class="font-diba text-xl blue-title mb-2 leading-tight"><?php the_title(); ?></h4>
                            <div class="text-gray-600 text-xs line-clamp-3 leading-relaxed text-justify"><?php echo get_the_excerpt(); ?></div>
                            <div class="read-more">ادامه خبر <i class="fas fa-angle-double-left"></i></div>
                        </div>
                    </a>
                    <?php endwhile; wp_reset_postdata(); endif; ?>
                </div>

                <div id="interviews-list" class="side-column-long border-r">
                    <?php $q3 = new WP_Query(['category_name' => 'interviews', 'posts_per_page' => 8, 'ignore_sticky_posts' => 1]); 
                    if($q3->have_posts()): while($q3->have_posts()): $q3->the_post(); ?>
                    <a href="<?php the_permalink(); ?>" class="n-box flex-col md:flex-row">
                        <div class="w-20 h-16 flex-shrink-0 relative overflow-hidden rounded">
                            <?php the_post_thumbnail('thumbnail', ['class'=>'rounded w-full h-full object-cover']); ?>
                        </div>
                        <div class="flex-1 flex flex-col justify-between">
                            <div>
                                <h4 class="font-diba blue-title side-title"><?php the_title(); ?></h4>
                                <div class="side-excerpt"><?php echo get_the_excerpt(); ?></div>
                            </div>
                            <span class="view-badge"><i class="far fa-clock"></i> <?php echo get_the_time('H:i'); ?></span>
                        </div>
                    </a>
                    <?php endwhile; wp_reset_postdata(); endif; ?>
                </div>
            </div>

            <div class="load-more-global-wrapper">
                <button id="global-load-more" class="font-diba flex items-center mx-auto gap-2">
                    <i class="fas fa-plus-circle"></i> مشاهده اخبار بیشتر
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Mobile View -->
<div class="lg:hidden main-site-container">
    <div class="swiper swiper-mobile shadow-lg mb-4">
        <div class="swiper-wrapper">
            <?php $m_s = new WP_Query(['category_name' => 'bargozideh', 'posts_per_page' => 5, 'ignore_sticky_posts' => 1]);
            if($m_s->have_posts()): while($m_s->have_posts()): $m_s->the_post(); ?>
            <div class="swiper-slide relative">
                <a href="<?php the_permalink(); ?>" class="block relative h-[240px]">
                    <?php the_post_thumbnail('large', ['class'=>'w-full h-full object-cover']); ?>
                    <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/20 to-transparent"></div>
                    <div class="absolute bottom-0 right-0 p-4 w-full text-white">
                        <span class="bg-[#e31e24] text-white text-[10px] px-2 py-0.5 rounded mb-2 inline-block shadow-sm">برگزیده</span>
                        <h2 class="font-diba text-white text-lg leading-tight drop-shadow-md"><?php the_title(); ?></h2>
                    </div>
                </a>
            </div>
            <?php endwhile; wp_reset_postdata(); endif; ?>
        </div>
        <div class="swiper-pagination"></div>
    </div>

    <?php if ( is_active_sidebar( 'home-mobile-ad' ) ) : ?>
        <div class="mobile-home-ad-box">
            <div class="mobile-home-ad-label">تبلیغات</div>
            <div class="mobile-home-ad-content">
                <?php dynamic_sidebar( 'home-mobile-ad' ); ?>
            </div>
        </div>
    <?php endif; ?>

    <div class="flex w-full rounded-t-lg overflow-hidden shadow border-b border-gray-200 bg-white">
        <div class="m-tab-btn active group-1-tab" onclick="toggleTabs(event, 'group1', 'm-news')" data-slug="news" data-btn="btn-load-1">آخرین اخبار</div>
        <div class="m-tab-btn group-1-tab" onclick="toggleTabs(event, 'group1', 'm-tahlil')" data-slug="tahlil" data-btn="btn-load-1">تحلیل روز</div>
    </div>

    <div class="bg-white shadow-md mb-6 rounded-b-lg">
        <div id="m-news" class="m-content group1-content">
            <div id="list-news">
                <?php $mq1 = new WP_Query(['category_name'=>'news', 'posts_per_page'=>5, 'ignore_sticky_posts' => 1]);
                while($mq1->have_posts()): $mq1->the_post(); ?>
                    <a href="<?php the_permalink(); ?>" class="m-news-row">
                        <div class="m-row-thumb">
                            <?php the_post_thumbnail('thumbnail', ['class'=>'w-full h-full object-cover']); ?>
                        </div>
                        <div class="m-row-content">
                            <h4 class="m-row-title"><?php the_title(); ?></h4>
                            <div class="m-row-excerpt"><?php echo wp_trim_words(get_the_excerpt(), 20, '...'); ?></div>
                            <div class="m-row-meta"><i class="far fa-clock"></i> <?php echo get_the_date('j F Y'); ?></div>
                        </div>
                    </a>
                <?php endwhile; wp_reset_postdata(); ?>
            </div>
        </div>

        <div id="m-tahlil" class="m-content group1-content hidden">
            <div id="list-tahlil">
                <?php $mq2 = new WP_Query(['category_name'=>'tahlil', 'posts_per_page'=>5, 'ignore_sticky_posts' => 1]);
                while($mq2->have_posts()): $mq2->the_post(); ?>
                    <a href="<?php the_permalink(); ?>" class="m-news-row">
                        <div class="m-row-thumb">
                            <?php the_post_thumbnail('thumbnail', ['class'=>'w-full h-full object-cover']); ?>
                        </div>
                        <div class="m-row-content">
                            <h4 class="m-row-title"><?php the_title(); ?></h4>
                            <div class="m-row-excerpt"><?php echo wp_trim_words(get_the_excerpt(), 20, '...'); ?></div>
                            <div class="m-row-meta"><i class="far fa-clock"></i> <?php echo get_the_date('j F Y'); ?></div>
                        </div>
                    </a>
                <?php endwhile; wp_reset_postdata(); ?>
            </div>
        </div>

        <div class="p-4 text-center border-t">
            <button id="btn-load-1" onclick="loadMoreMobile('btn-load-1', 'group1')" class="w-full py-3 rounded-xl m-load-btn-style font-diba text-sm transition flex justify-center items-center gap-2">
                <i class="fas fa-plus-circle"></i> مشاهده اخبار بیشتر
            </button>
        </div>
    </div>

    <div class="flex w-full mt-4 rounded-t-lg overflow-hidden shadow text-sm border-b border-gray-200 bg-white">
        <div class="m-tab-btn active group-2-tab" onclick="toggleTabs(event, 'group2', 'm-most')" data-slug="most_viewed" data-btn="btn-load-2">پربازدید</div>
        <div class="m-tab-btn group-2-tab" onclick="toggleTabs(event, 'group2', 'm-video')" data-slug="video" data-btn="btn-load-2">چندرسانه‌ای</div>
        <div class="m-tab-btn group-2-tab" onclick="toggleTabs(event, 'group2', 'm-interviews')" data-slug="interviews" data-btn="btn-load-2">گفت‌وگو</div>
    </div>

    <div class="bg-white shadow-md mb-10 rounded-b-lg">
        <div id="m-most" class="m-content group2-content">
            <div id="list-most_viewed">
                <?php
                $args_mv_mob = [
                    'posts_per_page' => 5,
                    'suppress_filters' => false,
                    'orderby' => 'post_views',
                    'order' => 'DESC'
                ];
                $mq3 = new WP_Query($args_mv_mob);
                if (!$mq3->have_posts()) {
                    $args_mv_mob['suppress_filters'] = true;
                    $args_mv_mob['orderby'] = 'meta_value_num';
                    $args_mv_mob['meta_key'] = 'views';
                    $mq3 = new WP_Query($args_mv_mob);
                }
                if (!$mq3->have_posts()) {
                    unset($args_mv_mob['meta_key']);
                    unset($args_mv_mob['orderby']);
                    $mq3 = new WP_Query($args_mv_mob);
                }
                while($mq3->have_posts()): $mq3->the_post(); ?>
                    <a href="<?php the_permalink(); ?>" class="m-news-row">
                        <div class="m-row-thumb">
                            <?php the_post_thumbnail('thumbnail', ['class'=>'w-full h-full object-cover']); ?>
                        </div>
                        <div class="m-row-content">
                            <h4 class="m-row-title"><?php the_title(); ?></h4>
                            <div class="m-row-excerpt"><?php echo wp_trim_words(get_the_excerpt(), 20, '...'); ?></div>
                            <div class="m-row-meta">
                                <span class="text-xs text-blue-600 bg-blue-50 px-2 rounded-full ml-2"><?php echo $mq3->current_post + 1; ?>#</span>
                                <i class="far fa-eye ml-1"></i>
                                <span class="live-view-count" data-id="<?php the_ID(); ?>"><?php if(function_exists('get_post_views')) echo get_post_views(get_the_ID()); ?></span>
                            </div>
                        </div>
                    </a>
                <?php endwhile; wp_reset_postdata(); ?>
            </div>
        </div>

        <div id="m-video" class="m-content group2-content hidden">
            <div id="list-video">
                <?php
                $mq4 = new WP_Query([
                    'tax_query' => [
                        'relation' => 'OR',
                        ['taxonomy'=>'category', 'field'=>'slug', 'terms'=>'video'],
                        ['taxonomy'=>'category', 'field'=>'slug', 'terms'=>'image'],
                        ['taxonomy'=>'category', 'field'=>'slug', 'terms'=>'multimedia']
                    ],
                    'posts_per_page'=>5,
                    'ignore_sticky_posts' => 1
                ]);
                if($mq4->have_posts()): while($mq4->have_posts()): $mq4->the_post();
                $m_icon = has_category('video') ? 'fa-play' : 'fa-camera';
                
                // Video Preview Setup
                $m_video_preview = get_post_meta(get_the_ID(), 'video_preview_url', true);
                $m_has_valid_video = (!empty($m_video_preview) && filter_var($m_video_preview, FILTER_VALIDATE_URL));
                $thumb_bg = $m_has_valid_video ? 'bg-black' : '';
                ?>
                    <a href="<?php the_permalink(); ?>" class="m-news-row">
                        <div class="m-row-thumb relative <?php echo $thumb_bg; ?>">
                            <?php if ($m_has_valid_video) : ?>
                                <video src="<?php echo esc_url($m_video_preview); ?>" loop muted playsinline class="w-full h-full object-cover" style="object-fit:cover!important; opacity:0.8;"></video>
                            <?php elseif (has_post_thumbnail()) : ?>
                                <?php the_post_thumbnail('thumbnail', ['class'=>'w-full h-full object-cover']); ?>
                            <?php endif; ?>
                            <div class="absolute inset-0 bg-black/30 flex items-center justify-center text-white">
                                <i class="fas <?php echo $m_icon; ?>"></i>
                            </div>
                        </div>
                        <div class="m-row-content">
                            <h4 class="m-row-title"><?php the_title(); ?></h4>
                            <div class="m-row-excerpt"><?php echo wp_trim_words(get_the_excerpt(), 20, '...'); ?></div>
                            <span class="m-row-meta"><i class="far fa-clock"></i> <?php echo get_the_date(); ?></span>
                        </div>
                    </a>
                <?php endwhile; wp_reset_postdata(); endif; ?>
            </div>
        </div>

        <div id="m-interviews" class="m-content group2-content hidden">
            <div id="list-interviews">
                <?php $mq5 = new WP_Query(['category_name'=>'interviews', 'posts_per_page'=>5, 'ignore_sticky_posts' => 1]);
                if($mq5->have_posts()): while($mq5->have_posts()): $mq5->the_post(); ?>
                    <a href="<?php the_permalink(); ?>" class="m-news-row">
                        <div class="m-row-thumb">
                            <?php the_post_thumbnail('thumbnail', ['class'=>'w-full h-full object-cover']); ?>
                        </div>
                        <div class="m-row-content">
                            <h4 class="m-row-title"><?php the_title(); ?></h4>
                            <div class="m-row-excerpt"><?php echo wp_trim_words(get_the_excerpt(), 20, '...'); ?></div>
                            <span class="m-row-meta"><i class="far fa-clock"></i> <?php echo get_the_date(); ?></span>
                        </div>
                    </a>
                <?php endwhile; wp_reset_postdata(); endif; ?>
            </div>
        </div>

        <div class="p-4 text-center border-t">
            <button id="btn-load-2" onclick="loadMoreMobile('btn-load-2', 'group2')" class="w-full py-3 rounded-xl m-load-btn-style font-diba text-sm transition flex justify-center items-center gap-2">
                <i class="fas fa-plus-circle"></i> مشاهده اخبار بیشتر
            </button>
        </div>
    </div>
</div>

<!-- Dual Corner Promotional Popups -->
<?php 
$popup_page = get_page_by_path('popup-settings');
$popup_id   = $popup_page ? $popup_page->ID : 0;

// Right Popup Data
$show_right  = get_field('enable_right_popup', $popup_id);
$img_right   = get_field('right_popup_image', $popup_id);
$url_right   = get_field('right_popup_link', $popup_id);

// Left Popup Data
$show_left   = get_field('enable_left_popup', $popup_id);
$img_left    = get_field('left_popup_image', $popup_id);
$url_left    = get_field('left_popup_link', $popup_id);
?>

<!-- Right Popup Layout -->
<?php if ( $show_right && $img_right && $url_right ) : ?>
<div id="popupRight" class="sharji-corner-popup popup-right">
    <button type="button" class="sharji-popup-close" onclick="closeCornerPopup('popupRight')"><i class="fas fa-times"></i></button>
    <a href="<?php echo esc_url($url_right); ?>" target="_blank" rel="noopener noreferrer" class="sharji-popup-link">
        <img src="<?php echo esc_url(wp_get_attachment_image_url($img_right, 'medium_large')); ?>" alt="تبلیغات">
    </a>
</div>
<?php endif; ?>

<!-- Left Popup Layout -->
<?php if ( $show_left && $img_left && $url_left ) : ?>
<div id="popupLeft" class="sharji-corner-popup popup-left">
    <button type="button" class="sharji-popup-close" onclick="closeCornerPopup('popupLeft')"><i class="fas fa-times"></i></button>
    <a href="<?php echo esc_url($url_left); ?>" target="_blank" rel="noopener noreferrer" class="sharji-popup-link">
        <img src="<?php echo esc_url(wp_get_attachment_image_url($img_left, 'medium_large')); ?>" alt="تبلیغات">
    </a>
</div>
<?php endif; ?>

<?php get_footer(); ?>
