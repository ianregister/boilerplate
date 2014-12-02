<?php
/**
 * The archive for single posts template file.
 *
 * @package Beer
 * @subpackage IR
 * @since The Big Bang 1.0
 */
?>

<?php 
get_header();

	// Don't get confused, this means check what yo setting in the Dashboard is for Reading
	if ( is_home() ) {
		
		// Loop goes in here		
		get_template_part ('templates/blog');
		
	} 
	
	else if ( is_post_type_archive( 'some_post' ) ) {

		// Loop goes in here		
		get_template_part ('templates/some_archive');
		
	} 
	
get_footer();
?>