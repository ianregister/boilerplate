<?php 

global $post;

$id = get_option('page_on_front');
$post = get_post( $id );

// Get post data
setup_postdata($post);

?>

<div class="home">

	<h1 class="hidden">Home</h1>

<?php 

$image_loading = get_template_directory_uri().'/images/graphics/pixel.gif';
$image_normal = wp_get_attachment_image_src( get_post_thumbnail_id( $id ), 'home');
$image_retina = wp_get_attachment_image_src( get_post_thumbnail_id( $id ), 'home@2x');

?>
	<article>

			<img 	src="<?php echo $image_normal[0]; ?>"
			 		data-src="<?php echo $image_normal[0]; ?>"
			 		data-src-retina="<?php echo $image_retina[0]; ?>"
			 		class="unveil"
			 		alt="<?php echo get_the_title( $id ); ?>" 
			 		title="<?php echo get_the_title( $id ); ?>"
					width="960" 
					height="320" 
			/>
			
	</article>
</div>

