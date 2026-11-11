<?php
/**
 * Template Name: Sharji Sport - League Table (Blue & Modular)
 * File Name: page-league-table.php
 */

if (!function_exists('to_farsi_local')) {
    function to_farsi_local($number) {
        $persian_digits = array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹');
        $english_digits = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
        return str_replace($english_digits, $persian_digits, (string)$number);
    }
}

get_header('sport'); 

// --- محاسبات آمار ---
$total_goals_scored = 0;
$total_played_sum = 0;

$teams_query = new WP_Query([
    'post_type' => 'league_team',
    'posts_per_page' => -1,
]);

$table_data = [];

if( $teams_query->have_posts() ):
    while( $teams_query->have_posts() ) : $teams_query->the_post();
        if (!function_exists('get_field')) continue;

        $id = get_the_ID();
        $name = get_the_title();
        $logo = get_the_post_thumbnail_url($id, 'thumbnail'); 
        $played = (int)get_field('played');
        $won = (int)get_field('won');
        $drawn = (int)get_field('drawn');
        $lost = (int)get_field('lost');
        $gf = (int)get_field('gf');
        $ga = (int)get_field('ga');
        $deducted = (int)get_field('deducted');
        $form = get_field('form');

        $points = ($won * 3) + $drawn - $deducted;
        $diff = $gf - $ga;

        $total_goals_scored += $gf;
        $total_played_sum += $played;

        $table_data[] = [
            'name' => $name, 'logo' => $logo, 'played' => $played,
            'won' => $won, 'drawn' => $drawn, 'lost' => $lost,
            'gf' => $gf, 'ga' => $ga, 'diff' => $diff,
            'points' => $points, 'form' => $form
        ];
    endwhile;
    wp_reset_postdata();

    usort($table_data, function($a, $b) {
        if ($a['points'] != $b['points']) return $b['points'] - $a['points'];
        return $b['diff'] - $a['diff'];
    });
endif;

$total_matches_real = floor($total_played_sum / 2);
$avg_goal_per_match = ($total_matches_real > 0) ? round($total_goals_scored / $total_matches_real, 2) : 0;
$avg_min_per_goal = ($total_goals_scored > 0) ? round(($total_matches_real * 90) / $total_goals_scored, 2) : 0;
?>

<style>
    .league-wrapper {
        max-width: 1600px;
        margin: 0 auto;
        padding: 0 16px 32px;
    }
    .league-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 24px;
        flex-wrap: wrap;
        gap: 12px;
    }
    .league-header h1 {
        font-family: 'Diba', sans-serif;
        font-size: 24px;
        color: #fff;
        display: flex;
        align-items: center;
        gap: 12px;
        margin: 0;
    }
    .league-header h1 .indicator {
        width: 6px;
        height: 32px;
        background: #2563eb;
        border-radius: 9999px;
    }
    .league-season-badge {
        font-size: 12px;
        color: #6b7280;
        background: #1e293b;
        padding: 4px 12px;
        border-radius: 9999px;
        border: 1px solid #374151;
        white-space: nowrap;
    }
    
    .league-flex-row {
        display: flex;
        flex-direction: column;
        gap: 24px;
    }
    
    /* سایدبار */
    .league-sidebar {
        width: 100%;
        order: 2;
    }
    .league-sidebar-inner {
        display: flex;
        flex-direction: column;
        gap: 24px;
    }
    .league-stats-card {
        background: #1e293b;
        border-radius: 16px;
        border: 1px solid #374151;
        overflow: hidden;
    }
    .league-stats-header {
        background: rgba(15, 23, 42, 0.5);
        padding: 16px;
        border-bottom: 1px solid #374151;
        text-align: center;
    }
    .league-stats-header h3 {
        font-family: 'Diba', sans-serif;
        color: #fff;
        margin: 0;
        font-size: 16px;
    }
    .league-stats-body {
        padding: 20px;
        display: flex;
        flex-direction: column;
        gap: 12px;
        font-size: 14px;
    }
    .league-stat-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: #0f172a;
        padding: 12px;
        border-radius: 8px;
        border: 1px solid rgba(55, 65, 81, 0.5);
    }
    .league-stat-label { color: #9ca3af; }
    .league-stat-value { color: #fff; font-weight: bold; font-size: 18px; }
    
    .league-chart-section { padding: 0 20px 20px; }
    .league-chart-label { font-size: 10px; color: #6b7280; display: block; text-align: center; margin-bottom: 12px; }
    .league-chart-bars { display: flex; align-items: flex-end; gap: 4px; height: 64px; justify-content: center; opacity: 0.7; }
    .league-chart-bar { flex: 1; border-radius: 4px 4px 0 0; }
    .league-chart-labels { display: flex; justify-content: space-between; font-size: 9px; color: #6b7280; margin-top: 4px; padding: 0 4px; }
    
    /* جدول اصلی */
    .league-main {
        width: 100%;
        order: 1;
    }
    .league-table-card {
        background: #1e293b;
        border-radius: 16px;
        border: 1px solid #374151;
        overflow: hidden;
    }
    .league-table-tabs {
        display: flex;
        font-size: 14px;
        border-bottom: 1px solid #374151;
        background: #0f172a;
    }
    .league-table-tabs button {
        padding: 16px 24px;
        color: #fff;
        border: none;
        background: #1e293b;
        border-bottom: 2px solid #3b82f6;
        font-weight: bold;
        cursor: pointer;
        font-family: 'Vazirmatn', sans-serif;
        font-size: 14px;
    }
    
    .league-table-wrap { overflow-x: auto; }
    .league-table { width: 100%; border-collapse: collapse; white-space: nowrap; }
    .league-table thead { background: #0f172a; }
    .league-table th {
        padding: 12px 8px;
        font-size: 13px;
        color: #9ca3af;
        font-weight: bold;
        text-align: center;
        border-bottom: 1px solid #374151;
    }
    .league-table th:first-child { width: 40px; }
    .league-table th:nth-child(2) { text-align: right; min-width: 150px; }
    .league-table td {
        padding: 12px 8px;
        font-size: 14px;
        text-align: center;
        border-bottom: 1px solid rgba(55, 65, 81, 0.3);
        color: #d1d5db;
    }
    .league-table td:first-child { color: #9ca3af; }
    .league-table td:nth-child(2) { text-align: right; }
    .league-table tbody tr:hover { background: rgba(30, 41, 59, 0.5); }
    .league-table .team-cell { display: flex; align-items: center; gap: 12px; }
    .league-table .team-logo {
        width: 32px; height: 32px;
        background: rgba(255,255,255,0.1);
        border-radius: 50%;
        padding: 4px;
        display: flex; align-items: center; justify-content: center;
        overflow: hidden;
    }
    .league-table .team-logo img { width: 100%; height: 100%; object-fit: contain; }
    .league-table .team-name { color: #fff; }
    
    .diff-positive { color: #4ade80 !important; }
    .diff-negative { color: #f87171 !important; }
    .points-cell { color: #fff; font-size: 18px; font-weight: 900; }
    
    .form-badges { display: flex; justify-content: center; gap: 2px; }
    .form-badge {
        width: 20px; height: 20px;
        border-radius: 4px;
        display: flex; align-items: center; justify-content: center;
        font-size: 10px; font-weight: bold; color: #fff;
    }
    .form-w { background: #22c55e; }
    .form-d { background: #6b7280; }
    .form-l { background: #ef4444; }
    
    .league-table-footer {
        padding: 16px;
        border-top: 1px solid #374151;
        background: #0f172a;
        font-size: 10px;
        color: #6b7280;
        display: flex;
        gap: 16px;
        justify-content: center;
        flex-wrap: wrap;
    }
    .league-table-footer > div { display: flex; align-items: center; gap: 4px; }
    .legend-dot { width: 8px; height: 8px; border-radius: 2px; }
    .legend-green { background: #22c55e; }
    .legend-blue { background: #3b82f6; }
    .legend-red { background: #ef4444; }
    
    .fa-num { font-family: 'Vazirmatn', sans-serif; }
    .text-xs { font-size: 12px; }
    
    /* رسپانسیو */
    @media (min-width: 769px) {
        .league-header h1 { font-size: 30px; }
    }
    @media (min-width: 1025px) {
        .league-flex-row { flex-direction: row; }
        .league-sidebar { width: 25%; order: 2; }
        .league-main { width: 75%; order: 1; }
    }
</style>

<div class="league-wrapper">
    <div class="league-header">
        <h1>
            <span class="indicator"></span>
            جدول لیگ برتر ایران (جام خلیج فارس)
        </h1>
        <span class="league-season-badge fa-num">فصل ۱۴۰۵-۱۴۰۴</span>
    </div>

    <div class="league-flex-row">
        
        <!-- سایدبار آمار -->
        <aside class="league-sidebar">
            <div class="league-sidebar-inner">
                <div class="league-stats-card">
                    <div class="league-stats-header">
                        <h3>آمار لیگ برتر (فصل جاری)</h3>
                    </div>
                    
                    <div class="league-stats-body">
                        <div class="league-stat-item">
                            <span class="league-stat-label">مجموع گل‌های زده</span>
                            <span class="league-stat-value fa-num"><?php echo to_farsi_local($total_goals_scored); ?></span>
                        </div>
                        <div class="league-stat-item">
                            <span class="league-stat-label">مسابقات برگزار شده</span>
                            <span class="league-stat-value fa-num"><?php echo to_farsi_local($total_matches_real); ?></span>
                        </div>
                        <div class="league-stat-item">
                            <span class="league-stat-label">متوسط گل در بازی</span>
                            <span class="league-stat-value fa-num"><?php echo to_farsi_local($avg_goal_per_match); ?></span>
                        </div>
                        <div class="league-stat-item">
                            <span class="league-stat-label">متوسط دقیقه هر گل</span>
                            <span class="league-stat-value fa-num"><?php echo to_farsi_local($avg_min_per_goal); ?></span>
                        </div>
                    </div>

                    <div class="league-chart-section">
                        <span class="league-chart-label">پراکندگی دقایق گل‌ها</span>
                        <div class="league-chart-bars">
                            <div class="league-chart-bar" style="background: #4b5563; height: 30%; min-width: 0;"></div>
                            <div class="league-chart-bar" style="background: #4b5563; height: 45%; min-width: 0;"></div>
                            <div class="league-chart-bar" style="background: #6b7280; height: 60%; min-width: 0;"></div>
                            <div class="league-chart-bar" style="background: #6b7280; height: 50%; min-width: 0;"></div>
                            <div class="league-chart-bar" style="background: #4b5563; height: 40%; min-width: 0;"></div>
                            <div class="league-chart-bar" style="background: #2563eb; height: 75%; min-width: 0;"></div>
                        </div>
                        <div class="league-chart-labels fa-num">
                            <span>0'</span><span>45'</span><span>90'+</span>
                        </div>
                    </div>
                </div>
            </div>
        </aside>

        <!-- جدول اصلی -->
        <main class="league-main">
            <div class="league-table-card">
                
                <div class="league-table-tabs">
                    <button>مجموع</button>
                </div>

                <div class="league-table-wrap">
                    <table class="league-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>تیم</th>
                                <th>بازی</th>
                                <th style="color: #4ade80;">برد</th>
                                <th style="color: #d1d5db;">مساوی</th>
                                <th style="color: #f87171;">باخت</th>
                                <th dir="ltr">گل +/-</th>
                                <th>تفاضل</th>
                                <th style="color: #fff; font-weight: 900;">امتیاز</th>
                                <th style="width: 120px;">بازی های اخیر</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            if( !empty($table_data) ):
                                $rank = 1;
                                foreach($table_data as $team):
                                    $diff_sign = ($team['diff'] > 0) ? '+' : '';
                            ?>
                            <tr>
                                <td><?php echo to_farsi_local($rank++); ?></td>
                                <td>
                                    <div class="team-cell">
                                        <?php if($team['logo']): ?>
                                        <div class="team-logo">
                                            <img src="<?php echo esc_url($team['logo']); ?>" alt="">
                                        </div>
                                        <?php endif; ?>
                                        <span class="team-name"><?php echo esc_html($team['name']); ?></span>
                                    </div>
                                </td>
                                <td class="fa-num"><?php echo to_farsi_local($team['played']); ?></td>
                                <td class="fa-num"><?php echo to_farsi_local($team['won']); ?></td>
                                <td class="fa-num"><?php echo to_farsi_local($team['drawn']); ?></td>
                                <td class="fa-num"><?php echo to_farsi_local($team['lost']); ?></td>
                                <td class="fa-num text-xs"><?php echo to_farsi_local($team['gf'] . '-' . $team['ga']); ?></td>
                                <td class="fa-num <?php echo ($team['diff'] >= 0) ? 'diff-positive' : 'diff-negative'; ?>">
                                    <?php echo to_farsi_local($diff_sign . $team['diff']); ?>
                                </td>
                                <td class="points-cell fa-num"><?php echo to_farsi_local($team['points']); ?></td>
                                <td>
                                    <div class="form-badges">
                                        <?php 
                                        if($team['form']) {
                                            $results = explode(',', $team['form']);
                                            foreach($results as $res) {
                                                $res = strtoupper(trim($res));
                                                $class = 'form-d';
                                                if($res === 'W') $class = 'form-w';
                                                if($res === 'L') $class = 'form-l';
                                                echo '<span class="form-badge '.$class.'">'.$res.'</span>';
                                            }
                                        } else { echo '-'; }
                                        ?>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; else : ?>
                            <tr><td colspan="10" style="text-align: center; padding: 32px; color: #6b7280;">هنوز تیمی ثبت نشده است.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                
                <div class="league-table-footer">
                    <div><span class="legend-dot legend-green"></span>لیگ نخبگان آسیا</div>
                    <div><span class="legend-dot legend-blue"></span>سطح دوم آسیا</div>
                    <div><span class="legend-dot legend-red"></span>سقوط به دسته یک</div>
                </div>

            </div>
        </main>

    </div>
</div>

<?php get_footer('sport'); ?>