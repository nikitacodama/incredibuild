<?php
    $list = get_sub_field('list');
?>

<section class="reviews_slider">
    <div class="container container_sm reviews_slider-inner owl-carousel">
        <?php foreach($list as $item): ?>
            <div class="reviews_slider-item-wrapper">
            <div class="reviews_slider-item white flex align_fs justify_sb">
                <div class="reviews_slider-item-info flex_auto flex align_fs gap_24">
                    <div class="reviews_slider-item-image flex_auto">
                        <?php echo wp_get_attachment_image($item['image']['ID'], 'full'); ?>
                    </div>
                    <div class="reviews_slider-item-info-inner">
                        <div class="reviews_slider-item-name medium"><?php echo $item['name']; ?></div>
                        <div class="reviews_slider-item-position"><?php echo $item['position']; ?></div>
                        <?php if($item['social']): ?>
                            <div class="reviews_slider-item-social-links flex align_c gap_16 flex_wrap">
                                <?php foreach($item['social'] as $link): ?>
                                    <a href="<?php echo $link['url']; ?>" target="_blank">
                                        <?php echo wp_get_attachment_image($link['icon']['ID'], 'full'); ?>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                    <div class="reviews_slider-item-text medium"><?php echo $item['text']; ?></div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>