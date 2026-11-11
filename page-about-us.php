<?php /* Template Name: About Us Page */ ?>

<?php get_header(); ?>

<style>
    /* --- فونت‌ها و متغیرها --- */
    @font-face { font-family: 'Diba'; src: url('<?php echo get_template_directory_uri(); ?>/fonts/Diba.woff2') format('woff2'); font-weight: bold; }
    
    .font-diba { font-family: 'Diba', sans-serif !important; }
    .text-justify-custom { text-align: justify; text-justify: inter-word; }

    /* --- لی‌اوت اصلی --- */
    .site-main-wrapper {
        max-width: 1920px !important; margin: 0 auto !important; width: 100% !important;
        padding: 0 40px !important; direction: rtl !important; background: #f8fafc;
    }

    .main-card-container { background: #fff; border-radius: 12px; border: 1px solid #e2e8f0; overflow: hidden; }
    .content-area { padding: 50px; }

    /* --- انیمیشن --- */
    @keyframes fadeInUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
    .animate-fade-up { animation: fadeInUp 0.6s ease-out forwards; }

    /* --- استایل‌های متن و تیتر --- */
    .about-lead { font-size: 18px; line-height: 2.2; color: #334155; font-weight: 500; margin-bottom: 30px; }
    .section-title { 
        font-family: 'Diba', sans-serif; font-size: 22px; color: #0f172a; 
        margin-top: 40px; margin-bottom: 20px; border-right: 4px solid #e31e24; padding-right: 15px;
    }
    
    /* --- باکس نقل قول ویژه --- */
    .highlight-box {
        background: linear-gradient(135deg, #0056b3 0%, #004494 100%);
        color: #fff; padding: 30px; border-radius: 12px;
        margin: 40px 0; position: relative; overflow: hidden;
        box-shadow: 0 10px 30px rgba(0, 86, 179, 0.2);
    }
    .highlight-box::before {
        content: '\f10d'; font-family: 'Font Awesome 5 Free'; font-weight: 900;
        position: absolute; top: -10px; left: 20px; font-size: 80px; opacity: 0.1; color: #fff;
    }
    .highlight-text { font-size: 19px; line-height: 2; font-weight: bold; position: relative; z-index: 2; }

    /* --- گرید ویژگی‌ها --- */
    .feature-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin: 40px 0; }
    .feature-card { 
        background: #f8fafc; border: 1px solid #e2e8f0; padding: 25px 15px; 
        border-radius: 12px; text-align: center; transition: 0.3s;
    }
    .feature-card:hover { transform: translateY(-5px); border-color: #0056b3; background: #fff; box-shadow: 0 10px 20px rgba(0,0,0,0.05); }
    .feature-icon { font-size: 32px; color: #0056b3; margin-bottom: 15px; }
    .feature-title { font-family: 'Diba', sans-serif; font-size: 18px; color: #1e293b; margin-bottom: 10px; }
    .feature-desc { font-size: 13px; color: #64748b; line-height: 1.6; }

    /* --- باکس مدیریت --- */
    .management-box {
        background: #fff; border: 2px dashed #cbd5e1; border-radius: 16px;
        padding: 30px; margin-top: 50px; display: flex; flex-direction: column; gap: 15px;
        text-align: center;
    }
    .manager-grid { display: grid; grid-template-columns: 1fr; gap: 32px; }
    .manager-role { font-size: 14px; color: #64748b; margin-bottom: 5px; }
    .manager-name { font-family: 'Diba', sans-serif; font-size: 20px; color: #0056b3; font-weight: bold; }

    /* --- سایدبار --- */
    .dynamic-widgets-container { width: 100%; display: flex; flex-direction: column; gap: 25px; }
    .dynamic-widgets-container .widget, .dynamic-widgets-container aside { background: transparent !important; border: none !important; padding: 0 !important; margin: 0 !important; box-shadow: none !important; display: block !important; }
    .dynamic-widgets-container img { width: 100% !important; height: auto !important; display: block !important; border-radius: 12px; transition: all 0.3s ease; }

    /* --- Tailwind Replacements --- */
    .flex { display: flex; }
    .flex-col { flex-direction: column; }
    .items-center { align-items: center; }
    .justify-center { justify-content: center; }
    .justify-between { justify-content: space-between; }
    .gap-2 { gap: 8px; }
    .gap-3 { gap: 12px; }
    .gap-4 { gap: 16px; }
    .gap-8 { gap: 32px; }
    .w-full { width: 100%; }
    .h-full { height: 100%; }
    .h-32 { height: 128px; }
    .object-cover { object-fit: cover; }
    .overflow-hidden { overflow: hidden; }
    .relative { position: relative; }
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
    .text-slate-700 { color: #334155; }
    .text-slate-800 { color: #1e293b; }
    .text-\[\#0056b3\] { color: #0056b3; }
    .text-yellow-400 { color: #facc15; }
    .font-bold { font-weight: bold; }
    .text-sm { font-size: 14px; }
    .text-lg { font-size: 18px; }
    .text-3xl { font-size: 30px; }
    .text-\[14px\] { font-size: 14px; }
    .leading-6 { line-height: 1.5rem; }
    .leading-loose { line-height: 2; }
    .mb-4 { margin-bottom: 16px; }
    .mb-6 { margin-bottom: 24px; }
    .mb-10 { margin-bottom: 40px; }
    .mt-6 { margin-top: 24px; }
    .p-4 { padding: 16px; }
    .pb-8 { padding-bottom: 32px; }
    .text-center { text-align: center; }
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
        .site-main-wrapper { padding: 0 !important; background: #fff; }
        .content-area { padding: 25px 15px; }
        .main-card-container { border: none; border-radius: 0; }
        .feature-grid { grid-template-columns: 1fr; }
        .management-box { text-align: center; }
    }

    @media (min-width: 769px) {
        .md\:grid-cols-2 { grid-template-columns: repeat(2, 1fr); }
        .md\:text-5xl { font-size: 48px; }
        .md\:border-r { border-right: 1px solid #e2e8f0; }
        .md\:pr-8 { padding-right: 32px; }
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
                <article class="main-card-container shadow-sm animate-fade-up">
                    <div class="content-area">
                        <header class="text-center mb-10 border-b border-slate-100 pb-8">
                            <h1 class="font-diba text-3xl md:text-5xl text-slate-800 mb-4">
                                روایتِ <span class="text-[#0056b3]">شرجی پرس</span>
                            </h1>
                            <p class="text-slate-500 text-lg">بازگشتی برای شفافیت، توسعه و آگاهی</p>
                        </header>

                        <div class="text-justify-custom text-slate-700 leading-loose">
                            
                            <p class="about-lead">
                                <strong class="text-[#0056b3]">شرجی پرس؛</strong> از سال ۹۷ فعالیت رسمی و حرفه‌ای خود را آغاز کرد و در روزهایی که جهان در التهاب بیماری و اضطراب آینده می‌سوخت، در کنار مردم ایستاد؛ نه صرفاً به‌عنوان یک پایگاه خبری، بلکه به‌مثابه رسانه‌ای مسئول که آگاهی را حق جامعه می‌دانست و اطلاع‌رسانی دقیق را وظیفه‌ای اخلاقی. در آن روزهای دشوار، تلاش کردیم روایتگر حقیقت باشیم؛ بی‌هیاهو، بی‌اغراق و بی‌انحراف.
                            </p>

                            <div class="highlight-box">
                                <div class="highlight-text">
                                    "اکنون، پس از وقفه‌ای سه‌ساله، بار دیگر به صحنه بازمی‌گردیم. نه از سر تکرار، که از سر ضرورت. باور داریم سپهر رسانه‌ای منطقه بیش از هر زمان دیگری نیازمند صدایی صریح، تحلیلی عمیق و نگاهی مستقل است."
                                </div>
                            </div>

                            <h2 class="section-title">رسالت ما: پلی میان مردم و مسئولان</h2>
                            <p class="mb-6">
                                «شرجی پرس» بازگشته است تا خلأهای موجود در فضای خبری منطقه را با رویکردی حرفه‌ای و توسعه‌محور پوشش دهد. ما آمده‌ایم تا پلی شفاف و دوسویه میان مردم و مسئولان باشیم؛ تا مطالبات بی‌واسطه شهروندان شنیده شود و پاسخ‌گویی مدیران در چارچوبی منصفانه و مستند شکل گیرد.
                            </p>

                            <div class="feature-grid">
                                <div class="feature-card">
                                    <i class="fas fa-search feature-icon"></i>
                                    <h3 class="feature-title">شفافیت و نقد</h3>
                                    <p class="feature-desc">شفافیت نه تهدید که فرصت است؛ و نقد منصفانه، مقدمه اصلاح و پیشرفت.</p>
                                </div>
                                <div class="feature-card">
                                    <i class="fas fa-history feature-icon"></i>
                                    <h3 class="feature-title">پاسداشت هویت</h3>
                                    <p class="feature-desc">ثبت حافظه تاریخی و روایت ایستادگی مردم این اقلیم زرخیز.</p>
                                </div>
                                <div class="feature-card">
                                    <i class="fas fa-balance-scale feature-icon"></i>
                                    <h3 class="feature-title">استقلال حرفه‌ای</h3>
                                    <p class="feature-desc">بی‌وابستگی جناحی؛ سرمایه ما اعتماد مردم است و معیار ما منافع عمومی.</p>
                                </div>
                            </div>

                            <h2 class="section-title">چشم‌انداز آینده</h2>
                            <p class="mb-4">
                                در این مسیر، مسائل و موضوعات روز، سیاست‌ها و عملکرد دستگاه‌ها، با نگاهی موشکافانه و تحلیلی زیر ذره‌بین قرار خواهد گرفت. هم‌زمان، ثبت تراوشات ذهنی نام‌آوران، روایت پیشکسوتان و ثبت حافظه تاریخی منطقه، بخشی از تعهد ما به آینده‌ای ریشه‌دار خواهد بود.
                            </p>
                            <p class="mb-4">
                                ما بازگشته‌ایم تا اثرگذار باشیم؛ تا در فرآیند تصمیم‌سازی‌های کلان نقش ایفا کنیم و جامعه را از ثمرات تصمیمات صحیح منتفع سازیم. آمده‌ایم تا نسل تازه‌ای از خبرنگاران آگاه و متعهد را پرورش دهیم و سطح گفت‌وگوی عمومی را ارتقا بخشیم.
                            </p>
                            <p class="font-bold text-slate-800 mt-6">
                                این بازگشت، آغاز فصلی نو است. در هوای شرجی این دیار، حقیقت را صریح و بی‌پرده روایت خواهیم کرد، چرا که باور داریم این سامان، شایسته رسانه‌ای در تراز شأن تاریخی و ظرفیت‌های بزرگ آن است.
                            </p>

                            <div class="management-box">
                                <div class="manager-grid md:grid-cols-2">
                                    <div>
                                        <div class="manager-role">مدیرمسئول پایگاه خبری شرجی پرس</div>
                                        <div class="manager-name">مسعود باشی</div>
                                    </div>
                                    <div class="md:border-r md:pr-8">
                                        <div class="manager-role">سردبیر و مدیر تحریریه</div>
                                        <div class="manager-name">علی دایلی</div>
                                    </div>
                                </div>
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
                        <div id="sidebar-ads" class="dynamic-widgets-container">
                            <?php dynamic_sidebar( 'single-sidebar' ); ?>
                        </div>
                    <?php endif; ?>
                    
                    <?php if ( is_active_sidebar( 'single-sidebar-2' ) ) : ?>
                        <div id="sidebar-ads-2" class="dynamic-widgets-container">
                            <?php dynamic_sidebar( 'single-sidebar-2' ); ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

        </div>
    </main>
</div>

<?php get_footer(); ?>