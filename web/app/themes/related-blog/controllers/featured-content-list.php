<?php

if ( ! defined( 'ABSPATH' ) ) {
  die( '-1' );
}

// Get all posts types
$postTypesList = rltd_get_post_types( 'objects', 1 );
$postTypesList[] = array( 0 => 'page', 1 => 'Pages' );

// VC field mapping.
vc_map(
  array(
    'name'                    => __( 'Featured Content List', 'related-blog' ),
    'base'                    => 'rltd_featured_content_list',
    'description'             => __( '', 'related-blog' ),
    'class'                   => '',
    'show_settings_on_create' => true,
    'category'                => __( 'Related Blog', 'related-blog' ),
    // 'icon'                    => '',
    'content_element'         => true,
    'admin_enqueue_js'        => array( get_template_directory_uri() . '/controllers/js/featured-content-list.js' ),
    'params'                  => array(
      array(
        'type'            => 'textfield',
        'holder'          => 'h2',
        'class'           => '',
        'heading'         => __( 'Title', 'related-blog' ),
        'param_name'      => 'rltd_featured_content_list_title',
        'value'           => 'Featured',
        'description'     => __( '', 'related-blog' ),
        'admin_label'     => false,
        'save_always'     => true,
      ),
      array(
        'type'            => 'checkbox',
        'holder'          => '',
        'class'           => '',
        // 'heading'         => __( '', 'related-blog' ),
        'param_name'      => 'rltd_featured_content_list_custom_title',
        'description'     => __( '', 'related-blog' ),
        'value'           => array( __( 'Custom title', 'related-blog' ) => 'yes' ),
        'admin_label'     => false,
        'dependency'      => array(
          'callback'        => 'rltd_featured_content_list_custom_title_template_callback',
        ),
      ),
      array(
        'type'            => 'dropdown',
        'holder'          => '',
        'class'           => '',
        'heading'         => __( 'How many grid columns should the content organize?', 'related-blog' ),
        'param_name'      => 'rltd_featured_content_list_columns',
        'description'     => '',
        'value'           => array(
          __( 1, 'related-blog' ) => '1',
          __( 2, 'related-blog' ) => '2',
          __( 3, 'related-blog' ) => '3',
        ),
        'std'             => 2,
        'admin_label'     => false,
        'save_always'     => true,
      ),
      array(
        'type'            => 'param_group',
        'heading'         => __( 'Featured Item', 'related-blog' ),
        'param_name'      => 'rltd_featured_content_list_container',
        'description'     => __( '', 'related-blog' ),
        'admin_label'     => false,
        'params'          => array(
          array(
            'type'            => 'dropdown',
            'holder'          => '',
            'class'           => '',
            'heading'         => __( 'Choose the type of content this module will display', 'related-blog' ),
            'param_name'      => 'rltd_featured_content_list_item_external_link',
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
            'param_name'      => 'rltd_featured_content_list_item_link',
            'value'           => 'http://',
            'description'     => __( '', 'related-blog' ),
            'admin_label'     => false,
            'dependency'      => array(
              'element'         => 'rltd_featured_content_list_item_external_link',
              'value'           => array( 'yes' ),
            ),
          ),
          array(
            'type'            => 'autocomplete',
            'holder'          => 'div',
            'class'           => '',
            'heading'         => __( 'Content Reference', 'related-blog' ),
            'param_name'      => 'rltd_featured_content_list_item_reference',
            'description'     => __( 'Where is this linking to?<br />This will also pull in title and excerpt information.', 'related-blog' ),
            'value'           => '',
            'admin_label'     => false,
            'dependency'      => array(
              'element'            => 'rltd_featured_content_list_item_external_link',
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
            'param_name'      => 'rltd_featured_content_list_item_title',
            'value'           => '',
            'description'     => __( 'This field can override the title pulled in by the content reference field.', 'related-blog' ),
            'admin_label'     => false,
          ),
          array(
            'type'            => 'textfield',
            'holder'          => 'p',
            'class'           => '',
            'heading'         => __( 'Text', 'related-blog' ),
            'param_name'      => 'rltd_featured_content_list_item_text',
            'value'           => '',
            'description'     => __( 'This field can override the text excerpt pulled in by the content reference field.', 'related-blog' ),
            'admin_label'     => false,
          ),
          array(
            'type'            => 'attach_image',
            'holder'          => 'img',
            'class'           => '',
            'heading'         => __( 'Image', 'related-blog' ),
            'param_name'      => 'rltd_featured_content_list_item_image',
            'value'           => '',
            'description'     => __( '', 'related-blog' ),
            'admin_label'     => false,
          ),
        )
      ),
    ),
  )
);

// Include functions for autocomplete field
require_once vc_path_dir( 'CONFIG_DIR', 'grids/vc-grids-functions.php' );

if ( 'vc_get_autocomplete_suggestion' === vc_request_param( 'action' ) || 'vc_edit_form' === vc_post_param( 'action' ) ) {
  add_filter( 'vc_autocomplete_rltd_featured_content_list_rltd_featured_content_list_container_rltd_featured_content_list_item_reference_callback', 'vc_include_field_search', 10, 1 );
  add_filter( 'vc_autocomplete_rltd_featured_content_list_rltd_featured_content_list_container_rltd_featured_content_list_item_reference_render', 'vc_include_field_render', 10, 1 );
}

if ( !function_exists( 'rltd_featured_content_list_render' ) ) {
  function rltd_featured_content_list_render( $atts, $content = null ) {
    // Params extraction
    extract(
      shortcode_atts(
        array(
          'rltd_featured_content_list_title' => '',
          'rltd_featured_content_list_columns' => '',
          'rltd_featured_content_list_container' => '',
        ),
        $atts
      )
    );

    // Set the columns in Bootstrap style class numbers
    $columns = !empty( $rltd_featured_content_list_columns ) ? 12 / $rltd_featured_content_list_columns : 6;

    // Loop over nested/multi-instance items
    $container = !empty( $rltd_featured_content_list_container ) ? vc_param_group_parse_atts( $rltd_featured_content_list_container ) : array();

    $items = array();
    foreach ( $container as $post ) {
      // Get the permalink
      $link = $post['rltd_featured_content_list_item_external_link'] === 'yes' && !empty( $post['rltd_featured_content_list_item_link'] ) ? esc_url( $post['rltd_featured_content_list_item_link'] ) : ( !empty( $post['rltd_featured_content_list_item_reference'] ) ? get_permalink( $post['rltd_featured_content_list_item_reference'] ) : '' );

      // Get the page title
      $title = !empty( $post['rltd_featured_content_list_item_title'] ) ? $post['rltd_featured_content_list_item_title'] : ( !empty( $post['rltd_featured_content_list_item_reference'] ) ? get_the_title( $post['rltd_featured_content_list_item_reference'] ) : '' );

      // Get the excerpt text
      $text = !empty( $post['rltd_featured_content_list_item_text'] ) ? $post['rltd_featured_content_list_item_text'] : ( !empty( $post['rltd_featured_content_list_item_reference'] ) ? get_the_excerpt( $post['rltd_featured_content_list_item_reference'] ) : '' );

      // Get image source
      $image_id = !empty( $post['rltd_featured_content_list_item_image'] ) ? $post['rltd_featured_content_list_item_image'] : get_post_thumbnail_id( $post['rltd_featured_content_list_item_reference'] );

      // Get images
      $image_s = wp_get_attachment_image_src( $image_id, 'thumbnail' )[0];
      $image_m = wp_get_attachment_image_src( $image_id, 'medium' )[0];
      $image_l = wp_get_attachment_image_src( $image_id, 'large' )[0];

      // Get image alt tag
      $image_alt = get_post_meta( $image_id, '_wp_attachment_image_alt', true );

      // Get the category
      $category = !empty( $post['rltd_featured_content_list_item_reference'] ) ? @get_the_category( $post['rltd_featured_content_list_item_reference'] )[0] : '';
      if ( !empty( $category ) ) {
          $meta = $category->name;
          $meta_link = @get_category_link( $category->term_id );
      }

      // Build nested items array for rendering
      $items[] = array(
        'link' => @$link,
        'title' => @$title,
        'text' => @$text,
        'image_s' => @$image_s,
        'image_m' => @$image_m,
        'image_l' => @$image_l,
        'image_alt' => @$image_alt,
        'meta' => @$meta,
        'meta_link' => @$meta_link,
      );

      $link = $title = $text = $image_id = $image = $image_alt = $category = $meta = $meta_link = '';
    }

    // Parse the twig template with the shortcode's attributes and content.
    $compile = Timber::compile(
      'featured-content-list.twig',
      array(
        'title' => @$rltd_featured_content_list_title,
        'columns' => @$columns,
        'items' => @$items,
      )
    );

    return $compile;
  }

  add_shortcode( 'rltd_featured_content_list', 'rltd_featured_content_list_render' );
}
