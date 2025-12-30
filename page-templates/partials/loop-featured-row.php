<?php
/**
 * Featured layout - Row card.
 *
 * @package Incredibuild
 */

if ( ! isset( $args['post_id'] ) ) {
    return;
}

$post_id = (int) $args['post_id'];
$cpt = $args['cpt'];

if ( ! $post_id ) {
    return;
}

$external_link = get_field( 'external_link', $post_id );
$permalink     = $external_link ? $external_link : get_permalink( $post_id );

$target     = get_field('external_link', $post_id) ? '_blank' : '_self';
$title      = get_the_title( $post_id );

$category_label = '';

if ( $cpt[0] === 'news' ) {
    // Get meta value instead of categories
    $type_value = get_post_meta( $post_id, '_type', true );

    if ( ! empty( $type_value ) ) {
        $category_label = $type_value;
    }
} else {
    // Use normal WP category
    $categories = get_the_terms( $post_id, 'category' );
    $category   = ( ! empty( $categories ) && ! is_wp_error( $categories ) ) ? $categories[0] : null;

    if ( $category ) {
        $category_label = $category->name;
    }
}


$date_timestamp = get_post_time( 'U', true, $post_id );
$date_formatted = $date_timestamp ? date_i18n( 'j M Y', $date_timestamp ) : '';
$date_display   = $date_formatted ? ( function_exists( 'mb_strtoupper' ) ? mb_strtoupper( $date_formatted ) : strtoupper( $date_formatted ) ) : '';
$excerpt    = wp_trim_words( get_the_excerpt( $post_id ), 22, '…' );

$image_html = get_the_post_thumbnail( $post_id, 'medium', array( 'class' => 'cpt_featured-row__image-tag' ) );

?>

<a href="<?php echo esc_url( $permalink ); ?>" class="test cpt_featured-row border_bottom <?php echo esc_attr( $item_classes ); ?>" target="<?php echo esc_attr( $target ); ?>">

    <div class="cpt_featured-row__body">
        <?php if ( $category_label ) : ?>
            <span class="cpt_featured-row__category ff_mono tt_u category_image-before blue"><?php echo esc_html( $category_label); ?></span>
        <?php endif; ?>

        <?php if ( $title ) : ?>
            <h5 class="cpt_featured-row__title white">
                <?php echo esc_html( $title ); ?>
            </h5>
        <?php endif; ?>



        <?php if ( $date_display ) : ?>
            <div class="links_uppercase">
            <span class="cpt_featured-row__date" datetime="<?php echo esc_attr( get_the_date( 'c', $post_id ) ); ?>">
                [<?php echo esc_html( $date_display ); ?>]
        </span>
        </div>
        <?php endif; ?>
    </div>
</a>

