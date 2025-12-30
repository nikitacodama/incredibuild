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
<?php get_header(); ?>
<link href='/wp-content/themes/incredibuild_24/oldcss.css' rel='stylesheet' type='text/css'>
<link href='/wp-content/themes/incredibuild_24/helpers.css' rel='stylesheet' type='text/css'>
<div id="primary" class="content-area">
<main id="main" class="site-main" role="main">
 
<style>
#main .dropdown-wrapper{
    padding-top: 50px;
    padding-bottom: 50px;
    width: 75%;
    margin: auto;
}
html:lang(ja) #main .dropdown-wrapper{width: 100%; }


@media screen and (max-width: 1000px) {
  #main   .dropdown-wrapper{  width: 100%; }
}

#main .dropdown-wrapper .ae-select {
    border-radius: 25px;
    padding: 0 20px;
    font-size: 16px;
    color: #000;
    background-color: #ffffff;
    display: flex;
    align-items: center;
    border: 1px solid #D2DADC;
    position: relative;
    height: 45px;
}

#main .dropdown-wrapper .ae-select.chosen {
    color: #333;
}

#main .dropdown-wrapper .ae-select .down-icon, .ae-select .up-icon {
    position: absolute;
    right: 19px;
    top: -3px;
    transform: rotate(0.75turn);
    font-size: 36px;
}
.ae-dropdown .dropdown-menu li a {text-decoration: none; display: block;}
.ae-dropdown .dropdown-menu li a i.ss-icon {
    font-size: 16px;
    color: #000;
    text-decoration: none;
}
#main .dropdown-wrapper .ae-dropdown .dropdown-menu {
    background: #fff;
    box-shadow: none;
    border-radius: 11px;
    position: absolute;
    z-index: 1000;
    width: 100%;
}

#main .dropdown-wrapper .ae-dropdown .ae-select, .dropdown-wrapper .ae-dropdown .dropdown-menu>li {
    cursor: pointer;
}

#main .dropdown-wrapper .ae-dropdown .dropdown-menu>li>a:focus, .dropdown-wrapper .ae-dropdown .dropdown-menu>li>a:hover {
    background: none;
}

#main .dropdown-wrapper .ae-disabled{
    pointer-events: none;
}

#main .ae-hide{
  display:none;
}

#main .ae-dropdown ul.dropdown-menu{
  list-style-type: none;
}

#main .ae-dropdown ul.dropdown-menu{
  margin:0px;
  padding:5px;
  border: 1px solid #ccc;
}

#main .ae-dropdown ul.dropdown-menu li{
  padding:5px 0px;
}
#main .ae-dropdown.dropdown,.dropdowntitle {display:inline-block;} 
#main .ae-dropdown.dropdown.fb {width:12% ;}
html:lang(ja) #main .ae-dropdown.dropdown.fb {width: 16%;}

#main .ae-dropdown.dropdown {width:28% ;    position: relative;    padding: 0 5px; box-sizing: border-box;}
    html:lang(ja) #main .ae-dropdown.dropdown {width: 26%;}
#main .dropdowntitle {width:14%;    font-size: 18px;
    font-weight: 600;display: inline-block; }


    #util-menu li.button a { box-sizing: border-box;text-decoration: none; }
nav a {text-decoration: none;color:#1b1b1b;}

.sc .language-switcher {display:none;}
#main .dropdowntitle {
    width: 32%;
    font-size: 18px;
    font-weight: 600;
}
@media screen and (max-width:1000px) {
    #main .ae-dropdown.dropdown { width: 83%;}
    #main .dropdowntitle { width: 90%;}
 }

.page-numbers {display: flex;}
 </style>
<section class="hero-short">
            <img class="hero-bg" src="https://www.incredibuild.com/wp-content/uploads/2021/07/resources.jpg" srcset="https://www.incredibuild.com/wp-content/uploads/2021/07/resources-300x63.jpg 300w, https://www.incredibuild.com/wp-content/uploads/2021/07/resources-1024x213.jpg 1024w, https://www.incredibuild.com/wp-content/uploads/2021/07/resources-768x160.jpg 768w, https://www.incredibuild.com/wp-content/uploads/2021/07/resources-1536x320.jpg 1536w, https://www.incredibuild.com/wp-content/uploads/2021/07/resources-1200x250.jpg 1200w, https://www.incredibuild.com/wp-content/uploads/2021/07/resources.jpg 1920w" alt="" aria-hidden="true">            <div class="hero-wrap">
                <div class="hero-inner container-wide">
                    <h1 class="hero-title">Incredibuild Resources</h1>                    <svg class="hero-shape hero-shape-right" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="538" height="355" viewBox="0 0 538 355">
                        <defs>
                            <clipPath id="clip-path">
                            <rect id="Rectangle_129" data-name="Rectangle 129" width="538" height="355" transform="translate(1066 100)"></rect>
                            </clipPath>
                            <linearGradient id="linear-gradient" x1="0.5" y1="0.153" x2="0.5" y2="1" gradientUnits="objectBoundingBox">
                            <stop offset="0" stop-color="#00e5b1"></stop>
                            <stop offset="1"></stop>
                            </linearGradient>
                            <linearGradient id="linear-gradient-2" x1="0.5" y1="0.153" y2="0.722" xlink:href="#linear-gradient"></linearGradient>
                        </defs>
                        <g id="Group_177" data-name="Group 177" transform="translate(-1216 -145)">
                            <g id="Mask_Group_26" data-name="Mask Group 26" transform="translate(150 45)" opacity="0.5" clip-path="url(#clip-path)">
                            <g id="Group_123" data-name="Group 123" transform="translate(1075.978 100)">
                                <path id="Subtraction_1" data-name="Subtraction 1" d="M303.1,354.777H0L224.428,0h303.1L303.1,354.776Z" transform="translate(0 0)" opacity="0.5" fill="url(#linear-gradient)"></path>
                                <path id="Subtraction_2" data-name="Subtraction 2" d="M303.1,354.777H0L224.428,0h303.1L303.1,354.776Z" transform="translate(0 98.672)" opacity="0.5" fill="url(#linear-gradient-2)"></path>
                            </g>
                            </g>
                            <path id="Path_123" data-name="Path 123" d="M35.226,1.5h29.32L-.379,104.135H-29.7Z" transform="translate(1377.7 278.865)" fill="#00e5b1"></path>
                        </g>
                    </svg>
                    <svg class="hero-shape hero-shape-left" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="482" height="283" viewBox="0 0 482 283">
                        <defs>
                            <clipPath id="clip-path">
                            <rect id="Rectangle_132" data-name="Rectangle 132" width="482" height="283" transform="translate(1074 100.26)"></rect>
                            </clipPath>
                            <linearGradient id="linear-gradient" x1="0.5" y1="0.153" x2="0.5" y2="1" gradientUnits="objectBoundingBox">
                            <stop offset="0" stop-color="#00e5b1"></stop>
                            <stop offset="1"></stop>
                            </linearGradient>
                            <linearGradient id="linear-gradient-2" x1="0.5" y1="0.153" y2="0.722" xlink:href="#linear-gradient"></linearGradient>
                        </defs>
                        <g id="Mask_Group_27" data-name="Mask Group 27" transform="translate(1556 383.26) rotate(180)" opacity="0.5" clip-path="url(#clip-path)">
                            <g id="Group_124" data-name="Group 124" transform="translate(1073.962 99.982)">
                            <path id="Subtraction_3" data-name="Subtraction 3" d="M241.866,283.1H0L179.086,0H420.952L241.866,283.1Z" transform="translate(0 0)" opacity="0.5" fill="url(#linear-gradient)"></path>
                            <path id="Subtraction_4" data-name="Subtraction 4" d="M241.866,283.1H0L179.086,0H420.952L241.866,283.1Z" transform="translate(52 78.737)" opacity="0.5" fill="url(#linear-gradient-2)"></path>
                            </g>
                        </g>
                    </svg>
                </div>
            </div>
        </section>

    <section class="archive-wrap" data-cpt="resources_library" data-ppp="6">
        <div class="container-wide">
            <div class="dropdown-wrapper">
            <div class="ae-dropdown dropdown fb dropdowntitle">Filter by</div>>
                <!-- Resource Types Dropdown -->
                <div class="ae-dropdown dropdown">
                    <div class="ae-select">
                        <span class="ae-select-content">
                        <?php
// Check if 'resource_type' is set in the query string
if (isset($_GET['resource_type'])) {
    // Sanitize the input
    $resource_type_slug = sanitize_text_field($_GET['resource_type']);
    
    // Get the resource type term by slug
    $resource_type = get_term_by('slug', $resource_type_slug, 'resource_type'); // Use your taxonomy name

    // Check if the resource type exists
    if ($resource_type) {
        // Output the resource type name
        echo esc_html($resource_type->name); 
    } else {
        // If the resource type doesn't exist, you can output a default message
        echo 'Resource type not found.';
    }
} else {
    // Default message when no resource type is selected
    echo 'All Resource Types';
}
?>




                            
                        </span>
                        <i class="material-icons down-icon">‹</i>
                    </div>
                    <ul class="dropdown-menu ae-hide">
                        <li><a href="/resources" aria-label="All Resource Types">All Resource Types</a></li>
                        <?php
                        $resource_types = get_terms(array(
                            'taxonomy' => 'resource_type',
                            'hide_empty' => true, // Show only terms with posts
                        ));
                        foreach ($resource_types as $type) {
                            echo '<li><a href="?resource_type=' . esc_attr($type->slug) . '" aria-label="' . esc_attr($type->name) . '">' . esc_html($type->name) . '</a></li>';
                        }
                        ?>
                    </ul>
                </div>

                <!-- Categories Dropdown -->
                <div class="ae-dropdown dropdown">
                    <div class="ae-select">
                        <span class="ae-select-content">
                        <?php
// Check if 'category' is set in the query string
if (isset($_GET['category'])) {
    // Sanitize the input
    $category_slug = sanitize_text_field($_GET['category']);
    
    // Get the category object by slug
    $category = get_category_by_slug($category_slug);

    // Check if the category exists
    if ($category) {
        // Output the category name
        echo esc_html($category->name); 
    } else {
        // If the category doesn't exist, you can output a default message
        echo 'Category not found.';
    }
} else {
    // Default message when no category is selected
    echo 'All Categories';
}
?>
                        </span>
                        <i class="material-icons down-icon">‹</i>
                    </div>
                    <ul class="dropdown-menu ae-hide">
                        <li><a href="/resources" aria-label="All Categories">All Categories</a></li>
                        <?php
                        $categories = get_terms(array(
                            'taxonomy' => 'category',
                            'hide_empty' => true,
                            'object_ids' => get_posts(array(
                                'post_type' => 'resources_library',
                                'fields' => 'ids',
                                'posts_per_page' => -1,
                            )),
                        ));
                        foreach ($categories as $category) {
                            echo '<li><a href="?category=' . esc_attr($category->slug) . '" aria-label="' . esc_attr($category->name) . '">' . esc_html($category->name) . '</a></li>';
                        }
                        ?>
                    </ul>
                </div>

                <!-- Tags Dropdown -->
                <div class="ae-dropdown dropdown">
                    <div class="ae-select">
                        <span class="ae-select-content">
                        <?php
// Check if 'tag' is set in the query string
if (isset($_GET['tag'])) {
    // Sanitize the input
    $tag_slug = sanitize_text_field($_GET['tag']);
    
    // Get the tag term by slug
    $tag = get_term_by('slug', $tag_slug, 'post_tag'); // 'post_tag' is the taxonomy for tags

    // Check if the tag exists
    if ($tag) {
        // Output the tag name
        echo esc_html($tag->name); 
    } else {
        // If the tag doesn't exist, you can output a default message
        echo 'Tag not found.';
    }
} else {
    // Default message when no tag is selected
    echo 'All Tags';
}
?>

                        </span>
                        <i class="material-icons down-icon">‹</i>
                    </div>
                    <ul class="dropdown-menu ae-hide">
                        <li><a href="/resources" aria-label="All Tags">All Tags</a></li>
                        <?php
                        $tags = get_terms(array(
                            'taxonomy' => 'post_tag',
                            'hide_empty' => true,
                            'object_ids' => get_posts(array(
                                'post_type' => 'resources_library',
                                'fields' => 'ids',
                                'posts_per_page' => -1,
                            )),
                        ));
                        foreach ($tags as $tag) {
                            echo '<li><a href="?tag=' . esc_attr($tag->slug) . '" aria-label="' . esc_attr($tag->name) . '">' . esc_html($tag->name) . '</a></li>';
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </div>

        <div class="archive-grid container-wide">
            <?php
            // Query arguments
            $tax_query = array('relation' => 'AND');
            
            if (isset($_GET['resource_type']) && !empty($_GET['resource_type'])) {
                $tax_query[] = array(
                    'taxonomy' => 'resource_type',
                    'field'    => 'slug',
                    'terms'    => sanitize_text_field($_GET['resource_type']),
                );
            }

            if (isset($_GET['category']) && !empty($_GET['category'])) {
                $tax_query[] = array(
                    'taxonomy' => 'category',
                    'field'    => 'slug',
                    'terms'    => sanitize_text_field($_GET['category']),
                );
            }

            if (isset($_GET['tag']) && !empty($_GET['tag'])) {
                $tax_query[] = array(
                    'taxonomy' => 'post_tag',
                    'field'    => 'slug',
                    'terms'    => sanitize_text_field($_GET['tag']),
                );
            }

            // Custom query
            $args = array(
                'post_type' => 'resources_library',
                'posts_per_page' => 6,
                'paged' => get_query_var('page', 1), // Adjust for the custom page parameter
                'tax_query' => $tax_query,
            );

            $query = new WP_Query($args);

            if ($query->have_posts()) :
                while ($query->have_posts()) : $query->the_post();
                    $resource_type = get_post_meta(get_the_ID(), 'resource_type', true);
                    ?>
                    <div class="archive-item">
                        <a href="<?php the_permalink(); ?>" aria-label="<?php the_title_attribute(); ?>">
                            <div class="thumb-wrap">
                            <div class="type_icon">
    <?php
    // Get the resource type terms for the current post
    $terms = get_the_terms(get_the_ID(), 'resource_type');
    
    if ($terms && !is_wp_error($terms)) {
        // Display the first term (if multiple terms are assigned)
        $term = $terms[0];
        
        // Construct the URL for the term icon
        $icon_url = get_template_directory_uri() . '/img/' . esc_attr($term->slug) . '.svg';
        ?>
        <img src="<?php echo esc_url($icon_url); ?>" alt="Resource type: <?php echo esc_attr($term->name); ?>">
        <span class="resource-type <?php echo esc_attr($term->slug); ?>" aria-label="Resource type: <?php echo esc_attr($term->name); ?>">
            <?php echo esc_html(ucfirst($term->name)); ?>
        </span>
        <?php
    } else {
        echo '<p>No resource type set.</p>';
    }
    ?>
</div>



                                <?php if (has_post_thumbnail()) {
                                    the_post_thumbnail('full', array('alt' => get_the_title()));
                                } ?>
                            </div>
                            <h3><?php the_title(); ?></h3>
                        </a>
                    </div>
                    <?php
                endwhile;
                wp_reset_postdata();
            else :
                echo '<p>No resources found.</p>';
            endif;
            ?>
        </div>

        <section class="">
    <div class="basicWidth">
        <div class="pagination">
            <?php
            // Get the current page number
            $current_page = max(1, get_query_var('page'));

            // Generate pagination links
            echo paginate_links(array(
                'total' => $query->max_num_pages,
                'format' => '?page=%#%',
                'current' => $current_page,
                'prev_text' => __('« Prev'),
                'next_text' => __('Next »'),
                'type' => 'list', // Optional: outputs pagination as a list
            ));
            ?>
        </div>
    </div>
</section>

    </section>
</main>

</div>
<script>


jQuery( ".ae-dropdown" ).each(function(index) {
    jQuery(this).on("click", function(){
        jQuery(this).children('.dropdown-menu').toggleClass('ae-hide');
    });
});


</script>
<?php get_footer(); ?>