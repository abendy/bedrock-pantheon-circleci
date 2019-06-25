<?php

// Load VC includes/templates.
if ( class_exists( 'Vc_Manager' ) ) {

    function rltd_vc_before_init_actions() {

        // Remove default VC shortcodes.
        vc_remove_element( 'vc_accordion' );
        vc_remove_element( 'vc_basic_grid' );
        vc_remove_element( 'vc_btn' );
        vc_remove_element( 'vc_column_text' );
        vc_remove_element( 'vc_cta' );
        vc_remove_element( 'vc_custom_heading' );
        vc_remove_element( 'vc_empty_space' );
        vc_remove_element( 'vc_facebook' );
        vc_remove_element( 'vc_flickr' );
        vc_remove_element( 'vc_gallery' );
        vc_remove_element( 'vc_gmaps' );
        vc_remove_element( 'vc_googleplus' );
        vc_remove_element( 'vc_hoverbox' );
        vc_remove_element( 'vc_icon' );
        vc_remove_element( 'vc_images_carousel' );
        vc_remove_element( 'vc_line_chart' );
        vc_remove_element( 'vc_masonry_grid' );
        vc_remove_element( 'vc_masonry_media_grid' );
        vc_remove_element( 'vc_media_grid' );
        vc_remove_element( 'vc_message' );
        vc_remove_element( 'vc_pinterest' );
        vc_remove_element( 'vc_pie' );
        vc_remove_element( 'vc_posts_grid' );
        vc_remove_element( 'vc_posts_slider' );
        vc_remove_element( 'vc_progress_bar' );
        vc_remove_element( 'vc_raw_html' );
        vc_remove_element( 'vc_raw_js' );
        vc_remove_element( 'vc_round_chart' );
        vc_remove_element( 'vc_section' );
        vc_remove_element( 'vc_separator' );
        vc_remove_element( 'vc_single_image' );
        vc_remove_element( 'vc_tabs' );
        vc_remove_element( 'vc_text_separator' );
        vc_remove_element( 'vc_toggle' );
        vc_remove_element( 'vc_tour' );
        vc_remove_element( 'vc_tweetmeme' );
        vc_remove_element( 'vc_tta_accordion' );
        vc_remove_element( 'vc_tta_pageable' );
        vc_remove_element( 'vc_tta_tabs' );
        vc_remove_element( 'vc_tta_tour' );
        vc_remove_element( 'vc_video' );
        vc_remove_element( 'vc_widget_sidebar' );
        vc_remove_element( 'vc_wp_archives' );
        vc_remove_element( 'vc_wp_calendar' );
        vc_remove_element( 'vc_wp_categories' );
        vc_remove_element( 'vc_wp_custommenu' );
        vc_remove_element( 'vc_wp_links' );
        vc_remove_element( 'vc_wp_meta' );
        vc_remove_element( 'vc_wp_pages' );
        vc_remove_element( 'vc_wp_posts' );
        vc_remove_element( 'vc_wp_recentcomments' );
        vc_remove_element( 'vc_wp_rss' );
        vc_remove_element( 'vc_wp_search' );
        vc_remove_element( 'vc_wp_tagcloud' );
        vc_remove_element( 'vc_wp_text' );
        vc_remove_element( 'vc_zigzag' );

        vc_remove_element( 'vc_acf' );
        vc_remove_element( 'gravityform' );

        // Set custom module directory.
        $controllers_dir = get_template_directory() . '/controllers/';

        // Add custom modules/shortcodes.
        include_once $controllers_dir . 'inc.banner.php';
        include_once $controllers_dir . 'inc.block-quote.php';
        include_once $controllers_dir . 'inc.content.php';
        include_once $controllers_dir . 'inc.content-aggregate.php';
        include_once $controllers_dir . 'inc.content-list.php';
        include_once $controllers_dir . 'inc.content-teaser-carousel.php';
        include_once $controllers_dir . 'inc.dynamic-news-row.php';
        include_once $controllers_dir . 'inc.event-content.php';
        include_once $controllers_dir . 'inc.event-listing.php';
        include_once $controllers_dir . 'inc.events.php';
        include_once $controllers_dir . 'inc.feature-list.php';
        include_once $controllers_dir . 'inc.feature-tabs.php';
        include_once $controllers_dir . 'inc.featured-content.php';
        include_once $controllers_dir . 'inc.form.php';
        include_once $controllers_dir . 'inc.hero.php';
        include_once $controllers_dir . 'inc.job-listing.php';
        include_once $controllers_dir . 'inc.map.php';
        include_once $controllers_dir . 'inc.page-outro.php';
        include_once $controllers_dir . 'inc.social-media-feed.php';
        include_once $controllers_dir . 'inc.statistic.php';
        include_once $controllers_dir . 'inc.tables.php';
        include_once $controllers_dir . 'inc.title-block.php';
    }
    add_action( 'vc_before_init', 'rltd_vc_before_init_actions' );

    // Set VC as default editor for all content types.
    function rltd_vc_set_default_editor_post_types() {
        $post_types = rltd_get_post_types( 'names' );
        $post_types['page'] = 'page';

        vc_set_default_editor_post_types( array_values( $post_types ) );
        vc_editor_set_post_types( array_values( $post_types ) );
    }
    add_action( 'vc_before_init', 'rltd_vc_set_default_editor_post_types' );

    // Disable front end editor.
    function rltd_vc_disable_frontend() {
        vc_disable_frontend();
    }
    add_action( 'vc_before_init', 'rltd_vc_disable_frontend' );

    // Hide VC UI options.
    function rltd_hide_vc_options() {
        echo "<style>
        .wpb_vc_row .vc_controls.controls_row .vc_control.column_move,
        .wpb_vc_row .vc_controls.controls_row .vc_control.vc_row_layouts,
        .wpb_vc_row .vc_controls.controls_row .vc_control.column_add,
        .wpb_vc_row .vc_controls.controls_row .vc_control.column_clone,
        .wpb_vc_row .vc_controls.controls_row .vc_control.column_edit,
        #vc_no-content-helper {
            display: none !important;
        }
        </style>";
    }
    add_action( 'admin_head', 'rltd_hide_vc_options' );

    function rltd_vc_wp_enqueue_scripts() {
        wp_dequeue_style( 'js_composer_front' );
        wp_deregister_style( 'js_composer_front' );
        wp_dequeue_style( 'js_composer_custom_css' );
        wp_deregister_style( 'js_composer_custom_css' );
        wp_dequeue_script( 'wpb_composer_front_js' );
    }
    add_action( 'wp_enqueue_scripts', 'rltd_vc_wp_enqueue_scripts' );

    // Set RTE field width when textarea field present.
    function rltd_set_rte_width() {
        if ( 'vc_edit_form' === vc_post_param( 'action' )
            && ( 'rltd_content' === $_REQUEST['tag'] || 'rltd_content' === $_REQUEST['tag'] || 'rltd_natural_language_processing' === $_REQUEST['tag'] || 'rltd_tables' === $_REQUEST['tag'] )
        ) {
            echo '<style> #vc_ui-panel-edit-element, *[data-vc-ui-element="panel-edit-element"] { left: 50% !important; width: 60% !important; } .vc_ui-panel-window-inner { position: relative !important; left: -50% !important; } </style>';
        }
    }
    add_action( 'init', 'rltd_set_rte_width' );
}
