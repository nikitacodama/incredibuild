<?php
/**
 * Template Name: Flexible Page
 * Description: A flexible page template for creating custom pages with ACF flexible content.
 * Template Post Type: page
 *
 * @package Incredibuild
 * @since 1.0.0
 */
?>

<?php get_header(); ?>



<main class="main">
    <?php 
    $page_id = get_query_var('page_id');
    if($page_id):
        $page = get_post($page_id);
    else: 
        $page_id = get_the_ID();
    endif;
    if(have_rows('flexible_content' , $page_id)): ?>
        <?php while(have_rows('flexible_content' , $page_id)): the_row(); ?>
            <?php 
            // Get the layout name (e.g., 'hero_inner')
            $layout = get_row_layout();
            
            // Load the corresponding template file
            get_template_part('page-templates/flexible/' . $layout);
            ?>
        <?php endwhile; ?>
    <?php endif; ?>
</main>

<?php 
 $custom_css = get_field('custom_css');
 if($custom_css):
    echo '<style>';
    echo $custom_css;
    echo '</style>';
 endif;
?>


<?php get_footer(); ?>