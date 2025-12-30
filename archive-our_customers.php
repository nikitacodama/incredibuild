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

<style>
#main .dropdown-wrapper{
    padding-top: 50px;
    padding-bottom: 50px;
    width: 75%;
    margin: auto;
}
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
.ae-dropdown .dropdown-menu li a {text-decoration: none;}
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
#main .ae-dropdown.dropdown {width:35% ;    position: relative;}
#main .dropdowntitle {width:14%;    font-size: 18px;
    font-weight: 600;display: inline-block; }


    #util-menu li.button a { box-sizing: border-box;text-decoration: none; }
nav a {text-decoration: none;color:#1b1b1b;}

.sc .language-switcher {display:none;}

@media screen and (max-width:1000px) {
    #main .ae-dropdown.dropdown { width: 83%;}
    #main .dropdowntitle { width: 90%;}
 }

 .archive-item > a .thumb-wrap {
    width: 100%;
   margin: 0 0 30px 0;
   
}
.archive-item > a .thumb-wrap > img {
    width: 100%;
    height:auto;
    object-fit: inherit;
}
 </style>

<div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">

    <section class="hero-short gallery-hero">
            <div class="hero-oblique-gallery"><div class="item-wrap" style="--z-index: 7;"><div class="image-wrap"><img src="https://www.incredibuild.com/wp-content/uploads/2022/01/case-studies-header_0000_Layer-6.jpg" aria-hidden="true" alt=""></div></div><div class="item-wrap" style="--z-index: 6;"><div class="image-wrap"><img src="https://www.incredibuild.com/wp-content/uploads/2022/01/case-studies-header_0001_Layer-5.jpg" aria-hidden="true" alt=""></div></div><div class="item-wrap" style="--z-index: 5;"><div class="image-wrap"><img src="https://www.incredibuild.com/wp-content/uploads/2022/01/case-studies-header_0002_Layer-4.jpg" aria-hidden="true" alt=""></div></div><div class="item-wrap" style="--z-index: 4;"><div class="image-wrap"><img src="https://www.incredibuild.com/wp-content/uploads/2022/01/case-studies-header_0003_Layer-3.jpg" aria-hidden="true" alt=""></div></div><div class="item-wrap" style="--z-index: 3;"><div class="image-wrap"><img src="https://www.incredibuild.com/wp-content/uploads/2022/01/case-studies-header_0004_Layer-2.jpg" aria-hidden="true" alt=""></div></div><div class="item-wrap" style="--z-index: 2;"><div class="image-wrap"><img src="https://www.incredibuild.com/wp-content/uploads/2022/01/case-studies-header_0005_Layer-1.jpg" aria-hidden="true" alt=""></div></div></div>                    <div class="hero-wrap">
                        <div class="hero-inner container-wide">
                            <h1 class="hero-title">Our customers</h1>                        </div>
                    </div>
        </section>


<section class="archive-wrap" data-cpt="our_customers" data-ppp="">
    <div class="container-wide">
        <!-- Dropdown Filters -->
        <div class="dropdown-wrapper">
            <div class="dropdowntitle">Filter by</div>

            <!-- Tag Dropdown -->
            <div class="ae-dropdown dropdown">
                <div class="ae-select">
                    <span class="ae-select-content">
                        <?php echo (isset($_GET['tag']) ? get_tag(get_term_by('slug', $_GET['tag'], 'post_tag')->term_id)->name : 'All Process Types'); ?>
                    </span>
                    <i class="material-icons down-icon">‹</i>
                </div>
                <ul class="dropdown-menu ae-hide">
                    <li class="selected"><a href="<?php echo get_post_type_archive_link('our_customers'); ?>">All Process Types</a></li>
                    <?php
                    $args = array(
                        'post_type' => 'our_customers',
                        'posts_per_page' => -1,
                        'fields' => 'ids',
                    );
                    $customer_posts = get_posts($args);

                    if (!empty($customer_posts)) {
                        $tags = wp_get_object_terms($customer_posts, 'post_tag', array('fields' => 'all'));

                        if (!empty($tags) && !is_wp_error($tags)) {
                            foreach ($tags as $tag) {
                                echo '<li><a href="?tag=' . $tag->slug . '">' . $tag->name . '</a></li>';
                            }
                        } else {
                            echo '<li>No tags found</li>';
                        }
                    } else {
                        echo '<li>No posts found</li>';
                    }
                    ?>
                </ul>
            </div>

            <!-- Category Dropdown -->
            <div class="ae-dropdown dropdown">
                <div class="ae-select">
                    <span class="ae-select-content">
                        <?php echo (isset($_GET['category']) ? get_cat_name(get_term_by('slug', $_GET['category'], 'category')->term_id) : 'All Industries'); ?>
                    </span>
                    <i class="material-icons down-icon">‹</i>
                </div>
                <ul class="dropdown-menu ae-hide">
                    <li class="selected"><a href="<?php echo get_post_type_archive_link('our_customers'); ?>">All Industries</a></li>
                    <?php
                    if (!empty($customer_posts)) {
                        $categories = wp_get_object_terms($customer_posts, 'category', array('fields' => 'all'));

                        if (!empty($categories) && !is_wp_error($categories)) {
                            foreach ($categories as $category) {
                                echo '<li><a href="?category=' . $category->slug . '">' . $category->name . '</a></li>';
                            }
                        } else {
                            echo '<li>No categories found</li>';
                        }
                    } else {
                        echo '<li>No posts found</li>';
                    }
                    ?>
                </ul>
            </div>
        </div>
    </div>

    <!-- Our Customers Grid -->
    <div class="archive-grid container-wide">
<?php
// Set up pagination and query args based on selected filters
$paged = (get_query_var('page')) ? get_query_var('page') : 1;

$args = array(
    'post_type' => 'our_customers',
    'posts_per_page' => 12,
    'paged' => $paged,
);

if (isset($_GET['category'])) {
    $category = get_term_by('slug', $_GET['category'], 'category');
    if ($category) {
        $args['cat'] = $category->term_id;
    }
}

if (isset($_GET['tag'])) {
    $tag = get_term_by('slug', $_GET['tag'], 'post_tag');
    if ($tag) {
        $args['tag_id'] = $tag->term_id;
    }
}

$customers_query = new WP_Query($args);

if ($customers_query->have_posts()) :
    while ($customers_query->have_posts()) : $customers_query->the_post(); ?>
        <div class="archive-item">
            <a href="<?php the_permalink(); ?>">
                <div class="thumb-wrap">
                    <?php the_post_thumbnail(); ?>
                </div>
                <h3><?php the_title(); ?></h3>
                <div class="excerpt"><?php the_excerpt(); ?></div>
            </a>
        </div>
    <?php endwhile;
else : ?>
    <p>No customers found.</p>
<?php endif;
wp_reset_postdata();
?>

    </div>

    <!-- Pagination -->
    <div class="pagination">
        <?php
        $base_url = get_post_type_archive_link('our_customers');
        $query_string = array_filter($_GET); // Retain existing query strings (tags/categories)
        unset($query_string['page']); // Remove 'page' from query to construct the base URL
        $query_string = http_build_query($query_string);

        // Add correct separator for pagination links
        $pagination_base = !empty($query_string) ? $base_url . '?' . $query_string . '&page=%#%' : $base_url . '?page=%#%';

        $pagination_args = array(
            'base' => $pagination_base,
            'format' => '%#%',
            'current' => max(1, $paged),
            'total' => $customers_query->max_num_pages,
            'prev_text' => __('« Prev'),
            'next_text' => __('Next »'),
        );

        echo paginate_links($pagination_args);
        ?>
    </div>
</section>

        
    
    </main><!-- .site-main -->
</div>
<script>


jQuery( ".ae-dropdown" ).each(function(index) {
    jQuery(this).on("click", function(){
        jQuery(this).children('.dropdown-menu').toggleClass('ae-hide');
    });
});


</script>
<?php get_footer(); ?>