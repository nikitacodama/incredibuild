<?php
/**
 * Theme Setup Functions
 * 
 * Sets up theme defaults and registers support for various WordPress features.
 * Similar to the _s (Underscore) theme setup.
 *
 * @package Incredibuild
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 */
function incredibuild_setup() {
    /*
     * Make theme available for translation.
     * Translations can be filed in the /languages/ directory.
     */
    load_theme_textdomain('incredibuild', get_template_directory() . '/languages');

    // Add default posts and comments RSS feed links to head.
    add_theme_support('automatic-feed-links');

    /*
     * Let WordPress manage the document title.
     * By adding theme support, we declare that this theme does not use a
     * hard-coded <title> tag in the document head, and expect WordPress to
     * provide it for us.
     */
    add_theme_support('title-tag');

    /*
     * Enable support for Post Thumbnails on posts and pages.
     *
     * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
     */
    add_theme_support('post-thumbnails');

    // Set default Post Thumbnail size.
    set_post_thumbnail_size(1200, 9999);

    // Register navigation menus.
    register_nav_menus(
        array(
            'primary' => esc_html__('Primary Menu', 'incredibuild'),
            'footer'  => esc_html__('Footer Menu', 'incredibuild'),
            'social'  => esc_html__('Social Links Menu', 'incredibuild'),
        )
    );

    /*
     * Switch default core markup for search form, comment form, and comments
     * to output valid HTML5.
     */
    add_theme_support(
        'html5',
        array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
            'style',
            'script',
        )
    );

    // Add theme support for selective refresh for widgets.
    add_theme_support('customize-selective-refresh-widgets');

    /**
     * Add support for core custom logo.
     *
     * @link https://codex.wordpress.org/Theme_Logo
     */
    add_theme_support(
        'custom-logo',
        array(
            'height'      => 250,
            'width'       => 250,
            'flex-width'  => true,
            'flex-height' => true,
        )
    );

    // Add support for Block Styles.
    add_theme_support('wp-block-styles');

    // Add support for full and wide align images.
    add_theme_support('align-wide');

    // Add support for editor styles.
    add_theme_support('editor-styles');

    // Enqueue editor styles.
    add_editor_style('custom-editor-style.css');

    // Add support for responsive embedded content.
    add_theme_support('responsive-embeds');

    // Add support for custom line height controls.
    add_theme_support('custom-line-height');

    // Add support for experimental link color control.
    add_theme_support('experimental-link-color');

    // Add support for custom units.
    add_theme_support('custom-units');

    // Add support for custom spacing.
    add_theme_support('custom-spacing');

    // Add support for Post Formats.
    add_theme_support(
        'post-formats',
        array(
            'aside',
            'image',
            'video',
            'quote',
            'link',
            'gallery',
            'audio',
        )
    );
}
add_action('after_setup_theme', 'incredibuild_setup');

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function incredibuild_content_width() {
    $GLOBALS['content_width'] = apply_filters('incredibuild_content_width', 1200);
}
add_action('after_setup_theme', 'incredibuild_content_width', 0);

/**
 * Register widget areas.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function incredibuild_widgets_init() {
    // Main Sidebar
    register_sidebar(
        array(
            'name'          => esc_html__('Sidebar', 'incredibuild'),
            'id'            => 'sidebar-1',
            'description'   => esc_html__('Add widgets here to appear in your sidebar.', 'incredibuild'),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        )
    );

    // Footer Widget Area 1
    register_sidebar(
        array(
            'name'          => esc_html__('Footer 1', 'incredibuild'),
            'id'            => 'footer-1',
            'description'   => esc_html__('Add widgets here to appear in your footer.', 'incredibuild'),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        )
    );

    // Footer Widget Area 2
    register_sidebar(
        array(
            'name'          => esc_html__('Footer 2', 'incredibuild'),
            'id'            => 'footer-2',
            'description'   => esc_html__('Add widgets here to appear in your footer.', 'incredibuild'),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        )
    );

    // Footer Widget Area 3
    register_sidebar(
        array(
            'name'          => esc_html__('Footer 3', 'incredibuild'),
            'id'            => 'footer-3',
            'description'   => esc_html__('Add widgets here to appear in your footer.', 'incredibuild'),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        )
    );

    // Footer Widget Area 4
    register_sidebar(
        array(
            'name'          => esc_html__('Footer 4', 'incredibuild'),
            'id'            => 'footer-4',
            'description'   => esc_html__('Add widgets here to appear in your footer.', 'incredibuild'),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        )
    );
}
add_action('widgets_init', 'incredibuild_widgets_init');

/**
 * Enqueue scripts and styles.
 */
function incredibuild_scripts() {
    // Enqueue Google Fonts or custom fonts here if needed
    
    // Enqueue theme stylesheet
    wp_enqueue_style('incredibuild-style', get_stylesheet_uri(), array(), wp_get_theme()->get('Version'));

    // Enqueue navigation script
    wp_enqueue_script('incredibuild-navigation', get_template_directory_uri() . '/js/navigation.js', array(), wp_get_theme()->get('Version'), true);

    // Add comment reply script
    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'incredibuild_scripts');

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function incredibuild_pingback_header() {
    if (is_singular() && pings_open()) {
        printf('<link rel="pingback" href="%s">', esc_url(get_bloginfo('pingback_url')));
    }
}
add_action('wp_head', 'incredibuild_pingback_header');

/**
 * Custom template tags for this theme.
 */
if (!function_exists('incredibuild_posted_on')) :
    /**
     * Prints HTML with meta information for the current post-date/time.
     */
    function incredibuild_posted_on() {
        $time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
        if (get_the_time('U') !== get_the_modified_time('U')) {
            $time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
        }

        $time_string = sprintf(
            $time_string,
            esc_attr(get_the_date(DATE_W3C)),
            esc_html(get_the_date()),
            esc_attr(get_the_modified_date(DATE_W3C)),
            esc_html(get_the_modified_date())
        );

        $posted_on = sprintf(
            /* translators: %s: post date. */
            esc_html_x('Posted on %s', 'post date', 'incredibuild'),
            '<a href="' . esc_url(get_permalink()) . '" rel="bookmark">' . $time_string . '</a>'
        );

        echo '<span class="posted-on">' . $posted_on . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    }
endif;

if (!function_exists('incredibuild_posted_by')) :
    /**
     * Prints HTML with meta information for the current author.
     */
    function incredibuild_posted_by() {
        $byline = sprintf(
            /* translators: %s: post author. */
            esc_html_x('by %s', 'post author', 'incredibuild'),
            '<span class="author vcard"><a class="url fn n" href="' . esc_url(get_author_posts_url(get_the_author_meta('ID'))) . '">' . esc_html(get_the_author()) . '</a></span>'
        );

        echo '<span class="byline"> ' . $byline . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    }
endif;

if (!function_exists('incredibuild_entry_footer')) :
    /**
     * Prints HTML with meta information for the categories, tags and comments.
     */
    function incredibuild_entry_footer() {
        // Hide category and tag text for pages.
        if ('post' === get_post_type()) {
            /* translators: used between list items, there is a space after the comma */
            $categories_list = get_the_category_list(esc_html__(', ', 'incredibuild'));
            if ($categories_list) {
                /* translators: 1: list of categories. */
                printf('<span class="cat-links">' . esc_html__('Posted in %1$s', 'incredibuild') . '</span>', $categories_list); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
            }

            /* translators: used between list items, there is a space after the comma */
            $tags_list = get_the_tag_list('', esc_html_x(', ', 'list item separator', 'incredibuild'));
            if ($tags_list) {
                /* translators: 1: list of tags. */
                printf('<span class="tags-links">' . esc_html__('Tagged %1$s', 'incredibuild') . '</span>', $tags_list); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
            }
        }

        if (!is_single() && !post_password_required() && (comments_open() || get_comments_number())) {
            echo '<span class="comments-link">';
            comments_popup_link(
                sprintf(
                    wp_kses(
                        /* translators: %s: post title */
                        __('Leave a Comment<span class="screen-reader-text"> on %s</span>', 'incredibuild'),
                        array(
                            'span' => array(
                                'class' => array(),
                            ),
                        )
                    ),
                    wp_kses_post(get_the_title())
                )
            );
            echo '</span>';
        }

        edit_post_link(
            sprintf(
                wp_kses(
                    /* translators: %s: Name of current post. Only visible to screen readers */
                    __('Edit <span class="screen-reader-text">%s</span>', 'incredibuild'),
                    array(
                        'span' => array(
                            'class' => array(),
                        ),
                    )
                ),
                wp_kses_post(get_the_title())
            ),
            '<span class="edit-link">',
            '</span>'
        );
    }
endif;

if (!function_exists('incredibuild_post_thumbnail')) :
    /**
     * Displays an optional post thumbnail.
     *
     * Wraps the post thumbnail in an anchor element on index views, or a div
     * element when on single views.
     */
    function incredibuild_post_thumbnail() {
        if (post_password_required() || is_attachment() || !has_post_thumbnail()) {
            return;
        }

        if (is_singular()) :
            ?>

            <div class="post-thumbnail">
                <?php the_post_thumbnail(); ?>
            </div><!-- .post-thumbnail -->

        <?php else : ?>

            <a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
                <?php
                the_post_thumbnail(
                    'post-thumbnail',
                    array(
                        'alt' => the_title_attribute(
                            array(
                                'echo' => false,
                            )
                        ),
                    )
                );
                ?>
            </a>

            <?php
        endif; // End is_singular().
    }
endif;

if (!function_exists('wp_body_open')) :
    /**
     * Shim for sites older than 5.2.
     *
     * @link https://core.trac.wordpress.org/ticket/12563
     */
    function wp_body_open() {
        do_action('wp_body_open');
    }
endif;

// Hide PHP warnings, notices, and deprecated messages
error_reporting(E_ERROR | E_PARSE);
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);

// // Optionally log errors to a file instead (recommended for debugging)
 ini_set('log_errors', 1);
 ini_set('error_log', get_template_directory() . '/debug.log');

/**
 * Determine whether Gutenberg should be disabled for a given post type.
 *
 * Relies on an ACF options field `disable_gutenberg` that contains a `cpt`
 * array of post type identifiers. Returns true only when the current post type
 * is listed there.
 *
 * @param string $post_type Post type slug.
 * @return bool True if the post type is configured to disable Gutenberg.
 */

 
function incredibuild_admin_styles() {
    ?>
    <style>
        table{
            height: auto !important;
        }
        /* Fix ACF field heights in admin */
        .acf-input .acf-input-prepend,
        .acf-input .acf-input-append,
        .acf-field-type-settings * {
          height: auto !important; 
        }
        
        /* Admin menu customization */
        #adminmenu,
        #adminmenu .wp-submenu,
        #adminmenuback,
        #adminmenuwrap {
            background-color: #171E37;
        }
        
        #adminmenu a {
            color: #ffffff;
        }
        
        #adminmenu div.wp-menu-image:before {
            color: #1EFFAE;
        }
    </style>
    <?php
}
add_action('admin_head', 'incredibuild_admin_styles');

/**
 * Get the post type for the current query context.
 *
 * @return string|null
 */
function incredibuild_get_current_post_type() {
    $post_type = get_post_type();

    if ( $post_type ) {
        return $post_type;
    }

    global $post;

    if ( $post instanceof WP_Post ) {
        return $post->post_type;
    }

    $queried_object = get_queried_object();

    if ( $queried_object instanceof WP_Post ) {
        return $queried_object->post_type;
    }

    return null;
}

/**
 * Decide whether default theme assets should be disabled for this request.
 *
 * Default assets are turned off for the flexible page template and for any
 * singular post types that are listed in the `disable_gutenberg > cpt`
 * option (configured via ACF).
 *
 * @return bool
 */

/**
 * Get the page ID configured for a CPT archive in ACF
 *
 * @param string|null $post_type Optional. Post type to check. If not provided, gets from current query.
 * @return int|null Page ID if found, null otherwise
 */
function incredibuild_get_archive_flexible_page_id( $post_type = null ) {
	if ( ! function_exists( 'get_field' ) ) {
		return null;
	}

	// Get current post type if not provided
	if ( empty( $post_type ) ) {
		// On archive pages, get_post_type() might return the wrong type if global $post is set
		// So we check query vars first, then main query
		$post_type = get_query_var( 'post_type' );
		
		if ( empty( $post_type ) ) {
			global $wp_query;
			if ( isset( $wp_query->query_vars['post_type'] ) && ! empty( $wp_query->query_vars['post_type'] ) ) {
				$post_type = $wp_query->query_vars['post_type'];
			} elseif ( is_post_type_archive() && isset( $wp_query->queried_object->name ) ) {
				$post_type = $wp_query->queried_object->name;
			} else {
				// Last resort: try get_post_type() but only if we're not on an archive
				if ( ! is_archive() ) {
					$post_type = get_post_type();
				}
			}
		}
	}

	if ( empty( $post_type ) ) {
		return null;
	}

	// Get raw ACF data directly to avoid have_rows() ordering issues
	$archive_cpt_data = get_field( 'archive_cpt', 'option' );
	
	if ( empty( $archive_cpt_data ) || ! is_array( $archive_cpt_data ) ) {
		return null;
	}

	// Loop through repeater rows using raw array data
	foreach ( $archive_cpt_data as $row ) {
		if ( ! isset( $row['cpt'] ) || ! isset( $row['page'] ) ) {
			continue;
		}

		// Get CPT array field
		$cpt_list = $row['cpt'];

		// Normalize CPT list to array
		if ( empty( $cpt_list ) ) {
			continue;
		} elseif ( ! is_array( $cpt_list ) ) {
			$cpt_list = array( $cpt_list );
		}

		// Check if current CPT matches
		if ( in_array( $post_type, $cpt_list, true ) ) {
			// Get page field (could be ID, post object, or array)
			$page_field = $row['page'];
			
			if ( ! empty( $page_field ) ) {
				// Handle different return formats
				if ( is_array( $page_field ) && isset( $page_field['ID'] ) ) {
					$page_id = (int) $page_field['ID'];
				} elseif ( is_object( $page_field ) && isset( $page_field->ID ) ) {
					$page_id = (int) $page_field->ID;
				} else {
					$page_id = (int) $page_field;
				}
				
				// Verify page exists and is published
				$page = get_post( $page_id );
				if ( $page && 'publish' === $page->post_status && 'page' === $page->post_type ) {
					return $page_id;
				}
			}
		}
	}

	return null;
}

/**
 * Handle CPT archive template loading based on ACF configuration
 *
 * @param string $template Current template path
 * @return string Template path
 */
function handle_cpt_archive_template( $template = '' ) {
	// Only run on frontend, not admin
	if ( is_admin() ) {
		return $template;
	}

    if( !is_archive() ) {
        return $template;
    }

	// Get matched page ID using the separate function
	$matched_page_id = incredibuild_get_archive_flexible_page_id();

	// If we found a matching page, load the flexible page template
	if ( ! empty( $matched_page_id ) ) {
		// Set page_id in query vars so flexible-page.php can use it
		set_query_var( 'page_id', $matched_page_id );
		
		// Set global post to the matched page
		global $post;
		$post = get_post( $matched_page_id );
		setup_postdata( $post );

		// Get the flexible-page.php template path
		$flexible_template = locate_template( array( 'page-templates/flexible-page.php' ) );
		
		if ( ! empty( $flexible_template ) ) {
			return $flexible_template;
		}
	}

	return $template;
}
add_filter( 'template_include', 'handle_cpt_archive_template', 99 );


function incredibuild_is_archive_using_flexible_page() {
	// Only check on post type archives
	if ( ! is_post_type_archive() ) {
		return false;
	}

	// Use the separate function to get the page ID
	$page_id = incredibuild_get_archive_flexible_page_id();

	// Return true if a valid page ID was found
	return ! empty( $page_id );
}

function incredibuild_should_disable_default_assets() {

    if ( is_page_template( 'page-templates/flexible-page.php' ) || is_page_template( 'page-templates/default-page.php' ) || is_page_template( 'page-templates/fetch-page.php' ) ) {
        return true;
    }

	// Check if current CPT archive is using flexible-page template
	if ( incredibuild_is_archive_using_flexible_page() ) {
		return true;
	}


    if ( ! function_exists( 'incredibuild_is_gutenberg_disabled_for_post_type' ) ) {
        return false;
    }


    $post_type = incredibuild_get_current_post_type();


    if ( ! $post_type ) {
        return false;
    }

    return incredibuild_is_gutenberg_disabled_for_post_type( $post_type );
}

/**
 * Enqueue styles and scripts ONLY for flexible page template
 */
function incredibuild_enqueue_assets() {

    // if ( ! incredibuild_should_disable_default_assets() ) {
    //     return;
    // }

    // Dequeue all other theme styles first
    wp_dequeue_style('wp-block-library');
    wp_dequeue_style('wp-block-library-theme');
    wp_dequeue_style('wc-block-style');
    wp_dequeue_style('global-styles');
    
    wp_enqueue_style(
        'incredibuild-owl-carousel-css',
        get_template_directory_uri() . '/assets/libs/OwlCarousel/dist/assets/owl.carousel.css',
        array(),
        filemtime(get_template_directory() . '/assets/libs/OwlCarousel/dist/assets/owl.carousel.css')
    );

        // Enqueue Select2 globally for use across all templates
    wp_enqueue_style(
        'select2',
        'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css',
        array(),
        '4.1.0'
    );

    // Enqueue ONLY our custom CSS files
    wp_enqueue_style(
        'incredibuild-default',
        get_template_directory_uri() . '/assets/css/default.css',
        array(),
        filemtime(get_template_directory() . '/assets/css/default.css')
    );
    
    wp_enqueue_style(
        'incredibuild-style-custom',
        get_template_directory_uri() . '/assets/css/style.css',
        array('incredibuild-default'),
        filemtime(get_template_directory() . '/assets/css/style.css')
    );
    
    // Fonts are included in default.css, no need for separate fonts.css
    wp_enqueue_script(
        'incredibuild-owl-carousel-js',
        get_template_directory_uri() . '/assets/libs/OwlCarousel/dist/owl.carousel.min.js',
        array('jquery'),
        filemtime(get_template_directory() . '/assets/libs/OwlCarousel/dist/owl.carousel.min.js'),
        true
    );

        wp_enqueue_script(
        'select2',
        'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js',
        array( 'jquery' ),
        '4.1.0',
        true
    );

        wp_enqueue_script(
        'incredibuild-cpt-list-filters',
        get_template_directory_uri() . '/assets/scripts/cpt-list-with-filters.js',
        array( 'jquery', 'select2' ),
        filemtime( get_template_directory() . '/assets/scripts/cpt-list-with-filters.js' ),
        true
    );
    

    // Enqueue JavaScript
    wp_enqueue_script(
        'incredibuild-scripts',
        get_template_directory_uri() . '/assets/scripts/scripts.js',
        array('jquery', 'select2'),
        filemtime(get_template_directory() . '/assets/scripts/scripts.js'),
        true
    );
}
add_action('wp_enqueue_scripts', 'incredibuild_enqueue_assets', 100);

/**
 * Prevent WordPress from auto-loading theme style.css on flexible page
 */
function incredibuild_remove_default_stylesheet() {
    if ( ! incredibuild_should_disable_default_assets() ) {
        return;
    }

    // Remove the default WordPress theme stylesheet
    add_filter('stylesheet_uri', '__return_false');
    
    // Also filter the HTML output to remove style.css link
    add_filter('style_loader_tag', 'incredibuild_remove_style_css_tag', 10, 2);
}
add_action('wp_enqueue_scripts', 'incredibuild_remove_default_stylesheet', 1);

/**
 * Remove style.css link tag from HTML output
 */
function incredibuild_remove_style_css_tag($html, $handle) {
    if ( ! incredibuild_should_disable_default_assets() ) {
        return $html;
    }

    // Remove any link that points to the root style.css
    if (strpos($html, '/themes/incredibuild_24/style.css') !== false) {
        return '';
    }
    return $html;
}

/**
 * Remove all WordPress default styles and scripts from flexible template
 */
function incredibuild_dequeue_default_styles() {
    if ( ! incredibuild_should_disable_default_assets() ) {
        return;
    }

    // Remove WordPress default styles
    wp_dequeue_style('wp-block-library');
    wp_dequeue_style('wp-block-library-theme');
    wp_dequeue_style('wc-blocks-style');
    wp_dequeue_style('global-styles');
 
    wp_dequeue_style('classic-theme-styles');
    
    // Remove the main theme stylesheet
    remove_action('wp_enqueue_scripts', 'incredibuild_24_styles');
    
    // Also try to dequeue by common handle names
    wp_dequeue_style('incredibuild_24');
    wp_dequeue_style('theme-style');
    
    // Remove emoji scripts
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('wp_print_styles', 'print_emoji_styles');
}
add_action('wp_enqueue_scripts', 'incredibuild_dequeue_default_styles', 999);

/**
 * Remove other theme styles from flexible template (if they exist)
 */
function incredibuild_clean_flexible_template_styles() {
    if ( ! incredibuild_should_disable_default_assets() ) {
        return;
    }

    // Remove old theme styles if they're loaded
    wp_dequeue_style('incredibuild_24-style');
    wp_dequeue_style('style');
    wp_dequeue_style('oldcss');
    wp_dequeue_style('style_2024');
    wp_dequeue_style('style_old');
    wp_dequeue_style('style2.0');
    wp_dequeue_style('helpers');
    wp_dequeue_style('roi_css');
    wp_dequeue_style('slick2');
}
add_action('wp_enqueue_scripts', 'incredibuild_clean_flexible_template_styles', 9999);

 function incredibuild_is_gutenberg_disabled_for_post_type( $post_type ) {
    if ( empty( $post_type ) || ! function_exists( 'get_field' ) ) {
        return false;
    }


    $field_value = get_field( 'disable_gutenberg', 'option' );

    if ( empty( $field_value ) || ! is_array( $field_value ) ) {
        return false;
    }

    $cpt_list = $field_value['cpt'] ?? $field_value;

    if ( ! is_array( $cpt_list ) ) {
        return false;
    }

    $normalized = array();

    foreach ( $cpt_list as $item ) {
        $value = null;

        if ( is_string( $item ) && $item !== '' ) {
            $value = $item;
        } elseif ( is_array( $item ) ) {
            if ( isset( $item['value'] ) && is_string( $item['value'] ) ) {
                $value = $item['value'];
            } elseif ( isset( $item['post_type'] ) && is_string( $item['post_type'] ) ) {
                $value = $item['post_type'];
            }
        }

        if ( null === $value ) {
            continue;
        }

        $value     = sanitize_key( $value );
        $candidate = $value;

        if ( ! post_type_exists( $candidate ) && str_ends_with( $candidate, 's' ) ) {
            $singular = rtrim( $candidate, 's' );
            if ( post_type_exists( $singular ) ) {
                $candidate = $singular;
            }
        }

        if ( post_type_exists( $candidate ) ) {
            $normalized[] = $candidate;
        }
    }

    return in_array( $post_type, $normalized, true );
}

/**
 * Force selected custom post types to use classic PHP templates instead of block templates.
 *
 * When a post type is included in the ACF option `disable_gutenberg > cpt`,
 * the template resolution will bypass theme JSON/block templates and fall back to
 * PHP templates such as `single-{post_type}.php` or, as a last resort, `single.php`.
 */
function incredibuild_use_php_single_templates( $template ) {
    if ( ! is_singular() || is_page_template( 'page-templates/flexible-page.php' || is_page_template( 'page-templates/fetch-page.php' ) ) ) {
        return $template;
    }

    $post_type = get_post_type();

    if ( ! $post_type || ! incredibuild_is_gutenberg_disabled_for_post_type( $post_type ) ) {
        return $template;
    }

    $php_template = locate_template(
        array(
            "single-{$post_type}.php",
            'single.php',
        )
    );

    return $php_template ? $php_template : $template;
}
add_filter( 'template_include', 'incredibuild_use_php_single_templates', 99 );

/**
 * Force use of header.php and footer.php for all pages
 * Disables block templates and ensures PHP templates are used
 */
function incredibuild_force_php_templates( $template ) {
	// Don't interfere with admin or specific templates
	if ( is_admin() || is_page_template( 'page-templates/flexible-page.php' ) || is_page_template( 'page-templates/fetch-page.php' ) ) {
		return $template;
	}

	// For pages, force use of page.php instead of block templates
	if ( is_page() ) {
		$page_template = locate_template( array( 'page.php' ) );
		if ( $page_template ) {
			return $page_template;
		}
	}

	// For posts and other singular items, ensure single.php is used
	if ( is_singular() && ! is_page() ) {
		$post_type = get_post_type();
		$single_template = locate_template( array( "single-{$post_type}.php", 'single.php' ) );
		if ( $single_template ) {
			return $single_template;
		}
	}

	// For archives, ensure archive templates are used
	if ( is_archive() ) {
		$post_type = get_post_type();
		$archive_template = locate_template( array( "archive-{$post_type}.php", 'archive.php' ) );
		if ( $archive_template ) {
			return $archive_template;
		}
	}

	return $template;
}


/**
 * Disable block templates and force PHP templates
 * This prevents WordPress from using block templates (HTML files in templates/ folder)
 */
function incredibuild_disable_block_templates() {
	// Remove support for block templates to force PHP templates
	if ( current_theme_supports( 'block-templates' ) ) {
		remove_theme_support( 'block-templates' );
	}
}


/**
 * Override block template resolution to prefer PHP templates
 */
function incredibuild_prefer_php_templates( $template ) {
	// Don't interfere with admin or specific templates
	if ( is_admin() || is_page_template( 'page-templates/flexible-page.php' ) ) {
		return $template;
	}

	// Check if current template is a block template (HTML file)
	$template_file = get_page_template_slug();
	if ( ! empty( $template_file ) && strpos( $template_file, '.html' ) !== false ) {
		// Force use of PHP template instead
		if ( is_page() ) {
			$php_template = locate_template( array( 'page.php' ) );
			if ( $php_template ) {
				return $php_template;
			}
		}
	}

	return $template;
}


/**
 * Prevent block templates from being used
 * Forces WordPress to use PHP templates which call get_header() and get_footer()
 */
function incredibuild_prevent_block_templates( $template ) {
	// If WordPress is trying to use a block template (HTML file), force PHP template
	if ( ! empty( $template ) && strpos( $template, '.html' ) !== false ) {
		// For pages, use page.php
		if ( is_page() ) {
			$php_template = locate_template( array( 'page.php' ) );
			if ( $php_template ) {
				return $php_template;
			}
		}
		// For single posts
		if ( is_singular() && ! is_page() ) {
			$post_type = get_post_type();
			$php_template = locate_template( array( "single-{$post_type}.php", 'single.php' ) );
			if ( $php_template ) {
				return $php_template;
			}
		}
		// For archives
		if ( is_archive() ) {
			$post_type = get_post_type();
			$php_template = locate_template( array( "archive-{$post_type}.php", 'archive.php' ) );
			if ( $php_template ) {
				return $php_template;
			}
		}
	}
	return $template;
}

add_action( 'after_setup_theme', 'incredibuild_disable_block_templates', 20 );
add_filter( 'template_include', 'incredibuild_prefer_php_templates', 5 );
add_filter( 'template_include', 'incredibuild_force_php_templates', 10 );
add_filter( 'template_include', 'incredibuild_prevent_block_templates', 1 );

add_filter( 'body_class', function( $classes ) {
    if ( ! empty( $GLOBALS['is_gutenberg_body'] ) ) {
        $classes[] = 'gutenberg_body';
    }
    return $classes;
});
