<?php

/*
Plugin Name: Related Blog Load Plug-ins
Description: Load our must-use plug-ins from their respective directories.
Version:     2019.0.1
*/

if (!is_blog_installed()) {
  return;
}

if (!class_exists('Timber')) {
  require_once WP_PLUGIN_DIR . '/timber-library/timber.php';
}
