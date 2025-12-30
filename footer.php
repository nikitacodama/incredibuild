<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Incredibuild
 */

$header_content = get_field('header','options');
$header_logo = $header_content['logo'];
$footer_content = get_field('footer','options');
$adwards = $footer_content['adwards'];
$copyright = $footer_content['copyright'];
$columns = $footer_content['columns'];
$socials = $footer_content['socials'];
?>

	<div class="footer">
		<div class="container_default footer_top grid align_st justify_sb">
			<div class="footer_top-col footer_top-col-logo flex dir_col justify_sb">
			<?php if($header_logo): ?>
            <a href="<?php echo home_url(); ?>" class="header_logo flex_auto">
                <?php echo wp_get_attachment_image($header_logo['id'], 'full'); ?>
            </a>
            <?php endif; ?>
			<?php if($adwards): ?>
			<div class="adwards flex align_c gap_12 flex_wrap">
				<?php foreach($adwards as $adward): ?>
					<?php echo wp_get_attachment_image($adward['id'], 'full'); ?>
				<?php endforeach; ?>
			</div>
			<?php endif; ?>
			</div>
			<?php foreach($columns as $column): ?>
			<div class="footer_top-col footer_top-col-menu">
				<?php if($column['label']): ?>
				<div class="footer_label white semibold"><?php echo $column['label']; ?></div>
				<?php endif; ?>
				<?php if($column['links']): ?>
					<div class="footer_menu links_uppercase">
					<?php foreach($column['links'] as $link): ?>
						<a class="footer_menu-link" href="<?php echo $link['link']['url']; ?>"><?php echo $link['link']['title']; ?></a>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>
				<?php if($column['text']): ?>
				<div class="footer_text white">
					<?php echo $column['text']; ?>
				</div>
				<?php endif; ?>
			</div>
			<?php endforeach; ?>
		</div>
		<div class="container_default footer_bottom flex align_fe justify_sb">
			<?php if($copyright): ?>
			<div class="footer_copyright">
				<?php echo $copyright; ?>
			</div>
			<?php endif; ?>
			<?php if($socials): ?>
			<?php get_template_part('page-templates/partials/socials'); ?>
			<?php endif; ?>
		</div>
	</div>

</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>