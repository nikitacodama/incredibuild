<?php
function cptui_register_my_taxes() {
/**
	 * Taxonomy: Resource Types.
	 */
	$labels = array(
		'name'                       => _x( 'Resource Types', 'Taxonomy General Name', 'incredibuild' ),
		'singular_name'              => _x( 'Resource Type', 'Taxonomy Singular Name', 'incredibuild' ),
		'menu_name'                  => __( 'Resource Types', 'incredibuild' ),
		'all_items'                  => __( 'All Resource Types', 'incredibuild' ),
		'parent_item'                => __( 'Parent Resource Type', 'incredibuild' ),
		'parent_item_colon'          => __( 'Parent Resource Type:', 'incredibuild' ),
		'new_item_name'              => __( 'New Resource Type Name', 'incredibuild' ),
		'add_new_item'               => __( 'Add New Resource Type', 'incredibuild' ),
		'edit_item'                  => __( 'Edit Resource Type', 'incredibuild' ),
		'update_item'                => __( 'Update Resource Type', 'incredibuild' ),
		'view_item'                  => __( 'View Resource Type', 'incredibuild' ),
		'separate_items_with_commas' => __( 'Separate Resource Types with commas', 'incredibuild' ),
		'add_or_remove_items'        => __( 'Add or remove Resource Types', 'incredibuild' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'incredibuild' ),
		'popular_items'              => __( 'Popular Resource Types', 'incredibuild' ),
		'search_items'               => __( 'Search Resource Types', 'incredibuild' ),
		'not_found'                  => __( 'Not Found', 'incredibuild' ),
		'no_terms'                   => __( 'No Resource Types', 'incredibuild' ),
		'items_list'                 => __( 'Resource Types list', 'incredibuild' ),
		'items_list_navigation'      => __( 'Resource Types list navigation', 'incredibuild' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => false,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => false,
		'show_tagcloud'              => false,
        'show_in_rest'               => true
	);
	register_taxonomy( 'resource_type', array( 'resources_library' ), $args );

}
add_action( 'init', 'cptui_register_my_taxes' );