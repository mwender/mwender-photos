<?php if(!defined('ABSPATH')) { die(); }  

                


	// Code Snippet Code
	 
/**
 * Shortcode: [latest-post-id]
 *
 * Returns the ID of the most recent published Post.
 *
 * @since 1.0.0
 */
function shortcode_latest_post_id() {
  $latest_post = get_posts( array(
    'numberposts' => 1,
    'post_type'   => 'post',
    'post_status' => 'publish',
    'fields'      => 'ids',
  ) );

  return ! empty( $latest_post ) ? $latest_post[0] : '';
}
add_shortcode( 'latest-post-id', 'shortcode_latest_post_id' );

	// End Code Snippet Code