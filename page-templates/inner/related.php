<?php
/**
 * Related posts section.
 *
 * @package Incredibuild
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$post_id = isset( $args['post_id'] ) ? (int) $args['post_id'] : get_the_ID();
$columns = get_sub_field('columns') ? get_sub_field('columns') : 3;
$posts_per_page = get_sub_field('posts_per_page') ? get_sub_field('posts_per_page') : 3;
$title = get_sub_field('title') ? get_sub_field('title') : false;

if ( ! $post_id ) {
	return;
}

$post_type = isset( $args['cpt_name'] ) ? sanitize_key( $args['cpt_name'] ) : get_post_type( $post_id );

if ( 'posts' === $post_type ) {
	$post_type = 'post';
}

if ( ! $post_type ) {
	return;
}

$primary_category = null;
$categories       = get_the_terms( $post_id, 'category' );

if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) {
	$primary_category = $categories[0];
}

$query_args = array(
	'post_type'           => $post_type,
	'post_status'         => 'publish',
	'posts_per_page'      => $posts_per_page,
	'post__not_in'        => array( $post_id ),
	'ignore_sticky_posts' => true,
);

if ( $primary_category instanceof WP_Term ) {
	$query_args['tax_query'] = array(
		array(
			'taxonomy' => 'category',
			'field'    => 'term_id',
			'terms'    => array( $primary_category->term_id ),
		),
	);
}

$query = new WP_Query( $query_args );

if ( ! $query->have_posts() && isset( $query_args['tax_query'] ) ) {
	unset( $query_args['tax_query'] );
	$query = new WP_Query( $query_args );
}

if ( ! $query->have_posts() ) {
	wp_reset_postdata();
	return;
}

$post_type_object = get_post_type_object( $post_type );
$cpt_label        = $post_type_object && isset( $post_type_object->labels->name )
	? $post_type_object->labels->name
	: ucfirst( $post_type );

$post_type_file = $post_type === 'our_customers' ? 'case-study' : 'post';
?>

<section class="article_related">
	<div class="container container_md">
			<h2 class="article_related-title h4 white">
				<?php if($title): ?>
					<?php echo $title; ?>
				<?php else: ?>
				<?php
				printf(
					/* translators: %s: post type label */
					esc_html__( 'Related %s', 'incredibuild' ),
						esc_html( $cpt_label )
					);
					?>
				<?php endif; ?>
			</h2>

		<div class="article_related-grid cpt-list-grid" style="grid-template-columns: repeat(<?php echo $columns; ?>, 1fr);">
			<?php
			while ( $query->have_posts() ) :
				$query->the_post();

				get_template_part(
					'page-templates/partials/loop-' . $post_type_file,
					null,
					array(
						'post_id'      => get_the_ID(),
						'item_classes' => 'article_related-card',
					)
				);
			endwhile;
			?>
		</div>
	</div>
</section>

<?php
wp_reset_postdata();