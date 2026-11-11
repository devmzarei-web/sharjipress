<?php
/**
 * Template Name: Sharji Sport - Newspapers Gallery (Manual Sort)
 * File Name: page-newspapers.php
 */

get_header('sport'); 
?>

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

<?php get_footer('sport'); ?>
