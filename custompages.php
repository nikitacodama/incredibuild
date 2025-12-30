<?php 


function register_solutions_post_type() {
    $labels = array(
        'name'                  => _x( 'Solutions', 'Post Type General Name', 'text_domain' ),
        'singular_name'         => _x( 'Solution', 'Post Type Singular Name', 'text_domain' ),
        'menu_name'             => __( 'Solutions', 'text_domain' ),
        'name_admin_bar'        => __( 'Solutions', 'text_domain' ),
        'archives'              => __( 'Solutions Archives', 'text_domain' ),
        'attributes'            => __( 'Solutions Attributes', 'text_domain' ),
        'parent_item_colon'     => __( 'Parent Solutions:', 'text_domain' ),
        'all_items'             => __( 'All Solutions', 'text_domain' ),
        'add_new_item'          => __( 'Add New Solutions', 'text_domain' ),
        'add_new'               => __( 'Add New Solution', 'text_domain' ),
        'new_item'              => __( 'New Solutions', 'text_domain' ),
        'edit_item'             => __( 'Edit Solution', 'text_domain' ),
        'update_item'           => __( 'Update Solution', 'text_domain' ),
        'view_item'             => __( 'View Solution', 'text_domain' ),
        'view_items'            => __( 'View Solution', 'text_domain' ),
        'search_items'          => __( 'Search Solution', 'text_domain' ),
        'not_found'             => __( 'Not found', 'text_domain' ),
        'not_found_in_trash'    => __( 'Not found in Trash', 'text_domain' ),
        'featured_image'        => __( 'Featured Image', 'text_domain' ),
        'set_featured_image'    => __( 'Set featured image', 'text_domain' ),
        'remove_featured_image' => __( 'Remove featured image', 'text_domain' ),
        'use_featured_image'    => __( 'Use as featured image', 'text_domain' ),
        'insert_into_item'      => __( 'Insert into Solution', 'text_domain' ),
        'uploaded_to_this_item' => __( 'Uploaded to this Solution', 'text_domain' ),
        'items_list'            => __( 'Solutions list', 'text_domain' ),
        'items_list_navigation' => __( 'Solutions list navigation', 'text_domain' ),
        'filter_items_list'     => __( 'Filter Solutions list', 'text_domain' ),
    );
	$rewrite = array(
		'slug'                  => 'solutions',
		'with_front'            => false,
		'pages'                 => true,
		'feeds'                 => true,
	);
    $args = array(
        'label'                 => __( 'Solutions', 'text_domain' ),
        'description'           => __( 'Post Type Description', 'text_domain' ),
        'labels'                => $labels,
        'supports'              => array( 'title', 'editor', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields' ),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 4,
        'menu_icon'             => 'dashicons-lightbulb',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => true,
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
		'rewrite'               => $rewrite,
        'capability_type'       => 'post',
        'show_in_rest'          => true,
    );

    register_post_type( 'solutions', $args );
}

add_action( 'init', 'register_solutions_post_type', 0 );

function add_solutions_meta_box() {
    add_meta_box(
        'solutions_meta_box', // Unique ID
        'Additional Image', // Box title
        'display_solutions_meta_box', // Content callback
        'solutions', // Post type
        'side', // Context
        'default' // Priority
    );
}
add_action( 'add_meta_boxes', 'add_solutions_meta_box' );


/// Products

// Register Custom Post Type
function register_product_post_type() {
   

	$labels = array(
		'name'                  => _x( 'Products pages', 'Post Type General Name', 'products' ),
		'singular_name'         => _x( 'product', 'Post Type Singular Name', 'products' ),
		'menu_name'             => __( 'Products', 'products' ),
		'name_admin_bar'        => __( 'Products', 'products' ),
		'archives'              => __( 'Products', 'products' ),
		'attributes'            => __( 'Products', 'products' ),
		'parent_item_colon'     => __( 'Parent Item: Product', 'products' ),
		'all_items'             => __( 'Products pages', 'products' ),
		'add_new_item'          => __( 'Add New Product', 'products' ),
		'add_new'               => __( 'Add New', 'products' ),
		'new_item'              => __( 'Products pages', 'products' ),
		'edit_item'             => __( 'Products pages', 'products' ),
		'update_item'           => __( 'Product', 'products' ),
		'view_item'             => __( 'Product', 'products' ),
		'view_items'            => __( 'Products', 'products' ),
		'search_items'          => __( 'Product', 'products' ),
		'not_found'             => __( 'Not found', 'products' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'products' ),
		'featured_image'        => __( 'Featured Image', 'products' ),
		'set_featured_image'    => __( 'Set featured image', 'products' ),
		'remove_featured_image' => __( 'Remove featured image', 'products' ),
		'use_featured_image'    => __( 'Use as featured image', 'products' ),
		'insert_into_item'      => __( 'Insert into item', 'products' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'products' ),
		'items_list'            => __( 'Items list', 'products' ),
		'items_list_navigation' => __( 'Items list navigation', 'products' ),
		'filter_items_list'     => __( 'Filter items list', 'products' ),
	);
	$rewrite = array(
		'slug'                  => 'product',
		'with_front'            => false,
		'pages'                 => true,
		'feeds'                 => true,
	);
	$args = array(
		'label'                 => __( 'product', 'products' ),
		'description'           => __( 'Our Products', 'products' ),
		'labels'                => $labels,
        'supports'              => array( 'title', 'editor', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields', 'page-attributes' ),
		'hierarchical'          => true,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => 'product',
		
        'menu_icon'             => 'dashicons-products',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => false,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
        'rewrite'               => $rewrite,
        'capability_type'       => 'page',
        'show_in_rest'          => true,
	);

	register_post_type( 'product', $args );

}
add_action( 'init', 'register_product_post_type', 0 );


////

// Register Custom Post Type
function our_customers_post_type() {

	$labels = array(
		'name'                  => _x( 'Case Studies', 'Post Type General Name', 'our_customers' ),
		'singular_name'         => _x( 'Case Studies', 'Post Type Singular Name', 'our_customers' ),
		'menu_name'             => __( 'Case Studies', 'our_customers' ),
		'name_admin_bar'        => __( 'Case Studies', 'our_customers' ),
		'archives'              => __( 'Customer storys Archives', 'our_customers' ),
		'attributes'            => __( 'Item Attributes', 'our_customers' ),
		'parent_item_colon'     => __( 'Parent Item:', 'our_customers' ),
		'all_items'             => __( 'All Customer storys', 'our_customers' ),
		'add_new_item'          => __( 'Add New Customer story', 'our_customers' ),
		'add_new'               => __( 'Add Customer story', 'our_customers' ),
		'new_item'              => __( 'New Customer story', 'our_customers' ),
		'edit_item'             => __( 'Edit Customer story', 'our_customers' ),
		'update_item'           => __( 'Update Customer story', 'our_customers' ),
		'view_item'             => __( 'View Customer story', 'our_customers' ),
		'view_items'            => __( 'View Customer storys', 'our_customers' ),
		'search_items'          => __( 'Customer story', 'our_customers' ),
		'not_found'             => __( 'Not found', 'our_customers' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'our_customers' ),
		'featured_image'        => __( 'Featured Image', 'our_customers' ),
		'set_featured_image'    => __( 'Set featured image', 'our_customers' ),
		'remove_featured_image' => __( 'Remove featured image', 'our_customers' ),
		'use_featured_image'    => __( 'Use as featured image', 'our_customers' ),
		'insert_into_item'      => __( 'Insert into item', 'our_customers' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'our_customers' ),
		'items_list'            => __( 'Items list', 'our_customers' ),
		'items_list_navigation' => __( 'Items list navigation', 'our_customers' ),
		'filter_items_list'     => __( 'Filter items list', 'our_customers' ),
	);
	$rewrite = array(
		'slug'                  => 'case-studies',
		'with_front'            => false,
		'pages'                 => false,
		'feeds'                 => false,
	);
	$args = array(
		'label'                 => __( 'Our Customer', 'our_customers' ),
		'description'           => __( 'Post Type Description', 'our_customers' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields' ),
		'taxonomies'            => array( 'category', 'post_tag' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
        'menu_icon'             => 'dashicons-businessman',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'rewrite'               => $rewrite,
		'capability_type'       => 'post',
        'show_in_rest'          => true,
	);
	register_post_type( 'our_customers', $args );

}
add_action( 'init', 'our_customers_post_type', 0 );

// Register Custom Post Type
function our_partners_post_type() {

	$labels = array(
		'name'                  => _x( 'Our partners', 'Post Type General Name', 'partners' ),
		'singular_name'         => _x( 'partners', 'Post Type Singular Name', 'partners' ),
		'menu_name'             => __( 'Our partners', 'partners' ),
		'name_admin_bar'        => __( 'Our partner', 'partners' ),
		'archives'              => __( 'partners Archives', 'partners' ),
		'attributes'            => __( 'Item Attributes', 'partners' ),
		'parent_item_colon'     => __( 'Parent Item:', 'partners' ),
		'all_items'             => __( 'All partners', 'partners' ),
		'add_new_item'          => __( 'Add New partner', 'partners' ),
		'add_new'               => __( 'Add partner', 'partners' ),
		'new_item'              => __( 'New partner', 'partners' ),
		'edit_item'             => __( 'Edit partner', 'partners' ),
		'update_item'           => __( 'Update partner', 'partners' ),
		'view_item'             => __( 'View partner', 'partners' ),
		'view_items'            => __( 'View partner', 'partners' ),
		'search_items'          => __( 'partners', 'partners' ),
		'not_found'             => __( 'Not found', 'partners' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'partners' ),
		'featured_image'        => __( 'Featured Image', 'partners' ),
		'set_featured_image'    => __( 'Set featured image', 'partners' ),
		'remove_featured_image' => __( 'Remove featured image', 'partners' ),
		'use_featured_image'    => __( 'Use as featured image', 'partners' ),
		'insert_into_item'      => __( 'Insert into item', 'partners' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'partners' ),
		'items_list'            => __( 'Items list', 'partners' ),
		'items_list_navigation' => __( 'Items list navigation', 'partners' ),
		'filter_items_list'     => __( 'Filter items list', 'partners' ),
	);
	$rewrite = array(
		'slug'                  => 'partners',
		'with_front'            => false,
		'pages'                 => false,
		'feeds'                 => false,
	);
	$args = array(
		'label'                 => __( 'partners', 'partners' ),
		'description'           => __( 'Post Type Description', 'partners' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-networking',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'rewrite'               => $rewrite,
		'capability_type'       => 'page',
        'show_in_rest'          => true,
	);
	register_post_type( 'partners', $args );

}
add_action( 'init', 'our_partners_post_type', 0 );


// Register Custom Post Type
function resource_single_page() {

	$labels = array(
		'name'                  => _x( 'resource pages', 'Post Type General Name', 'text_domain' ),
		'singular_name'         => _x( 'resource page', 'Post Type Singular Name', 'text_domain' ),
		'menu_name'             => __( 'Resource page', 'text_domain' ),
		'name_admin_bar'        => __( 'Resource page', 'text_domain' ),
		'archives'              => __( 'Item Archives', 'text_domain' ),
		'attributes'            => __( 'Item Attributes', 'text_domain' ),
		'parent_item_colon'     => __( 'Parent Item:', 'text_domain' ),
		'all_items'             => __( 'Resource page', 'text_domain' ),
		'add_new_item'          => __( 'Add New Item', 'text_domain' ),
		'add_new'               => __( 'Resource page', 'text_domain' ),
		'new_item'              => __( 'Resource page', 'text_domain' ),
		'edit_item'             => __( 'Edit Resource page', 'text_domain' ),
		'update_item'           => __( 'Update Resource page', 'text_domain' ),
		'view_item'             => __( 'View Resource page', 'text_domain' ),
		'view_items'            => __( 'View Resource page', 'text_domain' ),
		'search_items'          => __( 'Search Resource page', 'text_domain' ),
		'not_found'             => __( 'Not found', 'text_domain' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'text_domain' ),
		'featured_image'        => __( 'Featured Image', 'text_domain' ),
		'set_featured_image'    => __( 'Set featured image', 'text_domain' ),
		'remove_featured_image' => __( 'Remove featured image', 'text_domain' ),
		'use_featured_image'    => __( 'Use as featured image', 'text_domain' ),
		'insert_into_item'      => __( 'Insert into Resource page', 'text_domain' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'text_domain' ),
		'items_list'            => __( 'Resource pages list', 'text_domain' ),
		'items_list_navigation' => __( 'Resource pages list navigation', 'text_domain' ),
		'filter_items_list'     => __( 'Filter items list', 'text_domain' ),
	);
	$rewrite = array(
		'slug'                  => 'resourcepage',
		'with_front'            => false,
		'pages'                 => false,
		'feeds'                 => false,
	);
	$args = array(
		'label'                 => __( 'resource page', 'text_domain' ),
		'description'           => __( 'single resource page', 'text_domain' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'revisions' ),
		'taxonomies'            => array( 'category', 'post_tag' ),
		'hierarchical'          => true,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => 'resources',
        'menu_icon'             => 'dashicons-format-aside',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'rewrite'               => $rewrite,
		'capability_type'       => 'page',
        'show_in_rest'          => true,
	);
	register_post_type( 'single_resource_page', $args );

}
add_action( 'init', 'resource_single_page', 0 );


// Register Custom Post Type
function integrations() {

	$labels = array(
		'name'                  => _x( 'integrations', 'Post Type General Name', 'text_domain' ),
		'singular_name'         => _x( 'integration', 'Post Type Singular Name', 'text_domain' ),
		'menu_name'             => __( 'integrations', 'text_domain' ),
		'name_admin_bar'        => __( 'integrations', 'text_domain' ),
		'archives'              => __( 'Item Archives', 'text_domain' ),
		'attributes'            => __( 'Item Attributes', 'text_domain' ),
		'parent_item_colon'     => __( 'Parent Item:', 'text_domain' ),
		'all_items'             => __( 'Integrations', 'text_domain' ),
		'add_new_item'          => __( 'Add New Item', 'text_domain' ),
		'add_new'               => __( 'Add New integration', 'text_domain' ),
		'new_item'              => __( 'New integration', 'text_domain' ),
		'edit_item'             => __( 'Edit integration', 'text_domain' ),
		'update_item'           => __( 'Update integration', 'text_domain' ),
		'view_item'             => __( 'View integration', 'text_domain' ),
		'view_items'            => __( 'View integration', 'text_domain' ),
		'search_items'          => __( 'Search Item', 'text_domain' ),
		'not_found'             => __( 'Not found', 'text_domain' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'text_domain' ),
		'featured_image'        => __( 'Featured Image', 'text_domain' ),
		'set_featured_image'    => __( 'Set featured image', 'text_domain' ),
		'remove_featured_image' => __( 'Remove featured image', 'text_domain' ),
		'use_featured_image'    => __( 'Use as featured image', 'text_domain' ),
		'insert_into_item'      => __( 'Insert into item', 'text_domain' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'text_domain' ),
		'items_list'            => __( 'Items list', 'text_domain' ),
		'items_list_navigation' => __( 'Items list navigation', 'text_domain' ),
		'filter_items_list'     => __( 'Filter items list', 'text_domain' ),
	);
	$rewrite = array(
		'slug'                  => 'integrations',
		'with_front'            => false,
		'pages'                 => false,
		'feeds'                 => false,
	);
	$args = array(
		'label'                 => __( 'integration', 'text_domain' ),
		'description'           => __( 'integrations', 'text_domain' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields' ),
		'taxonomies'            => array( 'category', 'post_tag' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => 'product',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'rewrite'               => $rewrite,
		'capability_type'       => 'post',
		'show_in_rest'          => true,
	);
	register_post_type( 'integrations', $args );

}
add_action( 'init', 'integrations', 0 );


// Register Custom Post Type
function our_resource_library_post_type() {

	$labels = array(
		'name'                  => _x( 'Resource Library', 'Post Type General Name', 'resources_library' ),
		'singular_name'         => _x( 'Resource Library', 'Post Type Singular Name', 'resources_library' ),
		'menu_name'             => __( 'Resource Library', 'resources_library' ),
		'name_admin_bar'        => __( 'Resource Library', 'resources_library' ),
		'archives'              => __( 'Resource Archives', 'resources_library' ),
		'attributes'            => __( 'Item Attributes', 'resources_library' ),
		'parent_item_colon'     => __( 'Parent Item:', 'resources_library' ),
		'all_items'             => __( 'Resource', 'resources_library' ),
		'add_new_item'          => __( 'Add New Resource', 'resources_library' ),
		'add_new'               => __( 'Add Resource', 'resources_library' ),
		'new_item'              => __( 'New Resource', 'resources_library' ),
		'edit_item'             => __( 'Edit Resource', 'resources_library' ),
		'update_item'           => __( 'Update Resource', 'resources_library' ),
		'view_item'             => __( 'View Resource', 'resources_library' ),
		'view_items'            => __( 'View Resource', 'resources_library' ),
		'search_items'          => __( 'Resource Library', 'resources_library' ),
		'not_found'             => __( 'Not found', 'resources_library' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'resources_library' ),
		'featured_image'        => __( 'Featured Image', 'resources_library' ),
		'set_featured_image'    => __( 'Set featured image', 'resources_library' ),
		'remove_featured_image' => __( 'Remove featured image', 'resources_library' ),
		'use_featured_image'    => __( 'Use as featured image', 'resources_library' ),
		'insert_into_item'      => __( 'Insert into item', 'resources_library' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'resources_library' ),
		'items_list'            => __( 'Items list', 'resources_library' ),
		'items_list_navigation' => __( 'Items list navigation', 'resources_library' ),
		'filter_items_list'     => __( 'Filter items list', 'resources_library' ),
	);
	$rewrite = array(
		'slug'                  => 'resources',
		'with_front'            => false,
		'pages'                 => false,
		'feeds'                 => false,
	);
	$args = array(
		'label'                 => __( 'resources library', 'resources_library' ),
		'description'           => __( 'Post Type Description', 'resources_library' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'thumbnail', 'custom-fields', 'excerpt' ),
		'taxonomies'            => array( 'category', 'post_tag' ),
		'hierarchical'          => true,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => 'resources',
        'menu_icon'             => 'dashicons-businessman',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'rewrite'               => $rewrite,
		'capability_type'       => 'post',
        'show_in_rest'          => true,
	);
	register_post_type( 'resources_library', $args );

}

add_action( 'init', 'our_resource_library_post_type', 0 );

// Register Custom Post Type
function glossary_post_type() {

	$labels = array(
		'name'                  => _x( 'Glossary', 'Post Type General Name', 'glossarys' ),
		'singular_name'         => _x( 'Glossarys', 'Post Type Singular Name', 'glossarys' ),
		'menu_name'             => __( 'Glossary', 'glossarys' ),
		'name_admin_bar'        => __( 'Glossary', 'glossarys' ),
		'archives'              => __( 'Glossary Archives', 'glossarys' ),
		'attributes'            => __( 'Item Attributes', 'glossarys' ),
		'parent_item_colon'     => __( 'Parent Item:', 'glossarys' ),
		'all_items'             => __( 'Glossarys', 'glossarys' ),
		'add_new_item'          => __( 'Add New Glossary', 'glossarys' ),
		'add_new'               => __( 'Add Glossary', 'glossarys' ),
		'new_item'              => __( 'New Glossary', 'glossarys' ),
		'edit_item'             => __( 'Edit Glossary', 'glossarys' ),
		'update_item'           => __( 'Update Glossary', 'glossarys' ),
		'view_item'             => __( 'View Glossary', 'glossarys' ),
		'view_items'            => __( 'View Glossary', 'glossarys' ),
		'search_items'          => __( 'Glossary', 'glossarys' ),
		'not_found'             => __( 'Not found', 'glossarys' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'glossarys' ),
		'featured_image'        => __( 'Featured Image', 'glossarys' ),
		'set_featured_image'    => __( 'Set featured image', 'glossarys' ),
		'remove_featured_image' => __( 'Remove featured image', 'glossarys' ),
		'use_featured_image'    => __( 'Use as featured image', 'glossarys' ),
		'insert_into_item'      => __( 'Insert into item', 'glossarys' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'glossarys' ),
		'items_list'            => __( 'Items list', 'glossarys' ),
		'items_list_navigation' => __( 'Items list navigation', 'glossarys' ),
		'filter_items_list'     => __( 'Filter items list', 'glossarys' ),
	);
	$rewrite = array(
		'slug'                  => 'glossary',
		'with_front'            => false,
		'pages'                 => false,
		'feeds'                 => false,
	);
	$args = array(
		'label'                 => __( 'Glossary', 'glossarys' ),
		'description'           => __( 'Post Type Description', 'glossarys' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'thumbnail', 'custom-fields' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => 'resources',
        'menu_icon'             => 'dashicons-businessman',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'rewrite'               => $rewrite,
		'capability_type'       => 'post',
        'show_in_rest'          => true,
	);
	register_post_type( 'glossarys', $args );

}
add_action( 'init', 'glossary_post_type', 0 );



// Register Custom Post Type
function company_post_type() {

	$labels = array(
		'name'                  => _x( 'Company', 'Post Type General Name', 'text_domain' ),
		'singular_name'         => _x( 'company', 'Post Type Singular Name', 'text_domain' ),
		'menu_name'             => __( 'Company', 'text_domain' ),
		'name_admin_bar'        => __( 'Company', 'text_domain' ),
		'archives'              => __( 'Item Archives', 'text_domain' ),
		'attributes'            => __( 'Item Attributes', 'text_domain' ),
		'parent_item_colon'     => __( 'Parent Item:', 'text_domain' ),
		'all_items'             => __( 'Company pages', 'text_domain' ),
		'add_new_item'          => __( 'Add New Item', 'text_domain' ),
		'add_new'               => __( 'Add New', 'text_domain' ),
		'new_item'              => __( 'New Item', 'text_domain' ),
		'edit_item'             => __( 'Edit Item', 'text_domain' ),
		'update_item'           => __( 'Update Item', 'text_domain' ),
		'view_item'             => __( 'View Item', 'text_domain' ),
		'view_items'            => __( 'View Items', 'text_domain' ),
		'search_items'          => __( 'Search Item', 'text_domain' ),
		'not_found'             => __( 'Not found', 'text_domain' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'text_domain' ),
		'featured_image'        => __( 'Featured Image', 'text_domain' ),
		'set_featured_image'    => __( 'Set featured image', 'text_domain' ),
		'remove_featured_image' => __( 'Remove featured image', 'text_domain' ),
		'use_featured_image'    => __( 'Use as featured image', 'text_domain' ),
		'insert_into_item'      => __( 'Insert into item', 'text_domain' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'text_domain' ),
		'items_list'            => __( 'Items list', 'text_domain' ),
		'items_list_navigation' => __( 'Items list navigation', 'text_domain' ),
		'filter_items_list'     => __( 'Filter items list', 'text_domain' ),
	);
	$rewrite = array(
		'slug'                  => 'company',
		'with_front'            => false,
		'pages'                 => false,
		'feeds'                 => false,
	);
	
	$args = array(
		'label'                 => __( 'company', 'text_domain' ),
		'description'           => __( 'Post Type Description', 'text_domain' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'page-attributes' ),
		'hierarchical'          => true,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => 'company',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => false,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'rewrite'               => $rewrite,
		'capability_type'       => 'page',
		'show_in_rest'          => true,
	);
	register_post_type( 'company', $args );

}
add_action( 'init', 'company_post_type', 0 );

// Register Custom Post Type
function news() {

	$labels = array(
		'name'                  => _x( 'news', 'Post Type General Name', 'text_domain' ),
		'singular_name'         => _x( 'news item', 'Post Type Singular Name', 'text_domain' ),
		'menu_name'             => __( 'News', 'text_domain' ),
		'name_admin_bar'        => __( 'News', 'text_domain' ),
		'archives'              => __( 'Item Archives', 'text_domain' ),
		'attributes'            => __( 'Item Attributes', 'text_domain' ),
		'parent_item_colon'     => __( 'Parent Item:', 'text_domain' ),
		'all_items'             => __( 'All News Items', 'text_domain' ),
		'add_new_item'          => __( 'Add New Item', 'text_domain' ),
		'add_new'               => __( 'Add News item', 'text_domain' ),
		'new_item'              => __( 'New Item', 'text_domain' ),
		'edit_item'             => __( 'Edit Item', 'text_domain' ),
		'update_item'           => __( 'Update Item', 'text_domain' ),
		'view_item'             => __( 'View Item', 'text_domain' ),
		'view_items'            => __( 'View Items', 'text_domain' ),
		'search_items'          => __( 'Search Item', 'text_domain' ),
		'not_found'             => __( 'Not found', 'text_domain' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'text_domain' ),
		'featured_image'        => __( 'Featured Image', 'text_domain' ),
		'set_featured_image'    => __( 'Set featured image', 'text_domain' ),
		'remove_featured_image' => __( 'Remove featured image', 'text_domain' ),
		'use_featured_image'    => __( 'Use as featured image', 'text_domain' ),
		'insert_into_item'      => __( 'Insert into item', 'text_domain' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'text_domain' ),
		'items_list'            => __( 'Items list', 'text_domain' ),
		'items_list_navigation' => __( 'Items list navigation', 'text_domain' ),
		'filter_items_list'     => __( 'Filter items list', 'text_domain' ),
	);
	$rewrite = array(
		'slug'                  => 'news',
		'with_front'            => false,
		'pages'                 => false,
		'feeds'                 => false,
	);
	$args = array(
		'label'                 => __( 'news item', 'text_domain' ),
		'description'           => __( 'Post Type Description', 'text_domain' ),
		'labels'                => $labels,
	
		'supports'              => array( 'title', 'editor', 'thumbnail', 'revisions', 'excerpt', 'custom-fields' ),
		'taxonomies'            => array( 'category', 'post_tag' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => 'company',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'rewrite'               => $rewrite,
		'capability_type'       => 'post',
		'show_in_rest'          => true,
	);
	register_post_type( 'news', $args );

}
add_action( 'init', 'news', 0 );

// Register Custom Post Type
function legal() {

	$labels = array(
		'name'                  => _x( 'legal pages', 'Post Type General Name', 'text_domain' ),
		'singular_name'         => _x( 'legal page', 'Post Type Singular Name', 'text_domain' ),
		'menu_name'             => __( 'legal pages', 'text_domain' ),
		'name_admin_bar'        => __( 'legal pages', 'text_domain' ),
		'archives'              => __( 'Item Archives', 'text_domain' ),
		'attributes'            => __( 'Item Attributes', 'text_domain' ),
		'parent_item_colon'     => __( 'Parent Item:', 'text_domain' ),
		'all_items'             => __( 'All Items', 'text_domain' ),
		'add_new_item'          => __( 'Add New Item', 'text_domain' ),
		'add_new'               => __( 'Add New', 'text_domain' ),
		'new_item'              => __( 'New Item', 'text_domain' ),
		'edit_item'             => __( 'Edit Item', 'text_domain' ),
		'update_item'           => __( 'Update Item', 'text_domain' ),
		'view_item'             => __( 'View Item', 'text_domain' ),
		'view_items'            => __( 'View Items', 'text_domain' ),
		'search_items'          => __( 'Search Item', 'text_domain' ),
		'not_found'             => __( 'Not found', 'text_domain' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'text_domain' ),
		'featured_image'        => __( 'Featured Image', 'text_domain' ),
		'set_featured_image'    => __( 'Set featured image', 'text_domain' ),
		'remove_featured_image' => __( 'Remove featured image', 'text_domain' ),
		'use_featured_image'    => __( 'Use as featured image', 'text_domain' ),
		'insert_into_item'      => __( 'Insert into item', 'text_domain' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'text_domain' ),
		'items_list'            => __( 'Items list', 'text_domain' ),
		'items_list_navigation' => __( 'Items list navigation', 'text_domain' ),
		'filter_items_list'     => __( 'Filter items list', 'text_domain' ),
	);
	$rewrite = array(
		'slug'                  => '',
		'with_front'            => false,
		'pages'                 => false,
		'feeds'                 => false,
	);
	$args = array(
		'label'                 => __( 'legal page', 'text_domain' ),
		'description'           => __( 'legal pages', 'text_domain' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor','template' ),

		'hierarchical'          => true,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
	
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => false,
		'menu_icon'             => 'dashicons-hammer',
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'rewrite'               => $rewrite,
		'capability_type'       => 'page',
		'show_in_rest'          => true,
	);

	
	register_post_type( 'legal', $args );

}
add_action( 'init', 'legal', 0 );

// Register Custom Post Type
function Landing_pages() {

	$labels = array(
		'name'                  => _x( 'Landing pages', 'Post Type General Name', 'text_domain' ),
		'singular_name'         => _x( 'Landing page', 'Post Type Singular Name', 'text_domain' ),
		'menu_name'             => __( 'Landing pages', 'text_domain' ),
		'name_admin_bar'        => __( 'Landing pages', 'text_domain' ),
		'archives'              => __( 'Item Archives', 'text_domain' ),
		'attributes'            => __( 'Item Attributes', 'text_domain' ),
		'parent_item_colon'     => __( 'Parent Item:', 'text_domain' ),
		'all_items'             => __( 'All Landing pages', 'text_domain' ),
		'add_new_item'          => __( 'Add New Landing page', 'text_domain' ),
		'add_new'               => __( 'Add New Landing page', 'text_domain' ),
		'new_item'              => __( 'New Landing page', 'text_domain' ),
		'edit_item'             => __( 'Edit Landing page', 'text_domain' ),
		'update_item'           => __( 'Update Landing page', 'text_domain' ),
		'view_item'             => __( 'View Landing page', 'text_domain' ),
		'view_items'            => __( 'View Landing pages', 'text_domain' ),
		'search_items'          => __( 'Search Landing pages', 'text_domain' ),
		'not_found'             => __( 'Not found', 'text_domain' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'text_domain' ),
		'featured_image'        => __( 'Featured Image', 'text_domain' ),
		'set_featured_image'    => __( 'Set featured image', 'text_domain' ),
		'remove_featured_image' => __( 'Remove featured image', 'text_domain' ),
		'use_featured_image'    => __( 'Use as featured image', 'text_domain' ),
		'insert_into_item'      => __( 'Insert into item', 'text_domain' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'text_domain' ),
		'items_list'            => __( 'Items list', 'text_domain' ),
		'items_list_navigation' => __( 'Items list navigation', 'text_domain' ),
		'filter_items_list'     => __( 'Filter items list', 'text_domain' ),
	);
	$rewrite = array(
		'slug'                  => 'lp',
		'with_front'            => false,
		'pages'                 => true,
		'feeds'                 => true,
	);
	$args = array(
		'label'                 => __( 'Landing page', 'text_domain' ),
		'description'           => __( 'Landing pages', 'text_domain' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'revisions' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-airplane',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => false,
		'exclude_from_search'   => true,
		'publicly_queryable'    => true,
		'rewrite'               => $rewrite,
		'capability_type'       => 'page',
		'show_in_rest'          => true,
	);



	register_post_type( 'Landing pages', $args );

}
add_action( 'init', 'Landing_pages', 0 );