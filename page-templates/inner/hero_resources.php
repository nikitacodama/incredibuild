<?php 
$cpt_name = $args['cpt_name'];
$post_id = $args['post_id'];
$excerpt  =  get_the_content() ? get_the_content() : get_sub_field('default_excerpt');
$buttons  =  get_field('buttons', $post_id) ? get_field('buttons', $post_id) : get_sub_field('buttons');
$cpt_name = $cpt_name === 'post' ? 'posts' : $cpt_name;
// Keep the post type slug for breadcrumbs (not the display label)
$cpt_name_for_breadcrumbs = $cpt_name;
$video = get_field('video', $post_id)

?>
<div class="article_top article_top-buttons article_top-resources border_bottom">
    <div class="container article_top-breadrumbs">
    <?php get_template_part('page-templates/partials/breadcrumbs', null, array('cpt_name' => $cpt_name_for_breadcrumbs)); ?>
    </div>
			<div class="container article_top-main flex align_st justify_sb">
				<div class="article_top-content flex dir_col justify_fs">
                    <div class="article_top-content-title flex align_c justify_fs"> 
                    <h1 class="article_top-title h2 white"><?php the_title(); ?></h1>
                    </div>
                    <?php if($excerpt): ?>
                    <div class="article_top-excerpt article_top-excerpt-content fz_18 white-70"><?php echo $excerpt; ?></div>
                    <?php endif; ?>
                    <?php if($buttons && !$video): ?>
                    <div class="article_top-buttons flex align_c justify_fs gap_16">
                        <?php get_template_part('page-templates/partials/part_buttons', null, array('buttons' => $buttons)); ?>
                    </div>
                    <?php endif; ?>
				</div>
				<div class="article_top-image flex_auto <?php echo $video ? 'article_top-video pause' : ''?>">
                    <?php if($video): ?>
                        <iframe src="<?php echo $video; ?>" allowfullscreen frameborder="0"></iframe>
                        <div class="article_top-video-play"></div>
                    <?php elseif(get_the_post_thumbnail($post_id)): ?>
						<?php the_post_thumbnail('full', array('class' => 'article_top-image-img ')); ?>
					<?php elseif($placeholder): ?>
						<?php echo wp_get_attachment_image($placeholder['ID'], 'full', false, array('class' => 'article_top-image-img')); ?>
					<?php endif; ?>
				</div>
			</div>
		</div>