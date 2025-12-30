<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Incredibuild
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">

    <?php wp_head(); ?>
</head>
<?php
get_gutenberg_class();
?>
<?php
// Get all languages in raw array
$languages = pll_the_languages([
    'raw' => 1,
    'show_flags' => 0,
    'show_names' => 0
]);

$current_lang = null;

// Loop to find the current language
if ($languages && is_array($languages)) {
    foreach ($languages as $lang) {
        echo '<div style="display: none;"> ';
            var_dump($lang);
        echo '</div>';
        if ($lang['current_lang']) {
            $current_lang = $lang;
            break;
        }
    }
}

if (!$current_lang) {
    $current_lang = [
        'slug' => 'en',
        'name' => 'English'
    ];
}
?>

<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>
    <div id="page" class="site">
        <?php
        $header_content = get_field('header', 'options');
        $header_logo = $header_content['logo'];
        $header_buttons = $header_content['buttons'];
        $top_bar = $header_content['top_bar'];
        ?>
        <div class="header_main-sticky">
            <?php if ($top_bar): ?>
                <div class="top_bar text_c medium black">
                    <div class="container_default">
                        <?php echo $top_bar; ?>
                    </div>
                </div>
            <?php endif; ?>
            <div class="header_main">
                <div class="container_default flex justify_sb align_c">
                    <?php if ($header_logo): ?>
                        <a href="<?php echo home_url(); ?>" class="header_logo flex_auto">
                            <?php echo wp_get_attachment_image($header_logo['id'], 'full'); ?>
                        </a>
                    <?php endif; ?>
                    <button class="menu_toggle">
                        <img src="<?php echo get_template_directory_uri() ?>/assets/images/menu-ic.svg"
                            alt="Menu Toggle">
                    </button>
                    <div class="header_menu">
                        <?php
                        wp_nav_menu(array(
                            'theme_location' => 'primary',
                            'walker' => new Incredibuild_Custom_Menu_Walker()
                        ));
                        ?>
                        <div class="header_buttons flex align_c gap_16">
                            <?php if ($header_buttons): ?>
                                <?php get_template_part('page-templates/partials/part_buttons', null, array('buttons' => $header_buttons)); ?>
                            <?php endif; ?>
                            <div class="lang-switcher flex_auto">
                                <button class="lang-switcher-current white-70 tt_u ff_mono medium">
                                    <img src="<?php echo get_template_directory_uri() ?>/assets/images/language-ic.svg"
                                        alt="Language">
                                    <?php
                                    echo $current_lang['name'];
                                    ?>
                                </button>
                                <div class="lang-switcher-dropdown tt_u ff_mono">
                                    <ul class="lang-switcher-dropdown-list">
                                        <?php foreach ($languages as $lang): ?>
                                            <?php 
                                                if (!$lang['current_lang']): ?>
                                                <li class="lang-<?php echo $lang['slug']; ?>">
                                                    <a class="lang-switcher-dropdown-list-item semibold" href="<?php echo esc_url($lang['url']); ?>">
                                                        <?php
                                                            echo '<span class="with_divider">' . $lang['slug'] . '</span>' . $lang['name'];
                                                        ?>
                                                    </a>
                                                </li>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>