<?php
    $title = get_sub_field('title');
    $text = get_sub_field('text'); 
    $buttons = get_sub_field('buttons');
    $cpt = get_sub_field('cpt'); 
    $cpt_list_manual = get_sub_field('cpt_list_manual');
    $posts_per_page = get_sub_field('posts_per_page');
?>

<section class="cpt_carousel">
    <div class="cpt_carousel-top flex align_fe justify_sb container container_md">
        <div class="cpt_carousel-top-content ">
        <?php if($title): ?>
            <h2 class="cpt_carousel-title white mb_24"><?php echo $title; ?></h2>
        <?php endif; ?>
        <?php if($text): ?>
            <div class="cpt_carousel-text gray-4 fz_18"><?php echo $text; ?></div>
        <?php endif; ?>
        </div>
        <?php if($buttons): ?>
            <div class="cpt_carousel-buttons flex_auto flex align_c justify_fe">
                <?php get_template_part('page-templates/partials/part_buttons', null, array('buttons' => $buttons)); ?>
            </div>
        <?php endif; ?>
    </div>
    <?php if($cpt): ?>
    <div class="cpt_carousel-owl-inner container container_md">
    <div class="cpt_carousel-owl owl-carousel">
        <?php
        // Prepare query arguments
        $query_args = array(
            'post_type'      => $cpt,
            'post_status'    => 'publish',
            'posts_per_page' => $posts_per_page ? intval($posts_per_page) : -1,
            'ignore_sticky_posts' => true,
        );

        // If manual list is provided, use those post IDs
        if (!empty($cpt_list_manual) && is_array($cpt_list_manual)) {
            $post_ids = array();
            foreach ($cpt_list_manual as $item) {
                if (is_object($item) && isset($item->ID)) {
                    $post_ids[] = $item->ID;
                } elseif (is_numeric($item)) {
                    $post_ids[] = intval($item);
                }
            }
            if (!empty($post_ids)) {
                $query_args['post__in'] = $post_ids;
                $query_args['orderby'] = 'post__in';
            }
        }

        // Execute query
        $query = new WP_Query($query_args);
        $cpt_template = $cpt == 'our_customers' ? 'case-study' : $cpt;
        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                get_template_part('page-templates/partials/loop-' . $cpt_template, null, array('cpt' => $cpt, 'post_id' => get_the_ID()));
            }
            wp_reset_postdata();
        }
        ?>
    </div>
    </div>
    <?php endif; ?>
</section>
