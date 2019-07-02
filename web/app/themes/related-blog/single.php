<?php

use Timber\Timber;

$context = Timber::get_context();

$context['page'] = Timber::get_post();

$context['password_required'] = post_password_required( $context['page']->ID );

if ( post_password_required( $context['page']->ID ) ) {
	Timber::render( 'single-password.twig', $context );
} else {
	Timber::render( array( 'single-' . $context['page']->ID . '.twig', 'single-' . $context['page']->post_type . '.twig', 'single.twig' ), $context );
}
