<?php

require_once 'includes/inc.theme-settings.php';
require_once 'includes/inc.admin-ui.php';
require_once 'includes/inc.visual-composer.php';
require_once 'includes/inc.twig.php';
require_once 'includes/inc.helpers.php';
require_once 'includes/inc.breadcrumbs.php';

function rltd_enqueue_styles() {
    wp_enqueue_style( 'rltd-style',
        get_template_directory_uri() . '/build/styles/main.css',
        array(),
        wp_get_theme()->get( 'Version' )
    );
}
add_action( 'wp_enqueue_scripts', 'rltd_enqueue_styles' );

function rltd_hide_parent( $themes ) {
    unset( $themes[get_template()] );
    return $themes;
}
add_filter( 'wp_prepare_themes_for_js','rltd_hide_parent' );
