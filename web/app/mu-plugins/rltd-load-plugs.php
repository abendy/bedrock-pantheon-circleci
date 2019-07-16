<?php

/*
Plugin Name: Related Blog Load Plug-ins
Description: Load our must-use plug-ins from their respective directories.
Version:     2019.0.1
*/

if (!is_blog_installed()) {
  return;
}

// require_once WPMU_PLUGIN_DIR . '/advanced-custom-fields/acf.php';

// if (!class_exists('Vc_Manager')) {
//     require_once WPMU_PLUGIN_DIR . '/js_composer/js_composer.php';
// }

if (!class_exists('Timber')) {
  require_once WP_PLUGIN_DIR . '/timber-library/timber.php';
}

// if (!class_exists('Options_Framework') and !function_exists('optionsframework_init')) {
//     require_once WPMU_PLUGIN_DIR . '/options-framework/options-framework.php';
// }
