<?php if(!defined('ABSPATH')) { die(); }  

                


	// Code Snippet Code
	 
add_action( 'rss2_item', function() {
  global $post;

  if ( has_post_thumbnail( $post->ID ) ) {
    $thumbnail_url = get_the_post_thumbnail_url( $post->ID, 'four-three' );

    if ( $thumbnail_url ) {
      echo '<media:content url="' . esc_url( $thumbnail_url ) . '" medium="image" />' . "\n";
    }
  }
} );

add_action( 'rss2_ns', function() {
  echo 'xmlns:media="http://search.yahoo.com/mrss/"';
} );

	// End Code Snippet Code