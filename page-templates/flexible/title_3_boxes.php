<?php
 $title = get_sub_field('title');
 $list = get_sub_field('list');
?>

<section class="title_3_boxes">
    <div class="container">
        <?php if($title): ?>
            <h2 class="title_3_boxes-title white text_c mb_48"><?php echo $title; ?></h2>
        <?php endif; ?>
        <?php if($list): ?>
            <div class="title_3_boxes-list">
                <?php foreach($list as $item): ?>
                    <div class="title_3_boxes-item">
                        <div class="title_3_boxes-item-inner">
                        <?php if($item['icon']): ?>
                            <div class="title_3_boxes-item-icon">
                                <?php echo wp_get_attachment_image($item['icon']['ID'], 'full'); ?>
                            </div>
                        <?php endif; ?>
                        <?php if($item['title']): ?>
                            <h4 class="title_3_boxes-item-title regular white lh-130"><?php echo $item['title']; ?></h4>
                        <?php endif; ?>
                        <?php if($item['text']): ?>
                            <div class="title_3_boxes-item-text fz_20 white-70 light"><?php echo $item['text']; ?></div>
                        <?php endif; ?>
                        </div>
                        <div class="title_3_boxes-item-after">
                        <svg width="406" height="299" viewBox="0 0 406 299" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g filter="url(#filter0_f_10068_680)">
                            <ellipse cx="206.369" cy="184.04" rx="170.182" ry="72.8355" transform="rotate(166.708 206.369 184.04)" fill="<?php echo $item['path_color']; ?>" fill-opacity="0.44"/>
                            </g>
                            <defs>
                            <filter id="filter0_f_10068_680" x="-63.1708" y="5.34058e-05" width="539.079" height="368.081" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                            <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                            <feBlend mode="normal" in="SourceGraphic" in2="BackgroundImageFix" result="shape"/>
                            <feGaussianBlur stdDeviation="51.5297" result="effect1_foregroundBlur_10068_680"/>
                            </filter>
                            </defs>
                        </svg>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>