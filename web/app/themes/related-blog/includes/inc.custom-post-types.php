<?php

function rltd_register_post_types() {

  // City post type

  $labels = array(
		'name'                  => _x( 'Cities', 'Post Type General Name', 'related-blog' ),
		'singular_name'         => _x( 'City', 'Post Type Singular Name', 'related-blog' ),
		'menu_name'             => __( 'Cities', 'related-blog' ),
		'name_admin_bar'        => __( 'Cities', 'related-blog' ),
		'archives'              => __( 'City Archives', 'related-blog' ),
		'attributes'            => __( 'City Attributes', 'related-blog' ),
		'parent_item_colon'     => __( 'Parent City:', 'related-blog' ),
		'all_items'             => __( 'All Cities', 'related-blog' ),
		'add_new_item'          => __( 'Add New City', 'related-blog' ),
		'add_new'               => __( 'Add New', 'related-blog' ),
		'new_item'              => __( 'New City', 'related-blog' ),
		'edit_item'             => __( 'Edit City', 'related-blog' ),
		'update_item'           => __( 'Update City', 'related-blog' ),
		'view_item'             => __( 'View City', 'related-blog' ),
		'view_items'            => __( 'View Cities', 'related-blog' ),
		'search_items'          => __( 'Search City', 'related-blog' ),
		'not_found'             => __( 'Not city found', 'related-blog' ),
		'not_found_in_trash'    => __( 'Not city found in Trash', 'related-blog' ),
		'featured_image'        => __( 'Featured Image', 'related-blog' ),
		'set_featured_image'    => __( 'Set featured image', 'related-blog' ),
		'remove_featured_image' => __( 'Remove featured image', 'related-blog' ),
		'use_featured_image'    => __( 'Use as featured image', 'related-blog' ),
		'insert_into_item'      => __( 'Insert into item', 'related-blog' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'related-blog' ),
		'items_list'            => __( 'Cities list', 'related-blog' ),
		'items_list_navigation' => __( 'Cities list navigation', 'related-blog' ),
		'filter_items_list'     => __( 'Filter items list', 'related-blog' ),
	);

  $args = array(
		'label'                 => __( 'City', 'related-blog' ),
		// 'description'           => __( '', 'related-blog' ),
		'labels'                => $labels,
    'supports'              => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'revisions' ),
		// 'taxonomies'            => array( 'post_tag' ), // Handled in function.php
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 50,
    'menu_icon'             => 'dashicons-building',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
    'has_archive'           => false,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
    'rewrite'               => array( 'slug' => 'city' ),
    'query_var'             => true
  );
  register_post_type( 'city', $args );


  // Neighborhood post type

  $labels = array(
		'name'                  => _x( 'Neighborhoods', 'Post Type General Name', 'related-blog' ),
		'singular_name'         => _x( 'Neighborhood', 'Post Type Singular Name', 'related-blog' ),
		'menu_name'             => __( 'Neighborhoods', 'related-blog' ),
		'name_admin_bar'        => __( 'Neighborhoods', 'related-blog' ),
		'archives'              => __( 'Neighborhood Archives', 'related-blog' ),
		'attributes'            => __( 'Neighborhood Attributes', 'related-blog' ),
		'parent_item_colon'     => __( 'Parent Neighborhood:', 'related-blog' ),
		'all_items'             => __( 'All Neighborhoods', 'related-blog' ),
		'add_new_item'          => __( 'Add New Neighborhood', 'related-blog' ),
		'add_new'               => __( 'Add New', 'related-blog' ),
		'new_item'              => __( 'New Neighborhood', 'related-blog' ),
		'edit_item'             => __( 'Edit Neighborhood', 'related-blog' ),
		'update_item'           => __( 'Update Neighborhood', 'related-blog' ),
		'view_item'             => __( 'View Neighborhood', 'related-blog' ),
		'view_items'            => __( 'View Neighborhoods', 'related-blog' ),
		'search_items'          => __( 'Search Neighborhood', 'related-blog' ),
		'not_found'             => __( 'Not city found', 'related-blog' ),
		'not_found_in_trash'    => __( 'Not city found in Trash', 'related-blog' ),
		'featured_image'        => __( 'Featured Image', 'related-blog' ),
		'set_featured_image'    => __( 'Set featured image', 'related-blog' ),
		'remove_featured_image' => __( 'Remove featured image', 'related-blog' ),
		'use_featured_image'    => __( 'Use as featured image', 'related-blog' ),
		'insert_into_item'      => __( 'Insert into item', 'related-blog' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'related-blog' ),
		'items_list'            => __( 'Neighborhoods list', 'related-blog' ),
		'items_list_navigation' => __( 'Neighborhoods list navigation', 'related-blog' ),
		'filter_items_list'     => __( 'Filter items list', 'related-blog' ),
	);

  $args = array(
		'label'                 => __( 'Neighborhood', 'related-blog' ),
		// 'description'           => __( '', 'related-blog' ),
		'labels'                => $labels,
    'supports'              => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'revisions' ),
		// 'taxonomies'            => array( 'post_tag' ), // Handled in function.php
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 51,
    'menu_icon'             => 'dashicons-location',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
    'has_archive'           => false,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
    'rewrite'               => array( 'slug' => 'neighborhood' ),
    'query_var'             => true
  );
  register_post_type( 'neighborhood', $args );


  // Property post type

  $labels = array(
		'name'                  => _x( 'Properties', 'Post Type General Name', 'related-blog' ),
		'singular_name'         => _x( 'Property', 'Post Type Singular Name', 'related-blog' ),
		'menu_name'             => __( 'Properties', 'related-blog' ),
		'name_admin_bar'        => __( 'Properties', 'related-blog' ),
		'archives'              => __( 'Property Archives', 'related-blog' ),
		'attributes'            => __( 'Property Attributes', 'related-blog' ),
		'parent_item_colon'     => __( 'Parent Property:', 'related-blog' ),
		'all_items'             => __( 'All Properties', 'related-blog' ),
		'add_new_item'          => __( 'Add New Property', 'related-blog' ),
		'add_new'               => __( 'Add New', 'related-blog' ),
		'new_item'              => __( 'New Property', 'related-blog' ),
		'edit_item'             => __( 'Edit Property', 'related-blog' ),
		'update_item'           => __( 'Update Property', 'related-blog' ),
		'view_item'             => __( 'View Property', 'related-blog' ),
		'view_items'            => __( 'View Properties', 'related-blog' ),
		'search_items'          => __( 'Search Property', 'related-blog' ),
		'not_found'             => __( 'Not city found', 'related-blog' ),
		'not_found_in_trash'    => __( 'Not city found in Trash', 'related-blog' ),
		'featured_image'        => __( 'Featured Image', 'related-blog' ),
		'set_featured_image'    => __( 'Set featured image', 'related-blog' ),
		'remove_featured_image' => __( 'Remove featured image', 'related-blog' ),
		'use_featured_image'    => __( 'Use as featured image', 'related-blog' ),
		'insert_into_item'      => __( 'Insert into item', 'related-blog' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'related-blog' ),
		'items_list'            => __( 'Properties list', 'related-blog' ),
		'items_list_navigation' => __( 'Properties list navigation', 'related-blog' ),
		'filter_items_list'     => __( 'Filter items list', 'related-blog' ),
	);

  $args = array(
		'label'                 => __( 'Property', 'related-blog' ),
		// 'description'           => __( '', 'related-blog' ),
		'labels'                => $labels,
    'supports'              => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'revisions' ),
		// 'taxonomies'            => array( 'post_tag' ), // Handled in function.php
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 52,
    'menu_icon'             => 'dashicons-admin-multisite',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
    'has_archive'           => false,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
    'rewrite'               => array( 'slug' => 'property' ),
    'query_var'             => true
  );
  register_post_type( 'property', $args );


  // Fixes pagination issue when custom post type slug is the same as the page's slug
  // e.g. if we have a /news/ landing page and each news page has a url prefix of /news/...
  // add_rewrite_rule(
  //   '^([^/]+)/page/([^/]+)',
  //   'index.php?pagename=$matches[1]&paged=$matches[2]',
  //   'top'
  // );
}

add_action( 'init', 'rltd_register_post_types', 0 );
