<?php

if ( ! defined( 'ABSPATH' ) ) {
    die( '-1' );
}

// VC field mapping.
vc_map(
  array(
    'name'                    => __( 'Ad', 'related-blog' ),
    'base'                    => 'rltd_ad',
    'description'             => __( '', 'related-blog' ),
    'class'                   => '',
    'show_settings_on_create' => true,
    'category'                => __( 'RLTD', 'related-blog' ),
    // 'icon'                    => '',
    'content_element'         => true,
    'params'                  => array(
      array(
        'type'            => 'dropdown',
        'holder'          => '',
        'class'           => '',
        'heading'         => __( 'Choose the type of content this module will display', 'related-blog' ),
        'param_name'      => 'rltd_ad_external_link',
        'description'     => '',
        'value'           => array(
          __( 'Internal page reference', 'related-blog' ) => 'internal',
          __( 'Static content', 'related-blog' )          => 'static',
          __( 'External link', 'related-blog' )           => 'yes',
        ),
        'admin_label'     => false,
        'save_always'     => true,
      ),
      array(
        'type'            => 'textfield',
        'holder'          => '',
        'class'           => '',
        'heading'         => __( 'Link', 'related-blog' ),
        'param_name'      => 'rltd_ad_link',
        'value'           => 'http://',
        'description'     => __( '', 'related-blog' ),
        'admin_label'     => false,
        'dependency'      => array(
          'element'         => 'rltd_ad_external_link',
          'value'           => array( 'yes' ),
        ),
      ),
      array(
        'type'            => 'autocomplete',
        'holder'          => 'div',
        'class'           => '',
        'heading'         => __( 'Content Reference', 'related-blog' ),
        'param_name'      => 'rltd_ad_reference',
        'description'     => __( 'Where is this linking to?', 'related-blog' ),
        'value'           => '',
        'admin_label'     => false,
        'dependency'      => array(
          'element'         => 'rltd_ad_external_link',
          'value'           => array( 'internal' ),
        ),
        'settings'        => array(
          // Accept a single value
          'multiple'        => false,
          // In UI show results grouped by groups, default false
          'groups'          => true,
          // In UI show results inline view, default false ( each value in own line )
          'display_inline'  => false,
          // delay for search. default 500
          'delay'           => 500,
          // auto focus input, default true
          'auto_focus'      => true,
        ),
      ),
      array(
        'type'            => 'attach_image',
        'holder'          => 'img',
        'class'           => '',
        'heading'         => __( 'Image', 'related-blog' ),
        'param_name'      => 'rltd_ad_image',
        'value'           => '',
        'description'     => __( '', 'related-blog' ),
        'admin_label'     => false,
      ),

    )
  )
);

// Include functions for autocomplete field
require_once vc_path_dir( 'CONFIG_DIR', 'grids/vc-grids-functions.php' );
if ( 'vc_get_autocomplete_suggestion' === vc_request_param( 'action' ) || 'vc_edit_form' === vc_post_param( 'action' ) ) {
  add_filter( 'vc_autocomplete_rltd_ad_rltd_ad_reference_callback', 'vc_include_field_search', 10, 1 );
  add_filter( 'vc_autocomplete_rltd_ad_rltd_ad_reference_render', 'vc_include_field_render', 10, 1 );
}

if ( !function_exists( 'rltd_ad_render' ) ) {
  function rltd_ad_render( $atts, $content = null ) {
    // Params extraction
    extract(
      shortcode_atts(
        array(
          'rltd_ad_external_link' => '',
          'rltd_ad_link' => '',
          'rltd_ad_reference' => '',
          'rltd_ad_image' => '',
        ),
        $atts
      )
    );

    // Get the permalink
    $link = $rltd_ad_external_link === 'yes' && !empty( $rltd_ad_link ) ? esc_url( $rltd_ad_link ) : ( !empty( $rltd_ad_reference ) ? get_permalink( $rltd_ad_reference ) : '' );

    // Get image id
    $image_id = !empty( $rltd_ad_image ) ? $rltd_ad_image : '';

    // Get image
    $image = wp_get_attachment_image_src( $image_id, 'full' )[0];

    // Get image alt.
    $image_alt = get_post_meta( $image_id, '_wp_attachment_image_alt', true );

    $compile = Timber::compile(
      'ad.twig',
      array(
        'link' => @$link,
        'image' => @$image,
        'image_alt' => @$image_alt,
      )
    );

    return $compile;
  }

  add_shortcode( 'rltd_ad', 'rltd_ad_render' );
}
