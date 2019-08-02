<?php

if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

$width = $offset = $el_class = $output = '';

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$width = rltd_wpb_translateColumnWidthToSpan( $width );
$width = vc_column_offset_class_merge( $offset, $width );

$custom_class = esc_attr( trim( vc_shortcode_custom_css_class( $css ) ) );

$css_classes = array(
  'main-col',
  'column',
  $width,
  $custom_class,
);

$wrapper_attributes = array();

$css_class = preg_replace( '/\s+/', ' ', apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, implode( ' ', array_filter( $css_classes ) ), $this->settings['base'], $atts ) );
$wrapper_attributes[] = 'class="' . esc_attr( trim( $css_class ) ) . '"';

$output .= '<div ' . implode( ' ', $wrapper_attributes ) . '>';
$output .= wpb_js_remove_wpautop( $content );
$output .= '</div>';

echo $output;
