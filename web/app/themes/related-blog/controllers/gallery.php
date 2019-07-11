<?php

if ( ! defined( 'ABSPATH' ) ) {
    die( '-1' );
}

// VC field mapping.
vc_map(
  array(
    'name'                    => __( 'Gallery', 'related-blog' ),
    'base'                    => 'rltd_gallery',
    'description'             => __( '', 'related-blog' ),
    'class'                   => '',
    'show_settings_on_create' => true,
    'category'                => __( 'RLTD', 'related-blog' ),
    // 'icon'                    => '',
    'content_element'         => true,
    'params'                  => array(
      array(
        'type'            => 'textfield',
        'holder'          => 'h2',
        'class'           => '',
        'heading'         => __( 'Title', 'related-blog' ),
        'param_name'      => 'rltd_gallery_title',
        'value'           => '',
        'description'     => __( '', 'related-blog' ),
        'admin_label'     => false,
        'save_always'     => true,
      ),
      array(
        'type'            => 'param_group',
        'heading'         => __( 'Gallery Item', 'related-blog' ),
        'param_name'      => 'rltd_gallery_container',
        'description'     => __( '', 'related-blog' ),
        'admin_label'     => false,
        'params'          => array(
          // array(
          //   'type'            => 'dropdown',
          //   'holder'          => '',
          //   'class'           => '',
          //   'heading'         => __( 'Choose the type of content this module will display', 'related-blog' ),
          //   'param_name'      => 'rltd_gallery_item_external_link',
          //   'description'     => '',
          //   'value'           => array(
          //     __( 'Internal page reference', 'related-blog' ) => 'internal',
          //     __( 'Static content', 'related-blog' )          => 'static',
          //     __( 'External link', 'related-blog' )           => 'yes',
          //   ),
          //   'admin_label'     => false,
          //   'save_always'     => true,
          // ),
          // array(
          //   'type'            => 'textfield',
          //   'holder'          => '',
          //   'class'           => '',
          //   'heading'         => __( 'Link', 'related-blog' ),
          //   'param_name'      => 'rltd_gallery_item_link',
          //   'value'           => 'http://',
          //   'description'     => __( '', 'related-blog' ),
          //   'admin_label'     => false,
          //   'dependency'      => array(
          //     'element'         => 'rltd_gallery_item_external_link',
          //     'value'           => array( 'yes' ),
          //   ),
          // ),
          // array(
          //   'type'            => 'autocomplete',
          //   'holder'          => 'div',
          //   'class'           => '',
          //   'heading'         => __( 'Content Reference', 'related-blog' ),
          //   'param_name'      => 'rltd_gallery_item_reference',
          //   'description'     => __( 'Where is this linking to?<br />This will also pull in title and excerpt information.', 'related-blog' ),
          //   'value'           => '',
          //   'admin_label'     => false,
          //   'dependency'      => array(
          //     'element'            => 'rltd_gallery_item_external_link',
          //     'value'           => array( 'internal' ),
          //   ),
          //   'settings'        => array(
          //     // Accept a single value
          //     'multiple'        => false,
          //     // In UI show results grouped by groups, default false
          //     'groups'          => true,
          //     // In UI show results inline view, default false ( each value in own line )
          //     'display_inline'  => false,
          //     // delay for search. default 500
          //     'delay'           => 500,
          //     // auto focus input, default true
          //     'auto_focus'      => true,
          //   ),
          // ),
          // array(
          //   'type'            => 'textfield',
          //   'holder'          => 'h3',
          //   'class'           => '',
          //   'heading'         => __( 'Title', 'related-blog' ),
          //   'param_name'      => 'rltd_gallery_item_title',
          //   'value'           => '',
          //   'description'     => __( 'This field can override the title pulled in by the content reference field.', 'related-blog' ),
          //   'admin_label'     => false,
          // ),
          // array(
          //   'type'            => 'textfield',
          //   'holder'          => 'p',
          //   'class'           => '',
          //   'heading'         => __( 'Text', 'related-blog' ),
          //   'param_name'      => 'rltd_gallery_item_text',
          //   'value'           => '',
          //   'description'     => __( 'This field can override the text excerpt pulled in by the content reference field.', 'related-blog' ),
          //   'admin_label'     => false,
          // ),
          array(
            'type'            => 'attach_image',
            'holder'          => 'img',
            'class'           => '',
            'heading'         => __( 'Image', 'related-blog' ),
            'param_name'      => 'rltd_gallery_item_image',
            'value'           => '',
            'description'     => __( '', 'related-blog' ),
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
  add_filter( 'vc_autocomplete_rltd_gallery_rltd_gallery_container_rltd_gallery_item_reference_callback', 'vc_include_field_search', 10, 1 );
  add_filter( 'vc_autocomplete_rltd_gallery_rltd_gallery_container_rltd_gallery_item_reference_render', 'vc_include_field_render', 10, 1 );
}

if ( !function_exists( 'rltd_gallery_render' ) ) {
  function rltd_gallery_render( $atts, $content = null ) {
    // Params extraction
    extract(
      shortcode_atts(
        array(
          'rltd_gallery_title' => '',
          'rltd_gallery_container' => '',
        ),
        $atts
      )
    );

    // Loop over nested/multi-instance items
    $container = !empty( $rltd_gallery_container ) ? vc_param_group_parse_atts( $rltd_gallery_container ) : array();

    foreach ( $container as $post ) {
      // Get the permalink
      // $link = $post['rltd_gallery_item_external_link'] === 'yes' && !empty( $post['rltd_gallery_item_link'] ) ? esc_url( $post['rltd_gallery_item_link'] ) : get_permalink( $post['rltd_gallery_item_reference'] );

      // Get the page title
      // $title = !empty( $post['rltd_gallery_item_title'] ) ? $post['rltd_gallery_item_title'] : ( !empty( $post['rltd_gallery_item_reference'] ) ? get_the_title( $post['rltd_gallery_item_reference'] ) : '' );

      // Get the excerpt text
      // $text = !empty( $post['rltd_gallery_item_text'] ) ? $post['rltd_gallery_item_text'] : ( !empty( $post['rltd_gallery_item_reference'] ) ? get_the_excerpt( $post['rltd_gallery_item_reference'] ) : '' );

      // Get image and alt tag
      if ( !empty( $post['rltd_gallery_item_image'] ) ) {
        $image_id = $post['rltd_gallery_item_image'];
        $image = wp_get_attachment_image_src( $image_id, 'rltd_thumbnail' )[0];

        $image_alt = get_post_meta( $image_id, '_wp_attachment_image_alt', true );
      }

      // Build nested items array for rendering
      $items[] = array(
        // 'link' => @$link,
        // 'title' => @$title,
        // 'text' => @$text,
        'image' => @$image,
        'image_alt' => @$image_alt,
      );

      $link = $title = $text = $image_id = $image = $image_alt = '';
    }

    $compile = Timber::compile(
      'gallery.twig',
      array(
        'title' => @$rltd_gallery_title,
        'items' => @$items,
      )
    );

    return $compile;
  }

  add_shortcode( 'rltd_gallery', 'rltd_gallery_render' );
}
