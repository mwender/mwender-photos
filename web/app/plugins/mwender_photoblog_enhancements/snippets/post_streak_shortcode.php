<?php if(!defined('ABSPATH')) { die(); }  

                


	// Code Snippet Code
	 

function get_consecutive_post_days() {
  global $wpdb;

  //error_log("Starting get_consecutive_post_days()...");

  // Check if the streak count is cached
  $cached_streak = get_transient('post_streak_count');
  if ($cached_streak !== false) {
    //error_log("Returning cached streak: " . $cached_streak);
    return (int) $cached_streak;
  }

  $today = current_time('Y-m-d'); // Use WP's local timezone

  error_log("Today's date: $today");

  // Get distinct post dates up to today (excluding future posts), ensuring the most recent post is first
  $query = $wpdb->prepare(
    "SELECT DISTINCT DATE(post_date) as post_date 
     FROM {$wpdb->posts} 
     WHERE post_type = 'post' 
     AND post_status = 'publish' 
     AND post_date <= %s
     ORDER BY post_date DESC, ID DESC",
    current_time('mysql') // Ensure correct time conversion
  );

  $results = $wpdb->get_col($query);

  if (empty($results)) {
    error_log("No published posts found.");
    return 0;
  }

  error_log("Found " . count($results) . " unique post dates.");
  error_log("First post date: " . $results[0]);

  // The first post must be from today, otherwise, the streak is 0
  if ($results[0] !== $today) {
    error_log("No post found for today. Streak ends.");
    return 0;
  }

  $streak = 1; // Start streak count at 1 (since we already confirmed today has a post)
  $expected_date = date('Y-m-d', strtotime($today . ' -1 day'));

  // Start from the second post in the list
  for ($i = 1; $i < count($results); $i++) {
    $post_date = $results[$i];

    error_log("Checking post date: $post_date (Expected: $expected_date)");

    if ($post_date == $expected_date) {
      // Continue streak
      $streak++;
      error_log("Streak incremented: $streak");
      // Move to the next expected date
      $expected_date = date('Y-m-d', strtotime($expected_date . ' -1 day'));
    } else {
      // A gap is found, stop the streak
      error_log("Gap found on $post_date. Ending streak.");
      break;
    }
  }

  // Cache the result for 1 hour (3600 seconds)
  set_transient('post_streak_count', $streak, 3600);

  error_log("Final streak count: $streak");

  return $streak;
}


// Invalidate the cache when a new post is published or updated
function reset_post_streak_cache($post_id, $post) {
  if ($post->post_type === 'post' && $post->post_status === 'publish') {
    delete_transient('post_streak_count');
  }
}

add_action('save_post', 'reset_post_streak_cache', 10, 2);

function display_post_streak_widget() {
  $streak = get_consecutive_post_days();
  
  if ($streak > 0) {
    echo '<div class="post-streak-widget">';
    echo '<p><strong>' . esc_html($streak) . ' consecutive day' . ($streak > 1 ? 's' : '') . ' of photos and counting!</strong></p>';
    echo '</div>';
  } else {
    echo '<div class="post-streak-widget"><p><strong>Check back for a new photo streak.</strong></p></div>';
  }
}

function register_post_streak_widget() {
  wp_add_dashboard_widget('post_streak_widget', 'Posting Streak', 'display_post_streak_widget');
}

add_action('wp_dashboard_setup', 'register_post_streak_widget');

function post_streak_sidebar_widget() {
  ob_start();
  display_post_streak_widget();
  return ob_get_clean();
}

add_shortcode('post_streak', 'post_streak_sidebar_widget');

	// End Code Snippet Code