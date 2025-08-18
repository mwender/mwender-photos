<?php
// Basic nonce validation (works for all hypermedia libraries)
if (!hm_validate_request()) {
    hm_die('Security check failed');
}

$previous_post_id = do_shortcode( '[latest-post-id]');

if ( is_numeric( $hmvals['post_id'] ) ){
	global $post;
	$post = get_post( $hmvals['post_id'] );
	$post_title = get_the_title( $post );
	$post_content = apply_filters( 'the_content', $post->post_content );
	$post_thumbnail = get_the_post_thumbnail( $post, 'large' );
	$post_date = get_the_date();
	setup_postdata( $post );
	$previous_post = get_adjacent_post( false, null, true );
	//$post_content = '<pre>$previous_post = '.print_r($previous_post, true).'</pre>';
	$previous_post_id = $previous_post->ID;
	wp_reset_postdata();
} else {
	$post_title = 'Post Title Goes Here...';
	$post_content = '<pre>$hmvals = ' . print_r( $hmvals, true ) . '</code>';
	$post_thumbnail = '<img decoding="async" src="https://photos.mwender.test/app/plugins/elementor/assets/images/placeholder.png" title="" alt="" loading="lazy">';
	$post_date = current_time( 'F j, Y, g:i a' );
}
?>
<a href="#" class="elementor-button" hx-swap="outerHTML" hx-get="/wp-html/v1/test?foo=<?= $previous_post_id ?>" hx-vals='{"post_id":"<?= $previous_post_id ?>"}'>Previous Swapped</a>
<div hx-swap-oob="true:#post-content.elementor-widget-text-editor"><?= $post_content ?></div>
<div hx-swap-oob="true:#post-title .elementor-heading-title"><?= $post_title ?></div>
<div hx-swap-oob="true:#post-thumbnail"><?= $post_thumbnail ?></div>
<div hx-swap-oob="true:#post-date .elementor-heading-title"><?= $post_date ?></div>