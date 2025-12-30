<?php 
    $title = get_sub_field('title');
    $gallery = get_sub_field('gallery');
?>

<section class="title_gallery overlay_side">
    <div class="container container_lg title_gallery-inner">
        <?php if($title): ?>
            <h2 class="title_gallery-title white strong_accent text_c"><?php echo $title; ?></h2>
        <?php endif; ?>
        <?php if($gallery): ?>
        <div class="title_gallery-gallery-wrapper">
            <div class="title_gallery-gallery owl-carousel">
                <?php foreach($gallery as $image): ?>
                    <div class="title_gallery-gallery-item">
                        <div class="title_gallery-gallery-item-image">
                            <?php echo wp_get_attachment_image($image['ID'], 'full'); ?>
                        </div>
                        <div class="title_gallery-gallery-item-caption ff_mono tt_u">
                            <?php echo $image['caption'] ? $image['caption'] : $image['title']; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>
    </div>
</section>