<?php
// Basic nonce validation (works for all hypermedia libraries)
if ( ! hm_validate_request() ) {
    hm_die( 'Security check failed' );
}

use function Photoblog\utilities\get_random_post_id;

$post_data = [
  'title'             => 'Post Title Goes Here...',
  'content'           => '<p>Post content gets inserted here.</p>',
  'thumbnail'         => '<img decoding="async" src="' . esc_url( includes_url( 'images/media/default.png' ) ) . '" alt="" loading="lazy">',
  'date'              => current_time( 'F j, Y, g:i a' ),
  'current_post_id'   => null,
  'nav_post_ids'  => [
    'previous_post_id'  => null,
    'random_post_id'    => null,
    'next_post_id'      => null,
  ],

];

// Setup $post_data
if ( is_numeric( $hmvals['post_id'] ) ) {
  global $post;
  $post = get_post( $hmvals['post_id'] );
  setup_postdata( $post );

  $previous_post = get_adjacent_post( false, '', true );
  $next_post     = get_adjacent_post( false, '', false );

  $previous_post_id = ( $previous_post instanceof WP_Post )? $previous_post->ID : '' ;
  $next_post_id = ( $next_post instanceof WP_Post )? $next_post->ID : '' ;

  $post_data = [
    'title'             => get_the_title( $post ),
    'content'           => apply_filters( 'the_content', $post->post_content ),
    'thumbnail'         => get_the_post_thumbnail( $post, 'photos-featured', array('class' => 'photo-viewer-featured-image') ),
    'date'              => get_the_date(),
    'current_post_id'   => $hmvals['post_id'],
    'nav_post_ids'  => [
      'previous_post_id'  => ( $previous_post instanceof WP_Post ) ? $previous_post->ID : null,
      'random_post_id'    => get_random_post_id( array( $previous_post_id, $next_post_id ) ),
      'next_post_id'      => ( $next_post instanceof WP_Post ) ? $next_post->ID : null,
    ],
  ];

  wp_reset_postdata();
}
?>
<div id="photo-viewer">
  <div id="photo-viewer-content">
    <h1 class="post-title"><?= $post_data['title'] ?></h1>
    <?= $post_data['thumbnail'] ?>
    <?= $post_data['content'] ?>
  </div>
  <div id="photo-nav">
    <?php 
    foreach( $post_data['nav_post_ids'] as $key => $id ){
      $classes = ['elementor-button'];
      if( empty( $id ) )
        $classes[] = 'disabled';
      $label = ucfirst( str_replace( '_post_id', '', $key ) );
      ?>
      <div class="col">
        <a class="<?= implode( ' ', $classes ) ?>"<?php if( ! in_array( 'disabled', $classes ) ) echo ' href="#"' ?> hx-push-url="<?= get_permalink( $id ) ?>" hx-target="#photo-viewer" hx-get="/wp-html/v1/getpost?post_id=<?= $id ?>"><?= $label ?></a>
      </div>
      <?php
    }
    ?>
  </div>
</div>


