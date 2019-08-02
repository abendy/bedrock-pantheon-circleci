<?php

if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

$output = '';

$css_classes = array(
  'wpb_animate_when_almost_visible wpb_fadeIn fadeIn wpb_start_animation animated',
  'columns',
  'is-marginless',
);

$wrapper_attributes = array();

$css_class = preg_replace( '/\s+/', ' ', implode( ' ', array_filter( array_unique( $css_classes ) ) ) );
$wrapper_attributes[] = 'class="' . esc_attr( trim( $css_class ) ) . '"';

$output .= '<div ' . implode( ' ', $wrapper_attributes ) . ' style="justify-content: space-between;">';
$output .= wpb_js_remove_wpautop( $content );
$output .= '</div>';

echo $output;
