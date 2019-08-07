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

  // Update default image dimensions
  update_option( 'thumbnail_size_w', 424 );
  update_option( 'thumbnail_size_h', 284 );
  update_option( 'thumbnail_crop', 1 );

  update_option( 'medium_size_w', 488 );
  update_option( 'medium_size_h', 327 );
  update_option( 'medium_crop', 1 );

  update_option( 'large_size_w', 744 );
  update_option( 'large_size_h', 499 );
  update_option( 'large_crop', 1 );

  // Add custom image sizes
  add_image_size( 'rltd_hero_full', 1330, 445, true );
  add_image_size( 'rltd_hero_mobile', 890, 445, true );

  function rltd_hero_images( $sizes ) {
    return array_merge(
      $sizes,
      array(
        'rltd_hero_full' => __( 'Hero Image (Desktop)' ),
        'rltd_hero_Mobile' => __( 'Hero Image (Mobile)' ),
      )
    );
  }
  add_filter( 'image_size_names_choose', 'rltd_hero_images' );
}
add_action( 'after_setup_theme', 'rltd_setup_theme' );

// Create footer logo setting
function rltd_customize_settings( $wp_customize ) {
  // Add WP settings
  $wp_customize->add_setting( 'rltd_footer_logo' );
  $wp_customize->add_setting( 'rltd_social_media_facebook' );
  $wp_customize->add_setting( 'rltd_social_media_twitter' );
  $wp_customize->add_setting( 'rltd_social_media_instagram' );

  // Add controls
  $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'rltd_footer_logo', array(
    'label' => __( 'Footer Logo', 'related-blog' ),
    'section' => 'title_tagline',
    'settings' => 'rltd_footer_logo',
  ) ) );

	$wp_customize->add_panel( 'rltd_social_media', array(
		'title'          => __( 'Social media', 'related-blog' ),
		'description'    => __( 'Set social media links in site header.', 'related-blog' ),
	) );

  $wp_customize->add_section( 'rltd_social_media' , array(
		'title'    => __( 'Social media', 'related-blog' ),
		'panel'    => 'rltd_social_media',
	) );

  $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'rltd_social_media_facebook', array(
    'label' => __( 'Facebook URL', 'related-blog' ),
    'section' => 'rltd_social_media',
    'settings' => 'rltd_social_media_facebook',
    'type'     => 'text',
  ) ) );

  $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'rltd_social_media_twitter', array(
    'label' => __( 'Twitter URL', 'related-blog' ),
    'section' => 'rltd_social_media',
    'settings' => 'rltd_social_media_twitter',
    'type'     => 'text',
  ) ) );

  $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'rltd_social_media_instagram', array(
    'label' => __( 'Instagram URL', 'related-blog' ),
    'section' => 'rltd_social_media',
    'settings' => 'rltd_social_media_instagram',
    'type'     => 'text',
  ) ) );
}
add_action( 'customize_register', 'rltd_customize_settings' );

// Remove default image sizes
add_action( 'init', function () {
  remove_image_size( 'thumbnail' );
  remove_image_size( 'medium' );
  remove_image_size( 'medium_large' );
  remove_image_size( 'large' );
} );

// Force city post types to use the index template
add_filter( 'template_include', function ( $template ) {
  $city = get_query_var( 'city' );
  $new_tpl = locate_template( 'index.php' );

  return ( !empty( $city ) && !empty( $new_tpl ) ) ? $new_tpl : $template ;
} );
