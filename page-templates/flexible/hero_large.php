<?php 
    $title = get_sub_field('title'); 
    $text = get_sub_field('text'); 
    $image = get_sub_field('image');
    $icon = get_sub_field('icon');
    $image_mobile = get_sub_field('image_mobile');
?>

<section class="hero_large hero_with_form" id="hero_large">
<?php if($image): ?>
    <div class="hero_large-image-wrap hero_with_form-image-wrap">
        <picture>
            <source srcset="<?php echo $image['url']; ?>" media="(min-width: 1024px)">
            <img src="<?php echo $image_mobile['url']; ?>" alt="<?php echo $image_mobile['alt']; ?>" class="hero_large-image-mobile">
        </picture>  
    </div>
<?php endif; ?>
    <div class="container hero_large-inner hero_with_form-inner text_c"> 
        <?php if($icon): ?>
            <div class="hero_large-icon mb_24">
                <?php echo wp_get_attachment_image($icon['ID'], 'full'); ?>
            </div>
        <?php endif; ?>
        <?php if($title): ?>
            <h1 class="hero_large-title white"><?php echo $title; ?></h1>
        <?php endif; ?>
        <?php if($text): ?>
            <div class="hero_large-text fz_18 white-70"><?php echo $text; ?></div>
        <?php endif; ?>
    </div>
</section>