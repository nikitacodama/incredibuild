<?php 
$cpt_name = $args['cpt_name'];
$post_id = $args['post_id'];
$excerpt  =  get_field('short_text', $post_id) ? get_field('short_text', $post_id) : get_sub_field('default_excerpt');
$buttons  =  get_field('buttons_action', $post_id) ? get_field('buttons', $post_id) : get_sub_field('buttons');
$cpt_name = $cpt_name === 'post' ? 'posts' : $cpt_name;

?>
<div class="article_top article_top-buttons border_bottom">
    <div class="container article_top-breadrumbs">
    <?php get_template_part('page-templates/partials/breadcrumbs', null, array('cpt_name' => $cpt_name)); ?>
    </div>
			<div class="container article_top-main flex align_st justify_sb">
				<div class="article_top-content flex dir_col justify_sb">
                    <div class="article_top-content-title flex align_c justify_fs"> 
                    <div class="article_top-icon flex_auto flex align_c justify_c">
					<?php if(get_the_post_thumbnail()): ?>
						<?php the_post_thumbnail('thumbnail', array('class' => 'article_top-image-img-icon')); ?>
					<?php endif; ?>
				</div>
                    <h1 class="article_top-title h2 white"><?php the_title(); ?></h1>
                    </div>
                    <?php if($excerpt): ?>
                    <div class="article_top-excerpt fz_18 white-70"><?php echo $excerpt; ?></div>
                    <?php endif; ?>
                    <?php if($buttons): ?>
                    <div class="article_top-buttons flex align_c justify_fs gap_16">
                        <?php get_template_part('page-templates/partials/part_buttons', null, array('buttons' => $buttons)); ?>
                    </div>
                    <?php endif; ?>
				</div>
			</div>
		</div>