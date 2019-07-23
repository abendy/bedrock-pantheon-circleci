<?php

// Add jQuery
function rltd_force_jquery_in_head(){
  wp_enqueue_script( 'jquery', false, array(), false, false );
}
add_filter( 'wp_enqueue_scripts', 'rltd_force_jquery_in_head', 1 );

// Remove `comments`
function rltd_remove_menu_page() {
  remove_menu_page( 'edit-comments.php' );
}
add_action( 'admin_init', 'rltd_remove_menu_page' );

// Remove meta/postboxes
function rltd_remove_meta_box() {
  $post_types = rltd_get_post_types( 'names' );
  $post_types['page'] = 'page';

  foreach ( $post_types as $post_type ) {
    // Author Metabox
    // remove_meta_box( 'authordiv', $post_type, 'normal' );
    // Category Metabox
    // remove_meta_box( 'categorydiv', $post_type, 'normal' );
    // Comments Status Metabox
    remove_meta_box( 'commentstatusdiv', $post_type, 'normal' );
    // Comments Metabox
    remove_meta_box( 'commentsdiv', $post_type, 'normal' );
    // Custom Fields Metabox
    remove_meta_box( 'postcustom', $post_type, 'normal' );
    // Page Attributes Metabox
    remove_meta_box( 'pageparentdiv', $post_type, 'normal' );
    // Slug Metabox
    // remove_meta_box( 'slugdiv', $post_type, 'normal' );
    // Tags Metabox
    // remove_meta_box( 'tagsdiv-post_tag', $post_type, 'normal' );
    // Trackback Metabox
    remove_meta_box( 'trackbacksdiv', $post_type, 'normal' );
  }
}
add_action( 'admin_init', 'rltd_remove_meta_box' );

// Add excerpt field to page type.
function rltd_add_post_type_support() {
  add_post_type_support( 'page', 'excerpt' );
}
add_action( 'init', 'rltd_add_post_type_support' );

// Add tags and category to all content types.
function rltd_register_taxonomy() {
  $post_types = rltd_get_post_types( 'names' );
  $post_types['page'] = 'page';

  foreach ( $post_types as $post_type ) {
    register_taxonomy_for_object_type( 'category', $post_type );
    register_taxonomy_for_object_type( 'post_tag', $post_type );
  }
}
add_action( 'init', 'rltd_register_taxonomy' );
