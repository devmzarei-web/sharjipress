<?php
/*
Template Name: Publishing Guide (راهنمای انتشار)
*/
get_header(); 
?>

<style>
    /* فونت‌ها و متغیرها */
    @font-face { font-family: 'Diba'; src: url('<?php echo get_template_directory_uri(); ?>/fonts/Diba.woff2') format('woff2'); font-weight: bold; }
    
    .yekan-bold { font-family: 'Diba', sans-serif !important; font-weight: 900; }
    .brand-accent { color: #0056b3; font-weight: bold; }

    /* تنظیمات لی‌اوت اصلی */
    .site-main-wrapper {
        max-width: 1920px !important; margin: 0 auto !important; width: 100% !important;
        padding: 0 40px !important; direction: rtl !important; background: #f8fafc;
    }

    /* باکس اصلی محتوا */
    .main-card-container { background: #fff; border-radius: 12px; border: 1px solid #e2e8f0; overflow: hidden; }
    .content-area { padding: 50px; }

    /* استایل لیست قوانین */
    .rules-list { list-style: none; counter-reset: rule-counter; padding: 0; }
    .rules-list li {
        position: relative;
        padding-right: 50px;
        margin-bottom: 25px;
        font-size: 16px;
        line-height: 2;
        color: #334155;
    }
    .rules-list li::before {
        counter-increment: rule-counter;
        content: counter(rule-counter);
        position: absolute;
        right: 0; top: 0;
        width: 35px; height: 35px;
        background: #f1f5f9;
        color: #0056b3;
        border-radius: 50%;
        text-align: center;
        line-height: 35px;
        font-weight: bold;
        font-family: 'Diba', sans-serif;
        border: 2px solid #e2e8f0;
    }
    .rules-list li strong { color: #1e293b; font-size: 17px; margin-left: 5px; }

    /* باکس‌های هشدار و توجه */
    .notice-box {
        background: #fff7ed; border-right: 4px solid #f97316;
        padding: 20px; border-radius: 8px; margin: 30px 0;
        color: #9a3412; font-size: 15px; line-height: 1.8;
    }
    .law-box {
        background: #f0fdf4; border: 1px dashed #22c55e;
        padding: 25px; border-radius: 12px; margin-top: 40px;
        text-align: center;
    }
    
    .section-title {
        font-family: 'Diba', sans-serif; font-size: 22px; color: #1e293b; 
        margin-top: 45px; margin-bottom: 25px; display: flex; align-items: center; gap: 12px;
        border-bottom: 1px solid #f1f5f9; padding-bottom: 12px;
    }
    .section-title i { color: #e31e24; }

    /* استایل‌های سایدبار */
    .dynamic-widgets-container { width: 100%; display: flex; flex-direction: column; gap: 25px; }
    .dynamic-widgets-container .widget, .dynamic-widgets-container aside { background: transparent !important; border: none !important; padding: 0 !important; margin: 0 !important; box-shadow: none !important; display: block !important; }
    .dynamic-widgets-container img { width: 100% !important; height: auto !important; display: block !important; border-radius: 12px; transition: all 0.3s ease; }
    .dynamic-widgets-container img:hover { transform: translateY(-5px); filter: brightness(1.05); }

    /* Tailwind Replacements */
    .flex { display: flex; }
    .flex-col { flex-direction: column; }
    .items-center { align-items: center; }
    .justify-between { justify-content: space-between; }
    .gap-2 { gap: 8px; }
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
    .bg-\[\#0056b3\] { background-color: #0056b3; }
    .bg-slate-100 { background-color: #f1f5f9; }
    .text-white { color: #fff; }
    .text-slate-500 { color: #64748b; }
    .text-slate-600 { color: #4b5563; }
    .text-slate-800 { color: #1e293b; }
    .text-yellow-400 { color: #facc15; }
    .font-bold { font-weight: bold; }
    .text-sm { font-size: 14px; }
    .text-lg { font-size: 18px; }
    .text-3xl { font-size: 30px; }
    .text-\[14px\] { font-size: 14px; }
    .leading-6 { line-height: 1.5rem; }
    .leading-loose { line-height: 2; }
    .mb-2 { margin-bottom: 8px; }
    .mb-3 { margin-bottom: 12px; }
    .mb-4 { margin-bottom: 16px; }
    .mb-6 { margin-bottom: 24px; }
    .mb-10 { margin-bottom: 40px; }
    .ml-2 { margin-left: 8px; }
    .ml-5 { margin-left: 20px; }
    .p-4 { padding: 16px; }
    .pb-3 { padding-bottom: 12px; }
    .pb-8 { padding-bottom: 32px; }
    .text-center { text-align: center; }
    .text-justify { text-align: justify; }
    .shadow-sm { box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05); }
    .transition { transition: all 0.3s; }
    .transition-all { transition: all 0.3s; }
    .transition-colors { transition: color 0.3s; }
    .transition-transform { transition: transform 0.5s; }
    .hover\:bg-slate-50:hover { background-color: #f8fafc; }
    .hover\:text-red-700:hover { color: #b91c1c; }
    .group:hover .group-hover\:scale-105 { transform: scale(1.05); }
    .group:hover .group-hover\:text-red-700 { color: #b91c1c; }
    .block { display: block; }

    @media (max-width: 1024px) {
        .site-main-wrapper { padding: 0 !important; background: #fff; }
        .content-area { padding: 25px 15px; }
        .main-card-container { border: none; border-radius: 0; }
    }

    @media (min-width: 769px) {
        .md\:text-4xl { font-size: 36px; }
        .md\:text-base { font-size: 16px; }
    }

    @media (min-width: 1025px) {
        .lg\:w-\[75\%\] { width: 75%; }
        .lg\:w-\[25\%\] { width: 25%; }
        .lg\:flex-row { flex-direction: row; }
        .lg\:py-12 { padding-top: 48px; padding-bottom: 48px; }
    }
</style>

<div class="site-main-wrapper">
    <main class="py-6 lg:py-12">
        <div class="flex flex-col lg:flex-row gap-8">
            
            <div class="w-full lg:w-[75%]">
                <article class="main-card-container shadow-sm">
                    <div class="content-area">
                        <header class="text-center mb-10 border-b border-slate-100 pb-8">
                            <h1 class="yekan-bold text-3xl md:text-4xl text-slate-800 mb-4">
                                راهنمای انتشار و <span class="brand-accent">اخلاق حرفه‌ای</span>
                            </h1>
                            <p class="text-slate-500 text-sm md:text-base">منشور اخلاقی و قوانین فعالیت در خبرگزاری شرجی پرس</p>
                        </header>

                        <div class="text-justify leading-loose text-slate-600">
                            <p class="mb-6">
                                خبرگزاری <strong>شرجی پرس</strong> به عنوان یک رسانه مستقل، خود را ملزم به رعایت قوانین جمهوری اسلامی ایران و اصول حرفه‌ای روزنامه‌نگاری می‌داند. تمامی محتوای منتشر شده در این پایگاه خبری بر اساس چارچوب‌های زیر تنظیم و منتشر می‌شوند.
                            </p>

                            <h2 class="section-title"><i class="fas fa-balance-scale"></i> اصول کلی انتشار خبر</h2>
                            <ul class="rules-list">
                                <li><strong>صحت و دقت:</strong> انتشار اخبار موثق و پرهیز از شایعه‌پراکنی خط قرمز ماست. تمامی اخبار قبل از انتشار از منابع رسمی راستی‌آزمایی می‌شوند.</li>
                                <li><strong>رعایت حریم خصوصی:</strong> نام و تصویر متهمان، قربانیان حوادث و کودکان بدون مجوز قانونی یا قضایی منتشر نخواهد شد.</li>
                                <li><strong>بی‌طرفی:</strong> شرجی پرس تریبون هیچ حزب یا جناح سیاسی خاصی نیست و اخبار را بدون جهت‌گیری شخصی منتشر می‌کند.</li>
                                <li><strong>ذکر منبع:</strong> استفاده از مطالب سایر رسانه‌ها تنها با ذکر نام منبع و رعایت حقوق کپی‌رایت انجام می‌شود.</li>
                            </ul>

                            <div class="notice-box">
                                <i class="fas fa-exclamation-triangle ml-2"></i>
                                <strong>سلب مسئولیت:</strong> مسئولیت صحت اخبار نقل شده از سایر خبرگزاری‌ها بر عهده منبع ذکر شده در خبر است و شرجی پرس تنها بازنشر کننده آن می‌باشد.
                            </div>

                            <h2 class="section-title"><i class="fas fa-comments"></i> قوانین بخش نظرات کاربران</h2>
                            <p class="mb-4 text-sm">انتشار نظرات کاربران به معنای تایید محتوای آن توسط شرجی پرس نیست. نظرات حاوی موارد زیر تایید نخواهند شد:</p>
                            <ul class="rules-list">
                                <li>توهین به مقدسات، مقامات عالی‌رتبه کشور و ادیان رسمی.</li>
                                <li>استفاده از الفاظ رکیک، تهمت، افترا و نشر اکاذیب علیه اشخاص حقیقی و حقوقی.</li>
                                <li>مطالبی که باعث ایجاد تفرقه قومیتی، مذهبی یا نژادی شود.</li>
                                <li>تبلیغات تجاری غیرمرتبط و لینک‌های مشکوک.</li>
                            </ul>

                            <h2 class="section-title"><i class="fas fa-camera"></i> ارسال خبر توسط شهروند خبرنگار</h2>
                            <p class="mb-4">مخاطبان گرامی می‌توانند گزارش‌ها، تصاویر و ویدیوهای خبری خود را برای ما ارسال کنند. این محتوا پس از بررسی و تایید سردبیر با نام ارسال‌کننده منتشر خواهد شد.</p>
                            
                            <div class="law-box">
                                <i class="fas fa-gavel text-3xl text-green-600 mb-3 block" style="font-size: 30px; color: #16a34a; margin-bottom: 12px;"></i>
                                <strong class="block text-slate-800 text-lg mb-2" style="display: block; color: #1e293b; font-size: 18px; margin-bottom: 8px;">قانون مطبوعات</strong>
                                <p class="text-sm text-slate-500" style="font-size: 14px; color: #64748b;">تمامی فعالیت‌های این وب‌سایت تابع قوانین و مقررات جمهوری اسلامی ایران و قانون مطبوعات می‌باشد.</p>
                            </div>
                        </div>
                    </div>
                </article>
            </div>

            <div class="w-full lg:w-[25%]">
                <div class="sticky flex flex-col gap-8">
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
                                <a href="<?php echo get_permalink($post->ID); ?>" class="flex flex-col gap-3 p-4 border-b border-slate-50 hover:bg-slate-50 transition-all group">
                                    <div class="w-full h-32 overflow-hidden rounded-lg bg-slate-100">
                                        <?php echo get_the_post_thumbnail($post->ID, 'medium', ['class' => 'w-full h-full object-cover group-hover:scale-105 transition-transform']); ?>
                                    </div>
                                    <h4 class="text-[14px] font-bold text-slate-800 leading-6 group-hover:text-red-700 transition-colors"><?php echo get_the_title($post->ID); ?></h4>
                                </a>
                            <?php endforeach; wp_reset_postdata(); 
                        endif; ?>
                    </div>

                    <?php if ( is_active_sidebar( 'single-sidebar' ) ) : ?>
                        <div class="dynamic-widgets-container">
                            <?php dynamic_sidebar( 'single-sidebar' ); ?>
                        </div>
                    <?php endif; ?>
                    
                    <?php if ( is_active_sidebar( 'single-sidebar-2' ) ) : ?>
                        <div class="dynamic-widgets-container">
                            <?php dynamic_sidebar( 'single-sidebar-2' ); ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

        </div>
    </main>
</div>

<?php get_footer(); ?>