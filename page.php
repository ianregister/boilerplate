<?php
/**
 * The page template file.
 *
 * @package Beer
 * @subpackage IR
 * @since The Big Bang 1.0
 */

get_header();

if ( have_posts() ) :
	while ( have_posts() ) : the_post();

		if ( is_front_page() ) {
			get_template_part ('templates/home');
		} else if ( is_page_template('gallery.php') ) {
			get_template_part ('templates/gallery');
		} else {
			get_template_part ('templates/page/' . $post->post_name );
		}

	endwhile;
	
endif;

get_footer();
?>