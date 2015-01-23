<?php
/**
 * The default single post content template file.
 *
 * @package Beer
 * @subpackage IR
 * @since The Big Bang 1.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $post;

// AJAX'd
if ( $_REQUEST['fragment'] ) {
	$fragment = explode('/',$_REQUEST['fragment']);
	$slug = $_REQUEST['slug'];
	//$post = get_page_by_path( $slug, OBJECT, 'post' );
	$id = url_to_postid( $_REQUEST['fragment'] );
	$post = get_post( $id );
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