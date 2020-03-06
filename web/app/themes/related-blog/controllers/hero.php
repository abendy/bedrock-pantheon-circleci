<?php

if ( ! defined( 'ABSPATH' ) ) {
    die( '-1' );
}

// VC field mapping.
vc_map(
  array(
    'name'                    => __( 'Hero', 'related-blog' ),
    'base'                    => 'rltd_hero',
    'description'             => __( '', 'related-blog' ),
    'class'                   => '',
    'show_settings_on_create' => true,
    'category'                => __( 'RLTD', 'related-blog' ),
    // 'icon'                    => '',
    'content_element'         => true,
    'params'                  => array(
      array(
        'type'            => 'param_group',
        'heading'         => __( 'Hero Item', 'related-blog' ),
        'param_name'      => 'rltd_hero_container',
        'description'     => __( '', 'related-blog' ),
        'admin_label'     => false,
        'params'          => array(
          array(
            'type'            => 'dropdown',
            'holder'          => '',
            'class'           => '',
            'heading'         => __( 'Choose the type of content this module will display', 'related-blog' ),
            'param_name'      => 'rltd_hero_item_external_link',
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
            'param_name'      => 'rltd_hero_item_link',
            'value'           => 'http://',
            'description'     => __( '', 'related-blog' ),
            'admin_label'     => false,
            'dependency'      => array(
              'element'         => 'rltd_hero_item_external_link',
              'value'           => array( 'yes' ),
            ),
          ),
          array(
            'type'            => 'autocomplete',
            'holder'          => 'div',
            'class'           => '',
            'heading'         => __( 'Content Reference', 'related-blog' ),
            'param_name'      => 'rltd_hero_item_reference',
            'description'     => __( 'Where is this linking to?<br />This will also pull in title and excerpt information.', 'related-blog' ),
            'value'           => '',
            'admin_label'     => false,
            'dependency'      => array(
              'element'         => 'rltd_hero_item_external_link',
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
            'type'            => 'textfield',
            'holder'          => 'h3',
            'class'           => '',
            'heading'         => __( 'Title', 'related-blog' ),
            'param_name'      => 'rltd_hero_item_title',
            'value'           => '',
            'description'     => __( 'This field can override the title pulled in by the content reference field.', 'related-blog' ),
            'admin_label'     => false,
          ),
          array(
            'type'            => 'checkbox',
            'holder'          => '',
            'class'           => '',
            // 'heading'         => __( '', 'related-blog' ),
            'param_name'      => 'rltd_hero_item_use_as_header',
            'description'     => __( 'Use hero title as the page title.', 'related-blog' ),
            'value'           => array( __( 'Use as page title', 'related-blog' ) => 'yes' ),
            'admin_label'     => false,
            'dependency'      => array(
              'element'         => 'rltd_hero_item_external_link',
              'value'           => array( 'static' ),
            ),
          ),
          array(
            'type'            => 'textfield',
            'holder'          => 'p',
            'class'           => '',
            'heading'         => __( 'Text', 'related-blog' ),
            'param_name'      => 'rltd_hero_item_text',
            'value'           => '',
            'description'     => __( 'This field can override the text excerpt pulled in by the content reference field.', 'related-blog' ),
            'admin_label'     => false,
          ),
          array(
            'type'            => 'attach_image',
            'holder'          => 'img',
            'class'           => '',
            'heading'         => __( 'Image', 'related-blog' ),
            'param_name'      => 'rltd_hero_item_image',
            'value'           => '',
            'description'     => __( '', 'related-blog' ),
            'admin_label'     => false,
          ),
          array(
            'type'            => 'textfield',
            'holder'          => '',
            'class'           => '',
            'heading'         => __( 'Background Video', 'related-blog' ),
            'param_name'      => 'rltd_hero_item_bg_video',
            'value'           => '',
            'description'     => __( 'Full Vimeo or YouTube URL', 'related-blog' ),
            'admin_label'     => false,
          ),
        )
      ),
    )
  )
);

// Include functions for autocomplete field
require_once vc_path_dir( 'CONFIG_DIR', 'grids/vc-grids-functions.php' );
if ( 'vc_get_autocomplete_suggestion' === vc_request_param( 'action' ) || 'vc_edit_form' === vc_post_param( 'action' ) ) {
  add_filter( 'vc_autocomplete_rltd_hero_rltd_hero_container_rltd_hero_item_reference_callback', 'vc_include_field_search', 10, 1 );
  add_filter( 'vc_autocomplete_rltd_hero_rltd_hero_container_rltd_hero_item_reference_render', 'vc_include_field_render', 10, 1 );
}

if ( !function_exists( 'rltd_hero_render' ) ) {
  function rltd_hero_render( $atts, $content = null ) {
    // Params extraction
    extract(
      shortcode_atts(
        array(
          'rltd_hero_container' => '',
        ),
        $atts
      )
    );

    // Get current post
    $post_type = @get_post()->post_type;

    // Loop over nested/multi-instance items
    $container = !empty( $rltd_hero_container ) ? vc_param_group_parse_atts( $rltd_hero_container ) : array();

    foreach ( $container as $post ) {
      $has_video_bg = false;
      $wrapper_attributes = array();
      $wrapper_attributes_string = '';
      $wrapper_classes = array();
      $wrapper_classes_string = '';

      // Get the permalink
      $link = $post['rltd_hero_item_external_link'] === 'yes' && !empty( $post['rltd_hero_item_link'] ) ? esc_url( $post['rltd_hero_item_link'] ) : ( !empty( $post['rltd_hero_item_reference'] ) ? get_permalink( $post['rltd_hero_item_reference'] ) : '' );

      // Get the page title
      $title = !empty( $post['rltd_hero_item_title'] ) ? $post['rltd_hero_item_title'] : ( !empty( $post['rltd_hero_item_reference'] ) ? get_the_title( $post['rltd_hero_item_reference'] ) : '' );

      // Should we use this as the page title?
      $h_tag = $post['rltd_hero_item_external_link'] === 'static' && isset( $post['rltd_hero_item_use_as_header'] ) && $post['rltd_hero_item_use_as_header'] === 'yes' ? 'h1' : 'h2';

      // Get the excerpt text
      $text = !empty( $post['rltd_hero_item_text'] ) ? $post['rltd_hero_item_text'] : ( !empty( $post['rltd_hero_item_reference'] ) ? get_the_excerpt( $post['rltd_hero_item_reference'] ) : '' );

      // Get image and alt tag
      if ( !empty( $post['rltd_hero_item_image'] ) ) {
        $image_id = $post['rltd_hero_item_image'];
        $image = wp_get_attachment_image_src( $image_id, 'rltd_hero_full' )[0];
        $image_m = wp_get_attachment_image_src( $image_id, 'rltd_hero_mobile' )[0];

        $image_alt = get_post_meta( $image_id, '_wp_attachment_image_alt', true );
      } else {
        $args = array(
          'type' => 'image_advanced',
          'multiple' => true
        );

        $hero_image_imgadv = rwmb_meta( 'hero_image_imgadv' , $args, $post['rltd_hero_item_reference'] );

        $image_id = reset( $hero_image_imgadv )['ID'];

        $image = wp_get_attachment_image_src( $image_id, 'rltd_hero_full' )[0];

        $image_alt = get_post_meta( $image_id, '_wp_attachment_image_alt', true );
      }

      // Test for valid background video
      if ( !empty( $post['rltd_hero_item_bg_video'] ) ) {
        parse_str( parse_url( $post['rltd_hero_item_bg_video'], PHP_URL_PATH ), $path );

        $video_id = str_replace( '/', '', array_keys( $path )[0] );

        if ( !preg_match( '/[^\d]/', $video_id ) ) {
          $has_video_bg = true;
        }
      }

      // Create wrapper attrs for background video
      if ( $has_video_bg && isset( $video_id ) ) {
        wp_enqueue_script( 'vc_youtube_iframe_api_js' );

        $wrapper_classes[] = 'hero--background-video';
        $wrapper_classes_string = implode( ' ', $wrapper_classes );

        $wrapper_attributes[] = "data-video-id='$video_id'";
        $wrapper_attributes_string = implode( ' ', $wrapper_attributes );
      }

      // Build nested items array for rendering
      $items[] = array(
        'link' => @$link,
        'title' => @$title,
        'h_tag' => @$h_tag,
        'text' => @$text,
        'image' => @$image,
        'image_m' => @$image_m,
        'image_alt' => @$image_alt,
        'video_id' => @$video_id,
        'wrapper_attributes' => @$wrapper_attributes_string,
        'wrapper_classes' => @$wrapper_classes_string,
      );

      $has_video_bg = $wrapper_attributes = $wrapper_attributes_string = $wrapper_classes = $wrapper_classes_string = '';
      $link = $title = $htag = $text = $image_id = $image = $image_m = $image_alt = $hero_image_imgadv = $video_id = '';
    }

    $compile = Timber::compile(
      'hero.twig',
      array(
        'post_type' => $post_type,
        'items' => @$items,
      )
    );

    return $compile;
  }

  add_shortcode( 'rltd_hero', 'rltd_hero_render' );
}
