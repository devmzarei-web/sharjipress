<?php
/*
Template Name: Publishing Guide (راهنمای انتشار)
*/
get_header(); 
?>

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
