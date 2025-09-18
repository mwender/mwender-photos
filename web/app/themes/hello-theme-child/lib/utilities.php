<?php

namespace Photoblog\utilities;

/**
 * Get a random WordPress post ID while excluding specific posts.
 *
 * @param array $exclude_ids Array of post IDs to exclude.
 * @return int|null Random post ID or null if none found.
 */
function get_random_post_id( $exclude_ids = [] ) {
    global $wpdb;

    // Build query with exclusion
    $placeholders = implode( ',', array_fill( 0, count( $exclude_ids ), '%d' ) );
    $sql          = "SELECT ID FROM {$wpdb->posts} 
                     WHERE post_type = 'post' 
                       AND post_status = 'publish'";

    if ( ! empty( $exclude_ids ) ) {
        $sql .= " AND ID NOT IN ($placeholders)";
    }

    $sql .= " ORDER BY RAND() LIMIT 1";

    // Prepare & get result
    $query = $wpdb->prepare( $sql, ...$exclude_ids );
    return (int) $wpdb->get_var( $query );
}

/**
 * Send an AnalyticsWP event for the given post.
 *
 * This function checks if the AnalyticsWP library is available, and if so,
 * sends a `page_view` event with details about the current post and user.
 *
 * @since 1.0.0
 *
 * @param int $post_id The ID of the post for which the event should be sent.
 *
 * @return void
 */
function send_analyticswp_event( $post_id ){
  // Make sure AnalyticsWP is loaded
  if ( class_exists( '\AnalyticsWP\Lib\Event' ) && method_exists( '\AnalyticsWP\Lib\Event', 'track_server_event' ) ) {

    $event_type = 'page_view';
    $page_url = get_permalink( $post_id );

    $args = [
      'page_url'                => $page_url,
      'unique_event_identifier' => 'post_' . $post_id . '_' . time(),
      'timestamp'               => gmdate( 'c' ),

      // Optional extras
      'user_id'    => get_current_user_id() ?: null,
      'referrer'   => $_SERVER['HTTP_REFERER'] ?? null,
      'device_type'=> wp_is_mobile() ? 'mobile' : 'desktop',
    ];

    if( $page_url != $_SERVER['HTTP_REFERER'] )
      $result = \AnalyticsWP\Lib\Event::track_server_event( $event_type, $args );

    if ( is_array( $result ) && ! empty( $result['error'] ) ) {
      error_log( 'AnalyticsWP event error: ' . $result['error'] );
    } else {
      // $result is event ID on success
      // error_log( 'AnalyticsWP event tracked with ID: ' . $result );
    }
  }    
}

