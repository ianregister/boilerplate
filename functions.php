<?php
/**
 * Beer functions and definitions.
 *
 * @package Beer
 * @subpackage IR
 * @since The Big Bang
 * @namespace beer_
 */


/* ==========================================================================
   Includes
   ========================================================================== */

include_once('includes/custom-posts.php');
include_once('includes/ajax.php');
include_once('includes/media.php');
include_once('includes/login.php');
include_once('includes/content.php');




/* Hard code image sizes (true = cropped)
   -------------------------------------------------------------------------- */

// Defaults (set to identical to avoid rendering unnecessary files)
update_option('thumbnail_size_w', 120);
update_option('thumbnail_size_h', 120);
update_option('thumbnail_crop', 1);

update_option('medium_size_w', 120);
update_option('medium_size_h', 120);
update_option('medium_crop', 1);

update_option('large_size_w', 120);
update_option('large_size_h', 120);
update_option('large_crop', 0);

// Home image
add_image_size( 'home', 960, 320, true );
add_image_size( 'home@2x', 1920, 640, true );

// Slideshow image
add_image_size( 'slide', 1020, 680, true );
add_image_size( 'slide@2x', 2040, 1360, true );

// Grid image
add_image_size( 'grid', 210, 9999, false );
add_image_size( 'grid@2x', 420, 9999, false );

// Product & page image
add_image_size( 'product', 460, 9999, false );
add_image_size( 'product@2x', 920, 9999, false );



/* ==========================================================================
   Remove junk
   http://digwp.com/2010/03/wordpress-functions-php-template-custom-functions/
   ========================================================================== */

remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'feed_links', 2);
remove_action('wp_head', 'index_rel_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'feed_links_extra', 3);
remove_action('wp_head', 'start_post_rel_link', 10, 0);
remove_action('wp_head', 'parent_post_rel_link', 10, 0);
remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0);

/* Hide admin bar for the boss */
if ( current_user_can( 'manage_options' ) ) {
    show_admin_bar( false );
}



/* ==========================================================================
   RSS Feeds
   ========================================================================== */

// disable all feeds
function beer_disable_feed() {
	wp_die(__('<h1>Feed not available, please visit our <a href="'.get_bloginfo('url').'">Home Page</a>!</h1>'));
}
add_action('do_feed',      'beer_disable_feed', 1);
add_action('do_feed_rdf',  'beer_disable_feed', 1);
add_action('do_feed_rss',  'beer_disable_feed', 1);
add_action('do_feed_rss2', 'beer_disable_feed', 1);
add_action('do_feed_atom', 'beer_disable_feed', 1);

// enable feed only
/*
disable feed_links
disable beer_disable_feed()
add this to header
<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />

*/



/* ==========================================================================
   Misc digwp.com functions.php tips
   http://digwp.com/2010/03/wordpress-functions-php-template-custom-functions/
   http://digwp.com/2010/04/wordpress-custom-functions-php-template-part-2/
   ========================================================================== */

// kill the admin nag
if (!current_user_can('edit_users')) {
	add_action('init', create_function('$a', "remove_action('init', 'wp_version_check');"), 2);
	add_filter('pre_option_update_core', create_function('$a', "return null;"));
}


// remove version info from head and feeds
function beer_complete_version_removal() {
	return '';
}
add_filter('the_generator', 'beer_complete_version_removal');


// customize admin footer text
function beer_admin_footer() {
	echo '<a href="http://ianregister.com" target="_blank">Web development by Ian Register</a>';
} 
add_filter('admin_footer_text', 'beer_admin_footer');




/* ==========================================================================
   Prevent editor adding new page
   http://erisds.co.uk/wordpress/spotlight-wordpress-admin-menu-remove-add-new-pages-or-posts-link
   ========================================================================== */


// Need to show if logged in only

function beer_modify_capabilities()
{
  // get the role you want to change: editor, author, contributor, subscriber
  $editor_role = get_role('editor');
  $editor_role->remove_cap('publish_pages');
  
  // for posts it should be:
  // $editor_role->remove_cap('publish_posts');
  
  // to add capabilities use add_cap()
}
add_action('admin_init','beer_modify_capabilities');


function beer_modify_menu()
{
  global $submenu;
  $submenu['edit.php?post_type=page'][10][1] = 'publish_pages';

  // for posts it should be:
  // $submenu['edit.php'][10][1] = 'publish_posts';
}
add_action('admin_menu','beer_modify_menu');


function beer_hide_buttons()
{
  global $current_screen;
  
  if($current_screen->id == 'edit-page' && !current_user_can('publish_pages'))
  {
    echo '<style>.add-new-h2{display: none;}</style>';  
  }
  
  // for posts the if statement would be:
  // if($current_screen->id == 'edit-post' && !current_user_can('publish_posts'))
}
add_action('admin_head','beer_hide_buttons');


function beer_permissions_admin_redirect() {
  $result = stripos($_SERVER['REQUEST_URI'], 'post-new.php?post_type=page');
  
  // for posts result should be:  
  // $result = stripos($_SERVER['REQUEST_URI'], 'post-new.php');
  
  if ($result!==false && !current_user_can('publish_pages')) {
    wp_redirect(get_option('siteurl') . '/wp-admin/index.php?permissions_error=true');
  }
  
  // for posts the if statement should be:
  // if ($result!==false && !current_user_can('publish_posts')) {
}

add_action('admin_menu','beer_permissions_admin_redirect');


function beer_permissions_admin_notice()
{
  // use the class "error" for red notices, and "update" for yellow notices
  echo "<div id='permissions-warning' class='error fade'><p><strong>".__('You do not have permission to access that page.')."</strong></p></div>";
}

function beer_permissions_show_notice()
{
  if($_GET['permissions_error'])
  {
    add_action('admin_notices', 'beer_permissions_admin_notice');  
  }
}
add_action('admin_init','beer_permissions_show_notice');




/* ==========================================================================
   Add Screen Info menu in Help dropdown menu
   http://wordpress.stackexchange.com/questions/84138/how-to-isolate-code-to-the-post-edit-screen
   ========================================================================== */

// Causes error in some plugins
//add_action('admin_head', 'beer_show_screen_info_in_help_tab');

function beer_show_screen_info_in_help_tab() {
    $screen = get_current_screen();
    $screen->add_help_tab( array(
        'id'      => 'screen',
        'title'   => 'Screen Info',
        'content' => '<pre>' . var_export($screen, true) . '</pre>',
    ) );
}




/* ==========================================================================
   Add site pages to Pages menu
   Remove Comments and Tools
   Remove New and Commments from admin bar
   
   http://melchoyce.github.io/dashicons/
   http://codex.wordpress.org/Function_Reference/add_menu_page
   ========================================================================== */

//add_action('admin_menu', 'beer_admin_menu');

function beer_admin_menu() {
	add_menu_page( 'Bikes', 'Bikes', 'read', 'edit.php?post_type=bike', '', 'dashicons-welcome-add-page', '3.1');
	add_menu_page( 'Accessories', 'Accessories', 'read', 'edit.php?post_type=accessory', '', 'dashicons-welcome-add-page', '3.2');
	add_menu_page( 'News', 'News', 'read', 'edit.php', '', 'dashicons-welcome-write-blog', '3.4');

	add_menu_page( 'Home', 'Home', 'read', 'post.php?post=1&action=edit', '', 'dashicons-admin-page', '5.0');
	add_menu_page( 'Hire', 'Hire', 'read', 'post.php?post=2&action=edit', '', 'dashicons-admin-page', '5.1');
	add_menu_page( 'Workshop', 'Workshop', 'read', 'post.php?post=3&action=edit', '', 'dashicons-admin-page', '5.5');
	add_menu_page( 'FAQs', 'FAQs', 'read', 'post.php?post=4&action=edit', '', 'dashicons-admin-page', '5.3');
	add_menu_page( 'Contact', 'Contact', 'read', 'post.php?post=5&action=edit', '', 'dashicons-admin-page', '5.4');
	
	add_submenu_page('edit.php?post_type=page', 'Home', 'Home', 'read', 'post.php?post=1&action=edit', '');
	add_submenu_page('edit.php?post_type=page', 'Hire', 'Hire', 'read', 'post.php?post=2&action=edit', '');
	add_submenu_page('edit.php?post_type=page', 'Workshop', 'Workshop', 'read', 'post.php?post=3&action=edit', '');
	add_submenu_page('edit.php?post_type=page', 'FAQs', 'FAQs', 'read', 'post.php?post=4&action=edit', '');
	add_submenu_page('edit.php?post_type=page', 'Contact', 'Contact', 'read', 'post.php?post=5&action=edit', '');

	// Add submenu pages to 'About' and hide it because there's no content on it.
	add_submenu_page('post.php?post=8&action=edit', 'About Our Products', 'About Our Products', 'read', 'post.php?post=9&action=edit' );
	add_submenu_page('post.php?post=8&action=edit', 'Our Natural Ingredients', 'Our Natural Ingredients', 'read', 'post.php?post=10&action=edit' );
	add_submenu_page('post.php?post=8&action=edit', 'Company History', 'Company History', 'read', 'post.php?post=11&action=edit' );
	add_submenu_page('post.php?post=8&action=edit', 'Manufacturing Process', 'Manufacturing Process', 'read', 'post.php?post=12&action=edit' );

	// Hide 'About' parent page in submenu
    remove_submenu_page( 'post.php?post=8&action=edit', 'post.php?post=8&action=edit' );
	
	// Hide comments
    remove_menu_page('edit-comments.php');

	remove_menu_page('edit.php?post_type=bike');
	remove_menu_page('edit.php?post_type=accessory');
	remove_menu_page('edit.php');

	
	if ( !current_user_can( 'manage_options' ) ) { 
		remove_menu_page('edit.php?post_type=page');
		remove_menu_page('tools.php');
	    remove_menu_page('profile.php');
	    //remove_submenu_page( 'edit.php?post_type=page', 'edit.php?post_type=page' );
	}

	// Get post id so we can do some customisation
	$post_id = $_GET['post'] ? $_GET['post'] : $_POST['post_ID'] ;

	// Hide editor on home page
	if( $post_id === '5' ){ 
		remove_post_type_support('page', 'editor');
	}

}


// http://digwp.com/2011/04/admin-bar-tricks/#add-remove-links
function beer_admin_bar() {
	global $wp_admin_bar;
	$wp_admin_bar->remove_menu('new-content');
	$wp_admin_bar->remove_menu('comments');
}
add_action( 'wp_before_admin_bar_render', 'beer_admin_bar' );


//http://www.xldstudios.com/adding-a-separator-to-the-wordpress-admin-menu/
// Create Admin Menu Separator
function beer_add_admin_menu_separator($position) {

	global $menu;
	$index = 0;

	foreach($menu as $offset => $section) {
		if (substr($section[2],0,9)=='separator')
		    $index++;
		if ($offset>=$position) {
			$menu[$position] = array('','read',"separator{$index}",'','wp-menu-separator');
			break;
	    }
	}

	ksort( $menu );
}

//Adds Admin Menu Separators
function beer_admin_menu_separators() {

	beer_add_admin_menu_separator('3.0');
	beer_add_admin_menu_separator(6);
	beer_add_admin_menu_separator('3.3');
}

// Registers admin menu separators
add_action('admin_menu','beer_admin_menu_separators');




/* ==========================================================================
   Change Posts to Blog / News etc
   http://revelationconcept.com/wordpress-rename-default-posts-news-something-else/
   ========================================================================== */

function beer_change_post_label() {
    global $menu;
    global $submenu;
    $menu[5][0] = 'News';
    //$submenu['edit.php'][5][0] = 'News';
    //$submenu['edit.php'][10][0] = 'Add News';
    //$submenu['edit.php'][16][0] = 'News Tags';
    echo '';
}

function beer_change_post_object() {
    global $wp_post_types;
    $labels = &$wp_post_types['post']->labels;
    $labels->name = 'News';
    $labels->singular_name = 'News';
    $labels->add_new = 'Add News';
    $labels->add_new_item = 'Add News';
    $labels->edit_item = 'Edit News';
    $labels->new_item = 'News';
    $labels->view_item = 'View News';
    $labels->search_items = 'Search News';
    $labels->not_found = 'No News found';
    $labels->not_found_in_trash = 'No News found in Trash';
    $labels->all_items = 'All News';
    $labels->menu_name = 'News';
    $labels->name_admin_bar = 'News';
}
 
add_action( 'admin_menu', 'beer_change_post_label' );
//add_action( 'init', 'beer_change_post_object' );




/* ==========================================================================
   Prevent Adding Media via Editor.
   ========================================================================== */

function beer_remove_media_controls() {
     remove_action( 'media_buttons', 'media_buttons' );
}
//add_action('admin_head','beer_remove_media_controls');




/* ==========================================================================
   Remove page-attributes 
   ========================================================================== */

function beer_remove_page_metabox() {
	remove_meta_box( 'pageparentdiv' , 'page' , 'normal' ); 
}
add_action( 'admin_menu' , 'beer_remove_page_metabox' );




/* ==========================================================================
   Remove custom taxonomy metaboxes
   ========================================================================== */

function beer_remove_custom_taxonomy()
{
	remove_meta_box( 'bike_branddiv', 'bike', 'side' );
	remove_meta_box( 'bike_typediv', 'bike', 'side' );
	remove_meta_box( 'bike_branddiv', 'brand', 'side' );
	remove_meta_box( 'accessory_branddiv', 'brand', 'side' );
}
add_action( 'admin_menu', 'beer_remove_custom_taxonomy' );




/* ==========================================================================
   ACF Options page re-label
   ========================================================================== */

if( function_exists('acf_set_options_page_title') && function_exists('acf_set_options_page_menu') )
{
	$title = 'Sidebar';
	$menu_name = 'Sidebar';
	acf_set_options_page_title( $title );
	acf_set_options_page_menu( $menu_name );
}

// Quick and dirty hack to hide...ahh...hide what?
add_action('admin_head', 'beer_custom_dashboard');

function beer_custom_dashboard() {
  echo '<style>
    #toplevel_page_wl-general-settings {display:none}
  </style>';
}



/* ==========================================================================
   Add Admin bar clear cache
   ========================================================================== */

//add_action( 'admin_bar_menu', 'clear_opcache', 999 );

function clear_opcache( $wp_admin_bar ) {
	$args = array(
		'id'    => 'clear_cache',
		'title' => 'Clear Cache',
		'href'  => '?page=opcache&action=reset'
	);
	$wp_admin_bar->add_node( $args );
}

// If action = reset and check nonce then:
function clear_cache() {
	opcache_reset();
}


?>