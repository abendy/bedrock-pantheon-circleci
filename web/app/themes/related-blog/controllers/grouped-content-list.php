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
    'name'                    => __( 'Grouped Content List', 'related-blog' ),
    'base'                    => 'rltd_grouped_content_list',
    'description'             => __( '', 'related-blog' ),
    'class'                   => '',
    'show_settings_on_create' => true,
    'category'                => __( 'Related Blog', 'related-blog' ),
    // 'icon'                    => '',
    'content_element'         => true,
    // 'admin_enqueue_js'        => array( get_template_directory_uri() . '/controllers/js/content-list.js' ),
    'params'                  => array(
      array(
        'type'            => 'dropdown',
        'holder'          => '',
        'class'           => '',
        'heading'         => __( 'How many grid columns should the content organize?', 'related-blog' ),
        'param_name'      => 'rltd_grouped_content_list_columns',
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
        'type'            => 'dropdown',
        'holder'          => '',
        'class'           => '',
        'heading'         => __( 'Content source', 'related-blog' ),
        'param_name'      => 'rltd_grouped_content_list_source',
        'description'     => __( 'Select content type for your grid.', 'related-blog' ),
        'value'           => $postTypesList,
        'admin_label'     => true,
        'save_always'     => true,
        // 'dependency'      => array(
        //   'callback'        => 'rltd_grouped_content_list_source_template_callback',
        // ),
      ),
      array(
        'type'            => 'dropdown',
        'holder'          => '',
        'class'           => '',
        'heading'         => __( 'Grouped by', 'related-blog' ),
        'param_name'      => 'rltd_grouped_content_list_grouped_by',
        'description'     => __( 'Select content type for your grid.', 'related-blog' ),
        'value'           => $postTypesList,
        'admin_label'     => true,
        'save_always'     => true,
        // 'dependency'      => array(
        //   'callback'        => 'rltd_grouped_content_list_grouped_by_template_callback',
        // ),
      ),
    ),
  )
);

if ( !function_exists( 'rltd_grouped_content_list_render' ) ) {
  function rltd_grouped_content_list_render( $atts, $content = null ) {
    // Params extraction
    extract(
      shortcode_atts(
        array(
          'rltd_grouped_content_list_columns' => '',
          'rltd_grouped_content_list_source' => '',
          'rltd_grouped_content_list_grouped_by' => '',
        ),
        $atts
      )
    );

    // Set the columns in Bootstrap style class numbers
    $columns = !empty( $rltd_grouped_content_list_columns ) ? 12 / $rltd_grouped_content_list_columns : 6;

    // Set default args for posts query
    $args = array(
      'order' => 'ASC',
      'orderby' => 'title',
      'public' => true,
      'posts_per_page' => '-1',
      'post_status' => 'publish',
      // 'post_type' => $rltd_grouped_content_list_grouped_by,
      'post_type' => $rltd_grouped_content_list_source,
    );

    // instantiate new query obj.
    $query = new WP_Query( $args );

    // Execute the query
    $post_data = $query->get_posts();

    // Reset postdata
    wp_reset_postdata();

    // Loop over query response
    foreach ( $post_data as $post ) {
      // Get the permalink
      $link = @get_post_meta( $post->ID, 'property_url' )[0];

      // Get the page title
      $title = get_the_title( $post->ID );

      // Get the excerpt text
      $text = get_the_excerpt( $post->ID );

      // Get image ID
      $image_id = @get_post_meta( $post->ID, 'property_image' )[0];

      // Get images
      $image_s = wp_get_attachment_image_src( $image_id, 'thumbnail' )[0];
      $image_m = wp_get_attachment_image_src( $image_id, 'medium' )[0];
      $image_l = wp_get_attachment_image_src( $image_id, 'large' )[0];

      // Get image alt tag
      $image_alt = get_post_meta( $image_id, '_wp_attachment_image_alt', true );

      // Get the address
      $meta = @get_post_meta( $post->ID, 'property_address' )[0];

      // Get associated neighborhood ID
      $property_neighborhood = @get_post_meta( $post->ID, 'property_neighborhood' )[0];

      // Get neighborhood name
      $neighborhood = @get_post( $property_neighborhood )->post_title;

      // Get neighborhood listing url
      $neighborhood_listing_url = @get_post_meta( @get_post( $property_neighborhood )->ID, 'neighborhood_listing_url' )[0];

      // Get associated city ID
      $neighborhood_city = @get_post_meta( @get_post( $property_neighborhood )->ID, 'neighborhood_city' )[0];

      // Get city name
      $neighborhood_city_value = @get_post( $neighborhood_city )->post_name;

      // Compare current page's ID to the page ID in the relationship field
      $neighborhood_city_id = @get_post( $neighborhood_city )->ID;
      $current_id = @get_post()->ID;

      if ( $neighborhood_city_id === $current_id ) {
        // Build nested items array for rendering
        $items[@$neighborhood][] = array(
          'link' => @$link,
          'title' => @$title,
          'text' => @$text,
          'image_s' => @$image_s,
          'image_m' => @$image_m,
          'image_l' => @$image_l,
          'image_alt' => @$image_alt,
          'meta' => @$meta,
          'neighborhood' => @$neighborhood,
          'neighborhood_listing_url' => @$neighborhood_listing_url,
        );
      }

      $link = $title = $text = $image = $image_alt = $meta = $neighborhood = $neighborhood_listing_url = '';
    }

    // Sort array by neighborhood (group)
    ksort( $items );

    // Parse the twig template with the shortcode's attributes and content.
    $compile = Timber::compile(
      'grouped-content-list.twig',
      array(
        'columns' => @$columns,
        'items' => @$items,
      )
    );

    return $compile;
  }

  add_shortcode( 'rltd_grouped_content_list', 'rltd_grouped_content_list_render' );
}
