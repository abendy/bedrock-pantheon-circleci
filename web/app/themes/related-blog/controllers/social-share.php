<?php

if ( ! defined( 'ABSPATH' ) ) {
  die( '-1' );
}

// VC field mapping.
vc_map(
  array(
    'name'                    => __( 'Social Share', 'related-blog' ),
    'base'                    => 'rltd_social_share',
    'description'             => __( '', 'related-blog' ),
    'class'                   => '',
    'show_settings_on_create' => false,
    'category'                => __( 'RLTD', 'related-blog' ),
    // 'icon'                    => '',
    // 'content_element'         => true,
  )
);

if ( !function_exists( 'rltd_social_share_render' ) ) {
  function rltd_social_share_render( $atts, $content = null ) {
    // Get current post
    $post_type = @get_post()->post_type;

    // Construct share URL for current page
    global $wp;
    $current_url = esc_url( home_url( add_query_arg( array(), $wp->request ) ) );

    $compile = Timber::compile(
      'social-share.twig',
      array(
        'post_type' => $post_type,
        'current_url' => $current_url,
      )
    );

    return $compile;
  }

  add_shortcode( 'rltd_social_share', 'rltd_social_share_render' );
}
