<?php

use Timber\Timber;

$context          = Timber::get_context();

$context['title'] = 'Search results for ' . get_search_query();

$args = array(
  'posts_per_page' => 9,
);

// Filter by pagination
global $paged;

if ( !isset( $paged ) || !$paged ) {
  $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : ( ( get_query_var( 'page' ) ) ? get_query_var( 'page' ) : 1 );
}

$args['paged'] = $paged;

$context['posts'] = new \Timber\PostQuery( $args );

Timber::render( 'search.twig', $context );
