<?php 
    $cpt = get_sub_field('cpt');
    $terms = get_terms(array(
        'taxonomy' => 'category',
        'hide_empty' => true,  // This hides categories with no posts
    ));
?>
<section class="cpt_list" data-cpt="<?php echo esc_attr($cpt); ?>">
    <div class="cpt_list-inner container container_lg flex align_fs justify_sb gap_64">
        <div class="cpt_list-aside flex dir_col gap_16 flex_auto">
            <div class="cpt_list-aside-toggle flex align_c justify_fs gap_10 blue tt_u ff_mono">
                <div class="cpt_list-aside-toggle-icon flex align_c justify_c">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/relume-ic.svg" alt="<?php echo __('Category', 'incredibuild');?>" >
                </div><?php echo __('Category', 'incredibuild');?>
            </div>
            <div class="cpt_list-aside-items flex dir_col gap_12 ff_mono">
                <?php 
                 if (!empty($terms) && !is_wp_error($terms)) :
                foreach ($terms as $term) :
                // Custom Query for posts of type 'integrations' within this category
                $args = array(
                    'post_type' => $cpt,
                    'post_status' => 'publish',
                    'posts_per_page' => -1,
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'category',
                            'field' => 'slug',
                            'terms' => $term->slug,
                        ),
                    ),
                );
                $cpt_query = new WP_Query($args); 
                if ($cpt_query->have_posts()) : ?>
                        <a href="<?php echo esc_attr($term->slug); ?>" data-category="<?php echo esc_attr($term->slug); ?>" class="cpt_list-aside-item-link tt_u white-45 td_n">
                            <?php echo esc_html($term->name); ?>
                        </a>
                <?php 
                endif;
                wp_reset_postdata();  // Reset query to avoid conflicts
            endforeach; 
            endif;
            ?>
            </div>
            <div class="cpt_list-aside-show-more show-more hidden_lg medium ff_mono tt_u green arrow_r" data-show-more="cpt_list-aside-item-link">
                <?php echo __('View All', 'incredibuild');?>
            </div>
        </div>
        <div class="cpt_list-content w_full bg_white-03">
<?php          // Get categories that have posts in the 'integrations' custom post type

        if (!empty($terms) && !is_wp_error($terms)) :
            foreach ($terms as $term) :
                // Custom Query for posts of type 'integrations' within this category
                $args = array(
                    'post_type' => $cpt,
                    'post_status' => 'publish',
                    'posts_per_page' => -1,
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'category',
                            'field' => 'slug',
                            'terms' => $term->slug,
                        ),
                    ),
                );
                $cpt_query = new WP_Query($args);

                // Only output the category container if there are posts
                if ($cpt_query->have_posts()) : ?>
                   <div class="cpt_list-category" data-category="<?php echo esc_attr($term->slug); ?>">
                   <h4 class="white"><?php echo esc_html($term->name); ?></h4>
                   <div class="cpt_list-category-items grid gap_16 text_c">
                    <?php while ($cpt_query->have_posts()) : $cpt_query->the_post();
                        get_template_part('page-templates/partials/loop-' . $cpt[0]);
                    endwhile; ?>
                   </div>
                   </div>
               <?php endif;
                wp_reset_postdata();  // Reset query to avoid conflicts
            endforeach;
        else :
            echo '<p>No categories found.</p>';
        endif; ?>
        </div>
    </div>
</section>