<?php
/**
 * Template Name: Sharji Sport - Newspapers Gallery (Manual Sort)
 * File Name: page-newspapers.php
 */

get_header('sport'); 
?>

<style>
    /* مودال */
    .newspaper-modal {
        display: none;
        position: fixed; z-index: 9999; left: 0; top: 0; width: 100%; height: 100%;
        background-color: rgba(0,0,0,0.9); backdrop-filter: blur(5px);
        align-items: center; justify-content: center;
    }
    .newspaper-modal.active { display: flex; animation: npFadeIn 0.3s; }
    .newspaper-modal img { max-height: 90vh; max-width: 90vw; border-radius: 8px; box-shadow: 0 0 20px rgba(255,255,255,0.1); }
    .close-modal { position: absolute; top: 20px; right: 30px; color: white; font-size: 40px; cursor: pointer; transition: 0.3s; }
    .close-modal:hover { color: #3b82f6; transform: scale(1.1); }
    @keyframes npFadeIn { from { opacity: 0; } to { opacity: 1; } }

    /* لی‌اوت */
    .np-wrapper {
        max-width: 1600px;
        margin: 0 auto;
        padding: 0 16px 40px;
        min-height: 100vh;
    }
    
    /* هدر */
    .np-header {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 40px;
        border-bottom: 1px solid #1f2937;
        padding-bottom: 24px;
        gap: 16px;
    }
    .np-header h1 {
        font-family: 'Diba', sans-serif;
        font-size: 30px;
        color: #fff;
        margin: 0 0 8px;
        text-align: right;
    }
    .np-header h1 span { color: #3b82f6; }
    .np-header p { color: #6b7280; font-size: 14px; margin: 0; }
    
    .np-header-badge {
        background: #1e293b;
        padding: 8px 16px;
        border-radius: 8px;
        border: 1px solid #374151;
        color: #9ca3af;
        font-size: 14px;
        display: flex;
        align-items: center;
        gap: 8px;
        white-space: nowrap;
    }
    
    /* گرید */
    .np-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 24px;
    }
    
    /* کارت */
    .np-card {
        cursor: pointer;
    }
    .np-card-inner {
        background: #1e293b;
        border-radius: 12px;
        overflow: hidden;
        border: 1px solid #374151;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.3);
        transition: all 0.3s;
    }
    .np-card:hover .np-card-inner {
        transform: translateY(-8px);
        border-color: rgba(59, 130, 246, 0.5);
    }
    
    .np-card-img-wrap {
        aspect-ratio: 3 / 4;
        overflow: hidden;
        position: relative;
    }
    .np-card-img-wrap img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s;
    }
    .np-card:hover .np-card-img-wrap img { transform: scale(1.05); }
    
    .np-card-overlay {
        position: absolute;
        inset: 0;
        background: rgba(0,0,0,0.5);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.3s;
    }
    .np-card:hover .np-card-overlay { opacity: 1; }
    .np-card-overlay i { font-size: 32px; color: #fff; }
    
    .np-card-no-img {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #1f2937;
        color: #4b5563;
    }
    
    .np-card-title {
        padding: 12px;
        text-align: center;
        background: #161f2f;
        border-top: 1px solid #374151;
    }
    .np-card-title h3 {
        color: #d1d5db;
        font-size: 14px;
        font-weight: bold;
        margin: 0;
        transition: color 0.3s;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    .np-card:hover .np-card-title h3 { color: #60a5fa; }
    
    /* حالت خالی */
    .np-empty {
        grid-column: 1 / -1;
        text-align: center;
        padding: 80px 20px;
        background: rgba(30, 41, 59, 0.5);
        border-radius: 16px;
        border: 1px dashed #374151;
    }
    .np-empty i { font-size: 48px; color: #4b5563; margin-bottom: 16px; display: block; }
    .np-empty span { color: #9ca3af; font-size: 18px; }
    
    /* رسپانسیو */
    @media (min-width: 641px) {
        .np-header { flex-direction: row; align-items: center; }
    }
    @media (min-width: 769px) {
        .np-grid { grid-template-columns: repeat(4, 1fr); }
    }
    @media (min-width: 1025px) {
        .np-grid { grid-template-columns: repeat(5, 1fr); }
    }
</style>

<div class="np-wrapper">
    
    <div class="np-header">
        <div style="text-align: right;">
            <h1>پیشخوان <span>روزنامه‌های ورزشی</span></h1>
            <p>آرشیو کامل روزنامه‌های ورزشی کشور</p>
        </div>
        
        <div class="np-header-badge">
            <i class="far fa-images"></i>
            <span>گالری مطبوعات</span>
        </div>
    </div>

    <div class="np-grid">
        <?php 
        $news_query = new WP_Query([
            'post_type'      => 'newspaper',
            'posts_per_page' => -1,
            'orderby'        => 'menu_order',
            'order'          => 'ASC',
        ]);

        if($news_query->have_posts()):
            while($news_query->have_posts()): $news_query->the_post();
                $image_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
        ?>
        
        <div class="np-card" onclick="openNewspaperModal('<?php echo esc_url($image_url); ?>')">
            <div class="np-card-inner">
                <div class="np-card-img-wrap">
                    <?php if($image_url): ?>
                        <img src="<?php echo esc_url($image_url); ?>" alt="<?php the_title(); ?>">
                        <div class="np-card-overlay">
                            <i class="fas fa-search-plus"></i>
                        </div>
                    <?php else: ?>
                        <div class="np-card-no-img">بدون تصویر</div>
                    <?php endif; ?>
                </div>
                
                <div class="np-card-title">
                    <h3><?php the_title(); ?></h3>
                </div>
            </div>
        </div>

        <?php 
            endwhile; 
            wp_reset_postdata();
        else:
        ?>
            <div class="np-empty">
                <i class="far fa-newspaper"></i>
                <span>هنوز روزنامه‌ای بارگذاری نشده است.</span>
            </div>
        <?php endif; ?>
    </div>

</div>

<!-- مودال -->
<div id="npImgModal" class="newspaper-modal" onclick="closeNewspaperModal()">
    <span class="close-modal">&times;</span>
    <img id="npModalImage" src="" onclick="event.stopPropagation()" alt="">
</div>

<script>
    function openNewspaperModal(src) {
        if(!src) return;
        document.getElementById('npModalImage').src = src;
        document.getElementById('npImgModal').classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    function closeNewspaperModal() {
        document.getElementById('npImgModal').classList.remove('active');
        document.body.style.overflow = 'auto';
    }
    
    document.addEventListener('keydown', function(event) { 
        if (event.key === "Escape") closeNewspaperModal(); 
    });
</script>

<?php get_footer('sport'); ?>