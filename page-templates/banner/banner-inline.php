<?php 
$title = $args['title'];
$subtitle = $args['subtitle'];
$text = $args['text'];
$buttons = $args['buttons'];
$image = $args['image'];
$image_mobile = $args['image_mobile'];
$banner_view = $args['banner_view'];
$banner_style = $args['banner_style'] ? $args['banner_style'] : '';
$image_position = $args['image_position'] ? $args['image_position'] : '';
?>

<section class="cta_inner flex align_c justify_fe dir_col <?php echo $banner_style; ?> <?php echo $banner_view; ?>">
        <div class="container flex align_fe justify_sb">
            <?php if ( $image || $image_mobile ) : ?>
                    <picture class="cta_inner-image cta_inner-image-<?php echo $image_position; ?>">
                        <?php if ( $image_mobile && isset( $image_mobile['url'] ) ) : ?>
                            <source media="(max-width: 767px)" srcset="<?php echo esc_url( $image_mobile['url'] ); ?>" />
                        <?php endif; ?>
                        <?php if ( $image && isset( $image['url'] ) ) : ?>
                            <img class="<?php echo $image_position; ?>" src="<?php echo esc_url( $image['url'] ); ?>" alt="<?php echo esc_attr( $image['alt'] ?? ( $title ?: '' ) ); ?>" />
                        <?php endif; ?>
                    </picture>
            <?php endif; ?>
            <?php if ( $subtitle ) : ?>
                <div class="tag hero_with_form-tag"><?php echo $subtitle; ?></div>
            <?php endif; ?>

            <div class="cta_inner-content text_l">
                <?php if ( $title ) : ?>
                    <h2 class="cta_inner-title fz_56 white mb_24"><?php echo $title; ?></h2>
                <?php endif; ?>

                <?php if ( $text ) : ?>
                    <div class="cta_inner-description white"><?php echo $text; ?></div>
                <?php endif; ?>
            </div>

            <?php if ( $buttons && is_array( $buttons ) ) : ?>
                    <div class="cta_inner-buttons flex align_c justify_c gap_16 flex_auto">
                        <?php get_template_part( 'page-templates/partials/part_buttons', null, array( 'buttons' => $buttons ) ); ?>
                    </div>
                <?php endif; ?>
        </div>
    </section>