<?php

// Registers ACF fields via PHP.
if ( class_exists( 'acf' ) ) {
  function rltd_acf_fields_init() {

    if ( function_exists( 'acf_add_local_field_group' ) ) {

      // City
      acf_add_local_field_group( array(
        'key' => 'group_58d9219d6217c',
        'title' => 'City Settings',
        'fields' => array(
          array(
            'key' => 'field_58d921af00078',
            'label' => 'Short Name',
            'name' => 'city_short_name',
            'type' => 'text',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
              'width' => '',
              'class' => '',
              'id' => '',
            ),
            'default_value' => '',
            'placeholder' => '',
            'prepend' => '',
            'append' => '',
            'maxlength' => 2,
          ),
        ),
        'location' => array(
          array(
            array(
              'param' => 'post_type',
              'operator' => '==',
              'value' => 'city',
            ),
          ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => 1,
        'description' => '',
        'modified' => 1490624956,
      ) );

      // Neighborhood
      acf_add_local_field_group( array(
        'key' => 'group_58d2a8e0932db',
        'title' => 'Neighborhood Settings',
        'fields' => array(
          array(
            'key' => 'field_58d2a8ea9a804',
            'label' => 'Listing URL',
            'name' => 'neighborhood_listing_url',
            'type' => 'text',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
              'width' => '',
              'class' => '',
              'id' => '',
            ),
            'default_value' => '',
            'placeholder' => '',
            'prepend' => '',
            'append' => '',
            'maxlength' => '',
          ),
          array(
            'key' => 'field_58d5174a58425',
            'label' => 'City',
            'name' => 'neighborhood_city',
            'type' => 'post_object',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
              'width' => '',
              'class' => '',
              'id' => '',
            ),
            'post_type' => array(
              0 => 'city',
            ),
            'taxonomy' => array(
            ),
            'allow_null' => 0,
            'multiple' => 0,
            'return_format' => 'object',
            'ui' => 1,
          ),
        ),
        'location' => array(
          array(
            array(
              'param' => 'post_type',
              'operator' => '==',
              'value' => 'neighborhood',
            ),
          ),
        ),
        'menu_order' => 0,
        'position' => 'acf_after_title',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => 1,
        'description' => '',
        'modified' => 1490360238,
      ) );

      // Property
      acf_add_local_field_group( array(
        'key' => 'group_58d02566434ff',
        'title' => 'Property Settings',
        'fields' => array(
          array(
            'key' => 'field_58d0264091a66',
            'label' => 'Image',
            'name' => 'property_image',
            'type' => 'image',
            'instructions' => '',
            'required' => 1,
            'conditional_logic' => 0,
            'wrapper' => array(
              'width' => '',
              'class' => '',
              'id' => '',
            ),
            'return_format' => 'array',
            'preview_size' => 'thumbnail',
            'library' => 'all',
            'min_width' => '',
            'min_height' => '',
            'min_size' => '',
            'max_width' => '',
            'max_height' => '',
            'max_size' => '',
            'mime_types' => '',
          ),
          array(
            'key' => 'field_58d0266291a67',
            'label' => 'URL to Listing',
            'name' => 'property_url',
            'type' => 'url',
            'instructions' => '',
            'required' => 1,
            'conditional_logic' => 0,
            'wrapper' => array(
              'width' => '',
              'class' => '',
              'id' => '',
            ),
            'default_value' => '',
            'placeholder' => '',
          ),
          array(
            'key' => 'field_58d520a4dbb75',
            'label' => 'Address',
            'name' => 'property_address',
            'type' => 'text',
            'instructions' => '',
            'required' => 1,
            'conditional_logic' => 0,
            'wrapper' => array(
              'width' => '',
              'class' => '',
              'id' => '',
            ),
            'default_value' => '',
            'placeholder' => '',
            'prepend' => '',
            'append' => '',
            'maxlength' => '',
          ),
          array(
            'key' => 'field_58d0267991a68',
            'label' => 'Set as featured property',
            'name' => 'property_featured',
            'type' => 'true_false',
            'instructions' => 'If this box is checked, this property will show in the featured properties box throughout the site.',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
              'width' => '',
              'class' => '',
              'id' => '',
            ),
            'message' => '',
            'default_value' => 0,
            'ui' => 0,
            'ui_on_text' => '',
            'ui_off_text' => '',
          ),
        ),
        'location' => array(
          array(
            array(
              'param' => 'post_type',
              'operator' => '==',
              'value' => 'property',
            ),
          ),
        ),
        'menu_order' => 0,
        'position' => 'acf_after_title',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => 1,
        'description' => '',
        'modified' => 1490642606,
      ) );
    }

  }
  add_action( 'init', 'rltd_acf_fields_init' );
}
