<?php
$title = get_sub_field('title');
$text = get_sub_field('text');
$image = get_sub_field('image');
$buttons = get_sub_field('buttons');
?>

<section class="text_image_aside">
    <div class="container text_image_aside-inner flex align_c justify_sb">
        <div class="text_image_aside-content">
            <?php if($title): ?>
                <h1 class="text_image_aside-title white mb_24"><?php echo $title; ?></h1>
            <?php endif; ?>
            <?php if($text): ?>
                <div class="text_image_aside-tex white-70 fz_18 mb_32"><?php echo $text; ?></div>
            <?php endif; ?>
            <?php if($buttons): ?>
                <div class="text_image_aside-buttons flex align_c justify_fs gap_16">
                    <?php get_template_part('page-templates/partials/part_buttons', null, array('buttons' => $buttons)); ?>
                </div>
            <?php endif; ?>
        </div>
        <div class="text_image_aside-image flex_auto">
            <?php echo wp_get_attachment_image($image['ID'], 'full'); ?>
        </div>
    </div>
</section>