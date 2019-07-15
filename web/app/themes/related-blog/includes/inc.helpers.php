<?php

// Get all custom content types
function rltd_get_post_types( $output = 'objects', $friendly = null ) {
  $args = array(
    // 'public'   => true,
    // '_builtin' => true
  );
  $output   = $output;
  $operator = 'and';
  $post_types = get_post_types( $args, $output, $operator );

  if ( $friendly && is_array( $post_types ) && !empty( $post_types ) ) {
    $postTypesList = array();

    foreach ( $post_types as $post_type ) {
      $postTypesList[] = array(
        $post_type->name,
        $post_type->label,
      );
    }
    asort( $postTypesList );

    return $postTypesList;
  }

  return $post_types;
}

// Shared function for filtering queries by taxonomy
function rltd_tax_query( $args, $taxonomies ) {
  // Create array of all taxonony IDs
  $taxonomies = explode( ',', $taxonomies );

  $taxonomies = array_map( 'trim', $taxonomies );

  asort( $taxonomies );

  $args['tax_query'] = array( 'relation' => 'OR' );

  // Loop over taxonomy and build query filter array
  foreach ( $taxonomies as $taxonomy ) {
    $term = get_term( $taxonomy );

    $tax_query = array( array(
      'taxonomy' => $term->taxonomy,
      'field' => 'slug',
      'terms' => $term->slug,
    ) );

    $args['tax_query'][] = $tax_query;
  }

  return $args;
}
