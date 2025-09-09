<?php if(!defined('ABSPATH')) { die(); }  

                


	// Code Snippet Code
	 
/**
 * Shortcode to display the current term's description.
 *
 * Usage: [term_description]
 *
 * Works on taxonomy archive pages (categories, tags, custom taxonomies).
 *
 * @return string Term description or empty string.
 */
add_shortcode( 'term_description', function () {
  if ( is_tax() || is_category() || is_tag() ) {
    $term = get_queried_object();
    if ( $term && ! empty( $term->description ) ) {
      return term_description( $term->term_id, $term->taxonomy );
    }
  }
  return '';
} );

	// End Code Snippet Code