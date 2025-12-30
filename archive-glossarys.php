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

<div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">
        <section class="hero right-action-hero-2">
            <div class="container-wide flex">
                <div>
                    <h1 class="bigH2">Glossary</h1>
                    <input id="myInput" type="text" placeholder="Search" data-uw-rm-form="fx" aria-label="Search">
                 
<style>
    #letter-main        {position:absolute;bottom:20px;}
    #letter-main li     {list-style: none;display: inline-block;line-height: 40px;}
    #letter-main li a {color:#c3c3c3;border: 1px solid #c3c3c3;padding: 5px;}
    #letter-main li a[href] {color:#000;border: 1px solid #000;padding: 5px;}


.hero                         {background-image:url('https://www.incredibuild.com/wp-content/uploads/2023/05/Glossary_arch_background.png');background-repeat:no-repeat;margin-bottom:130px;height:345px;} 
.right-action-hero-2          {padding: 10rem 0 0 0;}
.parent                       {display:grid;grid-template-columns:repeat(12, 1fr);grid-template-rows:1fr;grid-column-gap:0px;grid-row-gap:0px;}
.div1                         {grid-area: 1 / 1 / 2 / 2; }
.div2                         {grid-area: 1 / 2 / 2 / 13;border-bottom:2px solid #c3c3c3;padding-bottom:30px;margin-bottom:40px;}
.parent:last-of-type  .div2   {border-bottom:none;}
.term                         {width:30%;display:inline-block;vertical-align:top;border-radius:12px;margin:1%;padding:30px;box-sizing:border-box;}
.term:hover                   {box-shadow:0px 25px 40px #0000000D;background:#FFFFFF 0% 0% no-repeat padding-box;}
.div1 span                    {font-family:'Poppins',sans-serif;margin-top:47px;display:block;font:normal normal bold 34px/56px Poppins;text-align:center;line-height:217%;color:#000000;width:72px;height:72px;border-radius:50%;background:#02F0B9 0% 0% no-repeat padding-box;opacity:1;}
.term a                       {text-decoration:none;color:#000;}
.term a h3                    {margin-top:0;font-size:21px;line-height:30px;display:-webkit-box;-webkit-line-clamp: 3;-webkit-box-orient:vertical;overflow:hidden;}
.term a p                     {height:106px;text-align:left;font:normal normal normal 16px/20px Poppins;letter-spacing:0px;color:#000000;opacity:1;}
#myInput                      {padding:15px;font:normal normal normal 14px/32px Poppins;top:263px;left:372px;width:540px;max-width:100%;height:20px;background:#FFFFFF 0% 0% no-repeat padding-box;border:1px solid #C9D5D9;border-radius:5px;opacity:1;margin-top:10px;}

/* Medium devices (landscape tablets, 768px and up) */
@media only screen and (max-width: 768px) {
    .hero           {background-repeat:no-repeat;background-size:cover;background-position: 70% 0;margin-bottom: 70px;}
    .parent         {display: grid;grid-template-columns: 1fr;grid-template-rows: repeat(0.2fr, 1fr);}
    .div1           {grid-area: 1 / 1 / 2 / 2; }
    .div1 span      {font-family: 'Sora',sans-serif;margin-top: 7px;margin-left: 37px;}
    .div2           {grid-area: 2 / 1 / 3 / 2;padding-bottom:0 ; }
    .term           {width: 47%;}


}
@media only screen and (max-width: 600px) {
    .term {width: 100%;}
    #myInput {    width: 310px;} 
 
}

</style>

          <div class="container-wide">

          <?php
// Query to get all glossary posts ordered by title
$args = array(
    'post_type' => 'glossarys', // Custom post type 'glossary'
    'posts_per_page' => -1, // Get all posts
    'orderby' => 'title',
    'order' => 'ASC'
);
$glossary_query = new WP_Query($args);

// Initialize variables
$current_letter = '';
$letters_with_posts = array();

// First pass: Collect letters with posts
if ($glossary_query->have_posts()) :
    while ($glossary_query->have_posts()) : $glossary_query->the_post();
        $first_letter = strtoupper(substr(get_the_title(), 0, 1));
        if (!isset($letters_with_posts[$first_letter])) {
            $letters_with_posts[$first_letter] = true;
        }
    endwhile;
endif;

// Reset the query
wp_reset_postdata();
?>

<!-- Letter Index -->
<div id="linkBar">

   

<ul id="letter-main">
    <?php
    // Output the index of letters
    foreach (range('A', 'Z') as $letter) {
        if (isset($letters_with_posts[$letter])) {
            echo '<li><a id="link' . $letter . '" href="#' . $letter . '" data-uw-rm-brl="PR" data-uw-original-href="' . get_permalink() . '#' . $letter . '">' . $letter . '</a></li>';
        } else {
            echo '<li><a id="link' . $letter . '" tabindex="0">' . $letter . '</a></li>';
        }
    }
    ?>
</ul>
</div></div></div></section></main></div>
<!-- Glossary Archive -->
<div class="container-wide">
    <?php
    // Start the main loop for displaying posts
    $glossary_query = new WP_Query($args);
    if ($glossary_query->have_posts()) :
        while ($glossary_query->have_posts()) : $glossary_query->the_post();
        
            $first_letter = strtoupper(substr(get_the_title(), 0, 1));
            
            if ($first_letter !== $current_letter) {
                if ($current_letter !== '') {
                    echo '</div>'; // Close the previous letter section
                    echo '</div>'; // Close the previous .parent div
                }
                
                $current_letter = $first_letter;
                
                echo '<div class="parent">';
                echo '<div class="div1"><span>' . $current_letter . '</span></div>';
                echo '<div class="div2" id="' . $current_letter . '" name="' . $current_letter . '">';
            }
            
            ?>
            <div class="term">
                <a href="<?php the_permalink(); ?>">
                    <h3><?php the_title(); ?></h3>
                    <div class="excerpt">
                        <p><?php echo wp_trim_words(get_the_excerpt(), 14); ?></p>
                    </div>
                </a>
            </div>
            
        <?php endwhile;
        echo '</div>'; // Close the last letter section
        echo '</div>'; // Close the last .parent div
    else :
        echo '<p>No glossary terms found.</p>';
    endif;

    wp_reset_postdata(); // Reset post data after the query
    ?>
</div>
  
          

</div>





<?php
$template_part_block = '<!-- wp:template-part {"slug":"incredibuild-footer","theme":"incredibuild_24"} /-->';
echo do_blocks( $template_part_block );
?>
<script>



jQuery(document).ready(function(){
    jQuery("#myInput").on("keyup", function() {
    var value = jQuery(this).val().toLowerCase();
    jQuery(".term").filter(function() {
        jQuery(this).toggle(jQuery(this).text().toLowerCase().indexOf(value) > -1)
    });
    jQuery(".parent").filter(function() {
        jQuery(this).toggle(jQuery(this).text().toLowerCase().indexOf(value) > -1)
    });   
  });
});
</script>
<?php get_footer(); ?>