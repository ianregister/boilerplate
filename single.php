<?php
/**
 * The single post template file.
 *
 * @package Beer
 * @subpackage IR
 * @since The Big Bang 1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

get_header();

get_template_part ('templates/single/' . $post->post_type);

get_footer(); 

?>