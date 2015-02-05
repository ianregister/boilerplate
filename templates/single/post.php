<?php
/**
 * The default single post content template file.
 * URL expected similar to /2015/01/post-title-yo
 *
 * @package Beer
 * @subpackage IR
 * @since The Big Bang 1.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $post;

// AJAX'd
if ( $_REQUEST['fragment'] ) {
	$post_id = url_to_postid( $_REQUEST['fragment'] );
	$post = get_post( $post_id );
}

// If JS is turned off
else if ($_REQUEST['fragment'] == null) {
	$slug = get_page_uri($post->ID);
}

// Setup global post data
setup_postdata($post);

// Exit unless we're published
if( $post->post_status =='private' ) exit;

?>