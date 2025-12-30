<?php 
    $title = get_sub_field('title'); 
    // $image = get_sub_field('image');
    $buttons = get_sub_field('buttons');
?> 

<section class="cta_inner flex align_c justify_fe dir_col">
    <div class="container container_lg">
        <?php //if($image): ?>
                <!-- <div class="cta_inner-image">
                    <?php //echo wp_get_attachment_image($image['id'], 'full'); ?>
                </div> -->
            <?php //endif; ?>
        <div class="cta_inner-content text_c">
            <?php if($title): ?>
            <h2 class="cta_inner-title fz_64 white mb_32"><?php echo $title; ?></h2>
            <?php endif; ?>
            <?php if($buttons): ?>
                <div class="cta_inner-buttons flex align_c justify_c gap_16">
                    <?php get_template_part('page-templates/partials/part_buttons', null, array('buttons' => $buttons)); ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>