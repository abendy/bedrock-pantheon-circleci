<?php

get_header();

// Set the location for the Twig tpls.
if ( class_exists( 'Timber' ) ) {
  Timber::$dirname = array( '../views/modules', '../views/page' );
}

use Timber\Timber;

// Twigify
$context = Timber::get_context();
$posts = Timber::get_posts();

$add_breadcrumbs = new Rltd_Breadcrumbs();
$context['posts'] = $add_breadcrumbs->set_parent( $posts );

global $wp_query;
$context['found_posts'] = $wp_query->found_posts;
$context['search_query'] = get_search_query();
$context['pagination'] = get_the_posts_pagination( array(
                            'mid_size'  => 2,
                            'prev_text' => __( 'Previous', 'related-blog' ),
                            'next_text' => __( 'Next ', 'related-blog' ),
                        ) );

Timber::render(
    array( 'views/page/page.search.twig' ),
    $context
);

get_sidebar();

get_footer();
