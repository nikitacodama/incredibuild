<?php
function mytheme_add_admin_page() {
    add_menu_page(
        'Theme Settings',
        'Theme Settings',
        'manage_options',
        'mytheme-settings',
        'mytheme_create_admin_page',
        'dashicons-admin-generic',
        100
    );

    add_submenu_page('mytheme-settings', 'Banner', 'Banner', 'manage_options', 'mytheme-banner', 'mytheme_banner_page');
    add_submenu_page('mytheme-settings', 'Top Banner', 'Top Banner', 'manage_options', 'mytheme-top-banner', 'mytheme_top_banner_page'); // Renamed here
}
add_action('admin_menu', 'mytheme_add_admin_page');

function mytheme_create_admin_page() {
    ?>
    <div class="wrap">
        <h1>Theme Settings</h1>
    
        <?php
        if (isset($_GET['page']) && $_GET['page'] === 'mytheme-banner') {
            mytheme_banner_page();
        } elseif (isset($_GET['page']) && $_GET['page'] === 'mytheme-top-banner') {
            mytheme_top_banner_page();
        }
        else{
            mytheme_banner_page(); 
        }
        ?>
    </div>
    <?php
}

function mytheme_top_banner_page() {
    ?>
       <h1>Theme Settings</h1>
        <h2 class="nav-tab-wrapper">
            <a href="?page=mytheme-banner" class="nav-tab <?php echo (isset($_GET['page']) && $_GET['page'] === 'mytheme-banner') ? 'nav-tab-active' : ''; ?>">Banner</a>
            <a href="?page=mytheme-top-banner" class="nav-tab <?php echo (isset($_GET['page']) && $_GET['page'] === 'mytheme-top-banner') ? 'nav-tab-active' : ''; ?>">Top Banner</a>
        </h2>
    <form method="post" action="options.php">
        <?php
        settings_fields('mytheme_top_banner_settings_group'); // Use the top banner settings group
        $languages = pll_languages_list(); // Get available languages

        // Display the settings for each language in a switcher
        foreach ($languages as $lang) {
            ?>
            <div id="top-banner-settings-<?php echo esc_attr($lang); ?>" style="<?php echo $lang === pll_current_language() ? 'display: block;' : 'display: none;'; ?>">
                
                <div>
                    <label for="mytheme_top_banner_content_<?php echo $lang; ?>">Top Banner Content:</label>
                    <textarea name="mytheme_top_banner_content_<?php echo $lang; ?>" id="mytheme_top_banner_content_<?php echo $lang; ?>"><?php echo esc_textarea(get_option("mytheme_top_banner_content_{$lang}")); ?></textarea>
                </div>
                <div>
                    <label for="mytheme_show_top_banner_<?php echo $lang; ?>">Show Top Banner:</label>
                    <input type="checkbox" name="mytheme_show_top_banner_<?php echo $lang; ?>" id="mytheme_show_top_banner_<?php echo $lang; ?>" value="1" <?php checked(get_option("mytheme_show_top_banner_{$lang}"), 1); ?> />
                </div>
            </div>
            <?php
        }
        ?>
        
   

        <?php submit_button(); ?>
    </form>

    <script>
        // JavaScript to toggle language sections based on language selector
        function changeLanguage(lang) {
            <?php foreach ($languages as $lang) : ?>
                document.getElementById("top-banner-settings-<?php echo esc_js($lang); ?>").style.display = (lang === "<?php echo esc_js($lang); ?>") ? "block" : "none";
            <?php endforeach; ?>
        }
    </script>
    <?php
}


function mytheme_banner_page() {
    ?>
         <h1>Theme Settings</h1>
        <h2 class="nav-tab-wrapper">
            <a href="?page=mytheme-banner" class="nav-tab <?php echo (isset($_GET['page']) && $_GET['page'] === 'mytheme-banner') ? 'nav-tab-active' : ''; ?>">Banner</a>
            <a href="?page=mytheme-top-banner" class="nav-tab <?php echo (isset($_GET['page']) && $_GET['page'] === 'mytheme-top-banner') ? 'nav-tab-active' : ''; ?>">Top Banner</a>
        </h2>
    <form method="post" action="options.php">
        <?php
        settings_fields('mytheme_banner_settings_group'); // Ensure this matches the registered group
        do_settings_sections('mytheme-banner'); // Ensure this matches the settings section

        $languages = pll_languages_list();

        // Display the settings for each language in a switcher
        foreach ($languages as $lang) {
            ?>
            <div id="banner-settings-<?php echo esc_attr($lang); ?>" style="<?php echo $lang === pll_current_language() ? 'display: block;' : 'display: none;'; ?>">
              
                <?php mytheme_banner_fields($lang); ?>
            </div>
            <?php
        }

        submit_button();
        ?>
    </form>

    <script>
        // JavaScript to toggle language sections based on language selector
        document.getElementById("language_switcher").addEventListener("change", function() {
            const selectedLang = this.value;
            <?php foreach ($languages as $lang) { ?>
                document.getElementById("banner-settings-<?php echo esc_attr($lang); ?>").style.display = (selectedLang === "<?php echo esc_js($lang); ?>") ? "block" : "none";
            <?php } ?>
        });
    </script>
    <?php
}

function mytheme_banner_fields($lang) {
    ?>
    <div>
        <label for="mytheme_banner_title_<?php echo $lang; ?>">Banner Title:</label>
        <input type="text" name="mytheme_banner_title_<?php echo $lang; ?>" value="<?php echo esc_attr(get_option("mytheme_banner_title_{$lang}")); ?>" />
    </div>
    <div>
        <label for="mytheme_banner_text_<?php echo $lang; ?>">Banner Text:</label>
        <textarea name="mytheme_banner_text_<?php echo $lang; ?>"><?php echo esc_textarea(get_option("mytheme_banner_text_{$lang}")); ?></textarea>
    </div>
    <div>
        <label for="mytheme_banner_link_url_<?php echo $lang; ?>">Banner Link URL:</label>
        <input type="text" name="mytheme_banner_link_url_<?php echo $lang; ?>" value="<?php echo esc_attr(get_option("mytheme_banner_link_url_{$lang}")); ?>" />
    </div>
    <div>
        <label for="mytheme_banner_link_text_<?php echo $lang; ?>">Banner Link Text:</label>
        <input type="text" name="mytheme_banner_link_text_<?php echo $lang; ?>" value="<?php echo esc_attr(get_option("mytheme_banner_link_text_{$lang}")); ?>" />
    </div>
    <div>
        <label for="mytheme_banner_image_url_<?php echo $lang; ?>">Banner Image URL:</label>
        <input type="text" name="mytheme_banner_image_url_<?php echo $lang; ?>" value="<?php echo esc_attr(get_option("mytheme_banner_image_url_{$lang}")); ?>" />
    </div>
    <div>
        <label for="mytheme_show_banner_<?php echo $lang; ?>">Show Banner:</label>
        <input type="checkbox" name="mytheme_show_banner_<?php echo $lang; ?>" value="1" <?php checked(get_option("mytheme_show_banner_{$lang}"), true); ?> />
    </div>
    <?php
}

function mytheme_settings_init() {
    // Existing Banner settings
    add_settings_section('mytheme_banner_settings_section', 'Banner Settings', null, 'mytheme-banner');

    $languages = pll_languages_list();
    foreach ($languages as $lang) {
        register_setting('mytheme_banner_settings_group', "mytheme_banner_title_{$lang}");
        register_setting('mytheme_banner_settings_group', "mytheme_banner_text_{$lang}");
        register_setting('mytheme_banner_settings_group', "mytheme_banner_link_url_{$lang}");
        register_setting('mytheme_banner_settings_group', "mytheme_banner_link_text_{$lang}");
        register_setting('mytheme_banner_settings_group', "mytheme_banner_image_url_{$lang}");
        register_setting('mytheme_banner_settings_group', "mytheme_show_banner_{$lang}");
        
        // Register Top Banner settings for each language
        register_setting('mytheme_top_banner_settings_group', "mytheme_top_banner_content_{$lang}");
        register_setting('mytheme_top_banner_settings_group', "mytheme_show_top_banner_{$lang}");
    }
}


add_action('admin_init', 'mytheme_settings_init');
