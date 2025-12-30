<?php

$title = get_sub_field('title');
$text = get_sub_field('text');
$image = get_sub_field('image');
$image_mobile = get_sub_field('image_mobile');
$buttons = get_sub_field('buttons');
$enable_logo_animation = get_sub_field('enable_logo_animation');

// Build static logo animation images from theme folder instead of ACF.
$static_block_logo_animation = array();
$icons_dir = get_template_directory() . '/assets/images/integrations';
$icons_url = get_template_directory_uri() . '/assets/images/integrations';

if ( is_dir( $icons_dir ) ) {
    $icon_files = glob( $icons_dir . '/*.{png,jpg,jpeg,svg,gif}', GLOB_BRACE );

    if ( ! empty( $icon_files ) ) {
        foreach ( $icon_files as $icon_file ) {
            $file_name = basename( $icon_file );
            $static_block_logo_animation[] = array(
                'url' => $icons_url . '/' . $file_name,
                'alt' => pathinfo( $file_name, PATHINFO_FILENAME ),
                'filename' => $file_name,
            );
        }
        
        // Sort by filename (icon-1, icon-2, etc.)
        usort( $static_block_logo_animation, function( $a, $b ) {
            return strnatcasecmp( $a['filename'], $b['filename'] );
        } );
    }
}
?>

<section class="title_text_cta_center flex align_c justify_c">
    <?php if($image && !$enable_logo_animation): ?>
        <div class="title_text_cta_center-image">
            <picture>
                <source srcset="<?php echo $image['url']; ?>" media="(min-width: 768px)">
                <img src="<?php echo $image_mobile['url']; ?>" alt="<?php echo $image_mobile['alt']; ?>" class="title_text_cta_center-image-mobile">
            </picture>
        </div>
    <?php endif; ?>
    <div class="title_text_cta_center-grid hpblock grid container">
    <?php if ( $enable_logo_animation && ! empty( $static_block_logo_animation ) && is_array( $static_block_logo_animation ) ) : ?>
        <?php
        // Distribute logos: top and bottom get 1 more than left and right
        $total_logos = count( $static_block_logo_animation );
        $base_count = floor( ( $total_logos - 2 ) / 4 ); // Base for left/right (subtract 2 for top/bottom extras)
        $remaining = $total_logos - ( 2 * $base_count );
        
        // Calculate distribution
        $left_count = $base_count;
        $right_count = $base_count;
        $top_count = ceil( $remaining / 2 ); // Top gets more
        $bottom_count = $remaining - $top_count; // Bottom gets the rest
        
        // Split into blocks
        $logo_blocks = array(
            array_slice( $static_block_logo_animation, 0, $top_count ), // Top
            array_slice( $static_block_logo_animation, $top_count, $left_count ), // Left
            array_slice( $static_block_logo_animation, $top_count + $left_count, $right_count ), // Right
            array_slice( $static_block_logo_animation, $top_count + $left_count + $right_count, $bottom_count ), // Bottom
        );
        
        $block_classes = array( 'intIconsTop', 'intIconsLeft hideMobile', 'intIconsRight hideMobile', 'intIconsBottom' );
        ?>
            <?php foreach ( $logo_blocks as $block_index => $logo_block ) : ?>
                <div class="<?php echo esc_attr( $block_classes[ $block_index ] ); ?> intIcons title_text_cta_center-logo_animation-block title_text_cta_center-logo_animation-block-<?php echo esc_attr( $block_index + 1 ); ?>">
                    <?php foreach ( $logo_block as $logo ) : ?>
                        <?php
                        $logo_url = isset( $logo['url'] ) ? $logo['url'] : '';
                        $logo_alt = isset( $logo['alt'] ) ? $logo['alt'] : '';
                        if ( ! $logo_url ) {
                            continue;
                        }
                        ?>
                        <div class="title_text_cta_center-logo_animation-item">
                            <img src="<?php echo esc_url( $logo_url ); ?>" alt="<?php echo esc_attr( $logo_alt ); ?>">
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>
    <?php endif; ?>
    <div class="intIconsCenter intIcons title_text_cta_center-inner text_c">
        <?php if($title): ?>
            <h2 class="title_text_cta_center-title white">
                <?php echo $title; ?>
            </h2>
        <?php endif; ?>
        <?php if($text): ?>
            <div class="title_text_cta_center-text white fz_18 medium">
                <?php echo $text; ?>
            </div>
        <?php endif; ?>
        <?php if($buttons): ?>
            <div class="title_text_cta_center-buttons">
                <?php get_template_part('page-templates/partials/part_buttons', null, array('buttons' => $buttons)); ?>
            </div>
        <?php endif; ?>
    </div>
    </div>
</section>