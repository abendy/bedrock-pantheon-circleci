<?php

use Timber\Timber;

$context = Timber::get_context();

$context['page'] = Timber::get_post();

$context['password_required'] = post_password_required( $context['page']->ID );

$context['menu'] = new \Timber\Menu( 'main' );
$context['footer_menu'] = new \Timber\Menu( 'footer' );

$context['is_front_page'] = is_front_page();

Timber::render( 'index.twig', $context );
