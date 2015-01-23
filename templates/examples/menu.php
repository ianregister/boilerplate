<?php
/**
 * Walker class for custom menu in backend
 *
 * @package Beer
 * @subpackage IR
 * @since The Big Bang 1.0
 */
?>


<!-- Main navigation -->
<nav>
	<h3 class="hidden">Navigation Menu</h3>

<?php
wp_nav_menu(array(
    'menu' => 0,
    'container' => false,
	'menu_class' => 'menu',
	'items_wrap' => '<ul class="%2$s">%3$s</ul>',
	'walker'  => new UE_Walker()
));

// Custom walker class
class UE_Walker extends Walker_Nav_Menu {
  
// Indent ul sub-menus
function start_lvl( &$output, $depth ) {
    // depth dependent classes
    $indent = ( $depth > 0  ? str_repeat( "\t", $depth ) : '' ); // code indent
    $display_depth = ( $depth + 1); // because it counts the first submenu as 0
  
    // Start to build html
    $output .= "\n" . $indent . '<ul>' . "\n";
}
  
// Build HTML
 function start_el( &$output, $item, $depth, $args ) {
    global $wp_query;
    $indent = ( $depth > 0 ? str_repeat( "\t", $depth ) : '' ); // code indent

    // build html
    $output .= $indent . '<li>';
  
    // link attributes
    $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
    $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
    $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
    $attributes .= ! empty( $item->url )        ? ' href="'   . parse_url( esc_attr( $item->url ), PHP_URL_PATH ) .'"' : '';
  
    $item_output = sprintf( '%1$s<a%2$s>%3$s%4$s%5$s</a>%6$s',
        $args->before,
        $attributes,
        $args->link_before,
        apply_filters( 'the_title', $item->title, $item->ID ),
        $args->link_after,
        $args->after
    );
  
    // build html
    $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
}
}
	
?>

</nav>
