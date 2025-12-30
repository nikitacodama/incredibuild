<?php
// Get shortcode_list from args first (for fetch-page.php), fallback to get_sub_field()
// Check if args has shortcode_list (even if empty array) - this takes priority for fetch-page.php
if (isset($args['shortcode_list'])) {
	$shortcode_list = $args['shortcode_list'];
} else {
	$shortcode_list = get_sub_field('shortcode_list');
}

// Ensure it's an array
if (!is_array($shortcode_list)) {
	$shortcode_list = array();
}
$post_id = isset($args['post_id']) && $args['post_id'] ? $args['post_id'] : get_the_ID();
$compilation_time = get_field('compilation_time', $post_id) ? get_field('compilation_time', $post_id) : false;
$compilation_improve = get_field('compilation_improve', $post_id) ? get_field('compilation_improve', $post_id) : false;
$post_type = get_post_type($post_id);

// Get post content and check for benchmarks-wrap block
$post_content_raw = get_post_field('post_content', $post_id);
$benchmarks_block = false;
if ($post_content_raw) {
	// Check if content contains benchmarks-wrap block
	// Match from <div class="benchmarks-wrap to the closing </div> that closes the benchmarks-wrap div
	if (preg_match('/<div\s+class="benchmarks-wrap[^"]*"[^>]*>.*?<\/dl><\/div>/s', $post_content_raw, $matches)) {
		$benchmarks_block = $matches[0];
	}
}
?>
<div class="article_content border_bottom">
	<div class="article_content-inner container flex justify_sb align_st">
		<div class="article_content-text">
			<?php
			$post_content = get_post_field('post_content', $post_id);
			$post_content = apply_filters('the_content', $post_content);

			$about_output = '';
			$rest_content = $post_content;
			if ($post_type == 'our_customers') {
				// -----------------------
// CASE 1: H2 exists
// -----------------------
				if (preg_match('/<h2[^>]*>.*?<\/h2>/s', $post_content, $h2_match, PREG_OFFSET_CAPTURE)) {

					$h2 = $h2_match[0][0];          // first h2
					$h2_pos = $h2_match[0][1];      // position of h2
			
					// Find first <p> AFTER this h2
					$after_h2_content = substr($post_content, $h2_pos + strlen($h2));
					if (preg_match('/<p[^>]*>.*?<\/p>/s', $after_h2_content, $p_match)) {

						$first_p_after_h2 = $p_match[0];
						$about_output = $h2 . $first_p_after_h2;

						// Remove these from the rest content
						$rest_content = str_replace($h2, '', $post_content);
						$rest_content = str_replace($first_p_after_h2, '', $rest_content);
					}

				}
				// -----------------------
// CASE 2: No H2 → take first two <p>
// -----------------------
				else {
					if (preg_match_all('/<p[^>]*>.*?<\/p>/s', $post_content, $p_matches)) {

						$first_p = $p_matches[0][0] ?? '';
						$second_p = $p_matches[0][1] ?? '';

						$about_output = $first_p . $second_p;

						// Remove taken <p> from the rest content
						$rest_content = preg_replace('/<p[^>]*>.*?<\/p>/s', '', $post_content, 2);
					}
				}
				echo '<div class="content_about">' . $about_output . '</div>';
			}

			// Output (only for our_customers post type)    
			echo $rest_content;
			?>

			<?php 
				$compilation_table_top_title = get_field('compilation_table_top_title') ? get_field('compilation_table_top_title') : false;
				$compilation_table = get_field('compilation_table');
			?>

			<?php if (!$benchmarks_block && $compilation_table && $post_type == 'our_customers'): ?>
				<div class="article_content-compilation-time">
					<?php if($compilation_table_top_title ): ?>
					<h6 class="article_content-compilation-time-title white">
						<?php echo $compilation_table_top_title; ?>
					</h6>
					<?php endif; ?>
					<div class="flex dir_col gap_16">
					<?php foreach($compilation_table as $item): ?>
						<h6 class="article_content-compilation-time-title white">
							<?php echo $item['compilation_label']; ?>
						</h6>
					<div class="flex align_c gap_16">
						<div class="article_content-compilation-time-label w_full ff_mono text_c tt_u">
							<?php echo $item['compilation_time']; ?>
						</div>
						<div class="cpt_loop-card__compilation-time-divider flex_auto">
							<img src="<?php echo get_template_directory_uri(); ?>/assets/images/arrow-right-40.svg"
								alt="<?php esc_html_e('Divider', 'incredibuild'); ?>">
						</div>
						<div
							class="article_content-compilation-time-label article_content-compilation-time-label-improve w_full ff_mono green tt_u text_c">
							<?php echo $item['compilation_improve']; ?>
						</div>
					</div>						
					<?php endforeach; ?>
					</div>
				</div>
			<?php endif; ?>
		</div>
		<div class="article_content-sidebar flex_auto">
			<div class="article_content-sidebar-inner">
				<?php if (!empty($shortcode_list) && is_array($shortcode_list)): ?>
					<?php foreach ($shortcode_list as $shortcode) {
						if (isset($shortcode['shortcode'])) {
							echo do_shortcode($shortcode['shortcode']);
						}
					} ?>
				<?php else: ?>
					<?php echo do_shortcode('[table_content]'); ?>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>