<?php 
    $title = get_sub_field('title');
    $text = get_sub_field('text');
    $list = get_sub_field('list');
?>

<section class="our_story">
<div class="our_story-inner container container_md-2 flex align_st justify_sb">
    <?php if($list): ?>
            <?php 
            // Split items into two equal columns
            $total_items = count($list);
            $items_per_column = ceil($total_items / 2);
            $column1 = array_slice($list, 0, $items_per_column);
            $column2 = array_slice($list, $items_per_column);
            ?>
            <div class="our_story-column col_1 flex_auto">
                <?php foreach($column1 as $item):
                    $disable_linkidn = $item['disable_linkidn'] ? 'disable_linkidn' : '';
                    ?>
                    <a href="<?php echo $item['link']['url']; ?>" 
                    target="<?php echo $item['link']['target']; ?>" 
                    class="our_story-item white td_n <?php echo $disable_linkidn; ?>">
                        <div class="our_story-item-image"><?php echo wp_get_attachment_image($item['image']['ID'], 'full'); ?></div>
                        <div class="our_story-item-content">
                            <h6 class="our_story-item-title"><?php echo $item['title']; ?></h6>
                            <div class="our_story-item-subtitle fz_18"><?php echo $item['subtitle']; ?></div>
                        </div>
                   </a>
                <?php endforeach; ?>
            </div>
            <div class="our_story-column col-2 flex_auto">
                <?php foreach($column2 as $item):
                     $disable_linkidn = $item['disable_linkidn'] ? 'disable_linkidn' : '';
                    ?>
                    <a href="<?php echo $item['link']['url']; ?>" 
                    target="<?php echo $item['link']['target']; ?>" 
                    class="our_story-item white td_n <?php echo $disable_linkidn; ?>">
                        <div class="our_story-item-image"><?php echo wp_get_attachment_image($item['image']['ID'], 'full'); ?></div>
                        <div class="our_story-item-content">
                            <h6 class="our_story-item-title"><?php echo $item['title']; ?></h6>
                            <div class="our_story-item-subtitle fz_18"><?php echo $item['subtitle']; ?></div>
                        </div>
                   </a>
                <?php endforeach; ?>
        </div>
    <?php endif; ?>
    <div class="our_story-inner-content">
        <?php if($title): ?>
            <h2 class="our_story-title white"><?php echo $title; ?></h2>
        <?php endif; ?>
        <?php if($text): ?>
            <div class="our_story-text white-70"><?php echo $text; ?></div>
        <?php endif; ?>
    </div>
    </div>
</section>