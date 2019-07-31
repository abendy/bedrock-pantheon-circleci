<?php

use Timber\Timber;

$context          = Timber::get_context();

$context['title'] = 'Search results for ' . get_search_query();

$args = array(
  'posts_per_page' => 9,
);

$context['posts'] = new \Timber\PostQuery( $args );

Timber::render( 'search.twig', $context );
