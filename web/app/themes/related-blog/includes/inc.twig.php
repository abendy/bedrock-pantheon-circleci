<?php

class RelatedTimberSite extends Timber\Site {
	/** Add timber support. */
	public function __construct() {
		add_filter( 'timber/context', array( $this, 'add_to_context' ) );
		add_filter( 'timber/twig', array( $this, 'add_to_twig' ) );
		parent::__construct();
	}

	/** This is where you add some context
	 *
	 * @param string $context context['this'] Being the Twig's {{ this }}.
	 */
	public function add_to_context( $context ) {
		$context['menu'] = new Timber\Menu();
		$context['site'] = $this;
		return $context;
	}

	/** This is where you can add your own functions to twig.
	 *
	 * @param string $twig get extension.
	 */
	public function add_to_twig( $twig ) {
		return $twig;
	}
}

if ( class_exists( 'Timber' ) ) {
  $timber = new \Timber\Timber();

  // Sets the directories (inside your theme) to find .twig files
  Timber::$dirname = array( 'templates', 'templates/modules' );

  new RelatedTimberSite();
}
