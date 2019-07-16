<?php

class RelatedTimberSite extends Timber\Site {
  // Add timber support
  public function __construct() {
    add_filter( 'timber/context', array( $this, 'add_to_context' ) );
    add_filter( 'timber/twig', array( $this, 'add_to_twig' ) );
    parent::__construct();
  }

  // Add some context
  public function add_to_context( $context ) {
    $context['menu'] = new \Timber\Menu( 'main' );
    $context['footer_menu'] = new \Timber\Menu( 'footer' );

    $context['password_required'] = post_password_required( $context['page']->ID );

    $context['is_front_page'] = is_front_page();

    $context['site'] = $this;

    return $context;
  }

	// Add your own functions to twig
  public function add_to_twig( $twig ) {
    return $twig;
  }
}

if ( class_exists( 'Timber' ) ) {
  $timber = new \Timber\Timber();

  // Sets the directories (inside your theme) to find .twig files
  Timber::$dirname = array( 'templates', 'templates/global', 'templates/modules', 'templates/partial' );

  new RelatedTimberSite();
}
