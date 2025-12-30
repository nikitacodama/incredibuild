<?php
/**
 * Generic post card for CPT list with filters.
 *
 * @package Incredibuild
 */

if ( ! isset( $args['post_id'] ) ) {
    $post_id = get_the_ID();
} else {
    $post_id = (int) $args['post_id'];
}

if ( ! $post_id ) {
    return;
}

$permalink  = get_permalink( $post_id );
$title      = get_the_title( $post_id );
$header_title = get_post_meta($post_id, '_header_title', true);

if($header_title == ''){ 
    $header_title = get_field('short_text', $post_id) ? get_field('short_text', $post_id) : $title;
}


$categories = get_the_terms( $post_id, 'category' );
$category   = ( ! empty( $categories ) && ! is_wp_error( $categories ) ) ? $categories[0] : null;

$image_html = get_the_post_thumbnail( $post_id, 'medium_large', array( 'class' => 'cpt-list-card__image-tag' ) );

$item_classes = ! empty( $args['item_classes'] ) ? (string) $args['item_classes'] : '';

$compilation_table_top_title = get_field('compilation_table_top_title', $post_id) ? get_field('compilation_table_top_title', $post_id) : false;
$compilation_table = get_field('compilation_table', $post_id);

// Get post content and check for benchmarks-wrap block
$post_content = get_post_field('post_content', $post_id);
$benchmarks_block = false;
if ($post_content) {
    // Check if content contains benchmarks-wrap block
    // Match from <div class="benchmarks-wrap to the closing </div> that closes the benchmarks-wrap div
    if (preg_match('/<div\s+class="benchmarks-wrap[^"]*"[^>]*>.*?<\/dl><\/div>/s', $post_content, $matches)) {
        $benchmarks_block = $matches[0];
    }
}

?>
<a href="<?php echo esc_url( $permalink ); ?>" class="cpt_loop-card cpt_loop-card--case-study flex dir_col justify_sb <?php echo esc_attr( $item_classes ); ?>">

<div class="cpt_loop-top flex align_fs justify_sb">
<?php if ( $title ) : ?>
            <span class="cpt_featured-row__category ff_mono tt_u category_image-before blue"><?php echo $title; ?></span>
        <?php endif; ?>
<?php if ( $image_html ) : ?>
        <div class="cpt_loop-card__image" aria-hidden="true">
            <?php echo $image_html; ?>
        </div>
    <?php endif; ?>
</div>

    <div class="cpt_loop-card__content">

        <?php if ( $header_title ) : ?>
            <h5 class="cpt_loop-card__title white">
                <?php echo  $header_title; ?>
            </h5>
        <?php endif; ?>



        <?php if ($benchmarks_block) : ?>
            <?php echo $benchmarks_block; ?>
        <?php elseif ($compilation_table) : ?>
            <div class="cpt_loop-card__compilation-time dir_col flex gap_6">
                <?php if($compilation_table_top_title): ?>
                <div class="cpt_loop-card__compilation-time-label flex_auto">
                    <?php echo $compilation_table_top_title; ?>
                </div>
                <?php endif; ?>
                <div class="flex dir_col gap_6">
                <?php foreach($compilation_table as $item): ?>
                    <div class="cpt_loop-card__compilation-flex flex align_c gap_12">
                <div class="cpt_loop-card__compilation-time-label flex_auto">
                    <?php echo $item['compilation_label']; ?>
                </div>
                <div class="cpt_loop-card-bottom flex align_c justify_sb gap_12">
                <div class="cpt_loop-card__compilation-time-current fz_18 tt_u white ff_mono flex_auto">
                    <?php echo $item['compilation_time']; ?>
                </div>
                <div class="cpt_loop-card__compilation-time-divider flex_auto">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/arrow-right-40.svg" alt="<?php esc_html_e( 'Divider', 'incredibuild' ); ?>">
                </div>
                <div class="cpt_loop-card__compilation-time-improve fz_18 tt_u green ff_mono w_full text_c">
                    <?php echo $item['compilation_improve']; ?>
                </div>
                </div>
                </div>
                <?php endforeach; ?>
                                    
                </div>
            </div>
        <?php endif; ?>

    </div>

</a>

