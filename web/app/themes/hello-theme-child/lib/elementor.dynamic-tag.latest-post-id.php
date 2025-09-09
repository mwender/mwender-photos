<?php
/**
 * Plugin Name: Elementor Dynamic Tag - Latest Post ID
 * Description: Adds a custom dynamic tag for Elementor that outputs the latest Post ID.
 * Version: 1.0.0
 * Author: Michael Wender
 */
if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly.
}

use Elementor\Core\DynamicTags\Tag;

add_action( 'elementor/dynamic_tags/register', function( $dynamic_tags ) {
  //require_once __DIR__ . '/lib/class-dynamic-tag-latest-post-id.php';
  $dynamic_tags->register( new \Dynamic_Tag_Latest_Post_ID() );
} );

/**
 * Resolve dynamic tags inside Elementor Custom Attributes.
 */
add_action( 'elementor/frontend/widget/before_render', function( $widget ) {
  $settings = $widget->get_settings_for_display();

  if ( ! empty( $settings['custom_attributes'] ) ) {
    // Let Elementor's dynamic tags manager process it
    $resolved = \Elementor\Plugin::$instance->dynamic_tags->parse_tags_text( $settings['custom_attributes'] );

    // Update the widget’s attributes so it outputs properly
    $widget->add_render_attribute( '_wrapper', 'custom-attributes', $resolved );
  }
}, 10, 1 );

/**
 * Allow dynamic tags in Elementor Custom Attributes.
 */
add_filter( 'elementor/frontend/widget/parsed_custom_attributes', function( $attributes, $widget ) {
    $parsed = [];

    foreach ( $attributes as $key => $value ) {
        if ( is_string( $value ) && strpos( $value, '{{' ) !== false ) {
            // Resolve dynamic tags
            $value = \Elementor\Plugin::$instance->dynamic_tags->parse_tags_text( $value );
        }

        $parsed[ $key ] = $value;
    }

    return $parsed;
}, 10, 2 );

class Dynamic_Tag_Latest_Post_ID extends Tag {

  public function get_name() {
    return 'latest-post-id';
  }

  public function get_title() {
    return __( 'Latest Post ID', 'elementor-dynamic-tag' );
  }

  public function get_group() {
    return 'site'; // Appears in the "Site" group of dynamic tags
  }

  public function get_categories() {
    return [ \Elementor\Modules\DynamicTags\Module::TEXT_CATEGORY ];
  }

  public function render() {
    $latest = get_posts( [
      'numberposts' => 1,
      'post_type'   => 'post',
      'post_status' => 'publish',
      'fields'      => 'ids',
    ] );

    if ( ! empty( $latest ) ) {
      echo esc_html( $latest[0] );
    }
  }
}