<?php

use Timber\Timber;

$context = Timber::get_context();

$context['page'] = Timber::get_post();

// Get image
$context['page']->hero_image = wp_get_attachment_image_src( get_post_thumbnail_id( $context['page']->ID ), 'hero_full' )[0];

// Get image alt tag
$context['page']->hero_image_alt = get_post_meta( get_post_thumbnail_id( $context['page']->ID ), '_wp_attachment_image_alt', true );

$context['password_required'] = post_password_required( $context['page']->ID );

$context['menu'] = new \Timber\Menu( 'main' );
$context['footer_menu'] = new \Timber\Menu( 'footer' );

$context['is_front_page'] = is_front_page();

Timber::render( 'index.twig', $context );
