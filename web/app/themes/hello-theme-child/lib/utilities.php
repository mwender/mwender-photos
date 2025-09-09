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