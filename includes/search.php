<?php
/**
 * Search functions and definitions
 *
 * @package Beer
 * @subpackage IR
 * @since The Big Bang
 */

/* ==========================================================================
   Search improvments
   ========================================================================== */

// Switches default core markup for search form, comment form, and comments to output valid HTML5
add_theme_support( 'html5', array( 'search-form' ) );

// Rewrite URL
function beer_search_url_rewrite_rule() {
	if ( is_search() && !empty($_GET['s'])) {
		wp_redirect(home_url("/search/") . urlencode(get_query_var('s')));
		exit();
	}	
}
add_action('template_redirect', 'beer_search_url_rewrite_rule');


// http://bavotasan.com/2010/excluding-pages-from-wordpress-search/
function beer_search_post_types($query) {
	if ($query->is_search) {
	$query->set('post_type', array('post', 'acf' ));
	}
	return $query;
	}
	
add_filter('pre_get_posts','beer_search_post_types');


?>