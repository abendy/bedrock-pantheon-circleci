<?php

use Timber\Timber;

$context = Timber::get_context();

$context['menu'] = new \Timber\Menu( 'main' );
$context['footer_menu'] = new \Timber\Menu( 'footer' );

Timber::render( '404.twig', $context );
