<?php
/**
 * The default page content template file.
 *
 * @package Beer
 * @subpackage IR
 * @since The Big Bang 1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

global $post;

// AJAX'd
// Use 'fragment' not 'page' as it will deal with child pages
if ( $_REQUEST['fragment'] ) {
	$slug = $_REQUEST['fragment'];
	$post = get_page_by_path( $slug, OBJECT, 'page' );
}

// Setup global post data
setup_postdata($post);

// Exit unless we're published
if( $post->post_status =='private' ) exit;

?>