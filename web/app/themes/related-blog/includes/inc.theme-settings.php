<?php

function rltd_setup_theme() {
  // Add Custom logo support
  add_theme_support( 'custom-logo' );

  // Add menu support
  add_theme_support( 'menus' );

  // Register menus.
  register_nav_menus( array(
    'main'   => __( 'Main Navigation', 'related-blog' ),
    'footer' => __( 'Footer Navigation', 'related-blog' ),
  ) );

  // Add HTML5 theme support to search.
  add_theme_support( 'html5', array(
    'search-form',
  ) );

  // Let WordPress manage the document title
  add_theme_support( 'title-tag' );

  // Enable support for Post Thumbnails on posts and pages.
  // https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
  add_theme_support( 'post-thumbnails' );

  // Add default posts and comments RSS feed links to head.
  // add_theme_support( 'automatic-feed-links' );

  // Add custom image sizes
  add_image_size( 'rltd_thumbnail', 370, 248, true );

  function rltd_hero_images( $sizes ) {
    return array_merge(
      $sizes,
      array(
        'rltd_thumbnail' => __( 'Content List Thumbnail' ),
      )
    );
  }
  add_filter( 'image_size_names_choose', 'rltd_hero_images' );
}
add_action( 'after_setup_theme', 'rltd_setup_theme' );

// Force city post types to use the index template
add_filter( 'template_include', function ( $template ) {
  $city = get_query_var( 'city' );
  $new_tpl = locate_template( 'index.php' );

  return ( !empty( $city ) && !empty( $new_tpl ) ) ? $new_tpl : $template ;
} );
