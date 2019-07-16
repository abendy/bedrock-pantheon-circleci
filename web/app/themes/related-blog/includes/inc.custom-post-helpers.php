<?php

function rr_neighborhood_columns_settings( $columns ) {
  $columns = array(
    'cb' => '<input type="checkbox" />',
    'title' => __( 'Title', 'rr_backend' ),
    'city' => __( 'City', 'rr_backend' )
  );

  return $columns;
}
add_filter( 'manage_edit-neighborhood_columns', 'rr_neighborhood_columns_settings' );


function rr_neighborhood_columns_content( $column, $post_id ) {
  global $post;

  switch ( $column ) {
    /* If displaying the 'duration' column. */
    case 'city' :
      $city = get_post_meta( $post_id, 'neighborhood_city', true );

      if ( !empty( $city ) ) {
          echo "<a href='post.php?post=" . $city . "&action=edit'>" . get_the_title( $city ) . "</a>";
      } else {
          echo '<i>No city.</i>';
      }

      break;

    /* Just break out of the switch statement for everything else. */
    default :
      break;
  }
}
add_action( 'manage_neighborhood_posts_custom_column', 'rr_neighborhood_columns_content', 10, 2 );


// Additional Settings

function rr_property_extra_settings() {
  add_meta_box( 'property_relationships', 'Property Relationships', 'rr_property_extra_settings_config', 'property', 'normal', 'high' );
}
add_action( 'admin_init', 'rr_property_extra_settings' );


function rr_property_extra_settings_config() {
  global $post;

  $custom = get_post_custom( $post->ID );

  $property_neighborhood = $selected = '';

  if ( isset( $custom['property_neighborhood'][0] ) ) {
    $property_neighborhood = $custom['property_neighborhood'][0];
  }

  if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
    return;
  }

  $cities = new WP_Query( array(
    'post_type' => 'city',
    'orderby' => 'title',
    'order'   => 'ASC',
  ) );

  echo '<div class="metabox-options">'.PHP_EOL.
      '   <div class="metabox-option">'.PHP_EOL.
      '       <h4>Select Neighborhood</h4>'.PHP_EOL.
      '       <select name="property_neighborhood" class="select">'.PHP_EOL.
      '           <option value="">Select Neighborhood</option>'.PHP_EOL;

  while ( $cities->have_posts() ) {
    $cities->the_post();

    echo '           <optgroup label="' . get_the_title() . '">';

    $neighborhoods = new WP_Query( array(
      'post_type' => 'neighborhood',
      'meta_key' => 'neighborhood_city',
      'meta_value' => $post->ID,
      'meta_compare' => '=',
      'orderby' => 'title',
      'order'   => 'ASC',
    ) );

    while( $neighborhoods->have_posts() ) {
      $neighborhoods->the_post();

      $selected = '';

      if ( $post->ID == $property_neighborhood ) {
        $selected = 'selected';
      }

      echo '           <option value="' . $post->ID . '"' . $selected . '>' . get_the_title() . '</option>';

      wp_reset_postdata();
    }

    wp_reset_postdata();
  }

  echo '           </optgroup>'.PHP_EOL.
      '       </select>'.PHP_EOL.
      '   </div>'.PHP_EOL.
      '</div>'.PHP_EOL;

  wp_reset_postdata();
}


// Save Custom Fields

function rr_save_property_post_settings() {
  global $post;

  if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
    return;
  }
  else {
    if ( isset( $_POST['property_neighborhood'] ) ) {
      update_post_meta( $post->ID, 'property_neighborhood', $_POST['property_neighborhood'] );
    }
  }
}
add_action( 'save_post', 'rr_save_property_post_settings' );


// function rr_property_columns_settings() {
//   $columns = array(
//     'cb' => '<input type="checkbox" />',
//     'title' => __( 'Property', 'rr_backend' ),
//     'neighborhood' => __( 'Neighborhood', 'rr_backend' ),
//     'city' => __( 'City', 'rr_backend' )
//   );

//   return $columns;
// }
// add_filter( 'manage_edit-property_columns', 'rr_property_columns_settings' );


function rr_property_columns_content( $column, $post_id ) {
  global $post;

  switch ( $column ) {

    /* If displaying the 'duration' column. */
    case 'neighborhood':
      $neighborhood = get_post_meta( $post_id, 'property_neighborhood', true );

      if ( !empty( $neighborhood ) ) {
        echo "<a href='post.php?post=".$neighborhood.
        "&action=edit'>".get_the_title( $neighborhood ).
        "</a>";
      } else {
        echo '<i>No neighborhood.</i>';
      }

      break;
    case 'city':

      $neighborhood = get_post_meta( $post_id, 'property_neighborhood', true );
      $city = get_post_meta( $neighborhood, 'neighborhood_city', true );

      if ( !empty( $city ) ) {
        echo "<a href='post.php?post=".$city.
        "&action=edit'>".get_the_title( $city ).
        "</a>";
      } else {
        echo '<i>No city.</i>';
      }

      break;
  }
}
add_action( 'manage_property_posts_custom_column', 'rr_property_columns_content', 10, 2 );
