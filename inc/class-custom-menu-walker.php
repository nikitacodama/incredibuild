<?php
/**
 * Custom Menu Walker
 * 
 * Wraps sub-menus in a .sub-menu-wrapper container
 *
 * @package Incredibuild
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Custom walker class to wrap sub-menus in an additional container
 */
class Incredibuild_Custom_Menu_Walker extends Walker_Nav_Menu {
    
    /**
     * Starts the element output.
     *
     * @param string   $output Used to append additional content (passed by reference).
     * @param WP_Post  $item   Menu item data object.
     * @param int      $depth  Depth of menu item. Used for padding.
     * @param stdClass $args   An object of wp_nav_menu() arguments.
     * @param int      $id     Current item ID.
     */
    public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
        if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
            $t = '';
            $n = '';
        } else {
            $t = "\t";
            $n = "\n";
        }
        $indent = ( $depth ) ? str_repeat( $t, $depth ) : '';

        $classes   = empty( $item->classes ) ? array() : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;

        /**
         * Filters the arguments for a single nav menu item.
         */
        $args = apply_filters( 'nav_menu_item_args', $args, $item, $depth );

        /**
         * Filters the CSS classes applied to a menu item's list item element.
         */
        $class_names = implode( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ) );
        $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

        /**
         * Filters the ID applied to a menu item's list item element.
         */
        $id = apply_filters( 'nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args, $depth );
        $id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

        $output .= $indent . '<li' . $id . $class_names . '>';

        $atts           = array();
        $atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
        $atts['target'] = ! empty( $item->target ) ? $item->target : '';
        if ( '_blank' === $item->target && empty( $item->xfn ) ) {
            $atts['rel'] = 'noopener';
        } else {
            $atts['rel'] = $item->xfn;
        }
        $atts['href']         = ! empty( $item->url ) ? $item->url : '';
        $atts['aria-current'] = $item->current ? 'page' : '';

        /**
         * Filters the HTML attributes applied to a menu item's anchor element.
         */
        $atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );

        $attributes = '';
        foreach ( $atts as $attr => $value ) {
            if ( is_scalar( $value ) && '' !== $value && false !== $value ) {
                $value       = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
                $attributes .= ' ' . $attr . '="' . $value . '"';
            }
        }

        /** This filter is documented in wp-includes/post-template.php */
        $title = apply_filters( 'the_title', $item->title, $item->ID );

        /**
         * Filters a menu item's title.
         */
        $title = apply_filters( 'nav_menu_item_title', $title, $item, $args, $depth );

        // Get ACF icon field
        $icon = get_field('icon', $item);
        $enable_socials = get_field('enable_socials', $item);
        $recent_cpt = get_field('recent_cpt', $item);
        
        // Get menu item description
        $description = ! empty( $item->description ) ? $item->description : '';

        $item_output = $args->before;
        if ( $recent_cpt ) {
            ob_start();
            get_template_part( 'page-templates/partials/loop-menu', null, array( 'post_id' => $item->object_id ) );
            $item_output .= ob_get_clean();
            wp_reset_postdata();
        } else {
            // Wrap icon and link in a div
            $item_output .= '<div class="menu-item-inner ' . ( $enable_socials ? 'socials_enabled' : '' ) . '">';
            $item_output .= '<div class="menu-item-inner-content">';
            $item_output .= '<a ' . $attributes . ' class="menu-item-link-wrapper flex align_c gap_12">';

            // Add icon if exists
            if ( $icon ) {
                $item_output .= '<span class="menu-icon flex_auto">';
                if ( is_array( $icon ) && isset( $icon['url'] ) ) {
                    // Icon is an image
                    $item_output .= '<img src="' . esc_url( $icon['url'] ) . '" alt="' . esc_attr( $title ) . '" />';
                } else {
                    // Icon is HTML/SVG code
                    $item_output .= $icon;
                }
                $item_output .= '</span>';
            }

            $item_output .= '<div class="menu-item-title">';
            $item_output .= $args->link_before . $title . $args->link_after;
            $item_output .= '</div>';
            $item_output .= '</a>';

            // Add description in a separate div if it exists
            if ( $description ) {
                $item_output .= '<div class="menu-item-description">' . esc_html( $description ) . '</div>';
            }
            $item_output .= '</div>';

            if ( $enable_socials ) {
                ob_start();
                get_template_part( 'page-templates/partials/socials' );
                $item_output .= ob_get_clean();
            }

            $item_output .= '</div>';
        }
        $item_output .= $args->after;

        /**
         * Filters a menu item's starting output.
         */
        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    }
    
    /**
     * Starts the list before the elements are added.
     *
     * @param string   $output Used to append additional content (passed by reference).
     * @param int      $depth  Depth of menu item. Used for padding.
     * @param stdClass $args   An object of wp_nav_menu() arguments.
     */
    public function start_lvl( &$output, $depth = 0, $args = null ) {
        if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
            $t = '';
            $n = '';
        } else {
            $t = "\t";
            $n = "\n";
        }
        $indent = str_repeat( $t, $depth );

        // Add the sub-menu-wrapper div before the ul
        $classes = array( 'sub-menu' );

        /**
         * Filters the CSS class(es) applied to a menu list element.
         *
         * @param string[] $classes Array of the CSS classes that are applied to the menu `<ul>` element.
         * @param stdClass $args    An object of `wp_nav_menu()` arguments.
         * @param int      $depth   Depth of menu item. Used for padding.
         */
        $class_names = implode( ' ', apply_filters( 'nav_menu_submenu_css_class', $classes, $args, $depth ) );
        $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

        // Wrap the sub-menu in a .sub-menu-wrapper div
        $output .= "{$n}{$indent}<div class=\"sub-menu-wrapper\">{$n}";
        $output .= "{$indent}<ul$class_names>{$n}";
    }

    /**
     * Ends the list of after the elements are added.
     *
     * @param string   $output Used to append additional content (passed by reference).
     * @param int      $depth  Depth of menu item. Used for padding.
     * @param stdClass $args   An object of wp_nav_menu() arguments.
     */
    public function end_lvl( &$output, $depth = 0, $args = null ) {
        if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
            $t = '';
            $n = '';
        } else {
            $t = "\t";
            $n = "\n";
        }
        $indent = str_repeat( $t, $depth );

        // Close the ul and the .sub-menu-wrapper div
        $output .= "{$indent}</ul>{$n}";
        $output .= "{$indent}</div>{$n}";
    }
}

