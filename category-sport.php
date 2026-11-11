<?php
/**
 * Template Name: Sharji Sport (Final - With Polls)
 * File Name: category-sport.php
 */

get_header('sport'); 
?>



<div class="sport-page-shell">

    <!-- Desktop View -->
    <div class="lg:block hidden">
        <div class="max-w-[1600px] mx-auto px-4 py-6">
            <div class="flex flex-col lg:flex-row gap-6">

                <aside class="w-full lg:w-[25%] order-2 lg:order-1">
                    <div class="sticky top-24 flex flex-col gap-4">
                        
                        <div class="sport-sidebar-box rounded-xl overflow-hidden">
                            <div class="flex border-b border-gray-700 bg-[#161f2f]">
                                <button class="flex-1 py-3 sport-sidebar-heading text-white border-b-2 border-blue-600 bg-gray-800/50">آخرین اخبار</button>
                            </div>
                            <div class="p-4 flex flex-col gap-0 max-h-[400px] overflow-y-auto custom-scrollbar">
                                <?php 
                                $sidebar_news = new WP_Query(['category_name' => 'sport', 'posts_per_page' => 10, 'post__not_in' => [get_the_ID()]]);
                                if($sidebar_news->have_posts()): while($sidebar_news->have_posts()): $sidebar_news->the_post(); 
                                ?>
                                <a href="<?php echo add_query_arg('theme', 'sport', get_permalink()); ?>" class="timeline-item py-4 group -mr-4 pr-9 pl-2 rounded-l-lg block">
                                    <h3 class="sport-mini-title group-hover:text-white transition text-justify pl-2"><?php the_title(); ?></h3>
                                </a>
                                <?php endwhile; endif; wp_reset_postdata(); ?>
                            </div>
                        </div>

                        <div class="sport-sidebar-box rounded-xl overflow-hidden">
                            <div class="flex justify-between items-center border-b border-gray-700 bg-[#161f2f] px-4 py-3">
                                <span class="sport-sidebar-heading">جدول لیگ برتر</span>
                                <a href="<?php echo home_url('/league-table'); ?>" class="text-[10px] text-blue-400 hover:text-white transition">جدول کامل <i class="fas fa-angle-left"></i></a>
                            </div>
                            <div class="p-0">
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
                                    usort($table_data, function($a, $b) {
                                        if ($a['points'] != $b['points']) return $b['points'] - $a['points'];
                                        return $b['diff'] - $a['diff'];
                                    });
                                    $top_teams = array_slice($table_data, 0, 5);
                                }
                                ?>
                                <table class="w-full mini-table">
                                    <thead>
                                        <tr>
                                            <th class="w-6 text-center">#</th>
                                            <th class="text-right">تیم</th>
                                            <th class="text-gray-400 text-center">بازی</th>
                                            <th class="text-green-500/80 text-center">برد</th>
                                            <th class="text-gray-400 text-center">مساوی</th>
                                            <th class="text-red-500/80 text-center">باخت</th>
                                            <th class="text-gray-300 text-center">تفاضل</th>
                                            <th class="text-white font-bold w-10 text-center">امتیاز</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if(!empty($top_teams)): $rank = 1; foreach($top_teams as $team): $diff_color = ($team['diff'] >= 0) ? 'text-green-400' : 'text-red-400'; $diff_sign = ($team['diff'] > 0) ? '+' : ''; ?>
                                        <tr class="hover:bg-gray-800/50 transition">
                                            <td class="text-gray-500 font-bold text-center"><?php echo to_farsi_local($rank++); ?></td>
                                            <td class="text-right">
                                                <div class="flex items-center gap-1.5">
                                                    <?php if($team['logo']): ?>
                                                        <div class="w-5 h-5 bg-white/10 rounded-full p-0.5 flex items-center justify-center shrink-0">
                                                            <img src="<?php echo esc_url($team['logo']); ?>" class="w-full h-full object-contain">
                                                        </div>
                                                    <?php endif; ?>
                                                    <span class="text-gray-200 font-medium truncate max-w-[60px] block"><?php echo esc_html($team['name']); ?></span>
                                                </div>
                                            </td>
                                            <td class="text-gray-400 text-center"><?php echo to_farsi_local($team['played']); ?></td>
                                            <td class="text-gray-300 text-center"><?php echo to_farsi_local($team['won']); ?></td>
                                            <td class="text-gray-400 text-center"><?php echo to_farsi_local($team['drawn']); ?></td>
                                            <td class="text-gray-400 text-center"><?php echo to_farsi_local($team['lost']); ?></td>
                                            <td class="<?php echo $diff_color; ?> text-center"><?php echo to_farsi_local($diff_sign . $team['diff']); ?></td>
                                            <td class="font-black text-white bg-white/5 text-center"><?php echo to_farsi_local($team['points']); ?></td>
                                        </tr>
                                        <?php endforeach; else: ?>
                                            <tr><td colspan="8" class="text-center py-4 text-gray-500">جدول خالی است</td></tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <?php if ( is_active_sidebar( 'sport-sidebar' ) ) : ?>
                            <div id="sport-sidebar-area">
                                <?php dynamic_sidebar( 'sport-sidebar' ); ?>
                            </div>
                        <?php endif; ?>

                        <?php if ( is_active_sidebar( 'sport-ad-sidebar' ) ) : ?>
                            <div id="sport-ad-area">
                                <?php dynamic_sidebar( 'sport-ad-sidebar' ); ?>
                            </div>
                        <?php else: ?>
                            <div class="rounded-xl h-32 flex items-center justify-center text-blue-300/50 border border-blue-700/30" style="background: linear-gradient(135deg, #1e3a8a, #1e40af, #0f172a);">
                                <span class="text-sm font-bold border border-blue-500/30 px-3 py-1 rounded">تبلیغات</span>
                            </div>
                        <?php endif; ?>

                    </div>
                </aside>

                <main class="w-full lg:w-[75%] order-1 lg:order-2 flex flex-col gap-6">

                    <div class="hero-container shadow-2xl">
                        <div class="swiper hero-swiper">
                            <div class="swiper-wrapper">
                                <?php 
                                $hero = new WP_Query(['category_name' => 'sport', 'posts_per_page' => 2]);
                                if($hero->have_posts()): while($hero->have_posts()): $hero->the_post(); 
                                ?>
                                <div class="swiper-slide w-full h-full">
                                    <article class="sport-hero-article flex w-full h-full flex-col md:flex-row bg-[#1e293b] relative group">
                                        <div class="sport-hero-image-wrap w-full md:w-2/3 h-full relative overflow-hidden order-1 md:order-2">
                                            <a href="<?php echo add_query_arg('theme', 'sport', get_permalink()); ?>" class="block w-full h-full">
                                                <?php the_post_thumbnail('large', ['class' => 'w-full h-full object-cover group-hover:scale-105 transition duration-700']); ?>
                                            </a>
                                        </div>
                                        <div class="sport-hero-panel absolute bottom-0 right-0 w-full md:static md:w-1/3 p-6 md:p-10 flex flex-col justify-center order-2 md:order-1 z-10">
                                            <span class="sport-hero-badge"><span></span> تیتر یک ورزش</span>
                                            <h2 class="sport-hero-title">
                                                <a href="<?php echo add_query_arg('theme', 'sport', get_permalink()); ?>" style="color: inherit; text-decoration: none;"><?php the_title(); ?></a>
                                            </h2>
                                            <div class="sport-hero-excerpt hidden md:block"><?php echo get_the_excerpt(); ?></div>
                                            <div class="mt-4 pt-4 border-t border-gray-700 w-full">
                                                <a href="<?php echo add_query_arg('theme', 'sport', get_permalink()); ?>" class="sport-read-more">
                                                    ادامه مطلب <i class="fas fa-arrow-left"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </article>
                                </div>
                                <?php endwhile; endif; wp_reset_postdata(); ?>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <?php 
                        $sub_hero = new WP_Query(['category_name' => 'sport', 'posts_per_page' => 3, 'offset' => 2]);
                        while($sub_hero->have_posts()): $sub_hero->the_post(); 
                        ?>
                        <article class="sport-sub-card rounded-xl overflow-hidden group flex flex-col shadow-lg">
                            <a href="<?php echo add_query_arg('theme', 'sport', get_permalink()); ?>" class="block relative h-48 overflow-hidden">
                                <?php the_post_thumbnail('medium', ['class' => 'w-full h-full object-cover group-hover:scale-110 transition duration-500']); ?>
                            </a>
                            <div class="p-4 flex-1 flex flex-col">
                                <h3 class="sport-card-title line-clamp-2">
                                    <a href="<?php echo add_query_arg('theme', 'sport', get_permalink()); ?>" style="color: inherit; text-decoration: none;"><?php the_title(); ?></a>
                                </h3>
                            </div>
                        </article>
                        <?php endwhile; wp_reset_postdata(); ?>
                    </div>

                    <div class="mt-4">
                        <div class="sport-section-bar">
                            <span class="mark"></span>
                            <h3 class="sport-section-heading">سرخط خبرها</h3>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4">
                            <?php 
                            $main_list = new WP_Query(['category_name' => 'sport', 'posts_per_page' => 10]);
                            while($main_list->have_posts()): $main_list->the_post(); ?>
                            <article class="sport-news-row flex gap-4 p-3 rounded-xl group">
                                <div class="w-24 h-20 flex-shrink-0 rounded-lg overflow-hidden relative">
                                    <?php the_post_thumbnail('thumbnail', ['class' => 'w-full h-full object-cover group-hover:scale-110 transition']); ?>
                                </div>
                                <div class="flex flex-col justify-between py-0.5">
                                    <a href="<?php echo add_query_arg('theme', 'sport', get_permalink()); ?>">
                                        <h3 class="sport-mini-title line-clamp-2"><?php the_title(); ?></h3>
                                    </a>
                                    <span class="sport-time-text">
                                        <?php echo to_farsi_local(human_time_diff(get_the_time('U'), current_time('timestamp'))) . ' پیش'; ?>
                                    </span>
                                </div>
                            </article>
                            <?php endwhile; wp_reset_postdata(); ?>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </div>

    <!-- Mobile View -->
    <div class="lg:hidden sport-mobile-shell">

        <div class="swiper sport-mobile-slider">
            <div class="swiper-wrapper">
                <?php 
                $mobile_hero = new WP_Query(['category_name' => 'sport', 'posts_per_page' => 5, 'ignore_sticky_posts' => 1]);
                if($mobile_hero->have_posts()): while($mobile_hero->have_posts()): $mobile_hero->the_post(); 
                ?>
                <div class="swiper-slide">
                    <a href="<?php echo add_query_arg('theme', 'sport', get_permalink()); ?>" class="sport-mobile-slide-link">
                        <?php the_post_thumbnail('large', ['class' => 'w-full h-full object-cover']); ?>
                        <div class="sport-mobile-caption">
                            <span class="sport-mobile-badge">ورزش</span>
                            <h2 class="sport-mobile-title"><?php the_title(); ?></h2>
                        </div>
                    </a>
                </div>
                <?php endwhile; wp_reset_postdata(); endif; ?>
            </div>
            <div class="swiper-pagination"></div>
        </div>

        <?php if ( is_active_sidebar( 'sport-ad-sidebar' ) ) : ?>
            <div class="sport-mobile-ad">
                <div class="sport-mobile-ad-label">تبلیغات</div>
                <div class="sport-mobile-ad-content">
                    <?php dynamic_sidebar( 'sport-ad-sidebar' ); ?>
                </div>
            </div>
        <?php endif; ?>

        <div class="sport-mobile-tabs">
            <div class="sport-mobile-tab active sport-group-1-tab" onclick="toggleSportTabs(event, 'sport-group1', 'sport-m-latest')" data-slug="latest" data-btn="sport-btn-load-1">آخرین اخبار</div>
            <div class="sport-mobile-tab sport-group-1-tab" onclick="toggleSportTabs(event, 'sport-group1', 'sport-m-table')" data-slug="table" data-btn="sport-btn-load-1">جدول لیگ</div>
        </div>

        <div class="sport-mobile-panel">
            <div id="sport-m-latest" class="sport-mobile-content sport-group1-content">
                <div id="sport-list-latest">
                    <?php 
                    $sport_latest_mobile = new WP_Query(['category_name' => 'sport', 'posts_per_page' => 5, 'ignore_sticky_posts' => 1]);
                    if($sport_latest_mobile->have_posts()): while($sport_latest_mobile->have_posts()): $sport_latest_mobile->the_post(); 
                    ?>
                    <a href="<?php echo add_query_arg('theme', 'sport', get_permalink()); ?>" class="sport-mobile-row">
                        <div class="sport-mobile-thumb">
                            <?php the_post_thumbnail('thumbnail', ['class' => 'w-full h-full object-cover']); ?>
                        </div>
                        <div class="sport-mobile-row-content">
                            <h4 class="sport-mobile-row-title"><?php the_title(); ?></h4>
                            <div class="sport-mobile-row-excerpt"><?php echo wp_trim_words(get_the_excerpt(), 18, '...'); ?></div>
                            <div class="sport-mobile-row-meta"><i class="far fa-clock"></i> <?php echo to_farsi_local(get_the_date('j F Y')); ?></div>
                        </div>
                    </a>
                    <?php endwhile; wp_reset_postdata(); endif; ?>
                </div>
            </div>

            <div id="sport-m-table" class="sport-mobile-content sport-group1-content hidden">
                <div style="padding: 0;">
                    <?php 
                    $teams_query_mobile = new WP_Query(['post_type' => 'league_team', 'posts_per_page' => -1]);
                    $table_data_mobile = [];
                    if($teams_query_mobile->have_posts()) {
                        while($teams_query_mobile->have_posts()) {
                            $teams_query_mobile->the_post();
                            if (!function_exists('get_field')) continue;
                            $played = (int)get_field('played'); $won = (int)get_field('won'); $drawn = (int)get_field('drawn');
                            $lost = (int)get_field('lost'); $deducted = (int)get_field('deducted'); $gf = (int)get_field('gf'); $ga = (int)get_field('ga');
                            $points = ($won * 3) + $drawn - $deducted; $diff = $gf - $ga;
                            $table_data_mobile[] = ['name' => get_the_title(), 'logo' => get_the_post_thumbnail_url(get_the_ID(), 'thumbnail'), 'played' => $played, 'won' => $won, 'drawn' => $drawn, 'lost' => $lost, 'points' => $points, 'diff' => $diff];
                        }
                        wp_reset_postdata();
                        usort($table_data_mobile, function($a, $b) {
                            if ($a['points'] != $b['points']) return $b['points'] - $a['points'];
                            return $b['diff'] - $a['diff'];
                        });
                        $top_teams_mobile = array_slice($table_data_mobile, 0, 8);
                    }
                    ?>
                    <table class="w-full mini-table">
                        <thead>
                            <tr>
                                <th class="w-6 text-center">#</th>
                                <th class="text-right">تیم</th>
                                <th class="text-gray-400 text-center">بازی</th>
                                <th class="text-green-500/80 text-center">برد</th>
                                <th class="text-gray-400 text-center">مساوی</th>
                                <th class="text-red-500/80 text-center">باخت</th>
                                <th class="text-white font-bold w-10 text-center">امتیاز</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(!empty($top_teams_mobile)): $rank_mobile = 1; foreach($top_teams_mobile as $team): ?>
                            <tr>
                                <td class="text-gray-500 font-bold text-center"><?php echo to_farsi_local($rank_mobile++); ?></td>
                                <td class="text-right">
                                    <div class="flex items-center gap-1.5">
                                        <?php if($team['logo']): ?>
                                            <div class="w-5 h-5 bg-white/10 rounded-full p-0.5 flex items-center justify-center shrink-0">
                                                <img src="<?php echo esc_url($team['logo']); ?>" class="w-full h-full object-contain">
                                            </div>
                                        <?php endif; ?>
                                        <span class="text-gray-200 font-medium truncate max-w-[60px] block"><?php echo esc_html($team['name']); ?></span>
                                    </div>
                                </td>
                                <td class="text-gray-400 text-center"><?php echo to_farsi_local($team['played']); ?></td>
                                <td class="text-gray-300 text-center"><?php echo to_farsi_local($team['won']); ?></td>
                                <td class="text-gray-400 text-center"><?php echo to_farsi_local($team['drawn']); ?></td>
                                <td class="text-gray-400 text-center"><?php echo to_farsi_local($team['lost']); ?></td>
                                <td class="font-black text-white bg-white/5 text-center"><?php echo to_farsi_local($team['points']); ?></td>
                            </tr>
                            <?php endforeach; else: ?>
                                <tr><td colspan="7" class="text-center py-4 text-gray-500">جدول خالی است</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="sport-mobile-load-wrap">
                <button id="sport-btn-load-1" onclick="loadMoreSportMobile('sport-btn-load-1', 'sport-group1')" class="sport-mobile-load-btn">
                    <i class="fas fa-plus-circle"></i> مشاهده اخبار بیشتر
                </button>
            </div>
        </div>

        <div class="sport-mobile-tabs">
            <div class="sport-mobile-tab active sport-group-2-tab" onclick="toggleSportTabs(event, 'sport-group2', 'sport-m-headlines')" data-slug="headlines" data-btn="sport-btn-load-2">سرخط خبرها</div>
            <div class="sport-mobile-tab sport-group-2-tab" onclick="toggleSportTabs(event, 'sport-group2', 'sport-m-sidebar')" data-slug="sidebar" data-btn="sport-btn-load-2">خبرهای کوتاه</div>
        </div>

        <div class="sport-mobile-panel">
            <div id="sport-m-headlines" class="sport-mobile-content sport-group2-content">
                <div id="sport-list-headlines">
                    <?php 
                    $sport_headlines_mobile = new WP_Query(['category_name' => 'sport', 'posts_per_page' => 5, 'offset' => 5, 'ignore_sticky_posts' => 1]);
                    if($sport_headlines_mobile->have_posts()): while($sport_headlines_mobile->have_posts()): $sport_headlines_mobile->the_post(); 
                    ?>
                    <a href="<?php echo add_query_arg('theme', 'sport', get_permalink()); ?>" class="sport-mobile-row">
                        <div class="sport-mobile-thumb">
                            <?php the_post_thumbnail('thumbnail', ['class' => 'w-full h-full object-cover']); ?>
                        </div>
                        <div class="sport-mobile-row-content">
                            <h4 class="sport-mobile-row-title"><?php the_title(); ?></h4>
                            <div class="sport-mobile-row-excerpt"><?php echo wp_trim_words(get_the_excerpt(), 18, '...'); ?></div>
                            <div class="sport-mobile-row-meta"><i class="far fa-clock"></i> <?php echo to_farsi_local(get_the_date('j F Y')); ?></div>
                        </div>
                    </a>
                    <?php endwhile; wp_reset_postdata(); endif; ?>
                </div>
            </div>

            <div id="sport-m-sidebar" class="sport-mobile-content sport-group2-content hidden">
                <div id="sport-list-sidebar">
                    <?php 
                    $sport_sidebar_mobile = new WP_Query(['category_name' => 'sport', 'posts_per_page' => 5, 'offset' => 10, 'ignore_sticky_posts' => 1]);
                    if($sport_sidebar_mobile->have_posts()): while($sport_sidebar_mobile->have_posts()): $sport_sidebar_mobile->the_post(); 
                    ?>
                    <a href="<?php echo add_query_arg('theme', 'sport', get_permalink()); ?>" class="sport-mobile-row">
                        <div class="sport-mobile-thumb">
                            <?php the_post_thumbnail('thumbnail', ['class' => 'w-full h-full object-cover']); ?>
                        </div>
                        <div class="sport-mobile-row-content">
                            <h4 class="sport-mobile-row-title"><?php the_title(); ?></h4>
                            <div class="sport-mobile-row-excerpt"><?php echo wp_trim_words(get_the_excerpt(), 18, '...'); ?></div>
                            <div class="sport-mobile-row-meta"><i class="far fa-clock"></i> <?php echo to_farsi_local(get_the_date('j F Y')); ?></div>
                        </div>
                    </a>
                    <?php endwhile; wp_reset_postdata(); endif; ?>
                </div>
            </div>

            <div class="sport-mobile-load-wrap">
                <button id="sport-btn-load-2" onclick="loadMoreSportMobile('sport-btn-load-2', 'sport-group2')" class="sport-mobile-load-btn">
                    <i class="fas fa-plus-circle"></i> مشاهده اخبار بیشتر
                </button>
            </div>
        </div>
    </div>
</div>


<?php get_footer('sport'); ?>
