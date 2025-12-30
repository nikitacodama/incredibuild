<?php 
$post_id  = isset( $args['post_id'] ) ? (int) $args['post_id'] : get_the_ID();
$cpt_name = isset( $args['cpt_name'] ) ? $args['cpt_name'] : get_post_type( $post_id );
$cpt_name = $cpt_name === 'post' ? 'posts' : $cpt_name;
$excerpt  =  get_field('short_text', $post_id) ? get_field('short_text', $post_id) : get_sub_field('default_excerpt');
$results_text = get_field('results_text', $post_id) ? get_field('results_text', $post_id) : get_field('case_study_archive', 'options')['compilation_process_text'];
$label_industry = get_field('label_industry', $post_id) ? get_field('label_industry', $post_id) : get_field('case_study_archive', 'options')['label_industry'];
$label_process = get_field('label_process', $post_id) ? get_field('label_process', $post_id) : get_field('case_study_archive', 'options')['label_process'];
$label_results = get_field('label_results', $post_id) ? get_field('label_results', $post_id) : get_field('case_study_archive', 'options')['label_results'];

$primary_category = '';
$categories       = get_the_terms( $post_id, 'category' );

if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) {
    $primary_category = $categories[0]->name;
}

$tag_names = array();
$tags      = get_the_terms( $post_id, 'post_tag' );

if ( ! empty( $tags ) && ! is_wp_error( $tags ) ) {
    foreach ( $tags as $tag ) {
        $tag_names[] = $tag->name;
    }
}
?>
<div class="article_top article_top-case-study border_bottom">
    <div class="container article_top-breadrumbs">
    <?php get_template_part('page-templates/partials/breadcrumbs', null, array('cpt_name' => $cpt_name)); ?>
    </div>
			<div class="container article_top-main flex align_fe justify_sb">
				<div class="article_top-content flex dir_col justify_sb">
                <?php if(get_the_post_thumbnail()): ?>
            <div class="article_top-logo">
						<?php the_post_thumbnail('full', array('class' => 'article_top-logo-img ')); ?>
				</div>
                <?php endif; ?>
				    <h1 class="article_top-title h2 white"><?php the_title(); ?></h1>
                    <?php
                        $header_title = get_post_meta(get_the_ID(), '_header_title', true);
                            if ($header_title) {
                                echo '<h2 class="article_top-excerpt h5 white-70">' . $header_title . '</h2>';
                            } elseif($excerpt) {
                                    echo '<h2 class="article_top-excerpt h5 white-70">' . $excerpt . '</h2>';
                                }
                        ?>
                    <?php echo do_shortcode('[share]'); ?>
				</div>
                <div class="article_top-info flex_auto flex dir_col gap_16 white">
                    <div class="article_top-info-item">
                        <div class="article_top-info-item-label flex align_c justify_fs gap_8 semibold fz_18">
                            <img class="article_top-info-item-icon flex_auto" src="<?php echo get_template_directory_uri(); ?>/assets/images/building-ic.svg" alt="<?php _e('Industry', 'incredibuild'); ?>">
                            <?php if ( $label_industry ) : ?>
                                <?php echo $label_industry; ?>
                            <?php else : ?>
                                <?php _e('Industry', 'incredibuild'); ?>
                            <?php endif; ?>
                        </div>
                        <div class="article_top-info-item-value ff_mono tt_u">
                            <?php if ( $primary_category ) : ?>
                                <span class="article_top-info-item-chip"><?php echo esc_html( $primary_category ); ?></span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="article_top-info-item">
                        <div class="article_top-info-item-label flex align_c justify_fs gap_8 semibold fz_18">
                            <img class="article_top-info-item-icon flex_auto" src="<?php echo get_template_directory_uri(); ?>/assets/images/code-ic.svg" alt="<?php _e('Process', 'incredibuild'); ?>">
                            <?php if ( $label_process ) : ?>
                                <?php echo $label_process; ?>
                            <?php else : ?>
                                <?php _e('Process', 'incredibuild'); ?>
                            <?php endif; ?>
                        </div>
                        <div class="article_top-info-item-value ff_mono tt_u">
                            <?php if ( ! empty( $tag_names ) ) : ?>
                                <?php foreach ( $tag_names as $tag_name ) : ?>
                                    <span class="article_top-info-item-chip"><?php echo esc_html( $tag_name ); ?></span>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                     <?php if ( $results_text ) : ?>
                    <div class="article_top-info-item article_top-info-item-accent">
                        <div class="article_top-info-item-label flex align_c justify_fs gap_8 semibold fz_18 green">
                            <img class="flex_auto" src="<?php echo get_template_directory_uri(); ?>/assets/images/result-ic.svg" alt="<?php _e('Process', 'incredibuild'); ?>">
                            <?php if ( $label_results ) : ?>
                                <?php echo $label_results; ?>
                            <?php else : ?>
                                <?php _e('Results', 'incredibuild'); ?>
                            <?php endif; ?>
                        </div>
                         <?php if ( $results_text ) : ?>
                        <div class="article_top-info-item-value ff_mono tt_u green">
                            <?php if ( $results_text ) : ?>
                                <span class="article_top-info-item-chip"><?php echo $results_text; ?></span>
                            <?php endif; ?>
                        </div>
                        <?php endif; ?>
                    </div>
                     <?php endif; ?>
                </div>
			</div>
		</div>