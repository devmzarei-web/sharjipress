<?php
/**
 * Sharji Press - Comments Rendering Callbacks
 * Custom callbacks for main theme and sport sub-theme comment trees
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Main Theme Comment Callback
 */
function sharji_main_comment_callback( $comment, $args, $depth ) {
    $GLOBALS['comment'] = $comment;
    ?>
    <li <?php comment_class( 'mb-6 list-none' ); ?> id="comment-<?php comment_ID(); ?>">
        <div class="comment-body bg-white border border-slate-100 p-4 rounded-xl shadow-sm hover:shadow-md transition relative">
            <div class="flex items-start gap-3">
                <div class="flex-shrink-0">
                    <div class="w-10 h-10 rounded-full overflow-hidden border border-slate-200">
                        <?php echo get_avatar( $comment, 50, '', 'Avatar', ['class' => 'w-full h-full object-cover'] ); ?>
                    </div>
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex flex-wrap items-center justify-between mb-2">
                        <div class="flex items-center gap-2">
                            <h5 class="text-sm font-bold text-slate-800"><?php echo get_comment_author(); ?></h5>
                            <?php if ( $comment->user_id === get_the_author_meta( 'ID' ) ) : ?>
                                <span class="text-[10px] bg-blue-100 text-blue-600 px-2 py-0.5 rounded-full">نویسنده</span>
                            <?php endif; ?>
                        </div>
                        <span class="text-[11px] text-slate-400"><?php echo get_comment_date( 'j F Y' ); ?></span>
                    </div>
                    <div class="text-slate-600 text-sm leading-7 text-justify">
                        <?php if ( $comment->comment_approved == '0' ) : ?>
                            <p class="text-orange-500 text-xs bg-orange-50 p-2 rounded mb-2">دیدگاه شما در انتظار تأیید است.</p>
                        <?php endif; ?>
                        <?php comment_text(); ?>
                    </div>
                    <div class="mt-2 text-left">
                        <?php comment_reply_link( array_merge( $args, [
                            'depth'      => $depth,
                            'max_depth'  => $args['max_depth'],
                            'reply_text' => '<i class="fas fa-reply text-[10px]"></i> پاسخ',
                            'class'      => 'text-[11px] text-slate-400 hover:text-blue-600 transition inline-flex items-center gap-1',
                        ] ) ); ?>
                    </div>
                </div>
            </div>
        </div>
    <?php
}

/**
 * Sport Sub-theme Comment Callback with Gamification Ranks
 */
function sharji_sport_comment_callback( $comment, $args, $depth ) {
    $GLOBALS['comment'] = $comment;
    $user_id = $comment->user_id;
    $rank = $user_id ? get_sharji_user_rank( $user_id ) : ['title' => 'مهمان', 'color' => '#94a3b8', 'icon' => 'fa-user'];
    ?>
    <li <?php comment_class( 'mb-6 list-none' ); ?> id="comment-<?php comment_ID(); ?>">
        <div class="comment-body bg-[#1e293b] border border-gray-700 p-4 rounded-xl shadow-lg relative hover:border-blue-500/50 transition">
            <div class="flex items-start gap-4">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 rounded-full overflow-hidden border-2 border-gray-600 shadow-md">
                        <?php echo get_avatar( $comment, 60, '', 'Avatar', ['class' => 'w-full h-full object-cover'] ); ?>
                    </div>
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex flex-wrap items-center justify-between mb-2">
                        <div class="flex items-center gap-2">
                            <h5 class="text-sm font-bold text-white"><?php echo get_comment_author(); ?></h5>
                            <span class="text-[10px] px-2 py-0.5 rounded bg-[#0f172a] border border-gray-700 flex items-center gap-1 shadow-inner" style="color: <?php echo esc_attr( $rank['color'] ); ?>;">
                                <i class="fas <?php echo esc_attr( $rank['icon'] ); ?>"></i> <?php echo esc_html( $rank['title'] ); ?>
                            </span>
                        </div>
                        <span class="text-[11px] text-gray-500"><?php echo get_comment_date( 'j F Y' ); ?></span>
                    </div>
                    <div class="text-gray-300 text-sm leading-7 text-justify">
                        <?php if ( $comment->comment_approved == '0' ) : ?>
                            <p class="text-yellow-400 text-xs bg-yellow-900/20 p-2 rounded mb-2 border border-yellow-500/20">دیدگاه شما در انتظار تأیید است.</p>
                        <?php endif; ?>
                        <?php comment_text(); ?>
                    </div>
                    <div class="mt-3 text-left">
                        <?php comment_reply_link( array_merge( $args, [
                            'depth'      => $depth,
                            'max_depth'  => $args['max_depth'],
                            'reply_text' => '<i class="fas fa-reply text-[10px]"></i> پاسخ',
                            'class'      => 'text-[11px] text-blue-400 hover:text-white bg-[#0f172a] px-3 py-1 rounded border border-gray-700 transition inline-flex items-center gap-1',
                        ] ) ); ?>
                    </div>
                </div>
            </div>
        </div>
    <?php
}

