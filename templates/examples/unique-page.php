<?php 

global $post;

// AJAX'd
if ( $_REQUEST['fragment'] ) {
	$slug = basename( untrailingslashit( $_REQUEST['fragment'] ) );
	$post = get_page_by_path( untrailingslashit( $_REQUEST['fragment'] ) , OBJECT, 'page' );
}

// If JS is turned off
else if ($_REQUEST['fragment'] == null) {
	$slug = get_page_uri($post->ID);
}

// Get post data
setup_postdata($post);

?>

<div class="<?php echo $slug; ?>">

	<h1><?php the_title(); ?></h1>

</div>