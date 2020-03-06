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
    'name'                    => __( 'Content List', 'related-blog' ),
    'base'                    => 'rltd_content_list',
    'description'             => __( '', 'related-blog' ),
    'class'                   => '',
    'show_settings_on_create' => true,
    'category'                => __( 'Related Blog', 'related-blog' ),
    // 'icon'                    => '',
    'content_element'         => true,
    'admin_enqueue_js'        => array( get_template_directory_uri() . '/controllers/js/content-list.js' ),
    'params'                  => array(
      array(
        'type'            => 'dropdown',
        'holder'          => '',
        'class'           => '',
        'heading'         => __( 'Sort by', 'related-blog' ),
        'param_name'      => 'rltd_content_list_sort',
        'description'     => __( '', 'related-blog' ),
        'value'           => array(
          __( 'Latest', 'related-blog' ) => 'Latest',
          __( 'Popular', 'related-blog' ) => 'Popular',
        ),
        'admin_label'     => false,
        'save_always'     => true,
        'dependency'      => array(
          'callback'        => 'rltd_content_list_sort_template_callback',
        ),
      ),
      array(
        'type'            => 'textfield',
        'holder'          => 'h2',
        'class'           => '',
        'heading'         => __( 'Title', 'related-blog' ),
        'param_name'      => 'rltd_content_list_title',
        'value'           => 'Latest',
        'description'     => __( '', 'related-blog' ),
        'admin_label'     => false,
        'save_always'     => true,
      ),
      array(
        'type'            => 'checkbox',
        'holder'          => '',
        'class'           => '',
        // 'heading'         => __( '', 'related-blog' ),
        'param_name'      => 'rltd_content_list_custom_title',
        'description'     => __( '', 'related-blog' ),
        'value'           => array( __( 'Custom title', 'related-blog' ) => 'yes' ),
        'admin_label'     => false,
        'dependency'      => array(
          'callback'        => 'rltd_content_list_custom_title_template_callback',
        ),
      ),
      array(
        'type'            => 'dropdown',
        'holder'          => '',
        'class'           => '',
        'heading'         => __( 'Content source', 'related-blog' ),
        'param_name'      => 'rltd_content_list_source',
        'description'     => __( 'Select content type for your grid.', 'related-blog' ),
        'value'           => $postTypesList,
        'admin_label'     => true,
        'save_always'     => true,
        'dependency'      => array(
          // 'element'         => 'rltd_content_list_sort',
          // 'value'           => array( 'Latest', 'Popular' ),
          'callback'        => 'rltd_content_list_source_template_callback',
        ),
      ),
      array(
        'type'            => 'textfield',
        'holder'          => '',
        'class'           => '',
        'heading'         => __( 'Number of items', 'related-blog' ),
        'param_name'      => 'rltd_content_list_limit',
        'value'           => '4',
        'description'     => __( '', 'related-blog' ),
        'admin_label'     => false,
        'save_always'     => true,
        'dependency'      => array(
          'element'         => 'rltd_content_list_sort',
          'value'           => array( 'Latest', 'Popular' ),
        ),
      ),
      array(
        'type'            => 'dropdown',
        'holder'          => '',
        'class'           => '',
        'heading'         => __( 'How many grid columns should the content organize?', 'related-blog' ),
        'param_name'      => 'rltd_content_list_columns',
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
        'type'            => 'checkbox',
        'holder'          => '',
        'class'           => '',
        // 'heading'         => __( '', 'related-blog' ),
        'param_name'      => 'rltd_content_list_pagination',
        'description'     => __( '', 'related-blog' ),
        'value'           => array( __( 'Pagination', 'related-blog' ) => 'yes' ),
        'admin_label'     => false,
      ),
      array(
        'type'            => 'autocomplete',
        'holder'          => '',
        'class'           => '',
        'heading'         => __( 'Filter by category', 'related-blog' ),
        'param_name'      => 'rltd_content_list_taxonomies',
        'value'           => '',
        'description'     => __( 'Enter a category to filter.', 'related-blog' ),
        'admin_label'     => true,
        'dependency'      => array(
          'element'         => 'rltd_content_list_sort',
          'value'           => array( 'Latest', 'Popular' ),
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
    ),
  )
);

// Include functions for autocomplete field
require_once vc_path_dir( 'CONFIG_DIR', 'grids/vc-grids-functions.php' );

if ( 'vc_get_autocomplete_suggestion' === vc_request_param( 'action' ) || 'vc_edit_form' === vc_post_param( 'action' ) ) {
  add_filter( 'vc_autocomplete_rltd_content_list_rltd_content_list_taxonomies_callback', 'vc_autocomplete_taxonomies_field_search', 10, 1 );
  add_filter( 'vc_autocomplete_rltd_content_list_rltd_content_list_taxonomies_render', 'vc_autocomplete_taxonomies_field_render', 10, 1 );
}

if ( !function_exists( 'rltd_content_list_render' ) ) {
  function rltd_content_list_render( $atts, $content = null ) {
    // Params extraction
    extract(
      shortcode_atts(
        array(
          'rltd_content_list_sort' => '',
          'rltd_content_list_title' => '',
          'rltd_content_list_source' => '',
          'rltd_content_list_limit' => '',
          'rltd_content_list_columns' => '',
          'rltd_content_list_pagination' => '',
          'rltd_content_list_taxonomies' => '',
        ),
        $atts
      )
    );

    // Set the columns in Bootstrap style class numbers
    $columns = !empty( $rltd_content_list_columns ) ? 12 / $rltd_content_list_columns : 4;

    // Set default args for posts query
    $args = array(
      'order' => 'DESC',
      'orderby' => ( $rltd_content_list_sort === 'popular' ? 'meta_value_num' : 'date' ),
      'public' => true,
      'posts_per_page' => !empty( $rltd_content_list_limit ) ? $rltd_content_list_limit : '-1',
      'post_status' => 'publish',
      'post_type' => $rltd_content_list_source,
      'meta_key' =>  $rltd_content_list_sort === 'popular' ? 'post_views_count' : null,
    );

    // Filter by taxonomy
    if ( !empty( $rltd_content_list_taxonomies ) ) {
      // Run function to build in additional taxonomy arguments
      $args = rltd_tax_query( $args, $rltd_content_list_taxonomies );
    }

    // Filter by pagination
    if ( $rltd_content_list_pagination === 'yes' ) {
      global $paged;

      if ( !isset( $paged ) || !$paged ) {
        $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : ( ( get_query_var( 'page' ) ) ? get_query_var( 'page' ) : 1 );
      }

      $args['paged'] = $paged;
    }

    $context = Timber::get_context();

    // Execute the query
    $post_data = new \Timber\PostQuery( $args );

    if ( $rltd_content_list_pagination === 'yes' ) {
      $pagination = $post_data->pagination();
    }

    // Loop over query response
    $items = array();
    foreach ( $post_data as $post ) {
      // Get the permalink
      $link = get_permalink( $post->ID );

      // Get the page title
      $title = get_the_title( $post->ID );

      // Get the excerpt text
      $text = get_the_excerpt( $post->ID );

      // Get images
      $image_s = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'thumbnail' )[0];
      $image_m = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'medium' )[0];
      $image_l = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'large' )[0];
      $image_xl_s = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'rltd_hero_mobile' )[0];
      $image_xl_l = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'rltd_hero_full' )[0];

      // Get image alt tag
      $image_alt = get_post_meta( get_post_thumbnail_id( $post->ID ), '_wp_attachment_image_alt', true );

      // Get the category
      $category = @get_the_category( $post->ID )[0];
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
        'image_xl_s' => @$image_xl_s,
        'image_xl_l' => @$image_xl_l,
        'image_alt' => @$image_alt,
        'meta' => @$meta,
        'meta_link' => @$meta_link,
      );

      $link = $title = $text = $image_s = $image_m = $image_l = $image_xl = $image_xl_s = $image_xl_l = $image_alt = $category = $meta = $meta_link = '';
    }

    // If we have an uneven number of items for the column setting
    // then we'll make a content item full width
    // $num_per_row = isset( $rltd_content_list_limit ) ? $rltd_content_list_limit / $rltd_content_list_columns : false;
    // if ( !is_int( $num_per_row ) ) {
    //   $items[$rltd_content_list_columns]['wide'] = true;
    //   $items[$rltd_content_list_columns]['wide_classes'] = 12 / ( $rltd_content_list_columns - 1 );
    // }

    // Parse the twig template with the shortcode's attributes and content.
    $compile = Timber::compile(
      'content-list.twig',
      array(
        'title' => @$rltd_content_list_title,
        'columns' => @$columns,
        'items' => @$items,
        'pagination' => @$pagination,
      )
    );

    return $compile;
  }

  add_shortcode( 'rltd_content_list', 'rltd_content_list_render' );
}
