<?php 
    $title = get_sub_field('title'); 
    $tag = get_sub_field('tag');
    $text = get_sub_field('text'); 
    $shortcode = get_sub_field('shortcode');
    $image = get_sub_field('image');
    $image_mobile = get_sub_field('image_mobile');
?>

<section class="hero_with_form" id="hero_with_form">
<?php if($image): ?>
    <div class="hero_with_form-image-wrap">
            <picture>
                <source srcset="<?php echo $image['url']; ?>" media="(min-width: 1024px)">
                <img src="<?php echo $image_mobile['url']; ?>" alt="<?php echo $image_mobile['alt']; ?>" class="hero_with_form-image-mobile">
            </picture>  
    </div>
<?php endif; ?>
    <div class="container hero_with_form-inner text_c"> 
        <?php if($tag): ?>
            <div class="hero_with_form-tag-wrap">
            <div class="tag hero_with_form-tag">
                    <?php echo $tag; ?>
                </div>
            </div>
        <?php endif; ?>
        <?php if($title): ?>
            <h1 class="hero_with_form-title white"><?php echo $title; ?></h1>
        <?php endif; ?>
        <?php if($text): ?>
            <div class="hero_with_form-text white-70"><?php echo $text; ?></div>
        <?php endif; ?>
        <?php if ( $shortcode ) : ?>
            <div class="hero_with_form-inner">
            <?php $shortcode_trimmed = trim( $shortcode ); ?>   
            <?php if ( preg_match( '/^\[[\w-]+.*\]/', $shortcode_trimmed ) ) : ?>
                <?php echo do_shortcode( $shortcode_trimmed ); ?>
            <?php else : ?>
                <?php echo $shortcode; ?>
            <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</section>