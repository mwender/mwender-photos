<?php
/**
 * Plugin Name:     @mwender Photoblog Enhancements
 * Description:     Enhancements for the @mwender Photoblog.
 * Version:         1.0.0
 *
 */

if(!defined('ABSPATH')) {
    die;
}

include_once __DIR__ . '/WFPCore/Preconditions.php';
include_once __DIR__ . '/WFPCore/WordPressContext.php';

$preconditions = new \WFPCore\Preconditions();


if($preconditions->is_wpcb_request() || $preconditions->safe_mode()) {
	return;
}
$preconditions->output_autoreload();


include_once 'snippets/4_3_image.php';
include_once 'snippets/add_post_thumbnail_to_rss.php';
// include_once 'snippets/lightbox_for_galleries.php';
include_once 'snippets/global_scss_inline_css.php';
include_once 'snippets/post_streak_shortcode.php';
include_once 'snippets/latest_post_id.php';
include_once 'snippets/current_post_id_shortcode.php';
include_once 'snippets/uber_log.php';
// include_once 'snippets/photo_viewer.php';
include_once 'snippets/term_description.php';
// Snippets will go before this line, do not edit
