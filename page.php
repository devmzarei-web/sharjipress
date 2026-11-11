<?php get_header(); ?>

<div class="site-main-wrapper">
    <main class="py-6 lg:py-12">
        <div class="flex flex-col lg:flex-row gap-8">
            
            <div class="w-full lg:w-[75%]">
                <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
                <article class="main-card-container shadow-sm">
                    <div class="content-area">
                        <h1 class="yekan-bold text-2xl md:text-3xl mb-8 pb-4 border-b border-slate-100 text-blue-900 leading-tight">
                            <?php the_title(); ?>
                        </h1>

                        <div class="entry-content">
                            <?php the_content(); ?>
                        </div>
                    </div>
                </article>
                <?php endwhile; endif; ?>
            </div>

            <div class="w-full lg:w-[25%]">
                <div class="sticky flex flex-col gap-8">
                    
                    <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-sm">
                        <div class="bg-red-700 text-white p-4 yekan-bold text-sm flex justify-between items-center">
                            <span>پیشنهاد شرجی</span>
                            <i class="fas fa-star text-yellow-400"></i>
                        </div>
                        
                        <?php 
                        $sticky = get_option('sticky_posts');
                        $args = ['posts_per_page' => 3, 'post__in' => $sticky, 'ignore_sticky_posts' => 1];
                        if (empty($sticky)) { $args = ['posts_per_page' => 3, 'orderby' => 'rand']; }
                        
                        $editor_query = new WP_Query($args);
                        while($editor_query->have_posts()) : $editor_query->the_post(); ?>
                            <a href="<?php the_permalink(); ?>" class="flex flex-col gap-3 p-4 border-b border-slate-50 hover:bg-slate-50 transition-all group">
                                <div class="w-full h-32 overflow-hidden rounded-lg bg-slate-100">
                                    <?php if (has_post_thumbnail()) : the_post_thumbnail('medium', ['class' => 'w-full h-full object-cover group-hover:scale-105 transition-transform']); endif; ?>
                                </div>
                                <h4 class="text-[14px] font-bold text-slate-800 leading-6 group-hover:text-red-700 transition-colors">
                                    <?php the_title(); ?>
                                </h4>
                                <p class="text-[12px] text-slate-500 leading-5 line-clamp-2">
                                    <?php echo wp_trim_words(get_the_excerpt(), 18, '...'); ?>
                                </p>
                            </a>
                        <?php endwhile; wp_reset_postdata(); ?>
                    </div>

                    <?php if ( is_active_sidebar( 'single-sidebar' ) ) : ?>
                        <div id="index-clean-ads">
                            <?php dynamic_sidebar( 'single-sidebar' ); ?>
                        </div>
                    <?php endif; ?>

                </div>
            </div>

        </div>
    </main>
</div>

<?php get_footer(); ?>
