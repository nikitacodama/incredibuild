<?php
/**
 * The header for your theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @package WordPress
 * @subpackage Your_Theme
 * @since Your_Theme 1.0
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<?php
$template_part_block = '<!-- wp:template-part {"slug":"global-header","theme":"incredibuild_24"} /-->';
echo do_blocks( $template_part_block );
?>
<link href='/wp-content/themes/incredibuild_24/style_2024.css' rel='stylesheet' type='text/css'>





<?php
$template_part_block = '<!-- wp:template-part {"slug":"incredibuild-footer","theme":"incredibuild_24"} /-->';
echo do_blocks( $template_part_block );
?>

<?php wp_footer(); ?>

</body>
</html>