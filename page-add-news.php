<?php
/* Template Name: Frontend News Editor */

// ⚠️ CRITICAL: ACF form head must load before get_header() or any HTML is output!
acf_form_head();
get_header(); 
?>

<style>
    .frontend-editor-shell {
        background: rgba(255, 255, 255, 0.96);
        border-radius: 28px;
        border: 1px solid rgba(226, 232, 240, 0.95);
        padding: 50px 60px;
        box-shadow: 0 24px 65px rgba(15, 23, 42, 0.08);
        max-width: 1400px;
        margin: 0 auto;
        backdrop-filter: blur(10px);
    }
    
    /* =========================================================
       CSS GRID LAYOUT (DESKTOP)
    ========================================================= */
    .acf-fields {
        display: grid;
        grid-template-columns: 4.5fr 4.5fr 3fr; 
        gap: 20px 35px; 
        align-items: start;
    }

    /* RIGHT & CENTER (Main Content) */
    .acf-field[data-name="_post_title"] { grid-column: 1 / 3; grid-row: 1; }
    .acf-field[data-name="frontend_image"] { grid-column: 1 / 2; grid-row: 2; }
    .acf-field[data-name="frontend_excerpt"] { grid-column: 2 / 3; grid-row: 2; }
    .acf-field[data-name="_post_content"] { grid-column: 1 / 3; grid-row: 3 / 8; }

    /* FAR LEFT (Sidebar) */
    .acf-field[data-name="video_preview_url"] { grid-column: 3 / 4; grid-row: 1; }
    .acf-field[data-name="frontend_categories"] { grid-column: 3 / 4; grid-row: 2; }
    .acf-field[data-name="frontend_tags"] { grid-column: 3 / 4; grid-row: 3; }
    .acf-field[data-name="frontend_status"] { grid-column: 3 / 4; grid-row: 4; }

    /* =========================================================
       PLACEHOLDER STYLING
    ========================================================= */
    ::placeholder { color: #94a3b8 !important; opacity: 1 !important; font-weight: normal !important; }
    .acf-field[data-name="_post_title"] input::placeholder { color: #cbd5e1 !important; font-weight: bold !important; }

    /* =========================================================
       COMPONENT STYLING
    ========================================================= */
    
    /* Title */
    .acf-field[data-name="_post_title"] { padding: 0 !important; margin-bottom: 15px; }
    .acf-field[data-name="_post_title"] > .acf-label { display: none; }
    .acf-field[data-name="_post_title"] input {
        font-family: 'Diba', 'Vazirmatn', sans-serif !important; color: var(--sharji-blue) !important;
        font-size: 42px !important; line-height: 1.45 !important; padding: 0 0 22px 0 !important;
        border: none !important; background: transparent !important; box-shadow: none !important;
        border-radius: 0 !important; width: 100%;
    }
    .acf-field[data-name="_post_title"] .acf-input { position: relative; }
    .acf-field[data-name="_post_title"] .acf-input::after {
        content: ""; position: absolute; right: 0; bottom: 0; width: 86px; height: 5px; border-radius: 999px;
        background: linear-gradient(90deg, var(--sharji-red), var(--sharji-blue));
    }

    /* 🔥 BEAUTIFUL IMAGE UPLOADER 🔥 */
    .acf-field[data-name="frontend_image"] { padding: 0 !important; height: 100%; }
    .acf-field[data-name="frontend_image"] > .acf-label { display: none; } 
    .acf-field[data-name="frontend_image"] .acf-input { height: 100%; min-height: 300px; }
    
    .acf-field[data-name="frontend_image"] .acf-image-uploader {
        border-radius: 24px; overflow: hidden; border: 2px dashed #cbd5e1;
        background: #f8fafc; display: flex; flex-direction: column; justify-content: center; align-items: center;
        height: 100%; min-height: 300px; transition: all 0.3s ease; cursor: pointer;
    }
    .acf-field[data-name="frontend_image"] .acf-image-uploader:hover {
        border-color: var(--sharji-blue); background: #eff6ff;
    }
    .acf-field[data-name="frontend_image"] .acf-image-uploader.has-value {
        border: 1px solid #e2e8f0; border-style: solid; box-shadow: 0 18px 38px rgba(15, 23, 42, 0.10); padding: 0;
    }
    .acf-field[data-name="frontend_image"] .acf-image-uploader img { 
        width: 100%; height: 100%; object-fit: cover; min-height: 300px; 
    }

    .acf-field[data-name="frontend_image"] .hide-if-value p { font-size: 0 !important; text-align: center; }
    .acf-field[data-name="frontend_image"] .hide-if-value p::before {
        content: "\f0ee"; font-family: "Font Awesome 5 Free"; font-weight: 900;
        font-size: 52px; color: #94a3b8; transition: 0.3s ease; display: block; margin-bottom: 15px;
    }
    .acf-field[data-name="frontend_image"] .hide-if-value p::after {
        content: "برای انتخاب تصویر شاخص کلیک کنید";
        font-family: 'Vazirmatn', sans-serif; font-size: 15px; color: #475569; font-weight: bold; display: block; margin-bottom: 10px;
    }
    .acf-field[data-name="frontend_image"] .acf-image-uploader:hover .hide-if-value p::before {
        color: var(--sharji-blue); transform: translateY(-5px);
    }
    
    .acf-field[data-name="frontend_image"] .acf-button.button {
        background: var(--sharji-blue); color: #fff; border: none; padding: 10px 24px; border-radius: 999px;
        font-family: 'Vazirmatn', sans-serif !important; font-weight: 900; font-size: 13px !important; 
        text-decoration: none; box-shadow: 0 4px 12px rgba(0, 86, 179, 0.2); transition: 0.3s ease; display: inline-block;
    }
    .acf-field[data-name="frontend_image"] .acf-button.button:hover {
        background: var(--sharji-red); box-shadow: 0 6px 16px rgba(227, 30, 36, 0.25);
    }

    /* Excerpt Box */
    .acf-field[data-name="frontend_excerpt"] {
        background: radial-gradient(circle at top right, rgba(0, 86, 179, 0.10), transparent 36%), linear-gradient(180deg, #ffffff 0%, #f8fafc 100%) !important;
        border: 1px solid #e2e8f0 !important; border-right: 5px solid var(--sharji-blue) !important;
        border-radius: 24px !important; padding: 24px !important; height: 100%; display: flex; flex-direction: column;
    }
    .acf-field[data-name="frontend_excerpt"] > .acf-label label {
        color: var(--sharji-blue) !important; font-size: 15px !important; font-weight: 900 !important; margin-bottom: 12px !important;
    }
    .acf-field[data-name="frontend_excerpt"] > .acf-label label::before {
        content: ""; display: inline-block; width: 8px; height: 8px; border-radius: 999px; background: var(--sharji-blue); margin-left: 8px;
    }
    .acf-field[data-name="frontend_excerpt"] textarea {
        background: transparent !important; border: none !important; box-shadow: none !important; padding: 0 !important;
        font-family: 'Vazirmatn', sans-serif !important; font-size: 16px !important; line-height: 2.05 !important;
        color: #334155 !important; min-height: 220px; resize: none;
    }

    /* Content Editor */
    .acf-field[data-name="_post_content"] { padding: 0 !important; margin-top: 15px; }
    .acf-field[data-name="_post_content"] > .acf-label { display: none; }
    .wp-editor-container { border-radius: 16px !important; overflow: hidden; border: 1px solid #e2e8f0 !important; box-shadow: 0 10px 25px rgba(0,0,0,0.03) !important; }

    /* Compact Sidebar */
    .acf-field[data-name="video_preview_url"] > .acf-label label,
    .acf-field[data-name="frontend_categories"] > .acf-label label,
    .acf-field[data-name="frontend_tags"] > .acf-label label,
    .acf-field[data-name="frontend_status"] > .acf-label label {
        font-family: 'Diba', 'Vazirmatn', sans-serif !important; font-size: 14px !important; color: #1e293b !important; margin-bottom: 8px !important; 
    }

    .acf-field[data-name="video_preview_url"] input[type="url"],
    .acf-field[data-name="video_preview_url"] input[type="text"] {
        width: 100% !important; padding: 10px 14px !important; border-radius: 12px !important;
        border: 1px solid #cbd5e1 !important; background: #fff !important; box-shadow: none !important;
        font-size: 13px !important; direction: ltr; text-align: left; transition: 0.3s;
    }
    .acf-field[data-name="video_preview_url"] input:focus { border-color: var(--sharji-blue) !important; box-shadow: 0 0 0 3px rgba(0,86,179,0.1) !important; }

    .acf-field[data-name="frontend_categories"] .acf-input { max-height: none !important; }
    .acf-field[data-name="frontend_categories"] .acf-taxonomy-field {
        border: 1px solid #e2e8f0 !important; border-radius: 12px !important; background: #fff; padding: 10px;
    }
    .acf-field[data-name="frontend_categories"] .categorychecklist-holder,
    .acf-field[data-name="frontend_categories"] .acf-checkbox-list {
        max-height: 180px !important; overflow-y: auto !important; border: none !important; padding: 0 !important; margin: 0 !important;
    }
    .acf-field[data-name="frontend_categories"] ul li { font-size: 13px !important; color: #475569; margin-bottom: 5px; }

    .acf-field select, .select2-container .select2-selection--multiple {
        width: 100% !important; padding: 6px 12px !important; border-radius: 10px !important; 
        border: 1px solid #e2e8f0 !important; font-family: 'Vazirmatn', sans-serif !important; 
        font-size: 13px !important; color: #334155 !important; background: #fff !important; min-height: 38px !important;
    }

    /* Submit Button */
    .acf-form-submit { margin-top: 40px; border-top: 1px solid #e2e8f0; padding-top: 30px; text-align: left; }
    .acf-form-submit .acf-button {
        background: linear-gradient(135deg, var(--sharji-blue), #0b66c3) !important; color: #fff !important; border: none !important; border-radius: 14px !important;
        padding: 14px 45px !important; font-family: 'Vazirmatn', sans-serif !important; font-size: 16px !important; font-weight: 900 !important; cursor: pointer;
        box-shadow: 0 12px 24px rgba(0, 86, 179, 0.18); transition: all 0.25s ease;
    }
    .acf-form-submit .acf-button:hover { transform: translateY(-2px); background: linear-gradient(135deg, var(--sharji-red), #ef4444) !important; }

    /* =========================================================
       📱 PERFECT MOBILE RESPONSIVENESS
    ========================================================= */
    @media (max-width: 1024px) {
        .acf-fields { 
            display: flex !important; /* Switch from grid to flex for strict ordering */
            flex-direction: column !important;
            gap: 24px !important; 
        }
        .acf-field { width: 100% !important; margin: 0 !important; }
        
        /* Force Logical Mobile Reading Order */
        .acf-field[data-name="_post_title"] { order: 1; }
        .acf-field[data-name="frontend_image"] { order: 2; }
        .acf-field[data-name="frontend_excerpt"] { order: 3; }
        .acf-field[data-name="_post_content"] { order: 4; }
        .acf-field[data-name="video_preview_url"] { order: 5; }
        .acf-field[data-name="frontend_categories"] { order: 6; }
        .acf-field[data-name="frontend_tags"] { order: 7; }
        .acf-field[data-name="frontend_status"] { order: 8; }
        
        .frontend-editor-shell { padding: 35px 25px; }
    }

    @media (max-width: 768px) {
        .single-main-wrapper { margin-top: 20px !important; margin-bottom: 20px !important; padding: 0 15px !important; }
        .frontend-editor-shell { padding: 25px 15px; border-radius: 20px; }
        
        /* Typography Scaling */
        .acf-field[data-name="_post_title"] input { font-size: 26px !important; line-height: 1.5 !important; padding-bottom: 15px !important; }
        
        /* Component Scaling */
        .acf-field[data-name="frontend_image"] .acf-input,
        .acf-field[data-name="frontend_image"] .acf-image-uploader,
        .acf-field[data-name="frontend_image"] .acf-image-uploader img { min-height: 200px !important; height: 200px !important; }
        
        .acf-field[data-name="frontend_image"] .hide-if-value p::before { font-size: 38px !important; margin-bottom: 10px !important; }
        .acf-field[data-name="frontend_image"] .hide-if-value p::after { font-size: 13px !important; }
        
        .acf-field[data-name="frontend_excerpt"] { padding: 18px !important; border-radius: 18px !important; }
        .acf-field[data-name="frontend_excerpt"] textarea { min-height: 130px !important; font-size: 14.5px !important; }

        /* Full Width Mobile Button */
        .acf-form-submit { margin-top: 30px; text-align: center; }
        .acf-form-submit .acf-button { width: 100% !important; padding: 16px !important; font-size: 18px !important; }
    }
</style>

<div class="single-main-wrapper" style="margin-top: 50px; margin-bottom: 50px;">
    <main class="frontend-editor-shell">
        
        <?php
        if ( is_user_logged_in() ) {
            acf_form(array(
                'post_id'       => 'new_post',
                'new_post'      => array(
                    'post_type'   => 'post',
                    'post_status' => 'draft'
                ),
                'post_title'    => true,  
                'post_content'  => true,  
                'field_groups'  => array('group_sharji_frontend_news'),
                'submit_value'  => 'ذخیره خبر',
                'updated_message' => '<div style="background:#dcfce7; color:#16a34a; padding:15px; border-radius:12px; margin-bottom:30px; font-weight:bold; font-size: 16px;">خبر شما با موفقیت ذخیره شد.</div>',
            ));
        } else {
            echo '<div style="text-align: center; padding: 40px; color: #e31e24; font-family: Diba, sans-serif; font-size: 24px;">برای نوشتن خبر باید وارد حساب کاربری خود شوید.</div>';
        }
        ?>

    </main>
</div>

<!-- INJECT PLACEHOLDERS VIA JAVASCRIPT -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Title Placeholder
        const titleInput = document.querySelector('.acf-field[data-name="_post_title"] input');
        if(titleInput) titleInput.setAttribute('placeholder', 'عنوان خبر را اینجا تایپ کنید...');

        // Excerpt Placeholder
        const excerptInput = document.querySelector('.acf-field[data-name="frontend_excerpt"] textarea');
        if(excerptInput) excerptInput.setAttribute('placeholder', 'چکیده یا خلاصه خبر را در این کادر بنویسید...');

        // Video URL Placeholder
        const videoInput = document.querySelector('.acf-field[data-name="video_preview_url"] input');
        if(videoInput) videoInput.setAttribute('placeholder', 'https://example.com/video.mp4');
    });
</script>

<?php get_footer(); ?>