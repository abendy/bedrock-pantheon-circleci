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
          __( '--', 'related-blog' ) => 'More',
          __( 'Latest', 'related-blog' ) => 'Latest',
          // __( 'Popular', 'related-blog' ) => 'Popular',
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
        'value'           => 'More',
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
          'element'         => 'rltd_content_list_sort',
          'value'           => array( 'More', 'Latest', 'Popular' ),
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
          'value'           => array( 'More', 'Latest', 'Popular' ),
        ),
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
          'value'           => array( 'More', 'Latest', 'Popular' ),
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
          'rltd_content_list_taxonomies' => '',
        ),
        $atts
      )
    );

    // Get posts per page value or fallback to 3
    $posts_per_page = !empty( $rltd_content_list_limit ) ? $rltd_content_list_limit : '-1';

    // Set default args for posts query
    $args = array(
      'order' => 'DESC',
      'orderby' => 'date',
      'public' => true,
      'posts_per_page' => $posts_per_page,
      'post_status' => 'publish',
      'post_type' => $rltd_content_list_source,
    );

    // if ( $rltd_content_list_sort === 'popular' ) {
    //   $args['orderby']    = 'meta_value title';
    //   $args['meta_key']   = '<SOME_STATISTICS_FIELD>';
    //   $args['meta_query'] = array(
    //     array(
    //       'key' => '<SOME_STATISTICS_FIELD>',
    //       'compare' => 'EXISTS',
    //     )
    //   );
    // }

    // Filter by taxonomy
    if ( !empty( $rltd_content_list_taxonomies ) ) {
      // Run function to build in additional taxonomy arguments
      $args = rltd_tax_query( $args, $rltd_content_list_taxonomies );
    }

    // Get current page and append to custom query parameters array
    // https://wordpress.stackexchange.com/a/120408/126589
    if ( $rltd_content_list_sort === 'More' ) {
      $args['paged'] = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;
    }

    // instantiate new query obj.
    $query = new WP_Query( $args );

    // Execute the query
    $post_data = $query->get_posts();

    // Custom query loop pagination
    // https://wordpress.stackexchange.com/a/254200/126589
    if ( $rltd_content_list_sort === 'More' ) {
      $pagination = paginate_links(
        array(
          'total'        => $query->max_num_pages,
          'current'      => max( 1, get_query_var( 'paged' ) ),
          'format'       => 'page/%#%',
          'show_all'     => false,
          'end_size'     => 2,
          'prev_text'    => sprintf( '<i></i> %1$s', __( 'Previous', 'related-blog' ) ),
          'next_text'    => sprintf( '%1$s <i></i>', __( 'Next ', 'related-blog' ) ),
        )
      );
    }

    // Reset postdata
    wp_reset_postdata();

    // Loop over query response
    foreach ( $post_data as $post ) {
      // Get the post date
      $datetime = get_the_date( 'm-d-Y', $post->ID );

      // Get the permalink
      $link = get_permalink( $post->ID );

      // Get the page title
      $title = get_the_title( $post->ID );

      // Get the excerpt text
      $text = get_the_excerpt( $post->ID );

      // Get the category
      $category = get_the_category( $post->ID )[0]->name;

      // Get image source
      $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'thumbnail' )[0];

      // Get image alt tag
      $image_alt = get_post_meta( get_post_thumbnail_id( $post->ID ), '_wp_attachment_image_alt', true );

      // Build nested items array for rendering
      $items[] = array(
        // 'datetime' => @$datetime,
        'link' => @$link,
        'title' => @$title,
        // 'text' => @$text,
        // 'category' => $category,
        // 'image' => @$image,
        // 'image_alt' => @$image_alt,
      );

      $datetime = $link = $title = $text = $image = $image_alt = '';
    }

    // Parse the twig template with the shortcode's attributes and content.
    $compile = Timber::compile(
      'content-list.twig',
      array(
        'title' => @$rltd_content_list_title,
        'items' => @$items,
        'pagination' => @$pagination,
      )
    );

    return $compile;
  }

  add_shortcode( 'rltd_content_list', 'rltd_content_list_render' );
}
