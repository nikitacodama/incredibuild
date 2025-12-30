<?php
    $title = get_sub_field('title');
    $text = get_sub_field('text');
    $buttons = get_sub_field('buttons');
    $cpt = get_sub_field('cpt');
    $enable_breadcrumbs = get_sub_field('enable_breadcrumbs');
    $view = get_sub_field('view') ? get_sub_field('view') : 'default';
    $enable_filters = get_sub_field('enable_filters') ? get_sub_field('enable_filters') : false;
    $background_position = get_sub_field('background_position') ? get_sub_field('background_position') : 'top left';
    $background_image = get_sub_field('background_image') ? get_sub_field('background_image') : '';
    $category = get_sub_field('category'); 
    $tags = get_sub_field('tags'); 

    $category_terms = array();
    $selected_category_ids = array();

    if ( ! empty( $category ) ) {
        foreach ( (array) $category as $cat_item ) {
            if ( $cat_item instanceof WP_Term ) {
                $category_terms[]        = $cat_item;
                $selected_category_ids[] = (int) $cat_item->term_id;
            } elseif ( is_numeric( $cat_item ) ) {
                $term = get_term( (int) $cat_item, 'category' );
                if ( $term && ! is_wp_error( $term ) ) {
                    $category_terms[]        = $term;
                    $selected_category_ids[] = (int) $term->term_id;
                }
            } elseif ( is_array( $cat_item ) && isset( $cat_item['term_id'] ) ) {
                $term = get_term( (int) $cat_item['term_id'], 'category' );
                if ( $term && ! is_wp_error( $term ) ) {
                    $category_terms[]        = $term;
                    $selected_category_ids[] = (int) $term->term_id;
                }
            }
        }
    }

    $tag_terms = array();
    $selected_tag_ids = array();

    if ( ! empty( $tags ) ) {
        foreach ( (array) $tags as $tag_item ) {
            if ( $tag_item instanceof WP_Term ) {
                $tag_terms[]        = $tag_item;
                $selected_tag_ids[] = (int) $tag_item->term_id;
            } elseif ( is_numeric( $tag_item ) ) {
                $term = get_term( (int) $tag_item, 'post_tag' );
                if ( $term && ! is_wp_error( $term ) ) {
                    $tag_terms[]        = $term;
                    $selected_tag_ids[] = (int) $term->term_id;
                }
            } elseif ( is_array( $tag_item ) && isset( $tag_item['term_id'] ) ) {
                $term = get_term( (int) $tag_item['term_id'], 'post_tag' );
                if ( $term && ! is_wp_error( $term ) ) {
                    $tag_terms[]        = $term;
                    $selected_tag_ids[] = (int) $term->term_id;
                }
            }
        }
    }

    $tag_taxonomy = '';
    if ( ! empty( $tags ) ) {
        $tag_taxonomy = 'post_tag';
    }

    $cpt_class; 

    foreach($cpt as $cpt_item){
        $cpt_class .= ' cpt-' . $cpt_item;
    }
?>

<section class="hero_inner flex dir_col align_fs justify_fe <?php echo $cpt_class; ?> <?php echo $view; ?> <?php echo $enable_filters ? 'hero_inner--filters' : ''; ?>" 
style="background-position: <?php echo $background_position; ?>; <?php if($background_image): ?>background-image: url('<?php echo $background_image['url']; ?>');<?php endif; ?>">
    <div class="container hero_inner-wrap container_lg <?php echo $view === 'in-row' ? 'border_bottom' : ''; ?>">
        <?php if($enable_breadcrumbs): ?>
            <?php get_template_part('page-templates/partials/breadcrumbs', null, array('cpt_name' => $cpt)); ?>
        <?php endif; ?>
        <div class="hero_inner-content">
        <?php if($title): ?>
            <h1 class="hero_inner-title white"><?php echo $title; ?></h1>
        <?php endif; ?>
        <?php if($text): ?>
        <div class="hero_inner-text white-70"><?php echo $text; ?></div>
        <?php endif; ?>
        <?php if($buttons): ?>
        <div class="hero_inner-buttons flex align_c">
            <?php get_template_part('page-templates/partials/part_buttons', null, array('buttons' => $buttons)); ?>
        </div>
        <?php endif; ?>
        </div>
        <?php if($enable_filters): ?>
        <div class="hero_inner-filters">
            <?php get_template_part('page-templates/partials/filters', null, array('category_terms' => $category, 'tag_terms' => $tags, 'view' => 'select', 'tag_taxonomy' => $tag_taxonomy )); ?>
        </div>
    <?php endif; ?>
    </div>
</section>

