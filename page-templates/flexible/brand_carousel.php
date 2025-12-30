<?php 
 $title = get_sub_field('title');
 $text = get_sub_field('text'); 
 $gallery = get_sub_field('gallery');
 $enable_divider = get_sub_field('enable_divider');
?>

<section class="brand_carousel">
    <div class="container text_c <?php echo incredibuild_get_enable_divider_class(); ?>">
        <?php if($title): ?>
            <h2 class="brand_carousel-title white text_c"><?php echo $title; ?></h2>
        <?php endif; ?>
        <?php if($text): ?>
            <div class="brand_carousel-text medium white"><?php echo $text; ?></div>
        <?php endif; ?>
        <?php if($gallery): ?>
            <div class="brand_carousel-gallery-wrapper">
            <div class="brand_carousel-gallery owl-carousel">
                <?php foreach($gallery as $image): ?>
                    <div class="brand_carousel-gallery-item">
                        <img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>">
                    </div>
                <?php endforeach; ?>
            </div>
            </div>
        <?php endif; ?>
    </div>
</section>