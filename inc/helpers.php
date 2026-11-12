<?php
/**
 * Sharji Press - Helper Functions
 * Date conversions, Farsi numerals, and view counting
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Convert English digits to Persian digits
 */
if ( ! function_exists( 'sharji_to_farsi_digits' ) ) {
    function sharji_to_farsi_digits( $string ) {
        $persian = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
        $english = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
        return str_replace( $english, $persian, (string) $string );
    }
}

/**
 * Convert Persian digits to English digits
 */
if ( ! function_exists( 'sharji_to_english_digits' ) ) {
    function sharji_to_english_digits( $string ) {
        $persian = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
        $english = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
        return str_replace( $persian, $english, (string) $string );
    }
}

/**
 * Backwards compatibility aliases used in existing templates
 */
if ( ! function_exists( 'to_farsi_local' ) ) {
    function to_farsi_local( $number ) {
        return sharji_to_farsi_digits( $number );
    }
}

if ( ! function_exists( 'to_farsi' ) ) {
    function to_farsi( $string ) {
        return sharji_to_farsi_digits( $string );
    }
}

if ( ! function_exists( 'sharji_to_persian_num' ) ) {
    function sharji_to_persian_num( $number ) {
        return sharji_to_farsi_digits( $number );
    }
}

if ( ! function_exists( 'to_english_digits' ) ) {
    function to_english_digits( $string ) {
        return sharji_to_english_digits( $string );
    }
}

/**
 * Gregorian to Jalali (Solar Hijri) Date Conversion
 */
if ( ! function_exists( 'sharji_gregorian_to_jalali' ) ) {
    function sharji_gregorian_to_jalali( $gy, $gm, $gd ) {
        $g_d_m = [0, 31, 59, 90, 120, 151, 181, 212, 243, 273, 304, 334];

        if ( $gy > 1600 ) {
            $jy = 979;
            $gy -= 1600;
        } else {
            $jy = 0;
            $gy -= 621;
        }

        $gy2 = ( $gm > 2 ) ? ( $gy + 1 ) : $gy;

        $days = ( 365 * $gy )
            + intval( ( $gy2 + 3 ) / 4 )
            - intval( ( $gy2 + 99 ) / 100 )
            + intval( ( $gy2 + 399 ) / 400 )
            - 80
            + $gd
            + $g_d_m[$gm - 1];

        $jy += 33 * intval( $days / 12053 );
        $days %= 12053;

        $jy += 4 * intval( $days / 1461 );
        $days %= 1461;

        if ( $days > 365 ) {
            $jy += intval( ( $days - 1 ) / 365 );
            $days = ( $days - 1 ) % 365;
        }

        if ( $days < 186 ) {
            $jm = 1 + intval( $days / 31 );
            $jd = 1 + ( $days % 31 );
        } else {
            $jm = 7 + intval( ( $days - 186 ) / 30 );
            $jd = 1 + ( ( $days - 186 ) % 30 );
        }

        return [$jy, $jm, $jd];
    }
}

/**
 * Formatted Jalali Date for Posts
 */
if ( ! function_exists( 'sharji_jalali_post_date' ) ) {
    function sharji_jalali_post_date( $timestamp = null ) {
        if ( ! $timestamp ) {
            $timestamp = get_the_time( 'U' );
        }

        $gy = (int) date( 'Y', $timestamp );
        $gm = (int) date( 'n', $timestamp );
        $gd = (int) date( 'j', $timestamp );
        $weekday_index = (int) date( 'w', $timestamp );

        list( $jy, $jm, $jd ) = sharji_gregorian_to_jalali( $gy, $gm, $gd );

        $weekdays = [
            'یکشنبه',
            'دوشنبه',
            'سه‌شنبه',
            'چهارشنبه',
            'پنجشنبه',
            'جمعه',
            'شنبه',
        ];

        $months = [
            1  => 'فروردین',
            2  => 'اردیبهشت',
            3  => 'خرداد',
            4  => 'تیر',
            5  => 'مرداد',
            6  => 'شهریور',
            7  => 'مهر',
            8  => 'آبان',
            9  => 'آذر',
            10 => 'دی',
            11 => 'بهمن',
            12 => 'اسفند',
        ];

        return sharji_to_farsi_digits( $weekdays[$weekday_index] . ' ' . $jd . ' ' . $months[$jm] . ' ' . $jy );
    }
}

if ( ! function_exists( 'sharji_sport_jalali_date' ) ) {
    function sharji_sport_jalali_date( $timestamp = null ) {
        return sharji_jalali_post_date( $timestamp );
    }
}

/**
 * Get formatted post view count
 */
if ( ! function_exists( 'get_post_views' ) ) {
    function get_post_views( $post_id ) {
        $count = get_post_meta( $post_id, 'post_views_count', true );
        if ( $count === '' ) {
            return '۰';
        }
        return sharji_to_farsi_digits( number_format_i18n( (int) $count ) );
    }
}

// Sport Context Helpers
if ( ! function_exists( 'sharji_is_sport_single' ) ) {
    function sharji_is_sport_single() {
        if ( ! is_single() ) {
            return false;
        }
        $theme_param = isset( $_GET['theme'] ) ? sanitize_key( wp_unslash( $_GET['theme'] ) ) : '';
        return $theme_param === 'sport' || is_page_template( 'single-sport.php' );
    }
}

if ( ! function_exists( 'sharji_is_sport_context' ) ) {
    function sharji_is_sport_context() {
        return is_category( 'sport' )
            || is_page_template( 'page-league-table.php' )
            || is_page_template( 'page-newspapers.php' )
            || is_page_template( 'page-wlivescores.php' )
            || sharji_is_sport_single();
    }
}

// Editorial Permit Helper
if ( ! function_exists( 'sharji_render_erasaneh_trust_box' ) ) {
    function sharji_render_erasaneh_trust_box( $box_class = 'erasaneh-trust-box', $license_id = 83702 ) {
        $box_class   = sanitize_html_class( $box_class, 'erasaneh-trust-box' );
        $license_id  = absint( $license_id );
        $farsi_id    = sharji_to_farsi_digits( (string) $license_id );
        $container   = 'div_eRasanehTrustseal_' . $license_id;
        $fallback_id = 'sharjiPermitFallback_' . $license_id;
        ?>
        <div class="<?php echo esc_attr( $box_class ); ?>">
            <div id="<?php echo esc_attr( $container ); ?>"></div>
            <a href="https://e-rasaneh.ir/" target="_blank" rel="noopener noreferrer" class="sharji-permit-fallback" id="<?php echo esc_attr( $fallback_id ); ?>">
                <span class="sharji-permit-icon"><i class="fas fa-shield-alt"></i></span>
                <span class="sharji-permit-meta">
                    <strong class="sharji-permit-title">دارای مجوز رسمی رسانه</strong>
                    <span class="sharji-permit-sub">وزارت فرهنگ و ارشاد اسلامی | کد: <?php echo esc_html( $farsi_id ); ?></span>
                </span>
            </a>
        </div>
        <script>
        (function () {
            var sealEl = document.getElementById('<?php echo esc_js( $container ); ?>');
            var fallbackEl = document.getElementById('<?php echo esc_js( $fallback_id ); ?>');
            if (!sealEl || !fallbackEl) return;

            var syncSealState = function () {
                if (sealEl.children.length > 0 || sealEl.innerHTML.trim() !== '') {
                    fallbackEl.style.display = 'none';
                    return true;
                }
                return false;
            };

            if (typeof MutationObserver === 'function') {
                var observer = new MutationObserver(function () {
                    if (syncSealState()) {
                        observer.disconnect();
                    }
                });
                observer.observe(sealEl, { childList: true, subtree: true });
            }

            var script = document.createElement('script');
            script.src = 'https://trustseal.e-rasaneh.ir/trustseal.js';
            script.async = true;
            script.onload = function () {
                if (typeof window.eRasaneh_Trustseal === 'function') {
                    try {
                        window.eRasaneh_Trustseal(<?php echo (int) $license_id; ?>, true);
                        setTimeout(syncSealState, 300);
                    } catch (e) {}
                }
            };
            document.body.appendChild(script);
        })();
        </script>
        <?php
    }
}

// Author Visibility Helpers
if ( ! function_exists( 'sharji_can_manage_author_visibility' ) ) {
    function sharji_can_manage_author_visibility() {
        if ( ! is_user_logged_in() || ! current_user_can( 'manage_options' ) ) {
            return false;
        }
        $user = wp_get_current_user();
        return in_array( 'administrator', (array) $user->roles, true );
    }
}

if ( ! function_exists( 'sharji_should_show_post_author' ) ) {
    function sharji_should_show_post_author( $post_id = 0 ) {
        $post_id = $post_id ? absint( $post_id ) : get_the_ID();
        if ( ! $post_id ) {
            return false;
        }
        return get_post_meta( $post_id, '_sharji_show_author', true ) === '1';
    }
}

