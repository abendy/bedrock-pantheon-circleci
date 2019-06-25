<?php

class Rltd_Breadcrumbs {

    public function __construct() {

        // Get main navigation
        $this->menu_items = wp_get_nav_menu_items( 'main' );

    }

    public function set_parent( $posts ) {

        foreach( $posts as $key => $post ) {

            $parent_item_id = wp_filter_object_list( $this->menu_items, array( 'object_id' => $post->ID ), 'and', 'menu_item_parent' );

            if ( !empty( $parent_item_id ) ) {

                $parent_post_id = wp_filter_object_list( $this->menu_items, array( 'ID' => array_shift( $parent_item_id ) ), 'and', 'object_id' );

                if ( !empty( $parent_post_id ) ) {

                    $posts[$key]->parent_post = get_post( array_shift( $parent_post_id ) );

                    $this->set_parent( array( $posts[$key]->parent_post ) );

                }
            }
        }

        return $posts;
    }
}
