<?php get_header(); ?>

<style>
    /* 1. LAYOUT CONTAINER */
    .archive-main-wrapper {
        max-width: 1920px;
        margin: 0 auto;
        width: 100%;
        padding: 0 40px !important;
        direction: rtl;
        box-sizing: border-box;
    }

    /* 2. ARCHIVE HEADER */
    .archive-meta-box {
        background: #fff;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        padding: 15px 20px;
        margin-bottom: 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-right: 5px solid #0056b3;
    }
    .archive-title { font-family: 'Diba', sans-serif; font-size: 1.4rem; color: #1e293b; margin: 0; }
    
    .sort-select {
        background: #f8fafc;
        border: 1px solid #cbd5e1;
        border-radius: 6px;
        padding: 5px 10px;
        font-size: 0.85rem;
        color: #64748b;
        outline: none;
        cursor: pointer;
        font-family: 'Vazirmatn', sans-serif;
    }

    /* 3. NEWS LIST ITEMS */
    .archive-list-container {
        display: flex;
        flex-direction: column;
        gap: 10px; 
    }

    .news-list-item {
        display: flex;
        background: #fff;
        border: 1px solid #f1f5f9; 
        border-radius: 10px;
        overflow: hidden;
        height: 110px; 
        text-decoration: none !important;
        transition: 0.2s all;
        align-items: center;
        padding-left: 15px;
    }
    .news-list-item:hover {
        background: #fff;
        border-color: #0056b3;
        transform: translateX(-5px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.03);
    }

    .list-thumb {
        width: 160px; 
        height: 100%; 
        flex-shrink: 0;
        position: relative;
        margin-left: 20px;
    }
    .list-thumb img { width: 100%; height: 100%; object-fit: cover; }

    .list-body {
        flex-grow: 1;
        display: flex;
        flex-direction: column;
        justify-content: center;
        height: 100%;
        padding: 10px 0;
    }

    .list-title {
        font-family: 'Diba', sans-serif;
        font-size: 1.1rem;
        color: #1e293b;
        line-height: 1.6;
        margin-bottom: 8px;
        font-weight: bold;
        display: -webkit-box;
        -webkit-line-clamp: 2; 
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .news-list-item:hover .list-title { color: #0056b3; }

    .list-excerpt {
        font-size: 0.8rem;
        color: #64748b;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        margin-bottom: 8px;
    }

    .list-meta {
        font-size: 0.75rem;
        color: #94a3b8;
        display: flex;
        gap: 15px;
        font-family: 'Vazirmatn', sans-serif;
    }

    /* 4. SIDEBAR AD FIX */
    .sidebar-ad-container {
        width: 100%;
        margin-bottom: 25px;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    
    .sidebar-ad-container .widget, 
    .sidebar-ad-container .widget_media_image,
    .sidebar-ad-container div {
        margin: 0 !important;
        padding: 0 !important;
        border: none !important;
        background: transparent !important;
        box-shadow: none !important;
        width: 100%;
    }
    
    .sidebar-ad-container img {
        width: 100% !important;
        height: auto !important;
        border-radius: 16px !important;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        display: block;
        margin: 0 auto;
        transition: transform 0.3s;
    }
    .sidebar-ad-container img:hover {
        transform: translateY(-3px);
    }

    /* Pagination */
    .pagination-bar { margin-top: 40px; display: flex; justify-content: center; gap: 5px; }
    .page-numbers {
        width: 38px; height: 38px;
        display: flex; align-items: center; justify-content: center;
        background: #fff; border: 1px solid #cbd5e1; border-radius: 8px;
        color: #64748b; font-weight: bold; font-size: 0.95rem; text-decoration: none;
        transition: 0.2s;
    }
    .page-numbers.current, .page-numbers:hover { background: #0056b3; color: #fff; border-color: #0056b3; }

    .type-badge {
        position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);
        background: rgba(0,0,0,0.5); color: white;
        width: 32px; height: 32px; border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-size: 14px; border: 1px solid rgba(255,255,255,0.6);
    }

    /* Tailwind Replacements */
    .flex { display: flex; }
    .flex-col { flex-direction: column; }
    .items-center { align-items: center; }
    .justify-center { justify-content: center; }
    .justify-between { justify-content: space-between; }
    .gap-2 { gap: 8px; }
    .gap-3 { gap: 12px; }
    .gap-5 { gap: 20px; }
    .gap-6 { gap: 24px; }
    .gap-10 { gap: 40px; }
    .gap-15 { gap: 60px; }
    .w-full { width: 100%; }
    .h-full { height: 100%; }
    .h-32 { height: 128px; }
    .object-cover { object-fit: cover; }
    .overflow-hidden { overflow: hidden; }
    .relative { position: relative; }
    .absolute { position: absolute; }
    .top-50 { top: 50%; }
    .left-50 { left: 50%; }
    .sticky { position: sticky; top: 32px; }
    .rounded-lg { border-radius: 8px; }
    .rounded-xl { border-radius: 12px; }
    .rounded-2xl { border-radius: 16px; }
    .rounded-full { border-radius: 9999px; }
    .border { border: 1px solid #e2e8f0; }
    .border-b { border-bottom: 1px solid #f8fafc; }
    .border-slate-50 { border-color: #f8fafc; }
    .border-slate-200 { border-color: #e2e8f0; }
    .border-dashed { border-style: dashed; }
    .border-gray-300 { border-color: #d1d5db; }
    .border-red-600 { border-color: #dc2626; }
    .bg-white { background-color: #fff; }
    .bg-slate-100 { background-color: #f1f5f9; }
    .bg-\[\#0056b3\] { background-color: #0056b3; }
    .bg-gray-200 { background-color: #e5e7eb; }
    .text-white { color: #fff; }
    .text-slate-800 { color: #1e293b; }
    .text-gray-400 { color: #9ca3af; }
    .text-gray-500 { color: #6b7280; }
    .text-blue-500 { color: #3b82f6; }
    .text-red-400 { color: #f87171; }
    .text-red-500 { color: #ef4444; }
    .text-yellow-400 { color: #facc15; }
    .text-4xl { font-size: 2.25rem; }
    .text-xs { font-size: 12px; }
    .text-sm { font-size: 14px; }
    .text-\[13px\] { font-size: 13px; }
    .font-bold { font-weight: bold; }
    .font-normal { font-weight: 400; }
    .leading-6 { line-height: 1.5rem; }
    .mb-4 { margin-bottom: 16px; }
    .mb-8 { margin-bottom: 32px; }
    .mt-2 { margin-top: 8px; }
    .mt-4 { margin-top: 16px; }
    .ml-1 { margin-left: 4px; }
    .mr-2 { margin-right: 8px; }
    .p-4 { padding: 16px; }
    .p-12 { padding: 48px; }
    .text-center { text-align: center; }
    .block { display: block; }
    .shadow-sm { box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05); }
    .transition { transition: all 0.3s; }
    .transition-all { transition: all 0.3s; }
    .transition-colors { transition: color 0.3s; }
    .transition-transform { transition: transform 0.5s; }
    .hover\:bg-slate-50:hover { background-color: #f8fafc; }
    .hover\:text-red-700:hover { color: #b91c1c; }
    .group:hover .group-hover\:scale-105 { transform: scale(1.05); }
    .group:hover .group-hover\:text-red-700 { color: #b91c1c; }

    @media (max-width: 1024px) {
        .archive-main-wrapper { padding: 0 20px !important; }
    }
    @media (max-width: 640px) {
        .archive-main-wrapper { padding: 0 15px !important; }
        .list-thumb { width: 110px; margin-left: 10px; } 
        .list-excerpt { display: none; } 
        .news-list-item { height: 90px; }
        .list-title { font-size: 0.95rem; }
    }

    @media (min-width: 1025px) {
        .lg\:w-\[75\%\] { width: 75%; }
        .lg\:w-\[25\%\] { width: 25%; }
        .lg\:flex-row { flex-direction: row; }
        .lg\:py-12 { padding-top: 48px; padding-bottom: 48px; }
    }
</style>

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