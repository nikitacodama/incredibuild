<?php
/**
 * Template Name: Fetch Pages
 * Description: Render selected pages using the same option-based layouts
 *               as the Default Page template, but with a custom list of pages.
 * Template Post Type: page, legal, single_resource_page
 *
 * @package Incredibuild
 * @since 1.0.0
 */

$fetch_pages = get_field( 'fetch_pages_objects' );
?>

<?php get_header(); ?>

<main id="primary" class="site-main test">
	<?php
		// Normalize selected pages to an array of IDs.
		if ( ! empty( $fetch_pages ) ) {
			if ( ! is_array( $fetch_pages ) ) {
				$fetch_pages = array( $fetch_pages );
			}

			$page_ids = array();
			foreach ( $fetch_pages as $page ) {
				if ( is_numeric( $page ) ) {
					$page_ids[] = (int) $page;
				} elseif ( is_object( $page ) && isset( $page->ID ) ) {
					$page_ids[] = (int) $page->ID;
				}
			}

			$page_ids = array_filter( $page_ids );

			if ( ! empty( $page_ids ) ) {
				$post_type = 'page-default';

				// Set global variable with all page IDs for shortcodes to access
				global $incredibuild_fetch_page_ids;
				$incredibuild_fetch_page_ids = $page_ids;

				// Get templates data ONCE to avoid ACF pointer issues
				$templates_data = get_field( 'single_post_templates', 'option' );

				// For each selected page, run through the default-page logic
				// and render hero + content blocks for THAT page in order.
				foreach ( $page_ids as $page_id ) {

					$matched = false;

					// Loop through templates data using raw array (no ACF pointer issues)
					if ( ! empty( $templates_data ) && is_array( $templates_data ) ) {
						foreach ( $templates_data as $template_row ) {
							$cpt_list = isset( $template_row['cpt'] ) ? $template_row['cpt'] : array();

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

							// Get content layouts from this template row
							$content_layouts = isset( $template_row['single_post_content'] ) ? $template_row['single_post_content'] : array();

							if ( ! empty( $content_layouts ) && is_array( $content_layouts ) ) {
								foreach ( $content_layouts as $layout_row ) {
									$layout = isset( $layout_row['acf_fc_layout'] ) ? $layout_row['acf_fc_layout'] : '';

									if ( empty( $layout ) ) {
										continue;
									}

									// Set up ACF row context so get_sub_field() works in template parts
									// ACF uses global variables to track current row
									global $acf_row;
									$acf_row = $layout_row;
									
									// Also set the parent row context
									global $acf_parent_row;
									$acf_parent_row = $template_row;
									
									// Set global post ID for shortcodes to access
									global $incredibuild_current_post_id;
									$incredibuild_current_post_id = $page_id;

									// Extract shortcode_list from layout row to pass via args
									// This ensures it works even if ACF context isn't fully set up
									// Try different possible field names/structures
									$shortcode_list = array();
									if ( isset( $layout_row['shortcode_list'] ) ) {
										$shortcode_list = $layout_row['shortcode_list'];
									} elseif ( isset( $layout_row['shortcode_list'] ) && is_array( $layout_row['shortcode_list'] ) ) {
										$shortcode_list = $layout_row['shortcode_list'];
									}
									
									// Ensure it's an array
									if ( ! is_array( $shortcode_list ) ) {
										$shortcode_list = array();
									}

									// For this page, render hero + content etc in order.
									get_template_part(
										'page-templates/inner/' . $layout,
										null,
										array(
											'cpt_name' => get_post_type( $page_id ),
											'post_id'  => $page_id,
											'shortcode_list' => $shortcode_list,
										)
									);
									get_template_part(
										'page-templates/flexible/' . $layout,
										null,
										array(
											'cpt_name' => get_post_type( $page_id ),
											'post_id'  => $page_id,
										)
									);
									$matched = true;
								}
							}

							if ( $matched ) {
								break;
							}
						}
					}

					// Fallback: if nothing matched, use the standard content template for that page.
					if ( ! $matched ) {
						get_template_part( 'template-parts/content', get_post_type( $page_id ) );
					}
				}
			}
		}
	?>

	</main><!-- #main -->

<?php get_footer(); ?>