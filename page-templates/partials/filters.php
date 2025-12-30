<?php
$view               = isset( $args['view'] ) ? $args['view'] : 'checkbox';
$category_terms     = isset( $args['category_terms'] ) ? (array) $args['category_terms'] : array();
$tag_terms          = isset( $args['tag_terms'] ) ? (array) $args['tag_terms'] : array();
$category_taxonomy  = isset( $args['category_taxonomy'] ) ? $args['category_taxonomy'] : 'category';
$tag_taxonomy       = isset( $args['tag_taxonomy'] ) ? $args['tag_taxonomy'] : '';
$selected_categories = isset( $args['selected_categories'] ) ? array_map( 'absint', (array) $args['selected_categories'] ) : array();
$selected_tags       = isset( $args['selected_tags'] ) ? array_map( 'absint', (array) $args['selected_tags'] ) : array(); ?>

<?php if ( 'checkbox' === $view ) : ?>
	<div class="cpt-list-filters links_uppercase">
		<button type="button" class="cpt-list-filters__item is-active" data-term="all"><?php esc_html_e( 'All', 'incredibuild' ); ?></button>
		<?php if ( ! empty( $category_terms ) ) : ?>
			<?php foreach ( $category_terms as $term ) : ?>
				<button type="button" class="cpt-list-filters__item" data-term="<?php echo esc_attr( $term->slug ); ?>">
					<?php echo esc_html( $term->name ); ?>
				</button>
			<?php endforeach; ?>
		<?php endif; ?>
	</div>
<?php elseif ( 'select' === $view ) : ?>
	<div class="cpt-list-select-filters flex align_c gap_16">
		<div class="cpt-list-filters-label white semibold fz_18">
			<?php esc_html_e( 'Filter', 'incredibuild' ); ?>
		</div>

		<?php if ( $tag_taxonomy && ! empty( $tag_terms ) ) : ?>
			<select
				class="cpt-list-filters__select select2"
				data-taxonomy="<?php echo esc_attr( $tag_taxonomy ); ?>">
				<option value=""><?php esc_html_e( 'Process Type', 'incredibuild' ); ?></option>
				<?php foreach ( $tag_terms as $term ) : ?>
					<option value="<?php echo esc_attr( $term->term_id ); ?>">
						<?php echo esc_html( $term->name ); ?>
					</option>
				<?php endforeach; ?>
			</select>
		<?php endif; ?>


		<?php if ( ! empty( $category_terms ) ) : ?>
			<select
				class="cpt-list-filters__select select2"
				data-taxonomy="<?php echo esc_attr( $category_taxonomy ); ?>">
				<option value=""><?php esc_html_e( 'Industry', 'incredibuild' ); ?></option>
				<?php foreach ( $category_terms as $term ) : ?>
					<option value="<?php echo esc_attr( $term->term_id ); ?>">
						<?php echo esc_html( $term->name ); ?>
					</option>
				<?php endforeach; ?>
			</select>
		<?php endif; ?>

	</div>
<?php elseif ( 'type' === $view ) :
	$category_terms = ['press', 'news', 'educational'];
	?>
	<div class="cpt-list-filters cpt-list-filters-full-grid links_uppercase">
		<button type="button" class="cpt-list-filters__item is-active" data-term="all"><?php esc_html_e( 'All', 'incredibuild' ); ?></button>
		<?php if ( ! empty( $category_terms ) ) : ?>
			<?php foreach ( $category_terms as $term ) : ?>
				<button type="button" class="cpt-list-filters__item tt_u" data-term="<?php echo esc_attr( $term ); ?>">
					<?php echo esc_html( $term ); ?>
				</button>
			<?php endforeach; ?>
		<?php endif; ?>
	</div>
<?php elseif ( 'glossarys' === $view ) :
	$alphabet_letters = isset( $args['alphabet_letters'] ) && is_array( $args['alphabet_letters'] ) ? $args['alphabet_letters'] : range( 'A', 'Z' );
	?>
	<div class="cpt-list-filters cpt-alphabet-filters links_uppercase">
		<button type="button" class="cpt-list-filters__item is-active" data-term="all"><?php esc_html_e( 'All', 'incredibuild' ); ?></button>
		<?php if ( ! empty( $alphabet_letters ) ) : ?>
			<?php foreach ( $alphabet_letters as $letter ) : ?>
				<button type="button" class="cpt-list-filters__item tt_u" data-term="<?php echo esc_attr( $letter ); ?>">
					<?php echo esc_html( $letter ); ?>
				</button>
			<?php endforeach; ?>
		<?php endif; ?>
	</div>
<?php endif; ?>	