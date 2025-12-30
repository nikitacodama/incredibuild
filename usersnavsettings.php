<?php 

function remove_menus() {
	if( current_user_can( 'editor' ) ){
        remove_menu_page( 'tools.php' );
        remove_menu_page( 'profile.php' );
		remove_menu_page( 'edit-comments.php' );
		}
}
add_action( 'admin_menu', 'remove_menus' );