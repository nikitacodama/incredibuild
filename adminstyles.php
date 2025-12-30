<?php 


/**
 * Registers an editor stylesheet for the theme.
 */
function wpdocs_theme_add_editor_styles() {
    add_editor_style( 'custom-editor-style.css' );
}
add_action( 'admin_init', 'wpdocs_theme_add_editor_styles' );


function custom_admin_css() {
    echo '<style>
        /* Change the background color of the admin menu */
        #adminmenu, 
        #adminmenu .wp-submenu, 
        #adminmenuback, 
        #adminmenuwrap {
            background-color: #171E37; /* Change this to your preferred shade of blue */
        }
        
        /* Change the color of menu item text */
        #adminmenu a {
            color: #ffffff; /* White text for contrast */
        }
        
        /* Change the color of the menu item hover state */
        #adminmenu li.menu-top:hover, 
        #adminmenu li.opensub > a.menu-top, 
        #adminmenu li.menu-top > a:focus {
            background-color: #145a8e; /* A darker shade of blue */
            color: #ffffff; /* White text for contrast */
        }
        
        /* Change the color of active menu item */
        #adminmenu .wp-has-current-submenu a.wp-has-current-submenu,
        #adminmenu .wp-has-current-submenu .wp-submenu .wp-submenu-head, 
        #adminmenu .current a.menu-top {
            background-color: #145a8e; /* A darker shade of blue */
            color: #ffffff; /* White text for contrast */
        }
			#adminmenu div.wp-menu-image:before {color:#1EFFAE;}
			#menu-dashboard {    border-bottom: 3px solid #0094FF !important;}
			#toplevel_page_footer { border-top: 3px solid #0094FF !important;}
    </style>';
}
add_action('admin_head', 'custom_admin_css');
