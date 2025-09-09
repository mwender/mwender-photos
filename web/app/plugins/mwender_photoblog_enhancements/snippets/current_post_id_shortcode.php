<?php if(!defined('ABSPATH')) { die(); }  


add_action('plugins_loaded', function() {

                

	// Code Snippet Code
     

/**
 * Shortcode: [current-post-id]
 *
 * Returns the ID of the current post in The Loop.
 *
 * @return string Post ID or empty string if no global $post is found.
 */
function mw_current_post_id_shortcode() {
  global $post;

  if ( isset( $post->ID ) ) {
    return (string) $post->ID;
  }

  return '';
}
add_shortcode( 'current-post-id', 'mw_current_post_id_shortcode' );

    // End Code Snippet Code

}, 10);