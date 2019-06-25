<?php

// Remove `posts` and `comments`
function remove_posts_menu() {
    remove_menu_page( 'edit.php' );
    remove_menu_page( 'edit-comments.php' );
}
add_action( 'admin_init', 'remove_posts_menu' );

// Remove meta/postboxes
function rltd_remove_metaboxes() {
    $post_types = rltd_get_post_types( 'names' );
    $post_types['page'] = 'page';

    foreach ( $post_types as $post_type ) {
        // Author Metabox
        remove_meta_box( 'authordiv', $post_type, 'normal' );
        // Category Metabox
        remove_meta_box( 'categorydiv', $post_type, 'normal' );
        // Comments Status Metabox
        remove_meta_box( 'commentstatusdiv', $post_type, 'normal' );
        // Comments Metabox
        remove_meta_box( 'commentsdiv', $post_type, 'normal' );
        // Custom Fields Metabox
        remove_meta_box( 'postcustom', $post_type, 'normal' );
        // Trackback Metabox
        remove_meta_box( 'trackbacksdiv', $post_type, 'normal' );
    }
}
add_action( 'admin_init', 'rltd_remove_metaboxes' );

// Add excerpt field to page type.
function rltd_add_excerpt_to_page() {
    add_post_type_support( 'page', 'excerpt' );
}
add_action( 'init', 'rltd_add_excerpt_to_page' );

// Add tags and category to all content types.
function rltd_register_tags() {
    $post_types = rltd_get_post_types( 'names' );
    $post_types['page'] = 'page';

    foreach ( $post_types as $post_type ) {
        register_taxonomy_for_object_type( 'post_tag', $post_type );
    }
}
add_action( 'init', 'rltd_register_tags' );
