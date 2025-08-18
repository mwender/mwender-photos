<?php
// Basic nonce validation (works for all hypermedia libraries)
if (!hm_validate_request()) {
    hm_die('Security check failed');
}

// Setup $post_data
if ( is_numeric( $hmvals['post_id'] ) ){
	global $post;
	$post = get_post( $hmvals['post_id'] );
	setup_postdata( $post );
	$previous_post = get_adjacent_post( false, '', true );
	$next_post = get_adjacent_post( false, '', false );
	uber_log( '🔔 $next_post = ', $next_post );

	$post_data = [
		'title' 						=> get_the_title( $post ),
		'content'						=> apply_filters( 'the_content', $post->post_content ),
		'thumbnail'					=> get_the_post_thumbnail( $post, 'large' ),
		'date'							=> get_the_date(),
		'current_post_id'		=> $hmvals['post_id'],
		'previous_post_id'	=> $previous_post->ID,
		'next_post_id'			=> $next_post->ID,
	];

	wp_reset_postdata();
} else {
	$post_data = [
		'title' 						=> 'Post Title Goes Here...',
		'content'						=> '<p>Post content gets inserted here.</p>',
		'thumbnail'					=> '<img decoding="async" src="https://photos.mwender.test/app/plugins/elementor/assets/images/placeholder.png" title="" alt="" loading="lazy">',
		'date'							=> current_time( 'F j, Y, g:i a' ),
		'current_post_id'		=> null,
		'previous_post_id'	=> null,
		'next_post_id'			=> null,
	];
}

// <a href="#" class="elementor-button" hx-swap="outerHTML" hx-get="/wp-html/v1/getpost" hx-vals=\'{"post_id":"%d","label":"%s"}\'>%s</a>
?>
<a href="#" class="elementor-button" hx-swap="outerHTML" hx-get="/wp-html/v1/getpost" hx-vals='{"post_id":"<?= $hmvals['post_id'] ?>", "label": "<?= $hmvals['label'] ?>"}'><?= $hmvals['label'] ?></a>
<div hx-swap-oob="true:#post-content"><?= $post_data['content'] ?></div>
<div hx-swap-oob="true:#post-title .elementor-heading-title"><?= $post_data['title'] ?></div>
<div hx-swap-oob="true:#post-thumbnail"><?= $post_data['thumbnail'] ?></div>
<div hx-swap-oob="true:#api-debug"><pre>$post_data = <?= print_r( $post_data, true ) ?></pre></div>
