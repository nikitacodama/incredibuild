<?php
 $list = get_sub_field('list');
?>

<section class="social_boxes">
    <div class="divider_line-block"></div>
    <div class="container container_md">
        <div class="social_boxes-inner">
            <?php foreach($list as $item): ?>
                <?php if($item['link']): ?>
                <a href="<?php echo $item['link']['url']; ?>" target="<?php echo $item['link']['target']; ?>" class="social_boxes-item flex align_c justify_c td_n" style="grid-column: span <?php echo $item['column_span'] ? $item['column_span'] : 1; ?>;">
                    <?php if($item['image']): ?>
                        <div class="social_boxes-item-image">
                            <picture>
                                <source srcset="<?php echo $item['image']['url']; ?>" media="(min-width: 768px)">
                                <img src="<?php echo $item['image_mobile']['url']; ?>" alt="<?php echo $item['image_mobile']['alt']; ?>">
                            </picture>
                        </div>
                    <?php endif; ?>
                    <?php if($item['link']): ?>
                        <div class="social_boxes-item-title green tt_u ff_mono fz_15 td_n">
                            <?php echo $item['link']['title']; ?>
                        </div>
                    <?php endif; ?>
                    </a>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>
</section>