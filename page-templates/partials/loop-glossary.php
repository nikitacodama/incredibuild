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

$external_link = get_field( 'external_link', $post_id );
$permalink     = $external_link ? $external_link : get_permalink( $post_id );

$target     = get_field('external_link', $post_id) ? '_blank' : '_self';
$title      = get_the_title( $post_id );
$excerpt    = wp_trim_words( get_the_excerpt( $post_id ), 22, '…' );
$categories = get_the_terms( $post_id, 'category' );
$category   = ( ! empty( $categories ) && ! is_wp_error( $categories ) ) ? $categories[0] : null;

$date_timestamp = get_post_time( 'U', true, $post_id );
$date_formatted = $date_timestamp ? date_i18n( 'j M Y', $date_timestamp ) : '';
$date_display   = $date_formatted ? ( function_exists( 'mb_strtoupper' ) ? mb_strtoupper( $date_formatted ) : strtoupper( $date_formatted ) ) : '';

$image_html = get_the_post_thumbnail( $post_id, 'medium_large', array( 'class' => 'cpt-list-card__image-tag' ) );

$item_classes = ! empty( $args['item_classes'] ) ? (string) $args['item_classes'] : '';


?>

<a href="<?php echo esc_url( $permalink ); ?>" class="cpt_loop-card cpt_loop-card--glossary <?php echo esc_attr( $item_classes ); ?>" target="<?php echo esc_attr( $target ); ?>">

    <div class="cpt_loop-card__content flex dir_col gap_16 justify_sb">
        <div>

        <?php if ( $title ) : ?>
            <h5 class="cpt_loop-card__title white">
                <?php echo esc_html( $title ); ?>
        </h5>
        <?php endif; ?>

        <?php if ( $excerpt ) : ?>
            <div class="cpt_loop-card__excerpt">
                <?php echo esc_html( $excerpt ); ?>
            </div>
        <?php endif; ?>
        </div>

    </div>
</a>

