<?php

require_once get_template_directory() . '/includes/inc.helpers.php';
require_once get_template_directory() . '/includes/inc.admin-ui.php';
require_once get_template_directory() . '/includes/inc.theme-settings.php';
require_once get_template_directory() . '/includes/inc.acf.php';
require_once get_template_directory() . '/includes/inc.visual-composer.php';
require_once get_template_directory() . '/includes/inc.visual-composer.templates.php';
require_once get_template_directory() . '/includes/inc.twig.php';

// Load Custom Meta Box
require_once get_template_directory() . '/includes/meta-box.php';

add_action( 'wp_enqueue_scripts', function() {
  wp_register_style( 'animate-css', vc_asset_url( 'lib/bower/animate-css/animate.min.css' ), array(), WPB_VC_VERSION );
  wp_enqueue_style( 'animate-css' );
});
