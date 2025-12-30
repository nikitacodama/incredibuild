<?php
/**
 * Template part for displaying menu loop item
 *
 * @package Incredibuild
 */

// Get the post ID from args
$post_id = isset($args['post_id']) ? $args['post_id'] : 0;

if (!$post_id) {
    return;
}

// Get post data
$post = get_post($post_id);

if (!$post) {
    return;
}

// Get featured image
$thumbnail_id = get_post_thumbnail_id($post_id);
$thumbnail_url = $thumbnail_id ? wp_get_attachment_image_url($thumbnail_id, 'medium') : get_template_directory_uri() . '/assets/images/placeholder.jpg';
$thumbnail_alt = $thumbnail_id ? get_post_meta($thumbnail_id, '_wp_attachment_image_alt', true) : '';

// Get permalink
$permalink = get_permalink($post_id);
$title = get_the_title($post_id);
?>

<a href="<?php echo esc_url($permalink); ?>" class="menu_loop-item flex align_st gap_24">
        <div class="menu_loop-item-image flex_auto">
            <img src="<?php echo esc_url($thumbnail_url); ?>" alt="<?php echo esc_attr($thumbnail_alt ?: $title); ?>" />
</div>
    
    <div class="menu_loop-item-content flex dir_col gap_12">
        <h3 class="menu_loop-item-title">
                <?php echo esc_html($title); ?>
        </h3>
        
        <div class="menu_loop-item-link button_uppercase green arrow_r">
            <?php esc_html_e('Read More', 'incredibuild'); ?>
</div>
    </div>
</a>

