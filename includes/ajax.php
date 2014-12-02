<?php
/**
 * AJAX Functions and definitions
 *
 * @package Beer
 * @subpackage IR
 * @since The Big Bang
 */


// Enqueue app and all the other scripts, prints the ajaxurl in footer
// Note: Not using plugins that call built in jQuery

function beer_scripts() {

// Development:
/*
wp_enqueue_script( 'libraries', get_template_directory_uri() . '/js/app/libraries.min.js', null, 1.0, false );
wp_enqueue_script( 'plugins', get_template_directory_uri() . '/js/app/plugins.min.js', array( 'libraries' ), 1.0, false );
wp_enqueue_script( 'main', get_template_directory_uri() . '/js/app/main.min.js', array( 'plugins' ), 1.0, false );
*/


//Production:
wp_enqueue_script( 'lab', get_template_directory_uri() . '/js/app/libs/loader.js', null, 2.0, false );

// This needs match the url : App.ajaxurl & nonce in the ajax function call
// Change 'lab' to 'main' if enqueuing via the development method
wp_localize_script( 'lab', 'GinAjax', array(
	// URL to wp-admin/admin-ajax.php to process the request
	'ajaxurl'          => admin_url( 'admin-ajax.php' ),
 
	// generate a nonce with a unique ID so it can be checked later when an AJAX request is sent
	// Note: if needing to reuse (ie post multiple comments) then need to regenerate nonce
	'WhiskeyNonce' => wp_create_nonce( 'whiskey-nonce' )
	)
);

}
add_action('init','beer_scripts'); 


// Get home page content
function getHome(){
	$nonce = $_REQUEST['WhiskeyNonce'];
 
	// check to see if the submitted nonce matches with the
	// generated nonce we created earlier
	if ( ! wp_verify_nonce( $nonce, 'whiskey-nonce' ) ) {
		get_template_part('templates/404');
		die ();
		}
				
		// Load up our 'ol home page
		get_template_part('templates/home');

		// Time to go home for a beer
		die;
 }

add_action( 'wp_ajax_nopriv_get_home' , 'getHome' );
add_action( 'wp_ajax_get_home' , 'getHome' );




// Get default loop content
function getLoop(){
	$nonce = $_REQUEST['WhiskeyNonce'];
 
	// check to see if the submitted nonce matches with the
	// generated nonce we created earlier
	if ( ! wp_verify_nonce( $nonce, 'whiskey-nonce' ) ) {
		get_template_part('templates/404');
		die ();
		}

	// Check cache, if it has data then retrieve it
	$post_type = $_REQUEST['fragment'];
	if ( get_option( '_cache_' . $post_type , false ) ) {
		
		$content = get_option( '_cache_' . $post_type , true );
		
		echo $content;
		
	} else {

		// Load up our 'ol offer template
		get_template_part('templates/loop');

	}
	// Time to go home for a beer
	die;
 }

add_action( 'wp_ajax_nopriv_get_loop' , 'getLoop' );
add_action( 'wp_ajax_get_loop' , 'getLoop' );




// Get default page content
function getPage(){
	$nonce = $_REQUEST['WhiskeyNonce'];
 
	// check to see if the submitted nonce matches with the
	// generated nonce we created earlier
	if ( ! wp_verify_nonce( $nonce, 'whiskey-nonce' ) ) {
		get_template_part('templates/404');
		//echo('busted punk');
		die ();
		}

		// Load up our 'ol offer template
		get_template_part('templates/page');


		// Time to go home for a beer
		die;
 }

add_action( 'wp_ajax_nopriv_get_page' , 'getPage' );
add_action( 'wp_ajax_get_page' , 'getPage' );




// Get query content and send email
function getQuery(){
	$nonce = $_POST['WhiskeyNonce'];
 
	// check to see if the submitted nonce matches with the
	// generated nonce we created earlier
	if ( ! wp_verify_nonce( $nonce, 'whiskey-nonce' ) ) {
		die ( 'Busted Punk!');
		}
		
		// Turn the query string data into an array
		parse_str($_POST['data'], $data);

		// Prepare email
		$headers = 'From: '. ucwords(strtolower($data['name'])) . ' <' . sanitize_email( $data['email']) . '>' . "\r\n";
		$message = 'Website query from: ' . ucwords(strtolower(sanitize_text_field($data['name']))) . "\r\n\n";
		$message .= 'Query subject: ' . ucfirst(strtolower(sanitize_text_field($data['subject']))) . "\r\n\n";
		$message .= 'Email address: ' . sanitize_email($data['email']) . "\r\n";
		$message .= 'Phone number: ' . sanitize_text_field($data['number']) . "\r\n\n";
		$message .= 'How did '. ucwords(strtolower(sanitize_text_field($data['name']))) . ' hear about us: ' . ucfirst(strtolower(sanitize_text_field($data['how']))) . "\r\n\n";
		$message .= ucfirst(sanitize_text_field($data['text']));

		// Send email
		wp_mail( array('ian@54albert.com'), 'Query from SPL Website', $message, $headers );

		// Echo name for thank you message
		echo( ucwords(strtolower($data['name'])) );
		
		// Time to go home for a beer
		die;
 }

add_action( 'wp_ajax_nopriv_get_query' , 'getQuery' );
add_action( 'wp_ajax_get_query' , 'getQuery' );

?>