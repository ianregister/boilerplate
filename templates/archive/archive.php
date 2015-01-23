<?php
/**
 * The default archive content template file.
 *
 * @package Upside Elevate
 * @subpackage Upside Elevate
 * @since The Big Bang 1.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $post;

// AJAX'd
if ( $_REQUEST['fragment'] ) {
	$slug = $_REQUEST['fragment'];
	
	// Determine what post_type we are
	global $wp_post_types;
	
	// Compare each has_archive attribute and match to slug
	foreach ( $wp_post_types as $post_type ) :
	
		if( $post_type->has_archive === $slug ) {
			$archive_post_type = $post_type->name;
		}
	
	endforeach;
}

// If JS is turned off
else if ($_REQUEST['fragment'] == null) {
	$slug = get_page_uri($post->ID);
	$archive_post_type = $post->post_type;
}


// Get loop of room posts
$loop = new WP_Query( array(
	'post_type' => $archive_post_type,
	'post_status'=>'publish',
	'posts_per_page' => -1
	));

// Need to use while and not for because the post object works outa the box
while ( $loop->have_posts() ) : $loop->the_post();
endwhile;
?>