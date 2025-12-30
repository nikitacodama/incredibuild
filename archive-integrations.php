<?php
/**
 * Archive template for integrations post type
 * 
 * This template is handled by the handle_cpt_archive_template() function
 * which checks ACF options and loads flexible-page.php if configured
 *
 * @package WordPress
 * @subpackage Your_Theme
 * @since Your_Theme 1.0
 */

// The template is automatically handled by the template_include filter
// in functions.php via handle_cpt_archive_template()
// If no match is found in ACF, WordPress will fall back to this template

get_header();
?>

<main class="main">
    <?php if ( have_posts() ) : ?>
        <?php while ( have_posts() ) : the_post(); ?>
            <?php get_template_part( 'template-parts/content', get_post_type() ); ?>
        <?php endwhile; ?>
    <?php else : ?>
        <p><?php esc_html_e( 'No posts found.', 'text_domain' ); ?></p>
    <?php endif; ?>
</main>

<?php get_footer(); ?>