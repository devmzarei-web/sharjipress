<?php
/**
 * Template Name: Sharji Sport - League Table (Blue & Modular)
 * File Name: page-league-table.php
 */

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
