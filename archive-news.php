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
#main .dropdown-wrapper { width: 40%; margin-bottom: 11px !important;    }

.dropdown-wrapper{
    padding-top: 50px;
    padding-bottom: 50px;
    width: 65%;
    margin: auto;
}

.dropdown-wrapper .ae-select {
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

.dropdown-wrapper .ae-select.chosen {
    color: #333;
}

.dropdown-wrapper .ae-select .down-icon, .ae-select .up-icon {
    position: absolute;
    right: 19px;
    top: -3px;
    transform: rotate(0.75turn);
    font-size: 36px;
    font-style: initial;
}

.dropdown-wrapper .ae-dropdown .dropdown-menu {
    background: #fff;
    box-shadow: none;
    border-radius: 11px;
    position: absolute;
    z-index: 1000;
    width: 100%;
}

.dropdown-wrapper .ae-dropdown .ae-select, .dropdown-wrapper .ae-dropdown .dropdown-menu>li {
    cursor: pointer;
}

.dropdown-wrapper .ae-dropdown .dropdown-menu>li>a:focus, .dropdown-wrapper .ae-dropdown .dropdown-menu>li>a:hover {
    background: none;
}

.dropdown-wrapper .ae-disabled{
    pointer-events: none;
}

.ae-hide{
  display:none;
}

.ae-dropdown ul.dropdown-menu{
  list-style-type: none;
}

.ae-dropdown ul.dropdown-menu{
  margin:0px;
  padding:5px;
  border: 1px solid #ccc;
}

.ae-dropdown ul.dropdown-menu li{
  padding:5px 0px 5px 15px;

}
.ae-dropdown.dropdown,.dropdowntitle {display:inline-block;position: relative;} 
.ae-dropdown.dropdown {width:36% ;margin-right: 20px;}
.dropdowntitle {width:20%;    font-size: 18px;
    font-weight: 600;margin-bottom:11px; }
 .ae-dropdown .dropdown-menu li a { text-decoration:none;width:100%;display: block;}
 .ae-dropdown .dropdown-menu li a  i.ss-icon {font-size: 16px;color:#000;}

 @media screen and (max-width: 1000px) {
    .dropdown-wrapper{  width: 100%; }
    .dropdowntitle {width: 100%;margin-bottom:20px;}
 .ae-dropdown.dropdown {width: 100%;margin-bottom:20px;}
}
.case-study-summary p.and ,.ae-select-content{text-transform: capitalize;}
.case-study-summary {min-height: 100px;}

.right-action-hero-2 {background-color:#6AC5A7;}
.right-action-hero-2::after {
    content: "";
    display: block;
    position: absolute;
    bottom:0;
    left: 0;
    width: 100vw;
    height: 145px;
    background-color: #EAF0F2;
    -webkit-clip-path: polygon(100% 0, 0% 100%, 100% 100%);
    clip-path: polygon(100% 0, 0% 100%, 100% 100%);
}
.hero-text.educational {min-height: 395px;}
.hero-text.all{min-height: 190px; padding-bottom: 30px;}
.hero-text, .makbilit-con {      flex: none;  width: inherit;  text-align: center;    position: relative;}

.newselector {
    border-radius: 150px;
    border: 2px solid #171E37;
    width: 65%;
    margin: 0 auto 41px;
    display: flex;
    justify-content: space-between;
}
.newselector li {
    padding: 10px;
    border:4px solid #f0f3f4;
    border-radius: 150px;
    background: transparent;
    color: #171E37;
    text-align: center;
    font-size: 18px;
    font-style: normal;
    font-weight: 700;
    line-height: normal;
    width: 19%;

}
.newselector li.selected {background: #171E37;color:#34F1BA;}
.newselector li.selected a{color: #34F1BA;}
.newselector li a { text-decoration:none ; color:#171E37;  }
.spanButton {display: inline-block;border: 1px solid #171E37;padding: 4px 16px;border-radius: 20px;color: #171E37;text-align: center;font-size: 14px;font-style: normal;font-weight: 500;line-height: normal;    position: absolute;
    bottom: 22px;}
    .iam1 {position: absolute; right: -15%; bottom: 2%; width: 54%;}
   .iam2 {position: absolute; left: -20%; top: 0%; width: 40%;}
    @media screen and (max-width: 1000px) {  
        .newselector {flex-direction: column;border-radius: 14px !important;}
        .newselector li {width: auto;}
        .right-action-hero-2::after {height: 35px;}
        .iam1 {bottom: 6%;}
        .post-type-archive .hero { background-color: #6AC5A7; }
    }
    .right-action-hero-2 { padding: 4rem 0 10rem 0;}
    .page-numbers {    display: flex;}
    .page-numbers li a {margin: 0 1rem;}
    .page-numbers li a.current {color:#000;}
</style>      
<div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">
    

       

        <?php if (($_GET['nit']) == 'educational'): ?>

            <section class="hero right-action-hero-2 educational">
            <div class="basicWidth flex">
            
            
              
                                        <div class="hero-text educational">
                        <img src="/wp-content/uploads/2023/08/topsecret.png" class="iam2">
                    <h1 class="bigH2">Educational</h1>
                    <p class="bigParagraph">Learn more about Sophie and Incredibuild's work<br role="presentation" data-uw-rm-sr="">empowering young girls to dream bigger</p>
                    <img src="/wp-content/uploads/2023/08/educational_1.png" class="iam1">
                    </div>
                    
                
              
            </div>
          
        </section>
<?php else: ?>

    <section class="hero right-action-hero-2 ">
            <div class="basicWidth flex">
                                        <div class="hero-text all">
                    <h1 class="bigH2">News</h1>
                    <p class="bigParagraph">Stay up-to-date with all the latest Incredinews</p>
                    </div>
            </div>
        </section>


<?php endif ?>

        <section class="case-studies-list-area">
    <div class="basicWidth">
    <ul class="newselector">
                        <li <?php echo (!isset($_GET['nit']))  ? ' class="selected"' : ''; ?>><a href="/news" rel="bookmark" >All</a></li>
                        <li <?php echo (($_GET['nit']) == 'press')  ? ' class="selected"' : ''; ?>><a href="/news?nit=press" rel="bookmark" >Press</a></li>
                        <li <?php echo (($_GET['nit']) == 'news')  ? ' class="selected"' : ''; ?> ><a href="/news?nit=news" rel="bookmark" >News</a></li>
                        <li <?php echo (($_GET['nit']) == 'educational')  ? ' class="selected"' : ''; ?>><a href="/news?nit=educational" rel="bookmark" >Educational</a></li>
                        
                    </ul>
    <ul class="case-studies-list space-between flex-wrap">
        <?php
        // Get and sanitize the query string values
        $valid_values = array('news', 'press', 'educational'); // Define valid values
        $nit = isset($_GET['nit']) ? sanitize_text_field($_GET['nit']) : '';
        
        // Get the current page number from the query string, default to 1
        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;

        // Set up arguments for WP_Query with pagination
        $args = array(
            'post_type' => 'news',
            'posts_per_page' => 9, // Number of posts per page
            'paged' => $page, // Use 'paged' parameter
            'meta_query' => array()
        );

        // Add meta query only if $nit is valid and not empty
        if (!empty($nit) && in_array($nit, $valid_values)) {
            $args['meta_query'] = array(
                array(
                    'key' => '_type',
                    'value' => $nit,
                    'compare' => 'LIKE'
                )
            );
        }

        // Run the query
        $query = new WP_Query($args);

        // Check if there are posts
        if ($query->have_posts()) :
            while ($query->have_posts()) : $query->the_post();
                $post_excerpt = get_the_excerpt();
                $post_link = get_permalink();
                $featured_image = get_the_post_thumbnail_url(get_the_ID(), 'full');
                $post_title = get_the_title();
                $post_date = get_the_date('M j Y');
                $post_type = get_post_meta(get_the_ID(), '_type', true);

                ?>
                <li>
               
                    <a href="<?php  if ($post_type == "press") { echo esc_url($post_link); } else { echo "$post_excerpt";  }?>" <?php  if ($post_type == "press") { echo 'target="_self"'; } else { echo 'target="_blank"';  }?> aria-label="<?php echo esc_attr($post_title . ' ' . $post_date . ' / ' . $post_type); ?>">
                        <div class="case-study-featured-image-con">
                            <img src="<?php echo esc_url($featured_image); ?>" alt="<?php echo esc_attr($post_title); ?>" class="img-cover">
                        </div>
                        <div class="case-study-summary">
                            <h2><?php echo esc_html($post_title); ?></h2>

                            <p class="and"><?php echo esc_html($post_date . ' / ' . $post_type); ?></p>
                        </div>
                    </a>
                </li>
                <?php 
            endwhile; ?>
</ul>
   <?php 
         // Pagination
            $total_pages = $query->max_num_pages;
            if ($total_pages > 1) {
                $current_page = max(1, get_query_var('page'));
                echo '<section><div class="basicWidth"> <div class="pagination"> <ul class="page-numbers">';
                if ($current_page > 1) {
                    echo '<li><a href="' . esc_url(add_query_arg('page', $current_page - 1)) . '">« Previous</a></li>';
                }
                for ($i = 1; $i <= $total_pages; $i++) {
                    echo '<li><a href="' . esc_url(add_query_arg('page', $i)) . '" ' . ($i === $current_page ? 'class="current"' : '') . '>' . esc_html($i) . '</a></li>';
                }
                if ($current_page < $total_pages) {
                    echo '<li><a href="' . esc_url(add_query_arg('page', $current_page + 1)) . '">Next »</a></li>';
                }
                echo '</ul> </div> </div></section>';
            }

        else 
            echo '<p>No news items found.</p>';

        endif;

        // Restore original post data
        wp_reset_postdata();
        ?>
    
</div><!-- basicWidth -->
</section>
    
    </main><!-- #main -->
</div><!-- #primary -->

<?php get_footer(); ?>