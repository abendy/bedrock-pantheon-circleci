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

    $context['site'] = $this;

    return $context;
  }

	// Add your own functions to twig
  public function add_to_twig( $twig ) {
    // Use PHP's preg_match in Twig tpls.
    $twig->addFilter( new Timber\Twig_Filter( 'regex', function( $subject, $pattern, $matches ) {
      return preg_match( $pattern, $subject, $matches );
    } ) );

    // Use PHP's preg_replace in Twig tpls.
    $twig->addFilter( new Timber\Twig_Filter( 'regex_rplc', function( $subject, $pattern, $replacement ) {
      return preg_replace( $pattern, $replacement, $subject );
    } ) );

    return $twig;
  }
}

if ( class_exists( 'Timber' ) ) {
  $timber = new \Timber\Timber();

  // Sets the directories (inside your theme) to find .twig files
  Timber::$dirname = array( 'templates', 'templates/global', 'templates/modules', 'templates/partial' );

  new RelatedTimberSite();
}
