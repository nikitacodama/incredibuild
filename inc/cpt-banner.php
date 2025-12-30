<?php
/**
 * CPT Banner Shortcodes + Admin helpers
 *
 * Adds a shortcode for banner custom post type entries and exposes the
 * generated shortcode inside the edit screen and the list table.
 *
 * @package Incredibuild
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

/**
 * Attempt to detect the banner CPT slug.
 *
 * @return string|false
 */
function incredibuild_get_banner_post_type() {
    static $post_type = null;

    if ( null !== $post_type ) {
        return $post_type;
    }

    $post_type = apply_filters( 'incredibuild_banner_post_type', '' );

    if ( $post_type && post_type_exists( $post_type ) ) {
        return $post_type;
    }

    $candidates = array( 'banner', 'banners', 'cpt-banner', 'cpt_banner', 'banner_item' );

    foreach ( $candidates as $candidate ) {
        if ( post_type_exists( $candidate ) ) {
            $post_type = $candidate;
            return $post_type;
        }
    }

    $objects = get_post_types(
        array(
            'public'   => true,
            '_builtin' => false,
        ),
        'objects'
    );

    foreach ( $objects as $slug => $object ) {
        if ( false !== stripos( $slug, 'banner' ) || ( isset( $object->labels->name ) && false !== stripos( $object->labels->name, 'banner' ) ) ) {
            $post_type = $slug;
            return $post_type;
        }
    }

    $post_type = false;

    return $post_type;
}

/**
 * Shortcode tag used for rendering banners.
 *
 * @return string
 */
function incredibuild_get_banner_shortcode_tag() {
    return apply_filters( 'incredibuild_banner_shortcode_tag', 'cpt_banner' );
}

/**
 * Helper to generate the shortcode string for a given banner post.
 *
 * @param int $post_id Post ID.
 *
 * @return string
 */
function incredibuild_get_banner_shortcode_string( $post_id ) {
    $tag = incredibuild_get_banner_shortcode_tag();

    return sprintf( '[%s id="%d"]', $tag, absint( $post_id ) );
}

/**
 * Register shortcode and admin integrations once the post type is available.
 */
function incredibuild_bootstrap_banner_shortcode_features() {
    $post_type = incredibuild_get_banner_post_type();

    if ( ! $post_type ) {
        return;
    }

    add_shortcode( incredibuild_get_banner_shortcode_tag(), 'incredibuild_render_banner_shortcode' );

    add_action( 'add_meta_boxes', 'incredibuild_register_banner_shortcode_metabox' );

    add_filter( "manage_edit-{$post_type}_columns", 'incredibuild_add_banner_shortcode_column' );
    add_action( "manage_{$post_type}_posts_custom_column", 'incredibuild_render_banner_shortcode_column', 10, 2 );
}
add_action( 'init', 'incredibuild_bootstrap_banner_shortcode_features' );

/**
 * Render shortcode output.
 *
 * @param array $atts Shortcode attributes.
 *
 * @return string
 */
function incredibuild_render_banner_shortcode( $atts ) {
    if ( ! function_exists( 'get_field' ) ) {
        return '';
    }

    $post_type = incredibuild_get_banner_post_type();

    if ( ! $post_type ) {
        return '';
    }

    $defaults = array( 'id' => 0 );
    $atts     = shortcode_atts( $defaults, $atts, incredibuild_get_banner_shortcode_tag() );
    $post_id  = absint( $atts['id'] );

    if ( ! $post_id ) {
        global $post;

        if ( $post instanceof WP_Post && $post->post_type === $post_type ) {
            $post_id = $post->ID;
        }
    }

    if ( ! $post_id || $post_type !== get_post_type( $post_id ) ) {
        return '';
    }

    $title         = get_field( 'title', $post_id );
    $subtitle      = get_field( 'subtitle', $post_id );
    $text          = get_field( 'text', $post_id );
    $buttons       = get_field( 'buttons', $post_id );
    $image         = get_field( 'image', $post_id );
    $image_mobile  = get_field( 'image_mobile', $post_id );
    $banner_view   = get_field( 'banner_view', $post_id );
    $banner_style   = get_field( 'banner_style', $post_id );
    $image_position = get_field( 'image_position', $post_id );

    ob_start();
    ?>

    <?php 
    get_template_part( 'page-templates/banner/banner-' . $banner_view , null, 
    array( 'title' => $title, 
            'text' => $text, 
            'buttons' => $buttons, 
            'subtitle' => $subtitle,
            'image' => $image, 
            'image_mobile' => $image_mobile, 
            'banner_view' => $banner_view,
            'banner_style' => $banner_style,
            'image_position' => $image_position,
            ) ); ?>
    <?php
    return ob_get_clean();
}

/**
 * Register meta box on banner edit screen.
 */
function incredibuild_register_banner_shortcode_metabox() {
    $post_type = incredibuild_get_banner_post_type();

    if ( ! $post_type ) {
        return;
    }

    add_meta_box(
        'incredibuild-banner-shortcode',
        __( 'Banner Shortcode', 'incredibuild' ),
        'incredibuild_render_banner_shortcode_metabox',
        $post_type,
        'side',
        'high'
    );
}

/**
 * Display shortcode meta box.
 *
 * @param WP_Post $post Current post object.
 */
function incredibuild_render_banner_shortcode_metabox( $post ) {
    $shortcode = incredibuild_get_banner_shortcode_string( $post->ID );
    ?>
    <p><?php esc_html_e( 'Use the shortcode below to embed this banner.', 'incredibuild' ); ?></p>
    <input type="text" class="widefat" readonly value="<?php echo esc_attr( $shortcode ); ?>" onclick="this.select();" />
    <p><small><?php esc_html_e( 'Click the field to select the shortcode and copy it.', 'incredibuild' ); ?></small></p>
    <?php
}

/**
 * Add shortcode column to the banner list table.
 *
 * @param array $columns Existing columns.
 *
 * @return array
 */
function incredibuild_add_banner_shortcode_column( $columns ) {
    $columns['banner_shortcode'] = __( 'Shortcode', 'incredibuild' );

    return $columns;
}

/**
 * Render shortcode column content.
 *
 * @param string $column  Column name.
 * @param int    $post_id Post ID.
 */
function incredibuild_render_banner_shortcode_column( $column, $post_id ) {
    if ( 'banner_shortcode' !== $column ) {
        return;
    }

    echo '<code>' . esc_html( incredibuild_get_banner_shortcode_string( $post_id ) ) . '</code>';
}


