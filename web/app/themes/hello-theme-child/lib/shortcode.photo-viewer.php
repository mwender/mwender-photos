<?php
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

    ob_start();
    ?>   
    <div id="photo-viewer" hx-get="<?php echo esc_url( "/wp-html/v1/getpost?post_id={$post_id}" ); ?>" hx-trigger="load">
          <div id="photo-viewer-content">
            <h1 class="post-title skeleton" style="width: 50%; margin-left: auto; margin-right: auto;"></h1>
            <div class="skeleton" style="height: 420px; margin-bottom: 2rem;"></div>
            <p class="skeleton"></p>
            <p class="skeleton" style="width: 75%;"></p>
            <p class="skeleton" style="width: 80%;"></p>
            <div class="post-info">
                <p class="skeleton" style="width: 55%;"></p>
                <p class="skeleton" style="width: 20%;"></p>
            </div>
          </div>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode( 'photo_viewer', 'photo_viewer_shortcode' );
