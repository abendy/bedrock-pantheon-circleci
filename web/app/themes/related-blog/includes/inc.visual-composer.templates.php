<?php

// Load VC includes/templates.
if ( class_exists( 'Vc_Manager' ) ) {
  // Set default template assignments
  function rltd_home_page_tpl() {
    $data                 = array();
    $data['name']         = __( 'Home page template', 'related-blog' );
    $data['weight']       = 0;
    $data['content']      = <<<CONTENT
[vc_row][vc_column][rltd_hero][/vc_column][/vc_row]
CONTENT;

    vc_add_default_templates( $data );
  }
  add_action( 'vc_load_default_templates_action', 'rltd_home_page_tpl' );

  function rltd_category_page_tpl() {
    $data                 = array();
    $data['name']         = __( 'Category page template', 'related-blog' );
    $data['weight']       = 0;
    $data['content']      = <<<CONTENT
[vc_row][vc_column][rltd_hero][/vc_column][/vc_row]
CONTENT;

    vc_add_default_templates( $data );
  }
  add_action( 'vc_load_default_templates_action', 'rltd_category_page_tpl' );

  function rltd_post_tpl() {
    $data                 = array();
    $data['name']         = __( 'Post template', 'related-blog' );
    $data['weight']       = 0;
    $data['content']      = <<<CONTENT
[vc_row][vc_column][rltd_hero][/vc_column][/vc_row]
CONTENT;

    vc_add_default_templates( $data );
  }
  add_action( 'vc_load_default_templates_action', 'rltd_post_tpl' );
}
