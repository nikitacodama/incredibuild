<?php 
    $title = get_sub_field('title');
    $text = get_sub_field('text');
    $subtitle = get_sub_field('subtitle');
    $list = get_sub_field('list'); 
    $gallery = get_sub_field('gallery');
?>

<section class="country_list <?php echo $gallery ? 'is_gallery' : ''; ?>">
    <div class="container container_sm country_list-top flex align_fs justify_sb border_bottom">
        <?php if($title): ?>
            <h2 class="country_list-title white">
                <?php echo $title; ?>
            </h2>
        <?php endif; ?>
        <?php if($text): ?>
            <div class="country_list-text white-70">
                <?php echo $text; ?>
            </div>
        <?php endif; ?>
    </div>
    <div class="container container_sm country_list-bottom border_bottom">
        <?php if($subtitle): ?>
            <div class="country_list-subtitle white fz_18 text_c">
                <?php echo $subtitle; ?>
            </div>
        <?php endif; ?>
        <?php if($list): ?>
            <div class="country_list-list flex align justify_c flex_wrap">
                <?php foreach($list as $item): ?>
                    <div class="country_list-item">
                        <div class="country_list-item-image ff_mono tt_u flex align_c">
                            [
                            <img class="flex_auto" src="<?php echo $item['image']['url']; ?>" alt="<?php echo $item['image']['alt']; ?>">
                            <div class="country_list-item-label white">
                                <?php echo $item['label']; ?>
                            </div>
                            ] 
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <?php if($gallery): ?>
            <div class="country_list-gallery owl-carousel overlay_side">
                <?php 
                // Group gallery items into chunks of 3
                $gallery_chunks = array_chunk($gallery, 3);
                foreach($gallery_chunks as $chunk): ?>
                    <div class="country_list-gallery-item">
                        <?php foreach($chunk as $image): ?>
                            <div class="country_list-gallery-image">
                                <?php echo wp_get_attachment_image($image['ID'], 'full'); ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>