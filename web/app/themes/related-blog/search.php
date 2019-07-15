<?php

use Timber\Timber;

$context          = Timber::get_context();

$context['title'] = 'Search results for ' . get_search_query();

$context['posts'] = new \Timber\PostQuery();

$context['menu'] = new \Timber\Menu( 'main' );
$context['footer_menu'] = new \Timber\Menu( 'footer' );

Timber::render( 'search.twig', $context );
