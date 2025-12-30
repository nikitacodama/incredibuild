<?php 
$title = $args['title'];
$text = $args['text'];
$buttons = $args['buttons'];
$image = $args['image'];
$image_mobile = $args['image_mobile'];
$banner_view = $args['banner_view'];
$banner_style = $args['banner_style'] ? $args['banner_style'] : '';
$image_position = $args['image_position'] ? $args['image_position'] : '';
?>

<div class="cta_inner cta_aside flex align_c justify_fe dir_col <?php echo $banner_style; ?>  <?php echo $banner_view; ?>">
        <div class="flex align_fs dir_col justify_sb">
            <?php if ( $image || $image_mobile ) : ?>
                    <picture class="cta_inner-image cta_inner-image-<?php echo $image_position; ?>">
                        <?php if ( $image_mobile && isset( $image_mobile['url'] ) ) : ?>
                            <source media="(max-width: 767px)" srcset="<?php echo esc_url( $image_mobile['url'] ); ?>" />
                        <?php endif; ?>
                        <?php if ( $image && isset( $image['url'] ) ) : ?>
                            <img src="<?php echo esc_url( $image['url'] ); ?>" alt="<?php echo esc_attr( $image['alt'] ?? ( $title ?: '' ) ); ?>" />
                        <?php endif; ?>
                    </picture>
            <?php endif; ?>

            <div class="cta_inner-content text_l">
                <?php if ( $title ) : ?>
                    <h6 class="cta_inner-title white mb_24"><?php echo $title; ?></h6>
                <?php endif; ?>

                <?php if ( $text ) : ?>
                    <div class="cta_inner-description white"><?php echo $text; ?></div>
                <?php endif; ?>
            </div>

            <?php if ( $buttons && is_array( $buttons ) ) : ?>
                    <div class="cta_inner-buttons flex align_c justify_c gap_16">
                        <?php get_template_part( 'page-templates/partials/part_buttons', null, array( 'buttons' => $buttons ) ); ?>
                    </div>
                <?php endif; ?>
        </div>
</div>