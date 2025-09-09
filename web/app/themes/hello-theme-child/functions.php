<?php
/**
 * Theme functions and definitions.
 *
 * For additional information on potential customization options,
 * read the developers' documentation:
 *
 * https://developers.elementor.com/docs/hello-elementor-theme/
 *
 * @package HelloElementorChild
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

define( 'HELLO_ELEMENTOR_CHILD_VERSION', '2.0.0' );

function hello_elementor_child_setup() {
  // Let WordPress handle loading the block styles
  add_theme_support( 'wp-block-styles' );

  // Optional: adds the default editor styles to the frontend
  add_editor_style( 'editor-style.css' );

  // photos-featured: 2040px wide, unlimited height, no crop
  add_image_size( 'photos-featured', 2040, 9999, false );
}
add_action( 'after_setup_theme', 'hello_elementor_child_setup' );

/**
 * Load child theme scripts & styles.
 *
 * @return void
 */
function hello_elementor_child_scripts_styles() {

	wp_enqueue_style(
		'hello-elementor-child-style',
		get_stylesheet_directory_uri() . '/style.css',
		[
			'hello-elementor-theme-style',
		],
		filemtime( get_stylesheet_directory() . '/style.css' )
	); 
}
add_action( 'wp_enqueue_scripts', 'hello_elementor_child_scripts_styles', 20 );

require_once plugin_dir_path( __FILE__ ) . '/lib/elementor.dynamic-tag.latest-post-id.php';
require_once plugin_dir_path( __FILE__ ) . '/lib/shortcode.nav_button.php';
require_once plugin_dir_path( __FILE__ ) . '/lib/shortcode.photo-viewer.php';
require_once plugin_dir_path( __FILE__ ) . '/lib/utilities.php';
