<?php
/*
 * Template Name: Single Sport Dark (Full Features + Polls)
 * Template Post Type: post
 */

if (!function_exists('to_farsi_local')) {
    function to_farsi_local($number) {
        $persian_digits = array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹');
        $english_digits = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
        return str_replace($english_digits, $persian_digits, (string)$number);
    }
}

get_header('sport');
?>

<style>
    /* استایل‌های سایدبار */
    .timeline-item { position: relative; padding-right: 25px; border-right: 2px solid #334155; margin-bottom: 0; display: block; transition: 0.3s; text-decoration: none; }
    .timeline-item::before { content: ''; position: absolute; right: -6px; top: 50%; transform: translateY(-50%); width: 10px; height: 10px; background: #3b82f6; border: 2px solid #1e293b; border-radius: 50%; transition: 0.3s; box-shadow: 0 0 0 1px #3b82f6; }
    .timeline-item:hover::before { background: #fff; box-shadow: 0 0 10px #3b82f6, 0 0 0 2px #3b82f6; transform: translateY(-50%) scale(1.3); }
    .timeline-item:hover { border-right-color: #60a5fa; background: rgba(59, 130, 246, 0.05); }

    /* استایل جدول */
    .mini-table th { font-size: 9px !important; padding: 8px 1px !important; text-align: center !important; letter-spacing: -0.5px; }
    .mini-table td { font-size: 10.5px !important; padding: 6px 1px !important; vertical-align: middle; text-align: center; }
    .mini-table td:nth-child(2) { text-align: right; padding-right: 4px !important; }
    
    /* لی‌اوت */
    .sport-single-wrapper {
        max-width: 1600px;
        margin: 0 auto;
        padding: 0 16px 24px;
    }
    .sport-single-layout {
        display: flex;
        flex-direction: column;
        gap: 24px;
    }
    
    /* سایدبار */
    .sport-single-sidebar {
        width: 100%;
        order: 2;
    }
    .sport-single-sidebar-inner {
        display: flex;
        flex-direction: column;
        gap: 16px;
        position: sticky;
        top: 96px;
    }
    
    .sport-sidebar-card {
        background: #1e293b;
        border-radius: 12px;
        border: 1px solid rgba(55, 65, 81, 0.5);
        overflow: hidden;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.3);
    }
    .sport-sidebar-card-header {
        display: flex;
        border-bottom: 1px solid #374151;
        background: #161f2f;
    }
    .sport-sidebar-card-header button {
        flex: 1;
        padding: 12px;
        font-size: 14px;
        font-weight: bold;
        color: #fff;
        border: none;
        background: rgba(31, 41, 55, 0.5);
        border-bottom: 2px solid #3b82f6;
        cursor: pointer;
        font-family: 'Vazirmatn', sans-serif;
    }
    .sport-sidebar-card-body {
        padding: 16px;
        display: flex;
        flex-direction: column;
        max-height: 400px;
        overflow-y: auto;
    }
    
    .sport-table-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid #374151;
        background: #161f2f;
        padding: 12px 16px;
    }
    .sport-table-header span { font-size: 14px; font-weight: bold; color: #fff; }
    .sport-table-header a { font-size: 10px; color: #60a5fa; text-decoration: none; transition: color 0.3s; }
    .sport-table-header a:hover { color: #fff; }
    
    .sport-ad-placeholder {
        background: linear-gradient(to right, #1e3a8a, #1e40af);
        border-radius: 12px;
        height: 128px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: rgba(147, 197, 253, 0.5);
        border: 1px solid rgba(29, 78, 216, 0.3);
        font-size: 14px;
        font-weight: bold;
    }
    
    /* محتوای اصلی */
    .sport-single-main {
        width: 100%;
        order: 1;
        display: flex;
        flex-direction: column;
        gap: 24px;
    }
    
    .sport-article-card {
        background: #1e293b;
        border-radius: 16px;
        border: 1px solid rgba(55, 65, 81, 0.5);
        padding: 24px;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        position: relative;
        overflow: hidden;
    }
    
    .sport-article-meta {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 16px;
        font-size: 12px;
        color: #9ca3af;
        margin-bottom: 24px;
        border-bottom: 1px solid #374151;
        padding-bottom: 16px;
    }
    .sport-article-meta .categories { display: flex; flex-wrap: wrap; gap: 8px; }
    .sport-article-meta .categories a {
        background: rgba(37, 99, 235, 0.1);
        color: #3b82f6;
        padding: 4px 12px;
        border-radius: 9999px;
        font-weight: bold;
        border: 1px solid rgba(37, 99, 235, 0.2);
        text-decoration: none;
        font-size: 11px;
        transition: all 0.3s;
    }
    .sport-article-meta .categories a:hover { background: #2563eb; color: #fff; }
    
    .sport-font-size-controls {
        display: flex;
        align-items: center;
        gap: 4px;
        background: #0f172a;
        border: 1px solid #374151;
        border-radius: 4px;
        padding: 0 8px;
        height: 28px;
        margin-right: auto;
    }
    .sport-font-size-controls button {
        width: 24px;
        height: 100%;
        background: none;
        border: none;
        color: #9ca3af;
        cursor: pointer;
        font-size: 10px;
    }
    .sport-font-size-controls button:hover { color: #fff; }
    .sport-font-size-controls .divider { width: 1px; height: 12px; background: #374151; }
    
    .sport-article-title {
        font-family: 'Diba', sans-serif;
        font-size: 24px;
        color: #fff;
        line-height: 1.25;
        margin-bottom: 32px;
    }
    
    .sport-article-featured {
        display: flex;
        flex-direction: column;
        gap: 24px;
        margin-bottom: 32px;
    }
    .sport-article-featured .image-wrap {
        width: 100%;
        border-radius: 12px;
        overflow: hidden;
        border: 1px solid #374151;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.3);
    }
    .sport-article-featured .image-wrap img { width: 100%; height: auto; object-fit: cover; display: block; }
    
    .sport-article-excerpt {
        width: 100%;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }
    .sport-article-excerpt-inner {
        background: #0f172a;
        padding: 20px;
        border-radius: 12px;
        border-right: 4px solid #2563eb;
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }
    .sport-article-excerpt-inner .label {
        color: #3b82f6;
        font-weight: bold;
        font-size: 14px;
        margin-bottom: 12px;
    }
    .sport-article-excerpt-inner .text {
        font-size: 15px;
        line-height: 2rem;
        font-weight: 500;
        color: #d1d5db;
        text-align: justify;
    }
    
    .sport-article-content {
        color: #d1d5db;
        text-align: justify;
        line-height: 2rem;
    }
    
    .sport-article-tags {
        margin-top: 40px;
        padding-top: 24px;
        border-top: 1px solid #374151;
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        align-items: center;
    }
    .sport-article-tags .tags-label { color: #6b7280; font-size: 14px; margin-left: 8px; align-self: center; }
    .sport-article-tags a {
        background: #0f172a;
        color: #9ca3af;
        border: 1px solid #374151;
        padding: 4px 12px;
        border-radius: 8px;
        font-size: 12px;
        text-decoration: none;
        transition: all 0.3s;
    }
    .sport-article-tags a:hover { border-color: #3b82f6; color: #3b82f6; }

    /* اشتراک‌گذاری ورزشی - نسخه حرفه‌ای */
    .sport-share-box {
        margin-top: 28px;
        padding: 22px;
        border-radius: 18px;
        border: 1px solid rgba(59, 130, 246, 0.22);
        background:
            radial-gradient(circle at top left, rgba(59, 130, 246, 0.20), transparent 34%),
            linear-gradient(135deg, #0f172a 0%, #111827 52%, #172554 100%);
        position: relative;
        overflow: hidden;
        box-shadow: inset 0 1px 0 rgba(255,255,255,0.04), 0 18px 40px rgba(0,0,0,0.20);
    }

    .sport-share-box::before {
        content: "";
        position: absolute;
        top: -80px;
        left: -80px;
        width: 190px;
        height: 190px;
        border-radius: 9999px;
        background: rgba(37, 99, 235, 0.18);
        filter: blur(2px);
    }

    .sport-share-box::after {
        content: "";
        position: absolute;
        right: -60px;
        bottom: -80px;
        width: 180px;
        height: 180px;
        border-radius: 9999px;
        background: rgba(14, 165, 233, 0.09);
    }

    .sport-share-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 18px;
        margin-bottom: 18px;
        position: relative;
        z-index: 2;
    }

    .sport-share-title-wrap {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .sport-share-icon {
        width: 42px;
        height: 42px;
        border-radius: 14px;
        background: linear-gradient(135deg, #2563eb, #0ea5e9);
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 10px 25px rgba(37, 99, 235, 0.25);
    }

    .sport-share-icon i {
        font-size: 17px;
    }

    .sport-share-title {
        color: #f8fafc;
        font-size: 15px;
        font-weight: 900;
        margin-bottom: 4px;
    }

    .sport-share-subtitle {
        color: #94a3b8;
        font-size: 12px;
        line-height: 1.8;
    }

    .sport-share-grid {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        position: relative;
        z-index: 2;
    }

    .sport-share-btn {
        min-width: 46px;
        height: 44px;
        padding: 0 14px;
        border-radius: 12px;
        border: 1px solid rgba(148, 163, 184, 0.20);
        background: rgba(15, 23, 42, 0.78);
        color: #cbd5e1;
        text-decoration: none !important;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        font-size: 12px;
        font-weight: 800;
        cursor: pointer;
        transition: all 0.25s ease;
        font-family: 'Vazirmatn', sans-serif;
    }

    .sport-share-btn i {
        font-size: 17px;
    }

    .sport-share-btn:hover {
        color: #fff !important;
        transform: translateY(-3px);
        border-color: transparent;
        box-shadow: 0 12px 22px rgba(0,0,0,0.22);
    }

    .sport-share-btn.telegram:hover { background: #229ed9; }
    .sport-share-btn.whatsapp:hover { background: #22c55e; }
    .sport-share-btn.x-twitter:hover { background: #020617; }
    .sport-share-btn.facebook:hover { background: #1877f2; }
    .sport-share-btn.linkedin:hover { background: #0a66c2; }
    .sport-share-btn.native-share:hover { background: #7c3aed; }
    .sport-share-btn.copy:hover { background: #2563eb; }

    .sport-shortlink-row {
        margin-top: 16px;
        background: rgba(2, 6, 23, 0.52);
        border: 1px dashed rgba(148, 163, 184, 0.26);
        border-radius: 14px;
        padding: 10px;
        display: flex;
        align-items: center;
        gap: 10px;
        position: relative;
        z-index: 2;
        direction: ltr;
    }

    .sport-shortlink-input {
        flex: 1;
        min-width: 0;
        border: none;
        outline: none;
        background: transparent;
        color: #cbd5e1;
        font-size: 13px;
        font-family: Arial, sans-serif;
    }

    .sport-copy-shortlink {
        border: none;
        height: 36px;
        padding: 0 14px;
        border-radius: 10px;
        background: linear-gradient(135deg, #2563eb, #0ea5e9);
        color: #fff;
        font-size: 12px;
        font-weight: 900;
        cursor: pointer;
        transition: all 0.25s ease;
        white-space: nowrap;
        font-family: 'Vazirmatn', sans-serif;
    }

    .sport-copy-shortlink:hover {
        background: linear-gradient(135deg, #1d4ed8, #0284c7);
        transform: translateY(-1px);
    }

    .sport-copy-status {
        font-size: 12px;
        color: #4ade80;
        font-weight: 900;
        display: none;
        direction: rtl;
        white-space: nowrap;
    }
    
    /* اخبار مرتبط */
    .sport-related-section { margin-top: 16px; }
    .sport-related-title {
        font-family: 'Diba', sans-serif;
        font-size: 20px;
        color: #fff;
        margin-bottom: 16px;
        border-right: 4px solid #3b82f6;
        padding-right: 12px;
    }
    .sport-related-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 16px;
    }
    .sport-related-card {
        background: #1e293b;
        border-radius: 12px;
        overflow: hidden;
        border: 1px solid rgba(55, 65, 81, 0.5);
        transition: border-color 0.3s;
    }
    .sport-related-card:hover { border-color: rgba(59, 130, 246, 0.5); }
    .sport-related-card .thumb {
        position: relative;
        height: 160px;
        overflow: hidden;
    }
    .sport-related-card .thumb img {
        width: 100%; height: 100%; object-fit: cover;
        transition: transform 0.5s;
    }
    .sport-related-card:hover .thumb img { transform: scale(1.1); }
    .sport-related-card .info {
        padding: 12px;
    }
    .sport-related-card .info h3 {
        font-family: 'Diba', sans-serif;
        font-size: 14px;
        color: #e5e7eb;
        line-height: 1.5rem;
        transition: color 0.3s;
    }
    .sport-related-card:hover .info h3 { color: #60a5fa; }
    
    /* جدول مینی */
    .mini-table { width: 100%; border-collapse: collapse; }
    .mini-table thead tr { border-bottom: 1px solid #374151; }
    .mini-table tbody tr { border-bottom: 1px solid rgba(55, 65, 81, 0.3); transition: background 0.3s; }
    .mini-table tbody tr:hover { background: rgba(31, 41, 55, 0.5); }
    
    /* کامنت */
    .sport-comments-section { margin-top: 32px; }
    
    @media (min-width: 769px) {
        .sport-article-card { padding: 40px; }
        .sport-article-featured { flex-direction: row; }
        .sport-article-featured .image-wrap { width: 50%; }
        .sport-article-featured .sport-article-excerpt { width: 50%; }
        .sport-article-title { font-size: 30px; }
        .sport-related-grid { grid-template-columns: repeat(3, 1fr); }
    }
    
    @media (min-width: 1025px) {
        .sport-single-layout { flex-direction: row; }
        .sport-single-sidebar { width: 25%; order: 1; }
        .sport-single-main { width: 75%; order: 2; }
    }

    @media (max-width: 768px) {
        .sport-share-box {
            padding: 18px;
        }

        .sport-share-header {
            align-items: flex-start;
        }

        .sport-share-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
        }

        .sport-share-btn {
            width: 100%;
            padding: 0 10px;
        }

        .sport-shortlink-row {
            flex-wrap: wrap;
        }

        .sport-shortlink-input {
            width: 100%;
            flex-basis: 100%;
        }
    }
</style>

<div class="sport-single-wrapper">
    <div class="sport-single-layout">

        <!-- سایدبار -->
        <aside class="sport-single-sidebar">
            <div class="sport-single-sidebar-inner">
                
                <!-- آخرین اخبار -->
                <div class="sport-sidebar-card">
                    <div class="sport-sidebar-card-header">
                        <button>آخرین اخبار</button>
                    </div>
                    <div class="sport-sidebar-card-body">
                        <?php 
                        $sidebar_news = new WP_Query(['category_name' => 'sport', 'posts_per_page' => 10, 'post__not_in' => [get_the_ID()]]);
                        if($sidebar_news->have_posts()): while($sidebar_news->have_posts()): $sidebar_news->the_post(); 
                        ?>
                        <a href="<?php echo add_query_arg('theme', 'sport', get_permalink()); ?>" class="timeline-item" style="padding: 12px 0; margin-right: -16px; padding-right: 36px; padding-left: 8px;">
                            <span style="font-size: 10px; color: #60a5fa; display: block; margin-bottom: 4px; font-weight: bold;"><?php echo to_farsi_local(get_the_time('H:i')); ?></span>
                            <h3 style="font-size: 13px; line-height: 1.5rem; color: #d1d5db; font-weight: 500; text-align: justify; padding-left: 8px; margin: 0;"><?php the_title(); ?></h3>
                        </a>
                        <?php endwhile; endif; wp_reset_postdata(); ?>
                    </div>
                </div>

                <!-- جدول لیگ -->
                <div class="sport-sidebar-card">
                    <div class="sport-table-header">
                        <span>جدول لیگ برتر</span>
                        <a href="<?php echo home_url('/league-table'); ?>">جدول کامل <i class="fas fa-angle-left"></i></a>
                    </div>
                    <div style="padding: 0;">
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
                            usort($table_data, function($a, $b) { if ($a['points'] != $b['points']) return $b['points'] - $a['points']; return $b['diff'] - $a['diff']; });
                            $top_teams = array_slice($table_data, 0, 5);
                        }
                        ?>
                        <table class="mini-table">
                            <thead>
                                <tr><th style="width: 16px;">#</th><th style="text-align: right;">تیم</th><th style="color: #9ca3af;">بازی</th><th style="color: rgba(34, 197, 94, 0.8);">برد</th><th style="color: #9ca3af;">مساوی</th><th style="color: rgba(239, 68, 68, 0.8);">باخت</th><th style="color: #d1d5db;">تفاضل</th><th style="color: #fff; font-weight: bold; width: 32px;">امتیاز</th></tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($top_teams)): $rank = 1; foreach($top_teams as $team): 
                                    $diff_color = ($team['diff'] >= 0) ? 'color: #4ade80;' : 'color: #f87171;'; $diff_sign = ($team['diff'] > 0) ? '+' : ''; ?>
                                <tr>
                                    <td style="color: #6b7280; font-weight: bold;"><?php echo to_farsi_local($rank++); ?></td>
                                    <td style="text-align: right;"><div style="display: flex; align-items: center; gap: 6px;"><?php if($team['logo']): ?><img src="<?php echo esc_url($team['logo']); ?>" style="width: 16px; height: 16px; object-fit: contain;"><?php endif; ?><span style="color: #e5e7eb; font-weight: 500; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; max-width: 60px; display: block;"><?php echo esc_html($team['name']); ?></span></div></td>
                                    <td style="color: #9ca3af;"><?php echo to_farsi_local($team['played']); ?></td>
                                    <td style="color: #d1d5db;"><?php echo to_farsi_local($team['won']); ?></td>
                                    <td style="color: #9ca3af;"><?php echo to_farsi_local($team['drawn']); ?></td>
                                    <td style="color: #9ca3af;"><?php echo to_farsi_local($team['lost']); ?></td>
                                    <td style="<?php echo $diff_color; ?>"><?php echo to_farsi_local($diff_sign . $team['diff']); ?></td>
                                    <td style="font-weight: 900; color: #fff; background: rgba(255,255,255,0.05);"><?php echo to_farsi_local($team['points']); ?></td>
                                </tr>
                                <?php endforeach; else: ?><tr><td colspan="8" style="text-align: center; padding: 16px; color: #6b7280;">جدول خالی است</td></tr><?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <?php if ( is_active_sidebar( 'sport-sidebar' ) ) : ?>
                    <div id="sport-sidebar-area"><?php dynamic_sidebar( 'sport-sidebar' ); ?></div>
                <?php endif; ?>

                <?php if ( is_active_sidebar( 'sport-ad-sidebar' ) ) : ?>
                    <div id="sport-ad-area"><?php dynamic_sidebar( 'sport-ad-sidebar' ); ?></div>
                <?php else: ?>
                    <div class="sport-ad-placeholder">
                        <span style="border: 1px solid rgba(59, 130, 246, 0.3); padding: 4px 12px; border-radius: 4px;">جایگاه تبلیغات</span>
                    </div>
                <?php endif; ?>

            </div>
        </aside>

        <!-- محتوای اصلی -->
        <main class="sport-single-main">
            <?php if (have_posts()) : while (have_posts()) : the_post(); $current_post_id = get_the_ID(); ?>
            
            <article class="sport-article-card">
                <div class="sport-article-meta">
                    <div class="categories">
                        <?php $categories = get_the_category(); if ( $categories ) { foreach ( $categories as $category ) { echo '<a href="' . esc_url( get_category_link( $category->term_id ) ) . '">' . esc_html( $category->name ) . '</a>'; } } ?>
                    </div>
                    <span><i class="far fa-calendar" style="margin-left: 4px;"></i> <?php echo to_farsi_local(get_the_date()); ?></span>
                    <span><i class="far fa-clock" style="margin-left: 4px;"></i> <?php echo to_farsi_local(get_the_time('H:i')); ?></span>
                    <div class="sport-font-size-controls">
                        <button type="button" onclick="adjustFont(1)"><i class="fas fa-plus"></i></button>
                        <div class="divider"></div>
                        <button type="button" onclick="adjustFont(-1)"><i class="fas fa-minus"></i></button>
                    </div>
                </div>

                <h1 class="sport-article-title"><?php the_title(); ?></h1>
                
                <div class="entry-content" id="mainContent">
                    <div class="sport-article-featured">
                        <?php if (has_post_thumbnail()) : ?>
                        <div class="image-wrap"><?php the_post_thumbnail('large', ['class' => 'w-full h-auto object-cover']); ?></div>
                        <?php endif; ?>
                        <div class="sport-article-excerpt">
                            <div class="sport-article-excerpt-inner">
                                <span class="label">چکیده خبر</span>
                                <div class="text">
                                    <?php if (has_excerpt()) { echo get_the_excerpt(); } else { echo wp_trim_words(get_the_content(), 55, '...'); } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="sport-article-content"><?php the_content(); ?></div>
                </div>

                <?php $tags = get_the_tags(); if ($tags) : ?>
                <div class="sport-article-tags">
                    <span class="tags-label">برچسب‌ها:</span>
                    <?php foreach($tags as $tag) : ?><a href="<?php echo get_tag_link($tag->term_id); ?>"># <?php echo $tag->name; ?></a><?php endforeach; ?>
                </div>
                <?php endif; ?>

                <?php
                $sport_post_url       = get_permalink();
                $sport_post_title     = get_the_title();
                $sport_shortlink      = wp_get_shortlink();

                if ( empty( $sport_shortlink ) ) {
                    $sport_shortlink = home_url( '?p=' . get_the_ID() );
                }

                $sport_encoded_short  = rawurlencode( $sport_shortlink );
                $sport_encoded_title  = rawurlencode( $sport_post_title );
                $sport_share_text     = rawurlencode( $sport_post_title . "\n" . $sport_shortlink );
                ?>

                <div class="sport-share-box">
                    <div class="sport-share-header">
                        <div class="sport-share-title-wrap">
                            <div class="sport-share-icon">
                                <i class="fas fa-share-alt"></i>
                            </div>
                            <div>
                                <div class="sport-share-title">اشتراک‌گذاری خبر ورزشی</div>
                                <div class="sport-share-subtitle">این خبر را ارسال کنید یا لینک کوتاه آن را کپی کنید.</div>
                            </div>
                        </div>
                    </div>

                    <div class="sport-share-grid">
                        <a 
                            href="https://t.me/share/url?url=<?php echo esc_attr( $sport_encoded_short ); ?>&text=<?php echo esc_attr( $sport_encoded_title ); ?>" 
                            target="_blank" 
                            rel="noopener noreferrer"
                            class="sport-share-btn telegram"
                            title="اشتراک‌گذاری در تلگرام"
                        >
                            <i class="fab fa-telegram-plane"></i>
                            <span>تلگرام</span>
                        </a>

                        <a 
                            href="https://wa.me/?text=<?php echo esc_attr( $sport_share_text ); ?>" 
                            target="_blank" 
                            rel="noopener noreferrer"
                            class="sport-share-btn whatsapp"
                            title="اشتراک‌گذاری در واتساپ"
                        >
                            <i class="fab fa-whatsapp"></i>
                            <span>واتساپ</span>
                        </a>

                        <a 
                            href="https://twitter.com/intent/tweet?url=<?php echo esc_attr( $sport_encoded_short ); ?>&text=<?php echo esc_attr( $sport_encoded_title ); ?>" 
                            target="_blank" 
                            rel="noopener noreferrer"
                            class="sport-share-btn x-twitter"
                            title="اشتراک‌گذاری در ایکس"
                        >
                            <i class="fab fa-x-twitter"></i>
                            <span>ایکس</span>
                        </a>

                        <a 
                            href="https://www.facebook.com/sharer/sharer.php?u=<?php echo esc_attr( $sport_encoded_short ); ?>" 
                            target="_blank" 
                            rel="noopener noreferrer"
                            class="sport-share-btn facebook"
                            title="اشتراک‌گذاری در فیسبوک"
                        >
                            <i class="fab fa-facebook-f"></i>
                            <span>فیسبوک</span>
                        </a>

                        <button 
                            type="button"
                            class="sport-share-btn native-share"
                            onclick="sportNativeShare('<?php echo esc_js( $sport_post_title ); ?>', '<?php echo esc_js( $sport_shortlink ); ?>')"
                            title="اشتراک‌گذاری با موبایل"
                        >
                            <i class="fas fa-share-nodes"></i>
                            <span>اشتراک</span>
                        </button>

                        <button 
                            type="button"
                            class="sport-share-btn copy"
                            onclick="sportCopyText('<?php echo esc_js( $sport_shortlink ); ?>')"
                            title="کپی لینک کوتاه"
                        >
                            <i class="fas fa-link"></i>
                            <span>کپی لینک</span>
                        </button>
                    </div>

                    <div class="sport-shortlink-row">
                        <input 
                            id="sportShortlinkInput"
                            class="sport-shortlink-input"
                            type="text" 
                            value="<?php echo esc_url( $sport_shortlink ); ?>" 
                            readonly
                            aria-label="لینک کوتاه خبر"
                        >

                        <button 
                            type="button" 
                            class="sport-copy-shortlink"
                            onclick="sportCopyShortlink()"
                        >
                            کپی لینک کوتاه
                        </button>

                        <span id="sportCopyStatus" class="sport-copy-status">کپی شد</span>
                    </div>
                </div>
            </article>
            
            <?php
            $tags = wp_get_post_tags($current_post_id);
            if ($tags) {
                $tag_ids = array_column($tags, 'term_id');
                $related_query = new WP_Query([
                    'category_name' => 'sport',
                    'tag__in' => $tag_ids,
                    'post__not_in' => [$current_post_id],
                    'posts_per_page' => 3,
                    'ignore_sticky_posts' => 1
                ]);
                if (!$related_query->have_posts()) { $related_query = new WP_Query(['category_name' => 'sport', 'post__not_in' => [$current_post_id], 'posts_per_page' => 3]); }
                if ($related_query->have_posts()) : ?>
                <div class="sport-related-section">
                    <h3 class="sport-related-title">اخبار مرتبط ورزشی</h3>
                    <div class="sport-related-grid">
                        <?php while ($related_query->have_posts()) : $related_query->the_post(); ?>
                        <article class="sport-related-card">
                            <a href="<?php echo add_query_arg('theme', 'sport', get_permalink()); ?>" style="text-decoration: none;">
                                <div class="thumb"><?php the_post_thumbnail('medium', ['class' => 'w-full h-full object-cover']); ?></div>
                                <div class="info"><h3><?php the_title(); ?></h3></div>
                            </a>
                        </article>
                        <?php endwhile; wp_reset_postdata(); ?>
                    </div>
                </div>
                <?php endif; 
            }
            ?>

            <div class="sport-comments-section">
                <?php if ( comments_open() || get_comments_number() ) : comments_template('/comments-sport.php'); endif; ?>
            </div>

            <?php endwhile; endif; ?>
        </main>
    </div>
</div>

<script>
    function adjustFont(amount) {
        var content = document.getElementById('mainContent');
        var currentSize = parseFloat(window.getComputedStyle(content, null).getPropertyValue('font-size'));
        var newSize = currentSize + amount;
        if (newSize >= 14 && newSize <= 30) {
            content.style.fontSize = newSize + 'px';
            content.style.lineHeight = (newSize * 1.8) + 'px';
        }
    }

    function sportCopyText(text) {
        if (navigator.clipboard && window.isSecureContext) {
            navigator.clipboard.writeText(text).then(function() {
                sportShowCopyStatus();
            }).catch(function() {
                sportFallbackCopy(text);
            });
        } else {
            sportFallbackCopy(text);
        }
    }

    function sportFallbackCopy(text) {
        var tempInput = document.createElement('input');
        tempInput.value = text;
        document.body.appendChild(tempInput);
        tempInput.select();
        document.execCommand('copy');
        document.body.removeChild(tempInput);
        sportShowCopyStatus();
    }

    function sportCopyShortlink() {
        var input = document.getElementById('sportShortlinkInput');
        if (!input) return;

        sportCopyText(input.value);
    }

    function sportShowCopyStatus() {
        var status = document.getElementById('sportCopyStatus');
        if (!status) return;

        status.style.display = 'inline-block';

        setTimeout(function() {
            status.style.display = 'none';
        }, 1800);
    }

    function sportNativeShare(title, url) {
        if (navigator.share) {
            navigator.share({
                title: title,
                text: title,
                url: url
            }).catch(function() {});
        } else {
            sportCopyText(url);
        }
    }
</script>

<?php get_footer('sport'); ?>