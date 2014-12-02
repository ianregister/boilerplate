<?php
/**
 * Single product post template
 *
 * @author 		Ian Register
 * @package 	SpaceToCreate
 * @version     1
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $post;

// AJAX'd
if ( $_REQUEST['fragment'] ) {
	$fragment = explode('/',$_REQUEST['fragment']);
	$term = $fragment[1];
	$slug = $_REQUEST['slug'];
	$post = get_page_by_path( $slug, OBJECT, 'product' );
	$term_obj = get_term_by( 'slug', $term, 'product_cat' );
	$post_id = url_to_postid( $_REQUEST['fragment'] );
	$post = get_post( $post_id );
}

// If JS is turned off
else if ($_REQUEST['fragment'] == null) {
	$slug = get_page_uri($post->ID);
	$terms = wp_get_post_terms($post->ID,'product_cat');
	$term_obj = $terms[0];
}

// Setup global post data
setup_postdata($post);

// Exit unless we're published
if( $post->post_status =='private' ) exit;

?>

<article class="">

	<div class="column">

<?php 

$image_loading = get_template_directory_uri().'/images/graphics/pixel.gif';
$image_normal = wp_get_attachment_image_src( get_post_thumbnail_id( $id ), 'product');
$image_retina = wp_get_attachment_image_src( get_post_thumbnail_id( $id ), 'product@2x');

?>
		<img 	src="<?php echo $image_normal[0]; ?>"
		 		data-src="<?php echo $image_normal[0]; ?>"
		 		data-src-retina="<?php echo $image_retina[0]; ?>"
		 		class="unveil"
		 		alt="<?php echo get_the_title( $id ); ?>" 
		 		title="<?php echo get_the_title( $id ); ?>"
				width="<?php echo $image_normal[1]; ?>" 
				height="<?php echo $image_normal[2]; ?>" 
		/>
		
	</div>



</article>