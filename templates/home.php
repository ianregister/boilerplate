<?php 
/**
 * The home page content template file.
 *
 * @package Beer
 * @subpackage IR
 * @since The Big Bang 1.0
 */

global $post;

$id = get_option('page_on_front');
$post = get_post( $id );

// Get post data
setup_postdata($post);

?>

<div class="home">

	<h1 class="hidden">Home</h1>

<?php 
	
$images = null;

if ( $images ) :

	foreach ( $images as $image ) :

		$image_original = $image['url'];
		$image_loading = get_template_directory_uri().'/images/graphics/pixel-3x1.gif';
		$image_normal = $image['sizes']['home'];
		$image_retina = $image['sizes']['home@2x'];
	
		// Ensure we're not using the original image, which will likely be the wrong dimensions
		// because if original is too small WP will not render the hi-res version
		// and assuming the user has uploaded an image at least big enough for lo-res
		if ( $image_retina === $image_original ) $image_retina = $image_normal;

?>
	<article>

			<img 	src="<?php echo $image_normal; ?>"
			 		data-src="<?php echo $image_normal; ?>"
			 		data-src-retina="<?php echo $image_retina; ?>"
			 		class="unveil"
			 		alt="<?php echo get_the_title( $id ); ?>" 
			 		title="<?php echo get_the_title( $id ); ?>"
					width="960" 
					height="320" 
			/>
			
	</article>

<?php endforeach; ?>

<?php endif; ?>

</div>

