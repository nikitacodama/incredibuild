<?php
    $cpt_field       = get_sub_field('cpt');
    $categories      = get_sub_field('categories');
    $shortcode       = (string) get_sub_field('shortcode');
    $shortcode_line  = (int) get_sub_field('shortcode_line');
    $posts_per_page  = (int) get_sub_field('posts_per_page');
    $order = get_sub_field('order') ? get_sub_field('order') : 'DESC';
    $orderby = get_sub_field('order_by') ? get_sub_field('order_by') : 'date';
    $enable_filters = get_sub_field('enable_filters');
    $box_view = get_sub_field('box_view') ? get_sub_field('box_view') : 'post';
    $columns = get_sub_field('columns') ? get_sub_field('columns') : 3;
    $offset = get_sub_field('offset') ? get_sub_field('offset') : 0;
    $section_class = get_sub_field('section_class');

    $post_types = array();

    if ( is_array( $cpt_field ) ) {
        foreach ( $cpt_field as $post_type ) {
            $post_type = sanitize_key( $post_type );
            if ( $post_type ) {
                $normalized = $post_type;

                if ( ! post_type_exists( $normalized ) && 'posts' === $normalized ) {
                    $normalized = 'post';
                }

                if ( post_type_exists( $normalized ) ) {
                    $post_types[] = $normalized;
                }
            }
        }
    } elseif ( ! empty( $cpt_field ) ) {
        $post_type = sanitize_key( $cpt_field );
        if ( $post_type ) {
            $normalized = $post_type;

            if ( ! post_type_exists( $normalized ) && 'posts' === $normalized ) {
                $normalized = 'post';
            }

            if ( post_type_exists( $normalized ) ) {
                $post_types[] = $normalized;
            }
        }
    }

    
    if ( empty( $post_types ) ) {
        return;
    }

    $taxonomy        = 'category';
    $posts_per_page  = $posts_per_page > 0 ? $posts_per_page : 9;
    $shortcode_line  = $shortcode_line > 0 ? $shortcode_line : 0;
    $shortcode_b64   = $shortcode ? base64_encode( $shortcode ) : '';

    $category_filter_ids = array();
    if ( ! empty( $categories ) && is_array( $categories ) ) {
        foreach ( $categories as $cat ) {
            $category_filter_ids[] = (int) $cat;
        }
        $category_filter_ids = array_filter( $category_filter_ids );
    }

    $tag_taxonomy = '';
    foreach ( $post_types as $post_type_name ) {
        if ( is_object_in_taxonomy( $post_type_name, 'post_tag' ) ) {
            $tag_taxonomy = 'post_tag';
            break;
        }
    }

    $filter_type_attr = 'term';
    $filter_view      = 'checkbox';

    $is_news_layout     = count( $post_types ) === 1 && 'news' === $post_types[0];
    $is_glossary_layout = count( $post_types ) === 1 && 'glossarys' === $post_types[0];

    if ( $is_news_layout ) {
        $filter_type_attr = 'type';
        $filter_view      = 'type';
    }

    if ( $is_glossary_layout ) {
        $filter_type_attr = 'alphabet';
        $filter_view      = 'glossarys';
    }

    // Select2 is now enqueued globally in theme-setup.php

    wp_enqueue_script(
        'incredibuild-cpt-list-filters',
        get_template_directory_uri() . '/assets/scripts/cpt-list-with-filters.js',
        array( 'jquery', 'select2' ),
        filemtime( get_template_directory() . '/assets/scripts/cpt-list-with-filters.js' ),
        true
    );

    static $cpt_filters_script_localized = false;

    if ( ! $cpt_filters_script_localized ) {
        wp_localize_script(
            'incredibuild-cpt-list-filters',
            'IncredibuildCptFilters',
            array(
                'ajaxUrl' => admin_url( 'admin-ajax.php' ),
            )
        );
        $cpt_filters_script_localized = true;
    }

    $nonce         = wp_create_nonce( 'cpt_list_nonce' );
    $primary_cpt   = reset( $post_types );
    $query_postype = count( $post_types ) === 1 ? $primary_cpt : $post_types;

    $query_args = array(
        'post_type'      => $query_postype,
        'post_status'    => 'publish',
        'posts_per_page' => $posts_per_page,
        'paged'          => 1,
        'orderby'        => $orderby,
        'order'          => $order,
        'offset'         => $offset,
    );

    if ( ! empty( $category_filter_ids ) ) {
        $query_args['tax_query'] = array(
            array(
                'taxonomy' => $taxonomy,
                'field'    => 'term_id',
                'terms'    => $category_filter_ids,
            ),
        );
    }

    $query = new WP_Query( $query_args );

    $render = incredibuild_render_cpt_list_posts_html(
        $query,
        array(
            'offset'             => $offset,
            'shortcode'          => $shortcode,
            'shortcode_line'     => $shortcode_line,
            'posts_per_row'      => 3,
            'shortcode_rendered' => false,
            'box_view'           => $box_view,
            'order'              => $order,
            'orderby'            => $orderby,
        )
    );

    wp_reset_postdata();

    $has_more            = $query->max_num_pages > 1;
    $shortcode_rendered  = $render['shortcode_rendered'];
    $initial_shortcode   = $shortcode_rendered ? 1 : 0;


$object_ids_query = new WP_Query(
        array(
            'post_type'      => $query_postype,
            'post_status'    => 'publish',
            'fields'         => 'ids',
            'posts_per_page' => -1,
            'no_found_rows'  => true,
            'orderby'        => $orderby,
            'order'          => $order,
            'tax_query'      => ! empty( $category_filter_ids ) ? array(
                array(
                    'taxonomy' => $taxonomy,
                    'field'    => 'term_id',
                    'terms'    => $category_filter_ids,
                ),
            ) : array(),
        )
    );

    $object_ids = $object_ids_query->posts;

    wp_reset_postdata();

    $terms             = array();
    $tag_terms         = array();
    $alphabet_letters  = array();

    if ( ! empty( $object_ids ) ) {
        $terms = get_terms(
            array(
                'taxonomy'   => $taxonomy,
                'hide_empty' => false,
                // 'object_ids' => $object_ids,
                'include'    => ! empty( $category_filter_ids ) ? $category_filter_ids : array(),
            )
        );

        if ( $tag_taxonomy ) {
            $tag_terms = get_terms(
                array(
                    'taxonomy'   => $tag_taxonomy,
                    'hide_empty' => false,
                    'object_ids' => $object_ids,
                )
            );
        }
    }

    if ( $is_glossary_layout ) {
        $glossary_letters = array();

        $glossary_query = new WP_Query(
            array(
                'post_type'      => 'glossarys',
                'post_status'    => 'publish',
                'posts_per_page' => -1,
                'fields'         => 'ids',
                'orderby'        => 'title',
                'order'          => 'ASC',
            )
        );

        if ( $glossary_query->have_posts() ) {
            foreach ( $glossary_query->posts as $glossary_post_id ) {
                $title = get_the_title( $glossary_post_id );
                if ( ! $title ) {
                    continue;
                }

                $letter = mb_substr( $title, 0, 1 );
                $letter = mb_strtoupper( $letter );

                if ( ! preg_match( '/[A-Z]/u', $letter ) ) {
                    $letter = '#';
                }

                $glossary_letters[ $letter ] = true;
            }
        }

        wp_reset_postdata();

        if ( ! empty( $glossary_letters ) ) {
            $alphabet_letters = array_keys( $glossary_letters );
            sort( $alphabet_letters );

            if ( isset( $glossary_letters['#'] ) ) {
                $alphabet_letters = array_diff( $alphabet_letters, array( '#' ) );
                $alphabet_letters[] = '#';
            }
        } else {
            $alphabet_letters = range( 'A', 'Z' );
        }

      
    }
?>

<section class="cpt-list-with-filters <?php echo $section_class; ?>"
    data-cpt="<?php echo esc_attr( implode( ',', $post_types ) ); ?>"
    data-taxonomy="<?php echo esc_attr( $taxonomy ); ?>"
    data-posts-per-page="<?php echo esc_attr( $posts_per_page ); ?>"
    data-shortcode-line="<?php echo esc_attr( $shortcode_line ); ?>"
    data-shortcode="<?php echo esc_attr( $shortcode_b64 ); ?>"
    data-shortcode-rendered="<?php echo esc_attr( $initial_shortcode ); ?>"
    data-initial-shortcode-rendered="<?php echo esc_attr( $initial_shortcode ); ?>"
    data-has-more="<?php echo esc_attr( $has_more ? 1 : 0 ); ?>"
    data-include="<?php echo esc_attr( implode( ',', $category_filter_ids ) ); ?>"
    data-nonce="<?php echo esc_attr( $nonce ); ?>"
    data-selected-categories="<?php echo esc_attr( implode( ',', $category_filter_ids ) ); ?>"
    data-selected-tags=""
    data-default-offset="<?php echo $offset; ?>"
    data-tag-taxonomy="<?php echo esc_attr( $tag_taxonomy ); ?>"
    data-box-view="<?php echo esc_attr( $box_view ); ?>"
    data-filter-type="<?php echo esc_attr( $filter_type_attr ); ?>"
    data-order="<?php echo esc_attr( $order ); ?>"
    data-orderby="<?php echo esc_attr( $orderby ); ?>">
    
    <div class="container container_md">
        <?php if($enable_filters): ?>
            <?php
            get_template_part(
                'page-templates/partials/filters',
                null,
                array(
                    'view'               => $filter_view,
                    'category_terms'     => ! is_wp_error( $terms ) ? $terms : array(),
                    'tag_terms'          => ! is_wp_error( $tag_terms ) ? $tag_terms : array(),
                    'category_taxonomy'  => $taxonomy,
                    'tag_taxonomy'       => $tag_taxonomy,
                    'selected_categories'=> $category_filter_ids,
                    'selected_tags'      => array(),
                    'alphabet_letters'   => $alphabet_letters,
                )
            );
            ?>
        <?php endif; ?>
        <div class="cpt-list-grid" style="grid-template-columns: repeat(<?php echo esc_attr( $columns ); ?>, minmax(0, 1fr));">
            <?php
            if ( ! empty( $render['html'] ) ) {
                echo $render['html']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
            } else {
                echo '<div class="cpt-list-empty">' . esc_html__( 'No posts found.', 'incredibuild' ) . '</div>';
            }
            ?>
        </div>

        <?php if ( $has_more ) : ?>
            <div class="cpt-list-actions flex justify_c">
                <button type="button" class="cpt-list-load-more button_default secondary">
                    <?php esc_html_e( 'View More', 'incredibuild' ); ?>
                </button>
            </div>
        <?php endif; ?>
    </div>
</section>
<?php
    wp_reset_postdata();
?>