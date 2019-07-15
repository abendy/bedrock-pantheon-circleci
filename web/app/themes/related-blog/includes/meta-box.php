<?php
/**
 * Registering meta boxes
 */

/**
 * Add publication Feild
 */
add_filter( 'rwmb_meta_boxes', 'rr_register_meta_boxes' );

function rr_register_meta_boxes( $meta_boxes ) {
  /**
   * prefix of meta keys (optional)
   * Use underscore (_) at the beginning to make keys hidden
   * Alt.: You also can make prefix empty to disable it
   */

  $hero_image_prefix = 'hero_image_';

  $meta_boxes[] = array(
    // Meta box id, UNIQUE per meta box. Optional since 4.1.5
    'id'         => 'hero-image',
    // Meta box title - Will appear at the drag and drop handle bar. Required.
    'title'      => __( 'Hero Image', 'related-rentals-blog' ),
    // Post types, accept custom post types as well - DEFAULT is 'post'. Can be array (multiple post types) or string (1 post type). Optional.
    'post_types' => array( 'post' ),
    // Where the meta box appear: normal (default), advanced, side. Optional.
    'context'    => 'normal',
    // Order of meta box: high (default), low. Optional.
    'priority'   => 'high',
    // Auto save: true, false (default). Optional.
    'autosave'   => true,
    // List of meta fields
    'fields'     => array(
      // IMAGE ADVANCED (WP 3.5+)
      array(
        'name' => __( 'Hero Image Upload', 'related-rentals-blog' ),
        'id'   => "{$hero_image_prefix}imgadv",
        'type' => 'image_advanced',
        'max_file_uploads' => 1
      )
    )
  );

  // $slideshow_prefix = 'slideshow_';

  // $meta_boxes[] = array(
  //   // Meta box id, UNIQUE per meta box. Optional since 4.1.5
  //   'id'         => 'slideshow',
  //   // Meta box title - Will appear at the drag and drop handle bar. Required.
  //   'title'      => __( 'Slideshow', 'related-rentals-blog' ),
  //   // Post types, accept custom post types as well - DEFAULT is 'post'. Can be array (multiple post types) or string (1 post type). Optional.
  //   'post_types' => array( 'post' ),
  //   // Where the meta box appear: normal (default), advanced, side. Optional.
  //   'context'    => 'normal',
  //   // Order of meta box: high (default), low. Optional.
  //   'priority'   => 'high',
  //   // Auto save: true, false (default). Optional.
  //   'autosave'   => true,
  //   // List of meta fields
  //   'fields'     => array(
  //     // IMAGE ADVANCED (WP 3.5+)
  //     array(
  //       'name' => __( 'Image Slideshow Upload', 'related-rentals-blog' ),
  //       'id'   => "{$slideshow_prefix}imgadv",
  //       'type' => 'image_advanced'
  //     )
  //   )
  // );

  return $meta_boxes;
}
