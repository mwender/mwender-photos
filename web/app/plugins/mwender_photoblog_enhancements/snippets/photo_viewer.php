<?php if(!defined('ABSPATH')) { die(); }  


add_action('plugins_loaded', function() {

                

	// Code Snippet Code
    
/**
 * Shortcode: [photo_viewer post_id="123"]
 *
 * Displays a photo viewer for the given post or the current global post.
 */
function photo_viewer_shortcode( $atts ) {
    global $post;

    // Parse attributes
    $atts = shortcode_atts(
        array(
            'post_id' => 0,
        ),
        $atts,
        'photo_viewer'
    );

    // Determine post_id
    $post_id = intval( $atts['post_id'] );
    if ( ! $post_id && $post instanceof WP_Post ) {
        $post_id = $post->ID;
    }

    if ( ! $post_id ) {
        return '<div class="photo-viewer-error">No valid post ID found.</div>';
    }

    // Get post data
    $the_post   = get_post( $post_id );
    if ( ! $the_post ) {
        return '<div class="photo-viewer-error">Post not found.</div>';
    }

    $post_title = esc_html( get_the_title( $the_post ) );
    $content    = apply_filters( 'the_content', $the_post->post_content );
    $image_url  = get_the_post_thumbnail_url( $the_post, 'large' );

    if ( ! $image_url ) {
        $image_url = 'https://via.placeholder.com/800x600?text=No+Image'; // fallback
    }

    // Build HTML
/*
        <h1><?php echo $post_title; ?></h1>
        <a href="<?php echo esc_url( $image_url ); ?>" 
           data-elementor-open-lightbox="yes" 
           data-elementor-lightbox-title="<?php echo esc_attr( $post_title ); ?>">
            <img src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( $post_title ); ?>" />
        </a>
        <div class="entry-content">
            <?php echo $content; ?>
        </div>
*/

    ob_start();
    ?>
    <div id="photo-viewer" hx-get="<?php echo esc_url( "/wp-html/v1/getpost?post_id={$post_id}" ); ?>" hx-trigger="load">

    </div>
    <?php
    return ob_get_clean();
}
add_shortcode( 'photo_viewer', 'photo_viewer_shortcode' );

    // End Code Snippet Code

}, 10);