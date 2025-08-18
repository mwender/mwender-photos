<?php
use Elementor\Core\DynamicTags\Tag;

if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly.
}

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
