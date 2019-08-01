<?php

use Timber\Timber;

$context          = Timber::get_context();

$context['title'] = 'Search results for ' . get_search_query();

// Set search arguments

$args = array(
  'posts_per_page' => 9,
);

// Filter by search query

global $s;

if ( !isset( $s ) || !$s ) {
  $s = @get_query_var( 's' );
}

$args['s'] = $s;

// Filter by pagination

global $paged;

if ( !isset( $paged ) || !$paged ) {
  $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : ( ( get_query_var( 'page' ) ) ? get_query_var( 'page' ) : 1 );
}

$args['paged'] = $paged;

// Run search query

$context['posts'] = new \Timber\PostQuery( $args );

// Render

Timber::render( 'search.twig', $context );
