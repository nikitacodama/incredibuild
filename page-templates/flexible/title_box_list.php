<?php 
    $title = get_sub_field('title');
    $list = get_sub_field('list'); 
?>

<section class="title_box_list">
    <div class="container container_sm">
        <?php if($title): ?>
            <h3 class="title_box_list-title white border_bottom text_c"><?php echo $title; ?></h3>
        <?php endif; ?>
        <?php if($list): ?>
            <div class="title_box_list-list flex align_fs justify_sb gap_24">
            <div class="title_box_list-list-aside flex_auto flex dir_col gap_16 tt_u ff_mono">
                <?php 
                $counter = 0;
                foreach($list as $item): 
                    $counter++;
                    ?>
                    <div data-index="<?php echo $counter; ?>" class="title_box_list-list-aside-label <?php echo $counter == 1 ? 'active' : ''; ?>">
                            <?php echo $item['label']; ?>
                    </div>
                <?php endforeach; ?>
                </div>
                <div class="title_box_list-list-content">
                    <?php 
                    $counter = 0;
                    foreach($list as $item): 
                    $counter++;
                    ?>
                        <div class="title_box_list-list-content-item ">
                            <div class="title_box_list-list-content-item-inner flex dir_col justify_sb gap_32">
                            <div class="title_box_list-list-content-item-image">
                                <?php echo wp_get_attachment_image($item['icon']['ID'], 'full'); ?>
                            </div>
                            <div class="title_box_list-list-content-item-inner-content">
                                <h6 class="title_box_list-list-content-item-inner-title white">
                                    <?php echo $item['title']; ?>
                                </h6>
                                <div class="title_box_list-list-content-item-inner-text white-70">
                                        <?php echo $item['text']; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>