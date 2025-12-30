<?php 
    $title = get_sub_field('title');
    $text = get_sub_field('text');
    $aside_title = get_sub_field('aside_title');
    $aside_text = get_sub_field('aside_text');
    $aside_image = get_sub_field('aside_image');
    $aside_list = get_sub_field('aside_list');
    $list = get_sub_field('list');
    $enable_before = get_sub_field('enable_before');
    $section_class = get_sub_field('section_class');
    $section_id = get_sub_field('section_id');
    $combine_aside_and_list = get_sub_field('combine_aside_and_list');
?>

<section class="point_list <?php echo $section_class; ?> <?php echo $combine_aside_and_list ? 'combine_list' : ''; ?>" id="<?php echo $section_id; ?>">
    <?php if($title || $text): ?>
    <div class="point_list-top text_c">
        <div class="container">
            <?php if($title): ?>
                <h2 class="point_list-title semibold white mb_12"><?php echo $title; ?></h2>
            <?php endif; ?>
            <?php if($text): ?>
                <div class="point_list-text white-70"><?php echo $text; ?></div>
            <?php endif; ?>
        </div>
    </div>
    <?php endif; ?>
    <div class="point_list-inner container container_sm">
        <?php if($enable_before): ?>
            <div class="point_list-before"></div>
        <?php endif; ?>
        <div class="point_list-inner flex align_st justify_sb gap_64">
            <div class="point_list-inner-progress">
                <div class="point_list-inner-progress-bar"></div>
            </div>
            <div class="point_list-aside flex_auto flex dir_col">
                <div class="point_list-aside-inner">
                    <div class="point_list-aside-inner-top">
                        <?php if($aside_title): ?>
                    <h2 class="point_list-aside-title white "><?php echo $aside_title; ?></h2>
                    <?php endif; ?>
                    <?php if($aside_text): ?>
                        <div class="point_list-aside-text white-70"><?php echo $aside_text; ?></div>
                    <?php endif; ?>
                    <?php if($aside_image): ?>
                        <div class="point_list-aside-image">
                            <?php echo wp_get_attachment_image($aside_image['ID'], 'full'); ?>
                        </div>
                    <?php endif; ?>
                    </div>
                <?php if($aside_list && !$combine_aside_and_list): ?>
                    <div class="point_list-aside-inner-list flex dir_col gap_64 point_list-aside-desktop">
                        <?php foreach($aside_list as $item): ?>
                            <div class="point_list-aside-inner-list-item point_list-scroll-item">
                                <?php if($item['title']): ?>
                                    <h3 class="point_list-aside-inner-list-item-title mb_24 white">
                                        <?php echo $item['title']; ?>
                                </h3>
                                <?php endif; ?>
                                <?php if($item['text']): ?>
                                    <div class="point_list-aside-inner-list-item-text white fz_18">
                                        <?php echo $item['text']; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
                </div>
            </div>
            <div class="point_list-content flex_auto flex dir_col">
            <?php 
            // Check if mobile
            // $is_mobile = wp_is_mobile();
            $index = 0;
            // Combine lists for mobile in alternating order
            $combined_list = array();
            if ($combine_aside_and_list && $aside_list && $list) {
                $max_count = max(count($aside_list), count($list));
                for ($i = 0; $i < $max_count; $i++) {
                    // Add aside item if exists
                    if (isset($aside_list[$i])) {
                        $combined_list[] = array(
                            'type' => 'aside',
                            'data' => $aside_list[$i]
                        );
                    }
                    // Add main list item if exists
                    if (isset($list[$i])) {
                        $combined_list[] = array(
                            'type' => 'content',
                            'data' => $list[$i],
                            'index' => $i + 1
                        );
                    }
                }
            }
            
            // Render combined list for mobile, or regular list for desktop
            if ($combine_aside_and_list && !empty($combined_list)) {
                // Mobile: Combined alternating list
                foreach($combined_list as $combined_item): 
                    // Open wrapper every 2 items
                     if ($index % 2 === 0): ?>
                         <div class="point_list-aside-inner-wrap point_list-scroll-item">
                     <?php endif; ?>
                    <?php if ($combined_item['type'] == 'aside'):
                        // Render aside item
                        ?>
                        <div class="point_list-aside-inner-list-item">
                            <?php if($combined_item['data']['title']): ?>
                                <h3 class="point_list-aside-inner-list-item-title mb_24 white">
                                    <?php echo $combined_item['data']['title']; ?>
                                </h3>
                            <?php endif; ?>
                            <?php if($combined_item['data']['text']): ?>
                                <div class="point_list-aside-inner-list-item-text white fz_18">
                                    <?php echo $combined_item['data']['text']; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        <?php
                    else:
                        // Render content item
                        $item = $combined_item['data'];
                        $counter = $combined_item['index'];
                        $view = $item['box_image'] ? 'view-1' : 'view-2';
                        ?>
                        <div class="point_list-content-item <?php echo $view; ?> flex align_fs justify_sb gap_16">
                            <div class="point_list-content-item-number white flex_auto ff_mono tt_u">
                                <?php echo '0' . $counter; ?>
                            </div> 
                            <div class="point_list-content-item-inner <?php echo $view == 'view-2' ? 'border_bottom' : 'flex align_c justify_sb'; ?>">
                            <?php if ($item['box_image'] || $item['box_percent']): ?>
                                        <div class="point_list-content-item-image-wrapper flex_auto">
                                            <div class="point_list-content-item-image">
                                                <?php echo wp_get_attachment_image($item['box_image']['ID'], 'full'); ?>
                                            </div>
                                            <div class="point_list-content-item-image-box white">
                                                <div class="point_list-content-item-image-box-percent semibold flex align_fe justify_c">
                                                    <?php echo $item['box_percent'] ?>
                                                    <small>%</small>
                                                </div>
                                                <div class="point_list-content-item-image-box-percent-label text_c semibold">
                                                    <?php echo _e('Speed Improvement'); ?>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                            <div class="point_list-content-item-content">
                                <?php if($item['title']): ?>
                                    <div class="point_list-content-item-title white medium">
                                        <?php echo $item['title']; ?>
                                    </div>
                                <?php endif; ?>
                                <?php if($item['text']): ?>
                                    <div class="point_list-content-item-text white-70">
                                        <?php echo $item['text']; ?>
                                    </div>
                                <?php endif; ?>
                                <?php if($item['buttons']): ?>
                                    <div class="point_list-content-item-buttons flex align_c justify_fs gap_16">
                                        <?php get_template_part('page-templates/partials/part_buttons', null, array('buttons' => $item['buttons'])); ?>
                                    </div>
                                <?php endif;?> 
                                </div>
                            </div>
                        </div>
                        <?php
                    endif; ?>
                 <?php
                 $index++;

                 // Close wrapper after 2 items OR at the end
                 if ($index % 2 === 0 || $index === count($combined_list)): ?>
                     </div>
                 <?php endif; ?>
                <?php endforeach;
            } else {
                // Desktop: Regular list only
                $counter = 1;
                foreach($list as $item):
                $view = $item['box_image'] ? 'view-1' : 'view-2';
                ?>
                    <div class="point_list-content-item point_list-scroll-item <?php echo $view; ?> flex align_fs justify_sb gap_16">
                        <div class="point_list-content-item-number white flex_auto ff_mono tt_u">
                            <?php echo '0' . $counter; ?>
                        </div> 
                        <div class="point_list-content-item-inner <?php echo $view == 'view-2' ? 'border_bottom' : 'flex align_c justify_sb'; ?>">
                        <?php if ($item['box_image'] || $item['box_percent']): ?>
                                    <div class="point_list-content-item-image-wrapper flex_auto">
                                        <div class="point_list-content-item-image">
                                            <?php echo wp_get_attachment_image($item['box_image']['ID'], 'full'); ?>
                                        </div>
                                        <div class="point_list-content-item-image-box white">
                                            <div class="point_list-content-item-image-box-percent semibold flex align_fe justify_c">
                                                <?php echo $item['box_percent'] ?>
                                                <small>%</small>
                                            </div>
                                            <div class="point_list-content-item-image-box-percent-label text_c semibold">
                                                <?php echo _e('Speed Improvement'); ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                        <div class="point_list-content-item-content">
                            <?php if($item['title']): ?>
                                <div class="point_list-content-item-title white medium">
                                    <?php echo $item['title']; ?>
                                </div>
                            <?php endif; ?>
                            <?php if($item['text']): ?>
                                <div class="point_list-content-item-text white-70">
                                    <?php echo $item['text']; ?>
                                </div>
                            <?php endif; ?>
                            <?php if($item['buttons']): ?>
                                <div class="point_list-content-item-buttons flex align_c justify_fs gap_16">
                                    <?php get_template_part('page-templates/partials/part_buttons', null, array('buttons' => $item['buttons'])); ?>
                                </div>
                            <?php endif;?> 
                            </div>
                        </div>
                    </div>
                <?php 
                $counter++;
            endforeach; 
            }
            ?>
        </div>
        </div>
    </div>
</section>