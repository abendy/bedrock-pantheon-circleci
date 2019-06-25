<?php
function rltd_force_jquery_in_head(){
    wp_enqueue_script( 'jquery', false, array(), false, false );
}
add_filter( 'wp_enqueue_scripts', 'rltd_force_jquery_in_head', 1 );

function rltd_setup_theme() {
  // Register menus.
  register_nav_menus( array(
      'main'   => __( 'Main Navigation', 'related-blog' ),
      'mobile' => __( 'Utility Navigation', 'related-blog' ),
      'footer' => __( 'Footer Navigation', 'related-blog' ),
  ) );

  // Add Custom logo support
  add_theme_support( 'custom-logo' );

  // Add HTML5 theme support to search.
  add_theme_support( 'html5', array( 'search-form' ) );

  // Add additional image sizes
  add_theme_support( 'post-thumbnails' );

  // Let WordPress manage the document title
  add_theme_support( 'title-tag' );

  add_image_size( 'hero_small', 1155, 450, true );
  add_image_size( 'hero_medium', 1600, 500, true );
  add_image_size( 'hero_large', 1600, 555, true );
  add_image_size( 'hero_full', 1600, 720, true );

  function rltd_hero_images( $sizes ) {
      return array_merge(
          $sizes,
          array(
              'hero_small'   => __( 'Hero Image 1155x450' ),
              'hero_medium'  => __( 'Hero Image 1600x500' ),
              'hero_large'   => __( 'Hero Image 1600x555' ),
              'hero_full'    => __( 'Hero Image 1600x720' ),
          )
      );
  }
  add_filter( 'image_size_names_choose', 'rltd_hero_images' );
}
add_action( 'after_setup_theme', 'rltd_setup_theme' );



// function rltd_mce_buttons_1( $buttons ) {
//     $buttons = array(
//         'bold', 'italic', 'underline',
//         '|',
//         'bullist', 'numlist', 'blockquote',
//         '|',
//         'alignleft', 'aligncenter', 'alignright',
//         '|',
//         'link', 'unlink',
//         '|',
//         'wp_more',
//         '|',
//         'spellchecker',
//         '|',
//         'table',
//         '|',
//         'wp_adv'
//     );

//     return $buttons;
// }
// add_filter( 'mce_buttons', 'rltd_mce_buttons_1' );

// function rltd_mce_buttons_2( $buttons ) {
//     $buttons = array(
//         'formatselect',
//         '|',
//         'undo', 'redo',
//         '|',
//         'outdent', 'indent',
//         '|',
//         'cut', 'copy', 'pastetext', 'removeformat',
//         '|',
//         'subscript', 'superscript',
//         '|',
//         'charmap',
//         '|',
//         'fullscreen',
//         '|',
//         'wp_help',
//     );

//     return $buttons;
// }
// add_filter( 'mce_buttons_2', 'rltd_mce_buttons_2' );
