<?php

use Timber\Timber;

$context = Timber::get_context();

$context['page'] = Timber::get_post();

$context['is_front_page'] = is_front_page();

$templates = array( 'page-' . $context['page']->post_name . '.twig', 'page.twig' );
// https://wordpress.stackexchange.com/a/239838/126589
if ( is_front_page() ) {
	array_unshift( $templates, 'front-page.twig', 'home.twig' );
}
Timber::render( $templates, $context );
