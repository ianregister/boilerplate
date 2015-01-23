<?php
/**
 * AJAX Functions and definitions
 *
 * @package Beer
 * @subpackage IR
 * @since The Big Bang
 */


/* ==========================================================================
   Front end scripts
   ========================================================================== */

// Enqueue app and all the other scripts, prints the ajaxurl in footer
// Note: Not using plugins that call built in jQuery

function beer_scripts() {

//Production:
wp_enqueue_script( 'lab', get_template_directory_uri() . '/js/libs/loader.js', null, 2.0, false );

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
add_action('wp_enqueue_scripts','beer_scripts'); 


/* ==========================================================================
   Admin scripts
   ========================================================================== */

function beer_admin_scripts() {

wp_enqueue_style('beer-admin-style', get_template_directory_uri() . '/includes/dashboard.css', null, null, true);
wp_enqueue_script('beer-admin-script', get_template_directory_uri() . '/includes/dashboard.js', null, null, true);

// This needs match the url : App.ajaxurl & nonce in the ajax function call
// 'dashboard' is a WP call
wp_localize_script( 'beer-admin-script', 'BEER_Admin_Ajax', array(
	// URL to wp-admin/admin-ajax.php to process the request
	'ajaxurl'          => admin_url( 'admin-ajax.php' ),
 
	// generate a nonce with a unique ID so it can be checked later when an AJAX request is sent
	// Note: if needing to reuse (ie post multiple comments) then need to regenerate nonce
	'BEER_Admin_Nonce' => wp_create_nonce( 'beer-nonce' )
	//'UE_Admin_Nonce' => wp_create_nonce( 'beer-admin-nonce' )
	)
);

}
add_action('admin_enqueue_scripts','beer_admin_scripts'); 




/* ==========================================================================
   Functions to get content
   ========================================================================== */

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
		get_template_part( 'templates/home' );

		// Time to go home for a beer
		die;
 }

add_action( 'wp_ajax_nopriv_get_home' , 'getHome' );
add_action( 'wp_ajax_get_home' , 'getHome' );




// Get single post content
function getSingle(){
	$nonce = $_REQUEST['WhiskeyNonce'];
 
	// check to see if the submitted nonce matches with the
	// generated nonce we created earlier
	if ( ! wp_verify_nonce( $nonce, 'whiskey-nonce' ) ) {
		get_template_part('templates/404');
		die ();
		}
		
		// Get our post type
		$fragment = explode('/',$_REQUEST['fragment']);
		$post_type = $fragment[0];
		
		// Load up our 'ol home page
		get_template_part( 'templates/single/' . $post_type );

		// Time to go home for a beer
		die;
 }

add_action( 'wp_ajax_nopriv_get_single' , 'getSingle' );
add_action( 'wp_ajax_get_single' , 'getSingle' );




// Get single post content
function getArchive(){
	$nonce = $_REQUEST['WhiskeyNonce'];
 
	// check to see if the submitted nonce matches with the
	// generated nonce we created earlier
	if ( ! wp_verify_nonce( $nonce, 'whiskey-nonce' ) ) {
		get_template_part('templates/404');
		die ();
		}

		// Determine what post_type archive we are
		$archive = $_REQUEST['fragment'];
				
		// Load up our 'ol home page
		get_template_part('templates/archive/' . $archive );
		
		// Time to go home for a beer
		die;
 }

add_action( 'wp_ajax_nopriv_get_archive' , 'getArchive' );
add_action( 'wp_ajax_get_archive' , 'getArchive' );




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
		
		$page = $_REQUEST['page'];

		// Load up our contact page template
		if ( $page === 'contact' ) get_template_part( 'templates/page/' . $page );
		// Load up our 'ol default page template
		else get_template_part( 'templates/page/default' );
		
		// Time to go home for a beer
		die;
 }

add_action( 'wp_ajax_nopriv_get_page' , 'getPage' );
add_action( 'wp_ajax_get_page' , 'getPage' );




// Get default site title
function getSiteTitle(){
	$nonce = $_REQUEST['WhiskeyNonce'];
 
	// check to see if the submitted nonce matches with the
	// generated nonce we created earlier
	if ( ! wp_verify_nonce( $nonce, 'whiskey-nonce' ) ) {
		get_template_part('templates/404');
		//echo('busted punk');
		die ();
		}

		// Load up our 'ol offer template
		echo get_bloginfo( 'name', 'display' );
		//echo 'beer';

		// Time to go home for a beer
		die;
 }

add_action( 'wp_ajax_nopriv_get_site_title' , 'getSiteTitle' );
add_action( 'wp_ajax_get_site_title' , 'getSiteTitle' );




// Get default site tagline
function getTagline(){
	$nonce = $_REQUEST['WhiskeyNonce'];
 
	// check to see if the submitted nonce matches with the
	// generated nonce we created earlier
	if ( ! wp_verify_nonce( $nonce, 'whiskey-nonce' ) ) {
		get_template_part('templates/404');
		//echo('busted punk');
		die ();
		}

		// Load up our 'ol offer template
		echo get_bloginfo( 'description', 'display' );

		// Time to go home for a beer
		die;
 }

add_action( 'wp_ajax_nopriv_get_tagline' , 'getTagline' );
add_action( 'wp_ajax_get_tagline' , 'getTagline' );








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