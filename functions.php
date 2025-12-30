<?php 

include_once "inc/template-functions.php";
include_once "inc/theme-setup.php";
include_once "inc/class-custom-menu-walker.php";
include_once "inc/acf-menu-fields.php";
include_once "inc/cpt-banner.php";

include_once "custompages.php";
include_once "usersnavsettings.php";
include_once "adminstyles.php";
include_once "taxonomies.php";
include_once "customcodes.php";
require get_template_directory() . '/options.php'; // Adjust the path as necessary


// Add this code in your functions.php
function add_stylesheet_to_head() {
    echo "<link href='".get_stylesheet_uri()."' rel='stylesheet' type='text/css'>";
}


function enqueue_roi_css() {
    // Replace 'your-page-slug' with the actual slug or use is_page(123) with the page ID
    if (is_page('roicalculator')) {
        wp_enqueue_style('roi-css', get_template_directory_uri() . '/roi_css.css');
    }
}
add_action('wp_enqueue_scripts', 'enqueue_roi_css');

add_action( 'wp_head', 'add_stylesheet_to_head' );



function add_custom_scripts() {
    // Add external script directly to the header
    echo '<script src="https://go.incredibuild.com/js/forms2/js/forms2.min.js"></script>';
    
    // Enqueue local scripts
    wp_enqueue_script('custom-theme-script', get_template_directory_uri() . '/js/munchkin.min.js', array(), null, false);
    wp_enqueue_script('your-script', get_template_directory_uri() . '/js/jquery-3.7.1.min.js', array('jquery'), null, true);
    wp_enqueue_script('master-script', get_template_directory_uri() . '/js/Master.js', array('jquery'), null, true); // Enqueue Master.js
}
add_action('wp_enqueue_scripts', 'add_custom_scripts');


// add event date field to events post type
// Add Meta Box
function add_post_meta_boxes() {
    // Meta box for "our_customers" post type
    add_meta_box(
        "post_metadata_events_post",
        "Header Title",
        "post_meta_box_events_post",
        "our_customers",
        "side",
        "low"
    );

    // Meta box for "news" post type
    add_meta_box(
        "post_metadata_news_post",
        "Type",
        "post_meta_box_news_post",
        "news",
        "side",
        "high"
    );
}
add_action("add_meta_boxes", "add_post_meta_boxes");

// Save Meta Box Value
// Save Meta Box Value
function save_post_meta_boxes($post_id) {
    if (!isset($_POST['post_meta_boxes_nonce']) || !wp_verify_nonce($_POST['post_meta_boxes_nonce'], 'save_post_meta_boxes_nonce')) {
        return $post_id;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return $post_id;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return $post_id;
    }

    // Update the meta fields
    if (isset($_POST["_header_title"])) {
        update_post_meta($post_id, "_header_title", sanitize_text_field($_POST["_header_title"]));
    }

    if (isset($_POST["_type"])) {
        update_post_meta($post_id, "_type", sanitize_text_field($_POST["_type"]));
    }
}
add_action('save_post', 'save_post_meta_boxes');



// Render Meta Box Fields for "news"
function post_meta_box_news_post() {
    global $post;
    $type = get_post_meta($post->ID, '_type', true);

    // Define dropdown options
    $options = array(
        '' => 'Select Type',
        'press' => 'Press',
        'news' => 'News',
        'educational' => 'Educational'
    );

    wp_nonce_field('save_post_meta_boxes_nonce', 'post_meta_boxes_nonce'); // Add nonce field for security

    echo '<select name="_type">';
    foreach ($options as $value => $label) {
        $selected = ($value === $type) ? ' selected="selected"' : '';
        echo '<option value="' . esc_attr($value) . '"' . $selected . '>' . esc_html($label) . '</option>';
    }
    echo '</select>';
}
// Render Meta Box Fields for "our_customers"
function post_meta_box_events_post() {
    global $post;
    $headerTitle = get_post_meta($post->ID, '_header_title', true);
    wp_nonce_field('save_post_meta_boxes_nonce', 'post_meta_boxes_nonce');
    echo "<input type=\"text\" name=\"_header_title\" value=\"" . esc_attr($headerTitle) . "\" placeholder=\"header title\">";
}

// Shortcode to display Header Title
function display_header_title_shortcode($atts) {
    if (is_singular('our_customers') && in_the_loop() && is_main_query()) {
        global $post;
        $header_title = get_post_meta($post->ID, '_header_title', true);
        if (!empty($header_title)) {
            return esc_html($header_title);
        }
    }
    return '';
}
add_shortcode('header_title', 'display_header_title_shortcode');







// Shortcode to display Type
function display_type_shortcode($atts) {
    if (is_singular('news') && in_the_loop() && is_main_query()) {
        global $post;
        $type = get_post_meta($post->ID, '_type', true);
        if (!empty($type)) {
            return esc_html($type);
        }
    }
    return '';
}
add_shortcode('type', 'display_type_shortcode');


function dynamic_mkto_form_shortcode($atts) {
    // Set default form id if not provided in the shortcode
    $atts = shortcode_atts( array(
        'form_id' => '1006',
    ), $atts );

    // The form ID from shortcode attribute
    $form_id = esc_attr($atts['form_id']);

    // The script and form HTML
    ob_start();
    ?>

    <form id="mktoForm_<?php echo $form_id; ?>" data-form="<?php echo $form_id; ?>" class="ibmk-form"></form>
    <script>
        MktoForms2.loadForm("https://go.incredibuild.com", "915-OAR-847", "<?php echo $form_id; ?>", function(form) {
            form.onSubmit(function() {
                var vals = form.vals();
                
                if (vals.mktoFullName) {
                    var fullnameString = vals.mktoFullName.trim();
                    
                    if (fullnameString) {
                        var fullnameSplit = fullnameString.split(' ');
                        var firstName = fullnameSplit[0];
                        fullnameSplit[0] = '';
                        var lastName = fullnameSplit.join(' ').trim();
                        
                        if (firstName) {
                            form.vals({ "FirstName": firstName });
                        }
                        if (lastName) {
                            form.vals({ "LastName": lastName });
                        }
                    }
                }
                
                return false;
            });
        });
    </script>
    <?php
    return ob_get_clean();
}

add_shortcode('dynamic_mkto_form', 'dynamic_mkto_form_shortcode');

add_action('wp_ajax_nopriv_get_license_key', '__return_false', 0);
add_action('wp_ajax_get_license_key', '__return_false', 0);

// Add meta box for Integrations post type
function integrations_custom_fields() {
    add_meta_box(
        'integrations_meta_box', // ID of the meta box
        'Integration Details', // Title of the meta box
        'integrations_meta_box_callback', // Callback function
        'integrations', // Post type
        'normal', // Context
        'high' // Priority
    );
}
add_action('add_meta_boxes', 'integrations_custom_fields');

// Callback function to display fields
function integrations_meta_box_callback($post) {
    // Retrieve current values
    $main_title = get_post_meta($post->ID, '_main_title', true);
    $box1_title = get_post_meta($post->ID, '_box1_title', true);
    $box1_text = get_post_meta($post->ID, '_box1_text', true);
    $box2_title = get_post_meta($post->ID, '_box2_title', true);
    $box2_text = get_post_meta($post->ID, '_box2_text', true);
    $box3_title = get_post_meta($post->ID, '_box3_title', true);
    $box3_text = get_post_meta($post->ID, '_box3_text', true);
    $docs_link = get_post_meta($post->ID, '_docs_link', true);
    $docs_link_text = get_post_meta($post->ID, '_docs_link_text', true);

    // Display fields
    ?>
    <p>
        <label for="main_title">Main Title</label>
        <input type="text" name="main_title" id="main_title" value="<?php echo esc_attr($main_title); ?>" class="widefat">
    </p>
    <p>
        <label for="box1_title">Box 1 Title</label>
        <input type="text" name="box1_title" id="box1_title" value="<?php echo esc_attr($box1_title); ?>" class="widefat">
    </p>
    <p>
        <label for="box1_text">Box 1 Text</label>
        <textarea name="box1_text" id="box1_text" rows="4" class="widefat"><?php echo esc_textarea($box1_text); ?></textarea>
    </p>
    <p>
        <label for="box2_title">Box 2 Title</label>
        <input type="text" name="box2_title" id="box2_title" value="<?php echo esc_attr($box2_title); ?>" class="widefat">
    </p>
    <p>
        <label for="box2_text">Box 2 Text</label>
        <textarea name="box2_text" id="box2_text" rows="4" class="widefat"><?php echo esc_textarea($box2_text); ?></textarea>
    </p>
    <p>
        <label for="box3_title">Box 3 Title</label>
        <input type="text" name="box3_title" id="box3_title" value="<?php echo esc_attr($box3_title); ?>" class="widefat">
    </p>
    <p>
        <label for="box3_text">Box 3 Text</label>
        <textarea name="box3_text" id="box3_text" rows="4" class="widefat"><?php echo esc_textarea($box3_text); ?></textarea>
    </p>
    <p>
        <label for="docs_link">Docs Link</label>
        <input type="url" name="docs_link" id="docs_link" value="<?php echo esc_url($docs_link); ?>" class="widefat">
    </p>
    <p>
        <label for="docs_link_text">Docs Link Text</label>
        <input type="text" name="docs_link_text" id="docs_link_text" value="<?php echo esc_attr($docs_link_text); ?>" class="widefat">
    </p>
    <?php
}

// Save meta box values
function save_integrations_custom_fields($post_id) {
    // Check if current user can edit the post
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    // Save each field
    $fields = ['main_title', 'box1_title', 'box1_text', 'box2_title', 'box2_text', 'box3_title', 'box3_text', 'docs_link', 'docs_link_text'];
    foreach ($fields as $field) {
        if (isset($_POST[$field])) {
            update_post_meta($post_id, "_$field", sanitize_text_field($_POST[$field]));
        }
    }
}
add_action('save_post', 'save_integrations_custom_fields');


// Generic function to display meta fields
function display_meta_shortcode($atts) {
    global $post;

    // Define the mapping of shortcode names to meta keys
    $meta_keys = [
        'main_title' => '_main_title',
        'box1_title' => '_box1_title',
        'box1_text' => '_box1_text',
        'box2_title' => '_box2_title',
        'box2_text' => '_box2_text',
        'box3_title' => '_box3_title',
        'box3_text' => '_box3_text',
        'docs_link' => '_docs_link',
        'docs_link_text' => '_docs_link_text',
    ];

    // Get the shortcode name from attributes, defaulting to an empty string
    $shortcode_name = isset($atts['name']) ? $atts['name'] : '';

    // Check if the requested shortcode name exists in the mapping
    if (array_key_exists($shortcode_name, $meta_keys)) {
        $meta_key = $meta_keys[$shortcode_name];

        // Special handling for docs link, combining link and text
        if ($meta_key === '_docs_link') {
            $docs_link = get_post_meta($post->ID, '_docs_link', true);
            $docs_link_text = get_post_meta($post->ID, '_docs_link_text', true);
            if (!empty($docs_link) && !empty($docs_link_text)) {
                return '<div class="wp-block-button line"><a class="wp-element-button" href="' . esc_url($docs_link) . '">' . esc_html($docs_link_text) . '</a></div>';
            }
        } 
        elseif ($meta_key === '_main_title'){
            $meta_value = get_post_meta($post->ID, $meta_key, true);
            if (!empty($meta_value)) {
                return '<h2 class="'. esc_html($meta_key) .'">' . esc_html($meta_value) . '</h2>';
            }
        }
        else {
            $meta_value = get_post_meta($post->ID, $meta_key, true);
            if (!empty($meta_value)) {
                return '<span class="'. esc_html($meta_key) .'">' . esc_html($meta_value) . '</span>';
            }
        }
    }

    return '';
}

// Register the shortcode for each field
add_shortcode('display_meta', 'display_meta_shortcode');


function custom_js_meta_box() {
    $post_types = get_post_types(['public' => true]); // Get all public post types

    foreach ($post_types as $post_type) {
        add_meta_box(
            'custom_js_meta_box_id',
            'Custom JavaScript',
            'custom_js_meta_box_callback',
            $post_type, // Add meta box to each post type
            'normal',
            'high'
        );
    }
}
add_action('add_meta_boxes', 'custom_js_meta_box');

function custom_js_meta_box_callback($post) {
    // Retrieve the custom JS meta value if it exists
    $custom_js = get_post_meta($post->ID, '_custom_js', true);

    // Display the textarea with the raw JavaScript content
    echo '<label for="custom_js_field">Enter Custom JavaScript:</label>';
    // Here we use htmlspecialchars_decode() to decode HTML entities like &lt;
    echo '<textarea style="width:100%; min-height:200px;" name="custom_js_field">' . htmlspecialchars_decode($custom_js) . '</textarea>';
}

function save_custom_js_meta_box($post_id) {
    // Check if the custom JS field is set in the POST data
    if (isset($_POST['custom_js_field'])) {
        // Save the raw JavaScript without converting characters like < into &lt;
        update_post_meta($post_id, '_custom_js', $_POST['custom_js_field']);
    }
}
add_action('save_post', 'save_custom_js_meta_box');


function output_custom_js() {
    if (is_singular()) {
        global $post;
        $custom_js = get_post_meta($post->ID, '_custom_js', true);
        if (!empty($custom_js)) {
            echo '<script>' . $custom_js . '</script>';
        }
    }
}
add_action('wp_footer', 'output_custom_js');

function mytheme_display_banner() {
    $current_language = pll_current_language();
    $show_banner = get_option("mytheme_show_banner_{$current_language}");

    // Define paths to exclude
    $excluded_paths = ['/news', '/pricing', '/free-trial', '/lp','/incredibuild-acquires-garden','/incredibuild-accelerates-end-to-end-software-development-with-garden-acquisition'];
    $current_url_path = $_SERVER['REQUEST_URI'];

    // Check if URL contains excluded paths
    $is_excluded_path = false;
    foreach ($excluded_paths as $path) {
        if (strpos($current_url_path, $path) !== false) {
            $is_excluded_path = true;
            break;
        }
    }

    // Check if the banner should be displayed
    if ($show_banner && !$is_excluded_path && !isset($_COOKIE['banner_closed'])) {
        $banner_title = get_option("mytheme_banner_title_{$current_language}");
        $banner_text = get_option("mytheme_banner_text_{$current_language}");
        $banner_image_url = get_option("mytheme_banner_image_url_{$current_language}");
        $banner_link_url = get_option("mytheme_banner_link_url_{$current_language}");
        $banner_link_text = get_option("mytheme_banner_link_text_{$current_language}");

        // Output banner HTML
        echo '<div class="theme-banner" id="site-banner" style="display: none;"><div class="theme-banner-popup">';
        echo '<h2>' . $banner_title . '</h2>';
        echo '<p>' . $banner_text . '</p>';
        if ($banner_image_url) {
            echo '<img src="' . esc_url($banner_image_url) . '" alt="Banner Image">';
        }
        if ($banner_link_url && $banner_link_text) {
            echo '<a class="ReadMore" href="' . esc_url($banner_link_url) . '">' . esc_html($banner_link_text) . '</a>';
        }
        echo '<button id="close-banner" style="position: absolute; top: 10px; left: 10px;">✖</button>';
        echo '</div></div>';

        // JavaScript to handle closing the banner and setting a cookie
        ?>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Check for 'banner_closed' cookie existence
                const bannerClosed = document.cookie.split('; ').find(row => row.startsWith('banner_closed='));

                // Debug: Log the cookie status
                console.log('Banner cookie detected on load:', bannerClosed ? bannerClosed : 'Not set');

                // Only show the banner if the 'banner_closed' cookie does not exist
                if (!bannerClosed) {
                    document.getElementById('site-banner').style.display = 'block';
                }

                // Close banner and set cookie on click
                document.getElementById('close-banner').onclick = function() {
                    const expirationDate = new Date();
                    expirationDate.setTime(expirationDate.getTime() + (7 * 24 * 60 * 60 * 1000)); // 1 week

                    // Set the cookie
                    document.cookie = "banner_closed=true; expires=" + expirationDate.toUTCString() + "; path=/";
                    console.log('Setting banner_closed cookie with expiration:', expirationDate.toUTCString());

                    // Hide the banner
                    document.getElementById('site-banner').style.display = 'none';
                };
            });
        </script>
        <?php
    }
}
add_action('wp_footer', 'mytheme_display_banner');

function mytheme_add_banner_to_header() {
    // Get the option values
    $show_top_banner = get_option("mytheme_show_top_banner_" . pll_current_language());
    $top_banner_content = get_option('mytheme_top_banner_content_' . pll_current_language());

    // Only output if the top banner is set to show
    if ($show_top_banner) {
        echo '<div id="top-banner">';
        echo wp_kses_post($top_banner_content); // Output the banner content safely
        echo '</div>';
    }
}
add_action('wp_head', 'mytheme_add_banner_to_header');

// Adjust this to be placed at the end of the header if required
function mytheme_add_banner_after_masthead() {
    ?>
    <script>
        // Move the top banner to the end of the masthead
        document.addEventListener('DOMContentLoaded', function () {
            var masthead = document.getElementById('masthead-n');
            var topBanner = document.getElementById('top-banner');
            if (masthead && topBanner) {
                masthead.appendChild(topBanner);
            }
        });
    </script>
    <?php
}
add_action('wp_footer', 'mytheme_add_banner_after_masthead');

function ziv_last_two_posts_shortcode() {
    $args = array(
        'post_type' => 'post',
        'posts_per_page' => 2,
    );
    $query = new WP_Query($args);
    $output = '';

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $image_url = get_the_post_thumbnail_url(get_the_ID(), 'post-thumbnail');
            $image_alt = get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', true) ?: get_the_title();
            $post_title = get_the_title();
            $permalink = get_permalink();

            $output .= '
            <li class="zivwashere">
                <a class="addon Blog" href="' . esc_url($permalink) . '">
                    <span>' . esc_html($post_title) . '</span>
                    <img width="800" height="533" src="' . esc_url($image_url) . '" class="attachment-post-thumbnail size-post-thumbnail wp-post-image" alt="' . esc_attr($image_alt) . '" decoding="async" sizes="(max-width: 800px) 100vw, 800px">
                </a>
            </li>';
        }
        wp_reset_postdata();
    }

    return $output;
}
add_shortcode('ziv_last_two_posts', 'ziv_last_two_posts_shortcode');


function enqueue_heading_slider_script() {
    wp_enqueue_script(
        'heading-slider',
        get_template_directory_uri() . '/js/heading-slider.js',
        array( 'wp-blocks', 'wp-dom-ready', 'wp-hooks' ),
        filemtime( get_template_directory() . '/js/heading-slider.js' ),
        true
    );
    
    wp_enqueue_script(
        'group-class-selector',
        get_template_directory_uri() . '/js/group-class-selector.js',
        array( 'wp-blocks', 'wp-dom-ready', 'wp-hooks' ),
        filemtime( get_template_directory() . '/js/group-class-selector.js' ),
        true
    );
}
add_action( 'enqueue_block_editor_assets', 'enqueue_heading_slider_script' );

/**
 * One-time migration: populate ACF "buttons" repeater for resources_library posts
 * based on the first PDF download link found in post content.
 */
function incredibuild_migrate_resources_library_buttons() {
    // Run only in admin and only once.
    if ( ! is_admin() ) {
        return;
    }

    // Option flag so this runs only a single time.
    if ( get_option( 'incredibuild_resources_library_buttons_migrated_2' ) ) {
        return;
    }

    // Make sure ACF is available.
    if ( ! function_exists( 'get_field' ) || ! function_exists( 'update_field' ) ) {
        return;
    }

    // Get all resources_library posts.
    $query = new WP_Query(
        array(
            'post_type'      => 'resources_library',
            'post_status'    => 'publish',
            'posts_per_page' => -1,
            'fields'         => 'ids',
        )
    );

    if ( ! $query->have_posts() ) {
        update_option( 'incredibuild_resources_library_buttons_migrated_2', 1 );
        return;
    }

    foreach ( $query->posts as $post_id ) {
        // If buttons already exist, skip this post.
        $existing_buttons = get_field( 'buttons', $post_id );
        if ( ! empty( $existing_buttons ) ) {
            continue;
        }

        $content = get_post_field( 'post_content', $post_id );

        if ( empty( $content ) ) {
            continue;
        }

        $pdf_url = '';

        // 1) Try to find a PDF link in a wp:file block.
        if (
            preg_match(
                '/<div[^>]*class="[^"]*wp-block-file[^"]*"[^>]*>.*?<a[^>]+href="([^"]+\.pdf)"[^>]*>/is',
                $content,
                $matches
            )
        ) {
            $pdf_url = $matches[1];
        } else {
            // 2) Fallback: any <a> tag with a .pdf href and "download" attribute.
            if (
                preg_match(
                    '/<a[^>]+href="([^"]+\.pdf)"[^>]*download[^>]*>/i',
                    $content,
                    $matches
                )
            ) {
                $pdf_url = $matches[1];
            }
        }

        // 3) Fallback for lazyblock/gatedwhitepaper "file" attribute in block comment.
        if ( empty( $pdf_url ) ) {
            if (
                preg_match(
                    '/"file"\s*:\s*"([^"]+\.pdf)"/i',
                    $content,
                    $matches
                )
            ) {
                $pdf_url = $matches[1];
            }
        }

        if ( empty( $pdf_url ) ) {
            // No PDF found in this post; skip.
            continue;
        }

        // Build ACF repeater structure for "buttons".
        $buttons = array(
            array(
                'type' => 'primary',
                'link' => array(
                    'url'    => esc_url_raw( $pdf_url ),
                    'title'  => 'Download',
                    'target' => '_blank',
                ),
            ),
        );

        // If your ACF field name is "buttons", this will work.
        // If you use field keys, replace 'buttons' with the field key like 'field_123abc...'.
        update_field( 'buttons', $buttons, $post_id );
    }

    // Mark migration as done so it won't run again.
    update_option( 'incredibuild_resources_library_buttons_migrated_2', 1 );
}
// add_action( 'init', 'incredibuild_migrate_resources_library_buttons' );

function pll_copy_menu_full($source_menu_slug, $target_menu_slug, $target_lang = 'ja') {

    if (!function_exists('pll_set_term_language')) {
        return;
    }

    // Get source menu
    $source_menu = wp_get_nav_menu_object($source_menu_slug);
    if (!$source_menu) return;

    // Create target menu if not exists
    $target_menu = wp_get_nav_menu_object($target_menu_slug);
    if (!$target_menu) {
        $menu_id = wp_create_nav_menu($target_menu_slug);
        pll_set_term_language($menu_id, $target_lang);
        $target_menu = wp_get_nav_menu_object($menu_id);
    }

    // Get items from source menu
    $items = wp_get_nav_menu_items($source_menu->term_id, ['orderby' => 'menu_order']);
    if (!$items) return;

    $item_map = []; // old_id => new_id

    foreach ($items as $item) {

        // Translate linked object if possible
        $object_id = $item->object_id;
        if ($item->type === 'post_type' && function_exists('pll_get_post')) {
            $translated = pll_get_post($item->object_id, $target_lang);
            if ($translated) {
                $object_id = $translated;
            }
        }

        // Prepare args
        $args = [
            'menu-item-object-id' => $object_id,
            'menu-item-object'    => $item->object,
            'menu-item-type'      => $item->type,
            'menu-item-title'     => $item->title,
            'menu-item-url'       => $item->url,
            'menu-item-description' => $item->description,
            'menu-item-attr-title'  => $item->attr_title,
            'menu-item-target'      => $item->target,
            'menu-item-classes'     => implode(' ', (array) $item->classes),
            'menu-item-xfn'         => $item->xfn,
            'menu-item-status'      => 'publish',
        ];

        // Parent mapping
        if ($item->menu_item_parent && isset($item_map[$item->menu_item_parent])) {
            $args['menu-item-parent-id'] = $item_map[$item->menu_item_parent];
        }

        // Create menu item
        $new_item_id = wp_update_nav_menu_item(
            $target_menu->term_id,
            0,
            $args
        );

        if (is_wp_error($new_item_id)) continue;

        $item_map[$item->ID] = $new_item_id;

        // ✅ COPY ACF FIELDS FROM MENU ITEM
        if (function_exists('get_fields')) {
            $acf_fields = get_fields($item->ID);
            if ($acf_fields) {
                foreach ($acf_fields as $key => $value) {
                    update_field($key, $value, $new_item_id);
                }
            }
        }
    }
}

add_action('admin_init', function () {
    pll_copy_menu_full('primary', 'primary___ja', 'ja');
});