<?php

class OnePage_NavWalker extends Walker_Nav_Menu {
	
	/**
	 * Starts the element output.
	 *
	 * @since 3.0.0
	 * @since 4.4.0 The {@see 'nav_menu_item_args'} filter was added.
	 *
	 * @see Walker::start_el()
	 *
	 * @param string   $output Used to append additional content (passed by reference).
	 * @param WP_Post  $item   Menu item data object.
	 * @param int      $depth  Depth of menu item. Used for padding.
	 * @param stdClass $args   An object of wp_nav_menu() arguments.
	 * @param int      $id     Current item ID.
	 */
	public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		
		if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
			$t = '';
			$n = '';
		} else {
			$t = "\t";
			$n = "\n";
		}
		$indent = ( $depth ) ? str_repeat( $t, $depth ) : '';
		
		$classes = empty( $item->classes ) ? array() : (array) $item->classes;
		$classes[] = 'menu-item-' . $item->ID;
		
		/**
		 * Add class '.nav-item' inside <li> tag for Bootstrap
		 */
		$classes[] = 'nav-item';

		/**
		 * Add class '.active' inside <li> tag for Bootstrap active menu as well as for the parent menu, which have the active sub-menu
		 */
		if ( in_array( 'current-menu-item', $classes ) || in_array( 'current-menu-parent', $classes ) ) {
			$classes[] = 'active';
		}

		/**
		 * Add class '.dropdown' inside <li> tag for Bootstrap dropdown menu, ie, <li> having sub-menu
		 */
		if ( in_array( 'menu-item-has-children', $classes ) ) {
			$classes[] = 'dropdown';
		}

		/**
		 * Filters the arguments for a single nav menu item.
		 *
		 * @since 4.4.0
		 *
		 * @param stdClass $args  An object of wp_nav_menu() arguments.
		 * @param WP_Post  $item  Menu item data object.
		 * @param int      $depth Depth of menu item. Used for padding.
		 */
		$args = apply_filters( 'nav_menu_item_args', $args, $item, $depth );

		/**
		 * Filters the CSS class(es) applied to a menu item's list item element.
		 *
		 * @since 3.0.0
		 * @since 4.1.0 The `$depth` parameter was added.
		 *
		 * @param array    $classes The CSS classes that are applied to the menu item's `<li>` element.
		 * @param WP_Post  $item    The current menu item.
		 * @param stdClass $args    An object of wp_nav_menu() arguments.
		 * @param int      $depth   Depth of menu item. Used for padding.
		 */
		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ) );
		$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

		/**
		 * Filters the ID applied to a menu item's list item element.
		 *
		 * @since 3.0.1
		 * @since 4.1.0 The `$depth` parameter was added.
		 *
		 * @param string   $menu_id The ID that is applied to the menu item's `<li>` element.
		 * @param WP_Post  $item    The current menu item.
		 * @param stdClass $args    An object of wp_nav_menu() arguments.
		 * @param int      $depth   Depth of menu item. Used for padding.
		 */
		$id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args, $depth );
		$id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

		/**
		 * <li> is required for parent menu only in Bootstrap
		 */
		if ( $depth === 0 ) {
			$output .= $indent . '<li' . $id . $class_names . '>';
		}

		$atts = array();
		$atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
		$atts['target'] = ! empty( $item->target )     ? $item->target     : '';
		$atts['rel']    = ! empty( $item->xfn )        ? $item->xfn        : '';
		$atts['href']   = ! empty( $item->url )        ? $item->url        : '';
		
		/**
		 * Add '.nav-link' class for <a> in parent menu for Bootstrap
		 */
		if ( $depth === 0 ) {
			$atts['class'] = 'nav-link js-scroll-trigger';
		}
		
		/**
		 * Add the attributes for <a> in parent menu
		 *
		 * 1. Add '.dropdown-toggle' class for <a> in parent menu if it has sub-menu as required for Bootstrap
		 * 2. Add '.dropdown' as 'data-toggle' attribute in <a> in parent menu if it has sub-menu as required for Bootstrap
		 * 3. Add the current menu id attribute to indicate the exact menu to toggle for set in sub-menu div
		 * 4. Add the attribute of 'true' for 'aria-haspopup' in parent menu to indicate it has sub-menus
		 * 5. Add the attribute of 'false' for 'aria-expanded' in parent menu to indicate the sub-menus is hidden by default
		 * 6. Add the '#' link in the <a> tag in the parent menu if it has sub-menu as required for Bootstrap
		 */
		if ( $depth === 0 && in_array( 'menu-item-has-children', $classes ) ) {
			$atts['class']         .= ' dropdown-toggle';
			$atts['data-toggle']   = 'dropdown';
			$atts['id']            = 'navbar-dropdown-menu-link-' . $item->ID;
			$atts['aria-haspopup'] = "true";
			$atts['aria-expanded'] = "false";
			$atts['href']          = '#';
		}
		
		/**
		 * Add the attributes for <a> in sub-menu
		 * 1. Add '.dropdown-item' class for <a> inside sub-menu for Bootstrap
		 * 2. Add the current menu id attribute if you want to style the menu differently
		 */
		if ( $depth > 0 ) {
			$atts['class'] = 'dropdown-item';
			$atts['id']    = 'menu-item-' . $item->ID;
		}

		/**
		 * Add '.active' class inside <a> in sub-menu for Bootstrap
		 */
		if ( in_array( 'current-menu-item', $item->classes ) ) {
			$atts['class'] .= ' active';
		}

		/**
		 * Add '.disabled' class for <a> in menu for Bootstrap disabled class
		 */
		if ( in_array( 'disabled', $item->classes ) ) {
			$atts['class'] .= ' disabled';
		}

		/**
		 * Filters the HTML attributes applied to a menu item's anchor element.
		 *
		 * @since 3.6.0
		 * @since 4.1.0 The `$depth` parameter was added.
		 *
		 * @param array $atts {
		 *     The HTML attributes applied to the menu item's `<a>` element, empty strings are ignored.
		 *
		 *     @type string $title  Title attribute.
		 *     @type string $target Target attribute.
		 *     @type string $rel    The rel attribute.
		 *     @type string $href   The href attribute.
		 * }
		 * @param WP_Post  $item  The current menu item.
		 * @param stdClass $args  An object of wp_nav_menu() arguments.
		 * @param int      $depth Depth of menu item. Used for padding.
		 */
		$atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );
		
		$attributes = '';
		foreach ( $atts as $attr => $value ) {
			if ( ! empty( $value ) ) {
				$value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
				
				/**
				 * If '.disabled' class is added to the menu, add the url of '#' in it
				 */
				if ( in_array( 'disabled', $item->classes ) ) {
					$value = ( 'href' === $attr ) ? esc_url( '#' ) : esc_attr( $value );
				}

				if ( $attr !== 'href' ){
					$attributes .= ' ' . $attr . '="' . $value . '"';
				}
			}
		}
		
		// Replace links by anchors
		if ( $item->object == 'page' ){

            $varpost = get_post( $item->object_id );
            if ( is_home() ){
            	$attributes .= ' href="#' . $varpost->post_name . '"';
            } else {
            	$attributes .= ' href="' . home_url() . '/#' . $varpost->post_name . '"';
            }
        } else{
        	$attributes .= ! empty( $item->url ) ? ' href="' . esc_attr( $item->url ) .'"' : '';
        }

		/** This filter is documented in wp-includes/post-template.php */
		$title = apply_filters( 'the_title', $item->title, $item->ID );

		/**
		 * Filters a menu item's title.
		 *
		 * @since 4.4.0
		 *
		 * @param string   $title The menu item's title.
		 * @param WP_Post  $item  The current menu item.
		 * @param stdClass $args  An object of wp_nav_menu() arguments.
		 * @param int      $depth Depth of menu item. Used for padding.
		 */
		$title = apply_filters( 'nav_menu_item_title', $title, $item, $args, $depth );

		$item_output = $args->before;
		$item_output .= '<a'. $attributes .'>';
		$item_output .= $args->link_before . $title . $args->link_after;
		$item_output .= '</a>';
		$item_output .= $args->after;

		/**
		 * Filters a menu item's starting output.
		 *
		 * The menu item's starting output only includes `$args->before`, the opening `<a>`,
		 * the menu item's title, the closing `</a>`, and `$args->after`. Currently, there is
		 * no filter for modifying the opening and closing `<li>` for a menu item.
		 *
		 * @since 3.0.0
		 *
		 * @param string   $item_output The menu item's starting HTML output.
		 * @param WP_Post  $item        Menu item data object.
		 * @param int      $depth       Depth of menu item. Used for padding.
		 * @param stdClass $args        An object of wp_nav_menu() arguments.
		 */
		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
		
	}
	
}

?>
