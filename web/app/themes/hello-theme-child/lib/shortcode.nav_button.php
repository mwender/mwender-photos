<?php
/**
 * Shortcode: [nav_button label="Previous"]
 *
 * Outputs an HTMX-enabled button with the current post ID.
 *
 * Attributes:
 * - label: The text to display on the button (e.g., "Previous", "Next", "Random").
 *
 * Usage examples:
 * [nav_button label="Previous"]
 * [nav_button label="Next"]
 * [nav_button label="Random"]
 */
function hello_elementor_child_nav_button_shortcode( $atts ) {

  
  $atts = shortcode_atts(
    array(
      'label'             => 'Previous',
      'id'                => null,
      'previous_post_id'  => null,
      'next_post_id'      => null,
      'oob'               => true,
    ),
    $atts,
    'nav_button'
  );
  

  if( is_null( $atts['previous_post_id'] ) || is_null( $atts['next_post_id'] ) ){
    global $post;
    $post = get_post( $atts['id'] );
    setup_postdata( $post );

    $previous_post = get_adjacent_post( false, '', true );
    $next_post     = get_adjacent_post( false, '', false );

    $atts['previous_post_id'] = ( $previous_post instanceof WP_Post ) ? $previous_post->ID : null;
    $atts['next_post_id'] = ( $next_post instanceof WP_Post ) ? $next_post->ID : null;
    wp_reset_postdata();
  }

  if( 'Random' == $atts['label'] ){
    $atts['random_post_id'] = ( new WP_Query(['post_type' => 'post', 'posts_per_page' => 1, 'post__not_in' => [ $atts['id'] ], 'orderby' => 'rand']) )->posts[0]->ID ?? null;
  } else {
    $atts['random_post_id'] = null;
  }

  uber_log('🔔 $atts = ', $atts );

  $post_id = ( 'Previous' == $atts['label'] )? $atts['previous_post_id'] : $atts['next_post_id'] ;
  $oob_attr = ( $atts['oob'] )? 'hx-swap-oob="true:#nav-button-' . strtolower( $atts['label'] ) . '"' : '' ;

  $css_classes[] = 'elementor-button';
  switch( $atts['label'] ){
    case 'Previous':
      if( empty( $atts['previous_post_id'] ) )
        $css_classes[] = 'disabled';
      $hx_vals['post_id'] = $atts['previous_post_id'];
      $post_title = ( ! is_null( $atts['previous_post_id'] ) )? get_the_title( $atts['previous_post_id'] ) : '' ;
      break;

    case 'Next':
      if( empty( $atts['next_post_id'] ) )
        $css_classes[] = 'disabled';
      $hx_vals['post_id'] = $atts['next_post_id'];
      $post_title = ( ! is_null( $atts['next_post_id'] ) )? get_the_title( $atts['next_post_id'] ) : '' ;
      uber_log('🔔🔔 $hx_vals = ', $hx_vals );
      break;

    case 'Random':
      $hx_vals['post_id'] = $atts['random_post_id'];
      $post_title = get_the_title( $atts['random_post_id'] );
      break;
  }


  $html = '<a 
    href="#" 
    class="' . implode( ' ', $css_classes ). '" 
    id="nav-button-' . strtolower( $atts['label'] ) . '"
    hx-target="#nav-button-' . strtolower( $atts['label'] ) . '"
    ' . $oob_attr . '
    hx-swap="outerHTML"
    hx-get="/wp-html/v1/getpost"
    hx-push-url="' . get_permalink( $post_id ) . '"
    hx-vals=\'{"post_id":"' . $hx_vals['post_id'] . '","label":"' . $atts['label'] . '"}\'
    >' . esc_html( $atts['label'] ) . ' (' . $post_title . ')</a>';

  return $html;

}
add_shortcode( 'nav_button', 'hello_elementor_child_nav_button_shortcode' );
