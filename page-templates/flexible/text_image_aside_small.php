<?php 
$title = get_sub_field('title');
$text = get_sub_field('text');
$image = get_sub_field('image');
?>

<section class="text_image_aside_small">
    <div class="container container_sm text_image_aside_small-inner gap_64 flex align_c justify_sb">
        <div class="text_image_aside_small-content">
            <?php if($title): ?>
                <h2 class="text_image_aside_small-title white mb_24"><?php echo $title; ?></h2>
            <?php endif; ?>
            <?php if($text): ?>
                <div class="text_image_aside_small-text white-70 fz_18"><?php echo $text; ?></div>
            <?php endif; ?>
        </div>
        <?php if($image): ?>
            <div class="text_image_aside_small-image flex_auto">
                <?php echo wp_get_attachment_image($image['ID'], 'full'); ?>
            </div>
        <?php endif; ?>
    </div>
</section>