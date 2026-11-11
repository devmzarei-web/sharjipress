<?php get_header(); ?>


<div class="archive-main-wrapper">
    <main class="py-8 lg:py-12"> 
        <div class="flex flex-col lg:flex-row gap-10">
            
            <div class="w-full lg:w-[75%]">
                
                <?php
                $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
                $sort = isset($_GET['sort']) ? $_GET['sort'] : 'newest';
                
                $args = [
                    'post_status' => 'publish',
                    'posts_per_page' => 10,
                    'paged' => $paged,
                ];

                $obj = get_queried_object();
                if ( is_category() ) {
                    $args['cat'] = $obj->term_id;
                } elseif ( is_tag() ) {
                    $args['tag_id'] = $obj->term_id;
                } elseif ( is_search() ) {
                    $args['s'] = get_search_query();
                } elseif ( is_author() ) {
                    $args['author'] = $obj->ID;
                }

                if ($sort == 'oldest') {
                    $args['order'] = 'ASC';
                    $args['orderby'] = 'date';
                } elseif ($sort == 'views') {
                    $args['meta_key'] = 'post_views_count'; 
                    $args['orderby'] = 'meta_value_num';
                    $args['order'] = 'DESC';
                } else {
                    $args['order'] = 'DESC';
                    $args['orderby'] = 'date';
                }

                $the_query = new WP_Query($args);
                ?>

                <div class="archive-meta-box shadow-sm">
                    <h1 class="archive-title">
                        <?php 
                            if(is_category()){ single_cat_title(); } 
                            elseif(is_tag()){ single_tag_title('برچسب: '); } 
                            elseif(is_search()){ echo 'نتایج: ' . get_search_query(); } 
                            else { echo 'آرشیو مطالب'; }
                        ?>
                        <span class="text-xs text-gray-400 font-normal mr-2">(<?php echo $the_query->found_posts; ?> مورد)</span>
                    </h1>
                    
                    <form method="get" id="sortForm">
                        <select name="sort" class="sort-select" onchange="document.getElementById('sortForm').submit()">
                            <option value="newest" <?php selected($sort, 'newest'); ?>>جدیدترین</option>
                            <option value="oldest" <?php selected($sort, 'oldest'); ?>>قدیمی‌ترین</option>
                            <option value="views" <?php selected($sort, 'views'); ?>>پربازدیدترین</option>
                        </select>
                    </form>
                </div>

                <?php if ( $the_query->have_posts() ) : ?>
                    <div class="archive-list-container">
                        <?php while ( $the_query->have_posts() ) : $the_query->the_post(); 
                            $icon_html = '';
                            if (has_category('video') || has_category('multimedia')) {
                                $icon_html = '<div class="type-badge"><i class="fas fa-play"></i></div>';
                            } elseif (has_category('image')) {
                                $icon_html = '<div class="type-badge"><i class="fas fa-camera"></i></div>';
                            }
                        ?>
                        <a href="<?php the_permalink(); ?>" class="news-list-item">
                            <div class="list-thumb">
                                <?php if(has_post_thumbnail()): ?>
                                    <?php the_post_thumbnail('medium', ['class' => 'w-full h-full object-cover']); ?>
                                <?php else: ?>
                                    <img src="<?php echo get_template_directory_uri(); ?>/images/default.jpg" class="w-full h-full object-cover bg-gray-200">
                                <?php endif; ?>
                                <?php echo $icon_html; ?>
                            </div>
                            
                            <div class="list-body">
                                <h3 class="list-title"><?php the_title(); ?></h3>
                                <div class="list-excerpt">
                                    <?php echo wp_trim_words(get_the_excerpt(), 25, '...'); ?>
                                </div>
                                <div class="list-meta">
                                    <span><i class="far fa-clock ml-1 text-red-500"></i><?php echo get_the_date('j F Y'); ?></span>
                                    <?php if(function_exists('get_post_views')): ?>
                                        <span><i class="far fa-eye ml-1 text-blue-500"></i><?php echo get_post_views(get_the_ID()); ?></span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </a>
                        <?php endwhile; ?>
                    </div>

                    <div class="pagination-bar">
                        <?php
                        echo paginate_links(array(
                            'base' => str_replace(999999999, '%#%', esc_url(get_pagenum_link(999999999))),
                            'format' => '?paged=%#%',
                            'current' => max(1, get_query_var('paged')),
                            'total' => $the_query->max_num_pages,
                            'prev_text' => '<i class="fas fa-chevron-right"></i>',
                            'next_text' => '<i class="fas fa-chevron-left"></i>',
                        ));
                        ?>
                    </div>
                    <?php wp_reset_postdata(); ?>

                <?php else : ?>
                    <div class="bg-white p-12 text-center rounded-xl border border-dashed border-gray-300">
                        <i class="fas fa-search text-4xl text-gray-300 mb-4 block"></i>
                        <p class="text-gray-500 font-bold">موردی یافت نشد.</p>
                        <?php if($sort == 'views'): ?>
                            <p class="text-xs text-red-400 mt-2">توجه: اخبار تنها پس از اولین بازدید در این لیست نمایش داده می‌شوند.</p>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="w-full lg:w-[25%]">
                <div class="sticky flex flex-col gap-6">
                    
                    <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-sm">
                        <div class="bg-[#0056b3] text-white p-4 font-bold text-sm flex justify-between items-center">
                            <span>پیشنهاد شرجی</span><i class="fas fa-star text-yellow-400"></i>
                        </div>
                        <?php 
                        $editor_cache = wp_cache_get('editor_picks_sidebar', 'sidebar');
                        if (false === $editor_cache) {
                            $sticky = get_option('sticky_posts');
                            $args = !empty($sticky) ? ['posts_per_page' => 3, 'post__in' => $sticky, 'ignore_sticky_posts' => 1] : ['posts_per_page' => 3, 'orderby' => 'rand'];
                            $editor_query = new WP_Query($args);
                            $editor_cache = $editor_query->posts;
                            wp_cache_set('editor_picks_sidebar', $editor_cache, 'sidebar', 2 * HOUR_IN_SECONDS);
                        }
                        if ($editor_cache) :
                            foreach ($editor_cache as $post) : setup_postdata($post); ?>
                                <a href="<?php the_permalink(); ?>" class="flex flex-col gap-3 p-4 border-b border-slate-50 hover:bg-slate-50 transition-all group" style="display: flex; flex-direction: column; gap: 12px; padding: 16px; border-bottom: 1px solid #f8fafc; text-decoration: none;">
                                    <div class="w-full h-32 overflow-hidden rounded-lg bg-slate-100">
                                        <?php if (has_post_thumbnail()) : the_post_thumbnail('medium', ['class' => 'w-full h-full object-cover group-hover:scale-105 transition-transform']); endif; ?>
                                    </div>
                                    <h4 class="text-[13px] font-bold text-slate-800 leading-6 group-hover:text-red-700 transition-colors"><?php the_title(); ?></h4>
                                </a>
                            <?php endforeach; wp_reset_postdata(); 
                        endif; ?>
                    </div>

                    <?php if ( is_active_sidebar( 'single-sidebar' ) ) : ?>
                        <div id="sidebar-ads" class="sidebar-ad-container">
                            <?php dynamic_sidebar( 'single-sidebar' ); ?>
                        </div>
                    <?php endif; ?>

                    <?php if ( is_active_sidebar( 'single-sidebar-2' ) ) : ?>
                        <div id="sidebar-ads-2" class="sidebar-ad-container">
                            <?php dynamic_sidebar( 'single-sidebar-2' ); ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

        </div>
    </main>
</div>

<?php get_footer(); ?>
