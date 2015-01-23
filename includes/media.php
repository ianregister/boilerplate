<?php
/**
 * Media, image, MIME functions and definitions
 *
 * @package Beer
 * @subpackage IR
 * @since The Big Bang
 */


/* ==========================================================================
   Set video embed width and image sizes and jpg quality
   ========================================================================== */

if ( ! isset( $content_width ) ) { 
    $content_width = 550;
}
add_action( 'after_setup_theme', 'ue_start' );

function ue_start() {
add_theme_support( 'post-thumbnails' );

}



/* Set JPG quality
   -------------------------------------------------------------------------- */

add_filter('jpeg_quality', function($arg) { return 80; });



/* Set mime type for SVG
   -------------------------------------------------------------------------- */

function ue_mimetypes( $m ){
    $m['svg'] = 'image/svg+xml';
    $m['svgz'] = 'image/svg+xml';
    return $m;
}
add_filter( 'upload_mimes', 'ue_mimetypes' );





?>