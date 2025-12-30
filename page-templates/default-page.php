<?php
/**
 * Template Name: Default Page
 * Description: A flexible page template for creating custom pages with ACF flexible content.
 * Template Post Type: page, legal, single_resource_page
 *
 * @package Incredibuild
 * @since 1.0.0
 */
?>

<?php get_header(); ?>

<main id="primary" class="site-main">
	<?php
		$matched = false;
        $post_type = 'page-default';

		if ( have_rows( 'single_post_templates', 'option' ) ) :
			while ( have_rows( 'single_post_templates', 'option' ) ) :
				the_row();

				$cpt_list = get_sub_field( 'cpt' );

				if ( empty( $cpt_list ) ) {
					$cpt_list = array( $post_type );
				} elseif ( ! is_array( $cpt_list ) ) {
					$cpt_list = array( $cpt_list );
				}

				$normalized_cpts = array();
				foreach ( $cpt_list as $cpt_item ) {
					if ( ! is_string( $cpt_item ) || '' === $cpt_item ) {
						continue;
					}

					$sanitized = sanitize_key( $cpt_item );

					if ( 'page-default' === $sanitized ) {
						$sanitized = 'page-default';
					}

					$normalized_cpts[] = $sanitized;
				}

				if ( empty( $normalized_cpts ) || ! in_array( $post_type, $normalized_cpts, true ) ) {
					continue;
				}

				if ( have_rows( 'single_post_content' ) ) {
					while ( have_rows( 'single_post_content' ) ) {
						the_row();

						$layout = get_row_layout();

						if ( empty( $layout ) ) {
							continue;
						}

						get_template_part(
							'page-templates/inner/' . $layout,
							null,
							array(
								'cpt_name' => get_post_type(),
								'post_id'  => get_the_ID(),
							)
						);
						get_template_part(
							'page-templates/flexible/' . $layout,
							null,
							array(
								'cpt_name' => get_post_type(),
								'post_id'  => get_the_ID(),
							)
						);
						$matched = true;
					}
				}

				if ( $matched ) {
					break;
				}
			endwhile;
		endif;

		if ( ! $matched ) {
			get_template_part( 'template-parts/content', get_post_type() );
		}
	?>

	</main><!-- #main -->

<?php get_footer(); ?>