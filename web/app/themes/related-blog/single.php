<?php

use Timber\Timber;

$context = Timber::get_context();

$context['page'] = Timber::get_post();
$context['password_required'] = post_password_required( $context['page']->ID );
$context['is_front_page'] = is_front_page();

// If the hero is using the hero title as the page title
// remove the regular WP page title

$pattern = get_shortcode_regex( array( 'rltd_hero' ) );

$content = preg_match( "/$pattern/", $context['page']->post_content, $matches );

if ( $matches ) {
  $atts = shortcode_parse_atts( $matches[3] );

  extract(
    shortcode_atts(
      array(
        'rltd_hero_container' => '',
      ),
      $atts
    )
  );

  $container = !empty( $rltd_hero_container ) ? vc_param_group_parse_atts( $rltd_hero_container ) : array();

  if ( !empty( reset( $container )['rltd_hero_item_use_as_header'] ) && reset( $container )['rltd_hero_item_use_as_header'] === 'yes' ) {
    $context['page']->post_title = '';
  }
}



$has_hero = preg_match( '/\[rltd_hero/', $context['page']->post_content );

if ( !$has_hero ) {
  $args = array(
    'type' => 'image_advanced',
    'multiple' => true
  );

  $hero_image_imgadv = rwmb_meta( 'hero_image_imgadv' , $args, $context['page']->ID );

  if ( !empty( $hero_image_imgadv ) ) {
    $image_id = reset( $hero_image_imgadv )['ID'];

    // Get image
    $context['page']->hero_image = wp_get_attachment_image_src( $image_id, 'rltd_hero_full' )[0];

    // Get image alt tag
    $context['page']->hero_image_alt = get_post_meta( $image_id, '_wp_attachment_image_alt', true );
  }
}

Timber::render( 'single.twig', $context );
