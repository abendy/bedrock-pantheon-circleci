<?php

// Set the location for the Twig tpls.
if ( class_exists( 'Timber' ) ) {
  Timber::$dirname = array( '../views/modules', '../views/page' );
}

use Timber\Timber;

$context = Timber::get_context();
// $context['page'] = Timber::get_post();
$post = new TimberPost();
$context['post'] = $post;

Timber::render(
  array( '../views/page/page.default.twig' ),
  $context
);
