<?php
/**
 * Cache the loops
 *
 * @package Beer
 * @subpackage IR
 * @since The Big Bang
 */



/* Start with the portfolio loops, as those babies are well DB intensive */

/* Do something with the data entered */
add_action( 'save_post', 'beer_cache' );
add_action( 'save_post_bike', 'portfolio_cache' );
add_action( 'save_post_accessory', 'portfolio_cache' );

/* When the post is saved, saves our custom data */
function portfolio_cache( $post_id ) {

	/*
	* We need to verify this came from the our screen and with proper authorization,
	* because save_post can be triggered at other times.
	*/
	
/*
	// Check if our nonce is set.
	if ( ! isset( $_POST['myplugin_inner_custom_box_nonce'] ) )
	return $post_id;
	
	$nonce = $_POST['myplugin_inner_custom_box_nonce'];
	
	// Verify that the nonce is valid.
	if ( ! wp_verify_nonce( $nonce, 'myplugin_inner_custom_box' ) )
	  return $post_id;
*/
	
	// If this is an autosave, our form has not been submitted, so we don't want to do anything.
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
	  return $post_id;
	
	// Check permissions
	if ( !current_user_can( 'edit_page' , $post_id ) )
	    return;
	
	/* OK, its safe for us to save the data now. */
	
	// Get the gallery post type: wedding, private, video, corporate
	$post_type = get_post_type( $post_id );
	
	// Start buffer
	ob_start();
		global $post;
		//$post_type = 'gallery_wedding';
		get_template_part( 'templates/portfolio' );
		$cache = ob_get_contents();
	ob_end_clean();
		
	// Update the meta field in the database, appending the custom post type name.
	update_option( '_cache_portfolio_' . $post_type, $cache );
}


/* ==========================================================================
   Save cache when updating custom taxonomy
   ========================================================================== */

function beer_save_taxonomy( $post_id )
{
	// Get ACF fields data we're just about to save
	$fields = false;
 
	// Load data from post
	if( isset($_POST['fields']) )
	{
		$fields = $_POST['fields'];
	}

	// Ok let's do some stuff man
	$post_type = get_post_type( $post_id );
	
	// We're trying to target saving custom taxonomy only
	if ( $post_type === 'bike' ) continue;

	// Some test data
	update_option( '_cache_beer_now', 'I said beer now!' );
	
}
 
// run before ACF saves the $_POST['fields'] data
//add_action('acf/save_post', 'beer_save_taxonomy', 1);
 
// run after ACF saves the $_POST['fields'] data
add_action('acf/save_post', 'beer_save_taxonomy', 20);





?>