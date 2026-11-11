<?php get_header(); ?>

<style>
    /* تنظیمات کلی بدنه سایت */
    .site-main-wrapper {
        max-width: 1920px !important; margin: 0 auto !important; width: 100% !important;
        padding: 0 40px !important; direction: rtl !important; background: #f8fafc;
    }

    /* استایل باکس محتوا */
    .main-card-container { background: #fff; border-radius: 12px; border: 1px solid #e2e8f0; overflow: hidden; min-height: 500px; }
    .content-area { padding: 40px 50px; }
    
    .yekan-bold { font-family: 'Diba', 'Vazirmatn', sans-serif !important; font-weight: 900; }
    .entry-content { font-family: 'Vazirmatn', sans-serif; font-size: 17px; line-height: 1.9; color: #334155; text-align: justify; }

    /* --- بخش طلایی: نابود کردن باکس سفید تبلیغات --- */
    #index-clean-ads {
        width: 100% !important;
        display: flex !important;
        flex-direction: column !important;
        align-items: center !important;
        background: transparent !important;
    }

    /* حذف پس‌زمینه از تمام زیرمجموعه‌های ابزارک */
    #index-clean-ads, 
    #index-clean-ads *, 
    #index-clean-ads .widget, 
    #index-clean-ads aside, 
    #index-clean-ads div, 
    #index-clean-ads section {
        background-color: transparent !important;
        background: transparent !important;
        border: none !important;
        box-shadow: none !important;
        padding: 0 !important;
        outline: none !important;
    }

    /* تراز کردن لینک و عکس در وسط */
    #index-clean-ads a {
        display: block !important;
        margin: 0 auto 25px auto !important;
        width: fit-content !important;
    }

    #index-clean-ads img {
        display: block !important;
        max-width: 100% !important;
        height: auto !important;
        margin: 0 auto !important;
        border-radius: 12px !important;
        float: none !important;
    }

    /* مخفی کردن عناوین ابزارک تبلیغ */
    #index-clean-ads .widget-title, 
    #index-clean-ads h2, 
    #index-clean-ads h3 {
        display: none !important;
    }

    /* جایگزین‌های Tailwind */
    .flex { display: flex; }
    .flex-col { flex-direction: column; }
    .items-center { align-items: center; }
    .justify-between { justify-content: space-between; }
    .gap-3 { gap: 12px; }
    .gap-8 { gap: 32px; }
    .w-full { width: 100%; }
    .h-32 { height: 128px; }
    .h-full { height: 100%; }
    .object-cover { object-fit: cover; }
    .overflow-hidden { overflow: hidden; }
    .sticky { position: sticky; top: 32px; }
    .rounded-lg { border-radius: 8px; }
    .rounded-2xl { border-radius: 16px; }
    .border { border: 1px solid #e2e8f0; }
    .border-b { border-bottom: 1px solid #f1f5f9; }
    .border-slate-50 { border-color: #f8fafc; }
    .border-slate-100 { border-color: #f1f5f9; }
    .border-slate-200 { border-color: #e2e8f0; }
    .bg-white { background-color: #fff; }
    .bg-red-700 { background-color: #b91c1c; }
    .bg-slate-100 { background-color: #f1f5f9; }
    .text-white { color: #fff; }
    .text-slate-500 { color: #64748b; }
    .text-slate-800 { color: #1e293b; }
    .text-yellow-400 { color: #facc15; }
    .text-blue-900 { color: #1e3a8a; }
    .font-bold { font-weight: bold; }
    .text-sm { font-size: 14px; }
    .text-2xl { font-size: 24px; }
    .text-\[12px\] { font-size: 12px; }
    .text-\[14px\] { font-size: 14px; }
    .leading-5 { line-height: 1.25rem; }
    .leading-6 { line-height: 1.5rem; }
    .leading-tight { line-height: 1.25; }
    .mb-8 { margin-bottom: 32px; }
    .p-4 { padding: 16px; }
    .pb-4 { padding-bottom: 16px; }
    .transition { transition: all 0.3s; }
    .transition-all { transition: all 0.3s; }
    .transition-colors { transition: color 0.3s; }
    .transition-transform { transition: transform 0.5s; }
    .hover\:bg-slate-50:hover { background-color: #f8fafc; }
    .hover\:text-red-700:hover { color: #b91c1c; }
    .line-clamp-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
    .shadow-sm { box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05); }
    .group:hover .group-hover\:scale-105 { transform: scale(1.05); }
    .group:hover .group-hover\:text-red-700 { color: #b91c1c; }

    @media (max-width: 1024px) {
        .site-main-wrapper { padding: 0 !important; background: #fff; }
        .main-card-container { border: none; border-radius: 0; }
        .content-area { padding: 25px 15px; }
    }

    @media (min-width: 1025px) {
        .lg\:w-\[75\%\] { width: 75%; }
        .lg\:w-\[25\%\] { width: 25%; }
        .lg\:flex-row { flex-direction: row; }
        .lg\:py-12 { padding-top: 48px; padding-bottom: 48px; }
        .md\:text-3xl { font-size: 30px; }
    }

    @media (min-width: 769px) {
        .md\:text-3xl { font-size: 30px; }
    }
</style>

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

<script>
    // باز کردن تمام لینک‌های تبلیغات در تب جدید
    document.addEventListener('DOMContentLoaded', function() {
        const adLinks = document.querySelectorAll('#index-clean-ads a');
        adLinks.forEach(link => {
            link.setAttribute('target', '_blank');
            link.setAttribute('rel', 'noopener noreferrer');
        });
    });
</script>

<?php get_footer(); ?>