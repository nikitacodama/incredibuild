<?php
$list = get_sub_field('list');
$cpt  = get_sub_field('cpt');
$title = get_sub_field('title');
$buttons = get_sub_field('buttons');
$section_class = get_sub_field('section_class');

$cpt_class = '';

foreach($cpt as $item){
    if($item == 'news' || $item == 'posts'){
        $item = 'post';   
    }
    $cpt_class .= 'cpt-' . $item . ' ';
}

if($cpt[0] == 'posts'){
    $cpt = 'post';
}

// If list empty but CPT provided → load latest posts

if ( (empty($list) || !is_array($list)) && !empty($cpt) ) {

    $query = new WP_Query(array(
        'post_type'      => $cpt,
        'posts_per_page' => 4, // adjust number of posts you want
        'post_status'    => 'publish',
    ));

    $list = array();

    if ( $query->have_posts() ) {
        foreach ( $query->posts as $post ) {
            $list[] = $post->ID; // store post IDs
        }
    }

    wp_reset_postdata();
}

?>


<section class="cpt_featured <?php echo $section_class; ?> <?php echo $cpt_class; ?> <?php echo $buttons || $title ? 'has_title_buttons' : ''; ?>">
    <div class="container container_md">
    <?php if($title || $buttons): ?>
        <div class="cpt_featured-top flex align_c justify_sb">
            <?php if($title): ?>
                <h2 class="cpt_featured-title white">
                    <?php echo $title; ?>
                </h2>
            <?php endif; ?>
            <?php if($buttons): ?>
                <div class="cpt_featured-buttons">
                    <?php get_template_part('page-templates/partials/part_buttons', null, array('buttons' => $buttons)); ?>
                </div>
            <?php endif; ?>
        </div>
    <?php endif; ?>
        <div class="cpt_featured-grid">
            <?php foreach ($list as $index => $item) :

                $post_id = 0;

                if (is_object($item) && isset($item->ID)) {
                    $post_id = (int) $item->ID;
                } elseif (is_numeric($item)) {
                    $post_id = (int) $item;
                } elseif (is_array($item)) {
                    if (!empty($item['post']->ID)) {
                        $post_id = (int) $item['post']->ID;
                    } elseif (!empty($item['post'])) {
                        $post_id = (int) $item['post'];
                    } elseif (!empty($item['ID'])) {
                        $post_id = (int) $item['ID'];
                    }
                }

                if (!$post_id) continue;

                $template_slug = $index === 0 ? 'post' : 'featured-row';
                $item_classes  = $index === 0
                    ? 'cpt_featured-item cpt_loop-card--main'
                    : 'cpt_featured-item cpt_featured-item--row';
            ?>

                <?php get_template_part(
                    'page-templates/partials/loop',
                    $template_slug,
                    array(
                        'post_id'      => $post_id,
                        'item_classes' => $item_classes,
                        'cpt'          => $cpt,
                    )
                ); ?>

            <?php endforeach; ?>
        </div>
    </div>
</section>

