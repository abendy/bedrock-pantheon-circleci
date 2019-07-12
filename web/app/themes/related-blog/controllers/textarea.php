<?php

if ( ! defined( 'ABSPATH' ) ) {
  die( '-1' );
}

// VC field mapping.
vc_map(
  array(
    'name'                    => __( 'Textarea', 'related-blog' ),
    'base'                    => 'rltd_textarea',
    'description'             => __( '', 'related-blog' ),
    'class'                   => '',
    'show_settings_on_create' => true,
    'category'                => __( 'RLTD', 'related-blog' ),
    // 'icon'                    => '',
    'content_element'         => true,
    'params'                  => array(
      array(
        'type'            => 'textarea_html',
        'holder'          => 'p',
        'class'           => '',
        'heading'         => __( 'Text', 'related-blog' ),
        'param_name'      => 'content',
        'value'           => '',
        'description'     => __( 'This field can override the text excerpt pulled in by the content reference field.', 'related-blog' ),
        'admin_label'     => false,
      ),
    )
  )
);

if ( !function_exists( 'rltd_textarea_render' ) ) {
  function rltd_textarea_render( $atts, $content = null ) {
    // Parse the twig template with the shortcode's attributes and content.
    $compile = Timber::compile(
      'textarea.twig',
      array(
        'content' => @$content,
      )
    );

    return $compile;
  }

  add_shortcode( 'rltd_textarea', 'rltd_textarea_render' );
}
