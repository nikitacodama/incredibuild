<?php 
/**
 * Loop item for integrations
 * Displays as link if post has content, otherwise as div
 */

$image_url = get_the_post_thumbnail_url(get_the_ID(), 'thumbnail');
$post_link = get_permalink();
$post_title = get_the_title();
$post_content = get_the_content();

// Check if post has content (determines if clickable)
$has_content = !empty(trim(strip_tags($post_content)));
$has_link = $has_content && !empty($post_link);

// Use <a> if has content, otherwise <div>
$tag = $has_content ? 'a' : 'div';
$href_attr = $has_content ? ' href="' . esc_url($post_link) . '" tabindex="0"' : '';
?>

<<?php echo $tag; ?> class="cpt_list-item td_n flex dir_col align_c justify_fs gap_12" <?php echo $href_attr; ?>>
    <?php if ($image_url) : ?>
        <div class="cpt_list-item-icon flex align_c justify_c">
        <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($post_title); ?>">
        </div>
    <?php endif; ?>
    <div class="cpt_list-item-title white fz_18 td_n"><?php echo esc_html($post_title); ?></div>
</<?php echo $tag; ?>>