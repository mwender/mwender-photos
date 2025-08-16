<?php
/**
 * Plugin Name: Remote Uploads Redirect (Local Only)
 * Description: Redirects wp-content/uploads URLs to the production server in local environments.
 * Author: Michael Wender
 */
add_filter( 'upload_dir', function( $dirs ) {
  if ( defined( 'REMOTE_BASEURL' ) && REMOTE_BASEURL ) {
    $dirs['baseurl'] = REMOTE_BASEURL;
  }
  return $dirs;
} );