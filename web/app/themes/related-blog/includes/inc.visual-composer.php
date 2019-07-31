<?php

if ( class_exists( 'Vc_Manager' ) ) {
  // Remove default VC shortcodes.
  function rltd_vc_remove_element() {
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
    // vc_remove_element( 'gravityform' );
  }
  add_action( 'vc_before_init', 'rltd_vc_remove_element' );

  // Include custom mapped VC modules.
  function rltd_include_modules() {
    $controllers_dir = get_template_directory() . '/controllers/';

    include_once $controllers_dir . 'ad.php';
    include_once $controllers_dir . 'content-list.php';
    include_once $controllers_dir . 'featured-content-list.php';
    include_once $controllers_dir . 'grouped-content-list.php';
    // include_once $controllers_dir . 'gallery.php';
    include_once $controllers_dir . 'hero.php';
    include_once $controllers_dir . 'social-share.php';
    include_once $controllers_dir . 'text-block.php';
  }
  add_action( 'vc_before_init', 'rltd_include_modules' );

  // Set custom template directory
  function rltd_vc_set_shortcodes_templates_dir() {
    if ( function_exists( 'vc_set_shortcodes_templates_dir' ) ) {
      vc_set_shortcodes_templates_dir( get_template_directory() . '/templates/vc' );
    }
  }
  add_action( 'vc_before_init', 'rltd_vc_set_shortcodes_templates_dir' );

  // Convert to Bulma responsive classes
  function rltd_wpb_translateColumnWidthToSpan( $width ) {
    preg_match( '/(\d+)\/(\d+)/', $width, $matches );

    if ( ! empty( $matches ) ) {
      $part_x = (int) $matches[1];
      $part_y = (int) $matches[2];
      if ( $part_x > 0 && $part_y > 0 ) {
        $value = ceil( $part_x / $part_y * 12 );
        if ( $value > 0 && $value <= 12 ) {
          $width = 'is-' . $value;
        }
      }
    }

    return $width;
  }

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
    wp_dequeue_style( 'js_composer_front' );
    wp_deregister_style( 'js_composer_front' );
    wp_dequeue_script( 'wpb_composer_front_js' );
  }
  add_action( 'vc_before_init', 'rltd_vc_disable_frontend' );

  function rltd_disable_custom_css() {
    wp_dequeue_style( 'js_composer_custom_css' );
    wp_deregister_style( 'js_composer_custom_css' );
  }
  add_action( 'wp_enqueue_scripts', 'rltd_disable_custom_css' );

  // Hide VC UI options.
  function rltd_hide_vc_options() {
    echo "<style>
    .wpb_vc_row .vc_controls.controls_row .vc_control.column_add,
    .wpb_vc_row .vc_controls.controls_row .vc_control.column_edit,
    .wpb_vc_row .vc_controls.controls_row .vc_control.vc_column-toggle,
    #vc_no-content-helper {
      display: none !important;
    }
    </style>";
    echo '<style> .wpb_element_wrapper img { height: auto !important; max-width: 100% !important; } </style>';
  }
  add_action( 'admin_head', 'rltd_hide_vc_options' );

  // Set RTE field width when textarea field present.
  function rltd_set_rte_width() {
    if ( 'vc_edit_form' === vc_post_param( 'action' )
      && ( 'rltd_hero' === $_REQUEST['tag'] )
    ) {
      echo '<style> #vc_ui-panel-edit-element, *[data-vc-ui-element="panel-edit-element"] { left: 50% !important; width: 80% !important; } .vc_ui-panel-window-inner { position: relative !important; left: -50% !important; } </style>';
    }
  }
  add_action( 'init', 'rltd_set_rte_width' );
}
