<?php 
$cpt_name = $args['cpt_name'];
$placeholder = get_sub_field('placeholder');
$cpt_name = $cpt_name === 'post' ? 'posts' : $cpt_name;
$post_id = $args['post_id'] ? $args['post_id'] : get_the_ID();

// Generate ID from hero_post field or post title (matching shortcode logic)
$hero_post_field = get_sub_field('hero_post');
$post_title = get_the_title($post_id);
if ( ! empty( $hero_post_field ) ) {
    $heading_id = sanitize_title( $hero_post_field );
} else {
    $heading_id = sanitize_title( $post_title );
}
// Ensure ID is not empty
if ( empty( $heading_id ) ) {
    $heading_id = sanitize_title( $post_title );
    if ( empty( $heading_id ) ) {
        $heading_id = 'hero-' . $post_id;
    }
}
?>
<div class="article_top border_bottom <?php echo $cpt_name; ?>">
    <div class="container article_top-breadrumbs">
    <?php get_template_part('page-templates/partials/breadcrumbs', null, array('cpt_name' => $cpt_name)); ?>
    </div>
			<div class="container article_top-main flex align_st justify_sb">
				<div class="article_top-content flex dir_col justify_sb">
				    <h1 id="<?php echo esc_attr( $heading_id ); ?>" class="article_top-title h2 white"><?php echo get_the_title($post_id); ?></h1>
                    <div class="links_uppercase">
                    <span class="article_top-date">[ <?php echo get_the_date('', $post_id); ?> ]</span>
                    </div>
				</div>
				<div class="article_top-image flex_auto">
					<?php if(get_the_post_thumbnail($post_id)): ?>
						<?php the_post_thumbnail('full', array('class' => 'article_top-image-img ')); ?>
					<?php elseif($placeholder): ?>
						<?php echo wp_get_attachment_image($placeholder['ID'], 'full', false, array('class' => 'article_top-image-img')); ?>
					<?php endif; ?>
				</div>
			</div>
		</div>