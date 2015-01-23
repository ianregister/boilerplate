<?php
/**
 * Login page functions and definitions
 *
 * @package Beer
 * @subpackage IR
 * @since The Big Bang
 */


/* ==========================================================================
   Login logo, url etc, Dashboard icons
   ========================================================================== */

// Login logo
function ue_login_logo() {
    echo '<style type="text/css">
    	body.login {background-color:#fff;}
    	.wp-core-ui .button-primary {background-color: #000;text-transform:uppercase;border-color:#000;box-shadow: inset 0 1px 0 rgba(230, 211, 120, .5),0 1px 0 rgba(0,0,0,.15);transition: all 0.2s linear;}
    	
    	.wp-core-ui .button-primary:hover {background-color: #fff;color:#000;border-color:#000;box-shadow: inset 0 1px 0 rgba(244, 170, 149, 0.15),0 1px 0 rgba(244, 170, 149, 0.15);}
        h1 a{ background-image:url('.get_bloginfo('template_url').'/images/graphics/logo-login.png) !important; width:200px!important; height:200px!important; background-size: 200px 200px!important;margin-right:auto!important;margin-left:auto!important; }
        input[type=checkbox]:checked:before {color: #000;transition:all 0.2s linear}
        body.login #backtoblog{display:none!important}
        body.login #nav{margin-top:6px!important}
    </style>';
}
add_action('login_head', 'ue_login_logo');


// Change login URL from wordpress to us!
function ue_login_url(){  
    return get_home_url();
}
add_filter('login_headerurl', 'ue_login_url'); 


// Change alt text (ie on hover of logo on login page)
function ue_login_alt(){  
    echo get_option('blogname');
}
//add_filter('login_alt', 'ue_login_alt');


// Change the login page URL hover text
function ue_login_title(){
	return get_bloginfo('description'); // changing the title from "Powered by WordPress"
}
add_filter('login_headertitle', 'ue_login_title');


// Admin logo
function ue_admin_logo() {
   echo '<style type="text/css">
         #wp-admin-bar-wp-logo > .ab-item .ab-icon { background-image: url('.get_bloginfo('template_directory').'/images/graphics/logo.svg) !important; height:20px!important; background-size: 20px 20px!important; background-position:0 -1px; }
         #wpadminbar.nojs #wp-admin-bar-wp-logo:hover > .ab-item .ab-icon,
		 #wpadminbar #wp-admin-bar-wp-logo.hover > .ab-item .ab-icon {background-image: url('.get_bloginfo('url').'/wp-includes/images/admin-bar-sprite.png?d=20111130);background-position: 0 -104px;}
         </style>';
}
add_action('admin_head', 'ue_admin_logo');


/* Or...... */
function ue_enqueue_style() {
	wp_enqueue_style( 'core', 'style.css', false ); 
}

function ue_enqueue_script() {
	wp_enqueue_script( 'my-js', 'filename.js', false );
}

//add_action( 'login_enqueue_scripts', 'ue_enqueue_style', 10 );
//add_action( 'login_enqueue_scripts', 'ue_enqueue_script', 1 );

?>