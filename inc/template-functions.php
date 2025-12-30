<?php
/**
 * Template Functions
 * 
 * @package Incredibuild
 */

/**
 * AJAX Handler - Filter CPT by Category
 */
function incredibuild_filter_cpt_by_category() {
    // Verify nonce for security
    check_ajax_referer('cpt_filter_nonce', 'nonce');
    
    // Get parameters from AJAX request
    $category_slug = isset($_POST['category']) ? sanitize_text_field($_POST['category']) : '';
    $post_type = isset($_POST['post_type']) ? sanitize_text_field($_POST['post_type']) : 'integrations';
    
    // Build query arguments
    $args = array(
        'post_type' => $post_type,
        'post_status' => 'publish',
        'posts_per_page' => -1,
    );
    
    // Add category filter if category is specified
    if (!empty($category_slug) && $category_slug !== 'all') {
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'category',
                'field' => 'slug',
                'terms' => $category_slug,
            ),
        );
    }
    


    
    // Execute query
    $cpt_query = new WP_Query($args);
    
    // Start output buffering
    ob_start();
    
    if ($cpt_query->have_posts()) {
        while ($cpt_query->have_posts()) {
            $cpt_query->the_post();
            get_template_part('page-templates/partials/loop-' . $post_type);
        }
    } else {
        echo '<p class="white">' . __('No posts found in this category.', 'incredibuild') . '</p>';
    }
    
    wp_reset_postdata();
    
    // Get the output and clean buffer
    $output = ob_get_clean();
    
    // Send JSON response
    wp_send_json_success(array(
        'html' => $output,
        'category' => $category_slug
    ));
}
add_action('wp_ajax_filter_cpt_by_category', 'incredibuild_filter_cpt_by_category');
add_action('wp_ajax_nopriv_filter_cpt_by_category', 'incredibuild_filter_cpt_by_category');

/**
 * Render posts for the CPT list with filters component.
 *
 * @param WP_Query $query  Query instance.
 * @param array    $args   Rendering options.
 *
 * @return array
 */
function incredibuild_render_cpt_list_posts_html( $query, $args = array() ) {
    $defaults = array(
        'offset'              => 0,
        'shortcode'           => '',
        'shortcode_line'      => 0,
        'posts_per_row'       => 3,
        'shortcode_rendered'  => false,
        'box_view'            => 'post',
        'order'               => 'DESC',
        'orderby'             => 'date',
    );

    $options = wp_parse_args( $args, $defaults );

    
    $html              = '';
    $rendered          = 0;
    $threshold         = 0;
    $shortcode         = $options['shortcode'];
    $shortcode_set     = (bool) $options['shortcode_rendered'];
    $posts_per_row     = max( 1, (int) $options['posts_per_row'] );
    $box_view          = sanitize_key( $options['box_view'] );
    $shortcode_position = isset( $options['shortcode_line'] ) ? (int) $options['shortcode_line'] : 0;
    $order               = sanitize_key( $options['order'] );
    $orderby             = sanitize_key( $options['orderby'] );
    

    if ( $shortcode_position > 0 ) {
        $threshold = $shortcode_position;
    }

    // Check if this is a glossary layout
    $is_glossary = false;
    $current_letter = '';
    $previous_letter = '';
    
    if ( $query instanceof WP_Query ) {
        $query_post_types = $query->get( 'post_type' );
        if ( is_array( $query_post_types ) ) {
            $is_glossary = in_array( 'glossarys', $query_post_types, true );
        } else {
            $is_glossary = ( 'glossarys' === $query_post_types );
        }
    }

    if ( $query instanceof WP_Query && $query->have_posts() ) {
        // For glossary, we need to peek ahead to know when to add dividers
        // So we'll collect posts first, then render with dividers
        if ( $is_glossary ) {
            $posts = array();
            while ( $query->have_posts() ) {
                $query->the_post();
                $post_id = get_the_ID();
                $title = get_the_title( $post_id );
                $letter = '';
                if ( $title ) {
                    $letter = mb_substr( $title, 0, 1 );
                    $letter = mb_strtoupper( $letter );
                    if ( ! preg_match( '/[A-Z]/u', $letter ) ) {
                        $letter = '#';
                    }
                }
                $posts[] = array(
                    'id'     => $post_id,
                    'letter' => $letter,
                );
            }
            wp_reset_postdata();

            // Now render posts with dividers
            foreach ( $posts as $index => $post_data ) {
                $post_id = $post_data['id'];
                $current_letter = $post_data['letter'];
                $is_last_post = ( $index === count( $posts ) - 1 );
                $next_letter = '';
                
                // Check next post's letter
                if ( ! $is_last_post && isset( $posts[ $index + 1 ] ) ) {
                    $next_letter = $posts[ $index + 1 ]['letter'];
                }

                $rendered++;
                $global_index = (int) $options['offset'] + $rendered;

                ob_start();
                get_template_part( 'page-templates/partials/loop-' . $box_view, null, array( 'post_id' => $post_id ) );
                $html .= ob_get_clean();

                // Add divider after this post if:
                // 1. It's the last post, OR
                // 2. Next post has a different letter
                if ( $is_last_post || ( $next_letter !== '' && $current_letter !== $next_letter ) ) {
                    $html .= '<div class="cpt-list-glossary-divider"></div>';
                }

                if ( $threshold && $shortcode && ! $shortcode_set && $global_index >= $threshold ) {
                    $html         .= '<div class="cpt-list-shortcode">' . do_shortcode( $shortcode ) . '</div>';
                    $shortcode_set = true;
                }
            }
        } else {
            // Non-glossary: render normally
            while ( $query->have_posts() ) {
                $query->the_post();

                $rendered++;
                $global_index = (int) $options['offset'] + $rendered;

                ob_start();
                get_template_part( 'page-templates/partials/loop-' . $box_view, null, array( 'post_id' => get_the_ID() ) );
                $html .= ob_get_clean();

                if ( $threshold && $shortcode && ! $shortcode_set && $global_index >= $threshold ) {
                    $html         .= '<div class="cpt-list-shortcode">' . do_shortcode( $shortcode ) . '</div>';
                    $shortcode_set = true;
                }
            }
            wp_reset_postdata();
        }
    }

    return array(
        'html'                => $html,
        'rendered_count'      => $rendered,
        'shortcode_rendered'  => $shortcode_set,
    );
}

/**
 * AJAX handler for CPT list with filters.
 */
function incredibuild_cpt_list_with_filters_ajax() {
    check_ajax_referer( 'cpt_list_nonce', 'nonce' );

    $post_type         = isset( $_POST['postType'] ) ? sanitize_key( wp_unslash( $_POST['postType'] ) ) : '';
    $taxonomy          = isset( $_POST['taxonomy'] ) ? sanitize_key( wp_unslash( $_POST['taxonomy'] ) ) : 'category';
    $term              = isset( $_POST['term'] ) ? sanitize_text_field( wp_unslash( $_POST['term'] ) ) : 'all';
    $page              = isset( $_POST['page'] ) ? max( 1, (int) $_POST['page'] ) : 1;
    $posts_per_page    = isset( $_POST['postsPerPage'] ) ? max( 1, (int) $_POST['postsPerPage'] ) : 9;
    $shortcode_line    = isset( $_POST['shortcodeLine'] ) ? max( 0, (int) $_POST['shortcodeLine'] ) : 0;
    $shortcode_flag    = ! empty( $_POST['shortcodeRendered'] );
    $shortcode_raw     = isset( $_POST['shortcode'] ) ? wp_unslash( $_POST['shortcode'] ) : '';
    $shortcode         = '';
    $include_raw       = isset( $_POST['include'] ) ? wp_unslash( $_POST['include'] ) : '';
    $include_ids       = array();
    $categories_raw    = isset( $_POST['categories'] ) ? wp_unslash( $_POST['categories'] ) : '';
    $tags_raw          = isset( $_POST['tags'] ) ? wp_unslash( $_POST['tags'] ) : '';
    $tag_taxonomy      = isset( $_POST['tagTaxonomy'] ) ? sanitize_key( wp_unslash( $_POST['tagTaxonomy'] ) ) : '';
    $box_view_param    = isset( $_POST['boxView'] ) ? sanitize_key( wp_unslash( $_POST['boxView'] ) ) : 'post';
    $filter_type = isset( $_POST['filterType'] ) ? sanitize_text_field( wp_unslash( $_POST['filterType'] ) ) : 'term';
    $valid_values = array( 'news', 'press', 'educational' );
    $order        = isset( $_POST['order'] ) ? sanitize_text_field( wp_unslash( $_POST['order'] ) ) : 'DESC';
    $orderby      = isset( $_POST['orderby'] ) ? sanitize_text_field( wp_unslash( $_POST['orderby'] ) ) : 'date';
    $default_offset = isset( $_POST['offset'] ) ? max( 0, (int) $_POST['offset'] ) : 0;
    $initial_categories_raw = isset( $_POST['initialCategories'] ) ? wp_unslash( $_POST['initialCategories'] ) : '';
    $initial_include_raw = isset( $_POST['initialInclude'] ) ? wp_unslash( $_POST['initialInclude'] ) : '';


    if ( $include_raw ) {
        $include_ids = array_filter( array_map( 'absint', explode( ',', $include_raw ) ) );
    }

    $categories_filter_ids = array();
    if ( $categories_raw ) {
        $categories_filter_ids = array_filter( array_map( 'absint', explode( ',', $categories_raw ) ) );
    }

    $tags_filter_ids = array();
    if ( $tags_raw ) {
        $tags_filter_ids = array_filter( array_map( 'absint', explode( ',', $tags_raw ) ) );
    }

    // Check if current filters match initial/default state
    $initial_category_ids = array();
    if ( $initial_categories_raw ) {
        $initial_category_ids = array_filter( array_map( 'absint', explode( ',', $initial_categories_raw ) ) );
    }
    
    $initial_include_ids = array();
    if ( $initial_include_raw ) {
        $initial_include_ids = array_filter( array_map( 'absint', explode( ',', $initial_include_raw ) ) );
    }
    
    // Sort arrays for comparison
    sort( $categories_filter_ids );
    sort( $initial_category_ids );
    sort( $include_ids );
    sort( $initial_include_ids );
    
    // Determine if we're in default state (matches initial filters)
    $categories_match = $categories_filter_ids === $initial_category_ids;
    $include_match = $include_ids === $initial_include_ids;
    $tags_match = empty( $tags_filter_ids );
    $term_matches = 'all' === $term;
    $is_default_state = $categories_match && $include_match && $tags_match && $term_matches;

    if ( empty( $post_type ) ) {
        wp_send_json_error( array( 'message' => __( 'Invalid post type.', 'incredibuild' ) ) );
    }

    $order   = strtoupper( $order );
    $orderby = strtolower( $orderby );

    $allowed_order = array( 'ASC', 'DESC' );
    if ( ! in_array( $order, $allowed_order, true ) ) {
        $order = 'DESC';
    }

    $allowed_orderby = array( 'date', 'title', 'menu_order', 'modified', 'rand' );
    if ( ! in_array( $orderby, $allowed_orderby, true ) ) {
        $orderby = 'date';
    }

    // Calculate offset: apply default offset when in default state
    // WordPress applies offset first, then pagination, so we use base offset with paged
    $query_offset = 0;
    if ( $is_default_state && $default_offset > 0 ) {
        $query_offset = $default_offset;
    }

    $args = array(
        'post_type'      => $post_type,
        'post_status'    => 'publish',
        'posts_per_page' => $posts_per_page,
        'paged'          => $page,
        'order'          => $order,
        'orderby'        => $orderby,
    );

    // Apply offset when in default state
    if ( $query_offset > 0 ) {
        $args['offset'] = $query_offset;
    }

    $alphabet_letter         = '';
    $alphabet_where_callback = null;

    if ( 'alphabet' === $filter_type && $term && 'all' !== $term ) {
        $alphabet_letter = mb_substr( $term, 0, 1 );
        $alphabet_letter = mb_strtoupper( $alphabet_letter );
    }

    if ($filter_type == 'type' && $term != 'all') {
        $args['meta_query'] = array(
            array(
                'key' => '_type',
                'value' => $term,
                'compare' => 'LIKE'
            )
        );
    }



    if($filter_type != 'type') {

    $tax_query = array();

    if ( ! empty( $include_ids ) ) {
        $tax_query[] = array(
            'taxonomy' => $taxonomy,
            'field'    => 'term_id',
            'terms'    => $include_ids,
        );
    }

    if ( ! empty( $categories_filter_ids ) ) {
        $tax_query[] = array(
            'taxonomy' => $taxonomy,
            'field'    => 'term_id',
            'terms'    => $categories_filter_ids,
        );
    } elseif ( 'alphabet' !== $filter_type && $term && 'all' !== $term ) {
        $tax_query[] = array(
            'taxonomy' => $taxonomy,
            'field'    => 'slug',
            'terms'    => $term,
        );
    }

    if ( $tag_taxonomy && ! empty( $tags_filter_ids ) ) {
        $tax_query[] = array(
            'taxonomy' => $tag_taxonomy,
            'field'    => 'term_id',
            'terms'    => $tags_filter_ids,
        );
    }

    if ( ! empty( $tax_query ) ) {
        if ( count( $tax_query ) > 1 ) {
            $tax_query['relation'] = 'AND';
        }
        $args['tax_query'] = $tax_query;
    }

}

    if ( $alphabet_letter ) {
        global $wpdb;

        if ( '#' === $alphabet_letter ) {
            $alphabet_where_callback = static function ( $where ) use ( $wpdb ) {
                return $where . " AND {$wpdb->posts}.post_title REGEXP '^[^A-Z]'";
            };
        } else {
            $like = $wpdb->esc_like( $alphabet_letter ) . '%';
            $alphabet_where_callback = static function ( $where ) use ( $wpdb, $like ) {
                return $where . $wpdb->prepare( " AND {$wpdb->posts}.post_title LIKE %s", $like );
            };
        }

        add_filter( 'posts_where', $alphabet_where_callback );
    }

    if ( ! empty( $shortcode_raw ) ) {
        $decoded = base64_decode( $shortcode_raw, true );

        if ( false !== $decoded ) {
            $shortcode = $decoded;
        }
    }

    $query  = new WP_Query( $args );

    if ( $alphabet_where_callback ) {
        remove_filter( 'posts_where', $alphabet_where_callback );
    }

    // Calculate offset for render function: default offset + pagination offset
    // This is used for shortcode_line positioning
    $pagination_offset = ( $page - 1 ) * $posts_per_page;
    $render_offset = 0;
    if ( $is_default_state ) {
        $render_offset = $default_offset + $pagination_offset;
    } else {
        $render_offset = $pagination_offset;
    }

    $render = incredibuild_render_cpt_list_posts_html(
        $query,
        array(
            'offset'             => $render_offset,
            'shortcode'          => $shortcode,
            'shortcode_line'     => $shortcode_line,
            'posts_per_row'      => 3,
            'shortcode_rendered' => $shortcode_flag,
            'box_view'           => $box_view_param ? $box_view_param : 'post',
            'order'              => $order,
            'orderby'            => $orderby,
        )
    );

    $html = $render['html'];
    if ( '' === $html ) {
        $html = '<div class="cpt-list-empty">' . esc_html__( 'No posts found.', 'incredibuild' ) . '</div>';
    }

    $max_pages = (int) $query->max_num_pages;
    $has_more  = $page < $max_pages;

    wp_send_json_success(
        array(
            'html'               => $html,
            'shortcodeRendered'  => $render['shortcode_rendered'],
            'hasMore'            => $has_more,
            'nextPage'           => $has_more ? $page + 1 : null,
        )
    );
}
add_action( 'wp_ajax_cpt_list_with_filters', 'incredibuild_cpt_list_with_filters_ajax' );
add_action( 'wp_ajax_nopriv_cpt_list_with_filters', 'incredibuild_cpt_list_with_filters_ajax' );

/**
 * Generate a unique anchor ID for a heading.
 *
 * @param string $text      Heading text.
 * @param array  $used_ids  Previously generated IDs (passed by reference).
 *
 * @return string
 */
function incredibuild_generate_heading_anchor( $text, array &$used_ids ) {
    $base = sanitize_title( $text );

    if ( '' === $base ) {
        $base = 'section';
    }

    $candidate = $base;
    $suffix    = 2;

    while ( in_array( $candidate, $used_ids, true ) ) {
        $candidate = $base . '-' . $suffix;
        ++$suffix;
    }

    $used_ids[] = $candidate;

    return $candidate;
}

/**
 * Parse H2 headings from content, add IDs, and return structured data.
 *
 * @param string $content Post content.
 *
 * @return array|false Array with `content` and `headings` keys, or false on failure.
 */
function incredibuild_collect_h2_headings( $content ) {
    if ( empty( $content ) || false === stripos( $content, '<h2' ) ) {
        return false;
    }

    if ( ! class_exists( 'DOMDocument' ) ) {
        return false;
    }

    $dom = new DOMDocument();

    libxml_use_internal_errors( true );

    $libxml_flags = 0;
    if ( defined( 'LIBXML_HTML_NOIMPLIED' ) ) {
        $libxml_flags |= LIBXML_HTML_NOIMPLIED;
    }
    if ( defined( 'LIBXML_HTML_NODEFDTD' ) ) {
        $libxml_flags |= LIBXML_HTML_NODEFDTD;
    }

    $loaded = $dom->loadHTML(
        '<?xml encoding="utf-8" ?>' . $content,
        $libxml_flags
    );

    libxml_clear_errors();

    if ( ! $loaded ) {
        return false;
    }

    $headings = array();
    $used_ids = array();

    $nodes = $dom->getElementsByTagName( 'h2' );

    /** @var DOMElement $heading */
    foreach ( $nodes as $heading ) {
        $text = trim( $heading->textContent );

        if ( '' === $text ) {
            continue;
        }

        $existing_id = trim( $heading->getAttribute( 'id' ) );

        if ( '' !== $existing_id ) {
            $sanitized_id = sanitize_title( $existing_id );

            if ( '' === $sanitized_id ) {
                $sanitized_id = incredibuild_generate_heading_anchor( $text, $used_ids );
            } elseif ( in_array( $sanitized_id, $used_ids, true ) ) {
                $sanitized_id = incredibuild_generate_heading_anchor( $text, $used_ids );
            } else {
                $used_ids[] = $sanitized_id;
            }
        } else {
            $sanitized_id = incredibuild_generate_heading_anchor( $text, $used_ids );
        }

        $heading->setAttribute( 'id', $sanitized_id );

        $headings[] = array(
            'id'   => $sanitized_id,
            'text' => $text,
        );
    }

    if ( empty( $headings ) ) {
        return false;
    }

    return array(
        'content'  => $dom->saveHTML(),
        'headings' => $headings,
    );
}

/**
 * Ensure H2 headings inside the_content have stable IDs and cache them.
 *
 * @param string $content Post content.
 *
 * @return string
 */
function incredibuild_add_heading_ids_to_content( $content ) {
    if ( ! is_singular() ) {
        return $content;
    }

    global $incredibuild_toc_cache;

    $result = incredibuild_collect_h2_headings( $content );

    if ( ! $result ) {
        if ( isset( $incredibuild_toc_cache ) ) {
            unset( $incredibuild_toc_cache['post_id'], $incredibuild_toc_cache['headings'] );
        }
        return $content;
    }

    $incredibuild_toc_cache = array(
        'post_id'  => get_the_ID(),
        'headings' => $result['headings'],
    );

    return $result['content'];
}
add_filter( 'the_content', 'incredibuild_add_heading_ids_to_content', 8 );

/**
 * Shortcode: [table_content]
 * Outputs a table of contents based on H2 headings in the current post.
 *
 * @param array $atts Shortcode attributes.
 *
 * @return string
 */
function incredibuild_table_content_shortcode( $atts ) {
    if ( ! is_singular() ) {
        return '';
    }

    global $incredibuild_toc_cache;

    $post_id = get_the_ID();

    if ( ! $post_id ) {
        return '';
    }

    $headings = array();

    if (
        isset( $incredibuild_toc_cache['post_id'], $incredibuild_toc_cache['headings'] )
        && (int) $incredibuild_toc_cache['post_id'] === (int) $post_id
    ) {
        $headings = $incredibuild_toc_cache['headings'];
    } else {
        $raw_content = get_post_field( 'post_content', $post_id );
        $result      = incredibuild_collect_h2_headings( $raw_content );

        if ( $result ) {
            $headings = $result['headings'];
        }
    }

    if ( empty( $headings ) ) {
        return '';
    }

    $atts = shortcode_atts(
        array(
            'title' => __( 'Table of Contents', 'incredibuild' ),
        ),
        $atts,
        'table_content'
    );

    $title = $atts['title'];

    ob_start();
    ?>
    <nav class="ib-table-content" aria-label="<?php echo esc_attr( $title ); ?>">
        <h6 class="ib-table-content__title white"><?php echo esc_html( $title ); ?></h6>
        <div class="ib-table-content__list flex dir_col links_uppercase">
            <?php foreach ( $headings as $heading ) : ?>
                    <a class="ib-table-content__link" href="<?php echo esc_url( '#' . $heading['id'] ); ?>">
                        <?php echo esc_html( $heading['text'] ); ?>
                    </a>
            <?php endforeach; ?>
        </div>
    </nav>
    <?php
    return ob_get_clean();
}
add_shortcode( 'table_content', 'incredibuild_table_content_shortcode' );

/**
 * Collect H1 headings from hero_post flexible field layouts.
 *
 * @param int|array $post_id Post ID or array of post IDs (for fetch-page.php).
 *
 * @return array|false Array of headings with 'id' and 'text' keys, or false on failure.
 */
function incredibuild_collect_h1_hero_headings( $post_id ) {
    // Handle array of post IDs (from fetch-page.php)
    $post_ids = array();
    if ( is_array( $post_id ) ) {
        $post_ids = array_filter( array_map( 'absint', $post_id ) );
    } elseif ( $post_id ) {
        $post_ids = array( absint( $post_id ) );
    }

    if ( empty( $post_ids ) ) {
        return false;
    }

    $headings = array();
    $used_ids = array();

    // Get templates from options
    $templates = get_field( 'single_post_templates', 'option' );

    if ( empty( $templates ) || ! is_array( $templates ) ) {
        return false;
    }

    // Process each post ID
    foreach ( $post_ids as $current_post_id ) {
        $post_type = get_post_type( $current_post_id );

        if ( ! $post_type ) {
            continue;
        }

        // Find matching template for current post type
        foreach ( $templates as $template ) {
            $cpt_list = $template['cpt'] ?? array( 'post' );

            if ( empty( $cpt_list ) ) {
                $cpt_list = array( 'post' );
            } elseif ( ! is_array( $cpt_list ) ) {
                $cpt_list = array( $cpt_list );
            }

            // Normalize CPTs
            $normalized_cpts = array_map(
                function( $cpt ) {
                    $san = sanitize_key( $cpt );
                    return $san === 'posts' ? 'post' : $san;
                },
                $cpt_list
            );

            // Check if post type matches, or if it's a page type and template uses 'page-default'
            $matches = in_array( $post_type, $normalized_cpts, true );
            
            // Handle page-default case (used in fetch-page.php)
            if ( ! $matches && in_array( $post_type, array( 'page', 'legal', 'single_resource_page' ), true ) ) {
                $matches = in_array( 'page-default', $normalized_cpts, true );
            }

            if ( ! $matches ) {
                continue;
            }

            // Get single_post_content layouts from template
            $content_layouts = isset( $template['single_post_content'] ) ? $template['single_post_content'] : array();

            if ( empty( $content_layouts ) || ! is_array( $content_layouts ) ) {
                continue;
            }

            // Get post title (used for H1 text)
            $post_title = get_the_title( $current_post_id );

            if ( empty( $post_title ) ) {
                continue;
            }

            // Loop through layouts to find ALL hero_post layouts (not just the first one)
            foreach ( $content_layouts as $layout_row ) {
                $layout = isset( $layout_row['acf_fc_layout'] ) ? $layout_row['acf_fc_layout'] : '';

                if ( 'hero_post' !== $layout ) {
                    continue;
                }

                // Get hero_post field value from the layout row (used for ID)
                // This field is stored in the template structure
                $hero_post_field = isset( $layout_row['hero_post'] ) ? $layout_row['hero_post'] : '';

                // Generate ID from hero_post field or post title
                // This matches the logic in hero_post.php template
                if ( ! empty( $hero_post_field ) ) {
                    $heading_id = sanitize_title( $hero_post_field );
                } else {
                    $heading_id = sanitize_title( $post_title );
                }

                // Ensure unique ID across all headings
                if ( '' === $heading_id ) {
                    $heading_id = incredibuild_generate_heading_anchor( $post_title, $used_ids );
                } elseif ( in_array( $heading_id, $used_ids, true ) ) {
                    $heading_id = incredibuild_generate_heading_anchor( $post_title, $used_ids );
                } else {
                    $used_ids[] = $heading_id;
                }

                $headings[] = array(
                    'id'   => $heading_id,
                    'text' => $post_title,
                );

                // Don't break - collect all hero_post layouts
            }

            // Only process first matching template per post
            break;
        }
    }

    if ( empty( $headings ) ) {
        return false;
    }

    return $headings;
}

/**
 * Shortcode: [hero_content]
 * Outputs a table of contents based on H1 headings from hero_post flexible fields.
 *
 * @param array $atts Shortcode attributes.
 *
 * @return string
 */
function incredibuild_hero_content_shortcode( $atts ) {
    global $incredibuild_hero_toc_cache, $incredibuild_current_post_id, $incredibuild_fetch_page_ids;

    // Parse shortcode attributes
    $atts = shortcode_atts(
        array(
            'title'   => __( 'Hero Content', 'incredibuild' ),
            'post_id' => 0,
        ),
        $atts,
        'hero_content'
    );

    // For fetch-page.php, get all page IDs from global variable
    $post_ids = array();
    
    if ( ! empty( $incredibuild_fetch_page_ids ) && is_array( $incredibuild_fetch_page_ids ) ) {
        // Use all fetch page IDs
        $post_ids = $incredibuild_fetch_page_ids;
    } else {
        // Get single post ID from attribute, global variable (set by templates), or current post
        $post_id = ! empty( $atts['post_id'] ) ? absint( $atts['post_id'] ) : 0;
        
        if ( ! $post_id && ! empty( $incredibuild_current_post_id ) ) {
            $post_id = absint( $incredibuild_current_post_id );
        }
        
        if ( ! $post_id ) {
            $post_id = get_the_ID();
        }

        // If no post ID and not in a post context, try to get from global query
        if ( ! $post_id ) {
            global $wp_query;
            if ( isset( $wp_query->post ) && $wp_query->post ) {
                $post_id = $wp_query->post->ID;
            }
        }

        if ( $post_id ) {
            $post_ids = array( $post_id );
        }
    }

    if ( empty( $post_ids ) ) {
        return '';
    }

    // Create cache key from all post IDs
    $cache_key = md5( implode( ',', $post_ids ) );

    $headings = array();

    if (
        isset( $incredibuild_hero_toc_cache[ $cache_key ] )
        && ! empty( $incredibuild_hero_toc_cache[ $cache_key ]['headings'] )
    ) {
        $headings = $incredibuild_hero_toc_cache[ $cache_key ]['headings'];
    } else {
        $result = incredibuild_collect_h1_hero_headings( $post_ids );

        if ( $result ) {
            $headings = $result;
            $incredibuild_hero_toc_cache[ $cache_key ] = array(
                'post_ids' => $post_ids,
                'headings' => $headings,
            );
        }
    }

    if ( empty( $headings ) ) {
        return '';
    }

    $title = $atts['title'];

    ob_start();
    ?>
    <nav class="ib-table-content" aria-label="<?php echo esc_attr( $title ); ?>">
        <h6 class="ib-table-content__title white"><?php echo esc_html( $title ); ?></h6>
        <div class="ib-table-content__list flex dir_col links_uppercase">
            <?php foreach ( $headings as $heading ) : ?>
                    <a class="ib-table-content__link" href="<?php echo esc_url( '#' . $heading['id'] ); ?>">
                        <?php echo esc_html( $heading['text'] ); ?>
                    </a>
            <?php endforeach; ?>
        </div>
    </nav>
    <?php
    return ob_get_clean();
}
add_shortcode( 'hero_content', 'incredibuild_hero_content_shortcode' );

/**
 * Shortcode: [share]
 * Outputs social share links for the current post.
 *
 * @param array $atts Shortcode attributes.
 *
 * @return string
 */
function incredibuild_share_links_shortcode( $atts ) {
    if ( ! is_singular() ) {
        return '';
    }

    $post_id = get_the_ID();

    if ( ! $post_id ) {
        return '';
    }

    $permalink = get_permalink( $post_id );

    if ( ! $permalink ) {
        return '';
    }

    $atts = shortcode_atts(
        array(
            'title' => __( 'Share', 'incredibuild' ),
        ),
        $atts,
        'share'
    );

    $title         = $atts['title'];
    $encoded_url   = rawurlencode( $permalink );
    $post_title    = get_the_title( $post_id );
    $decoded_title = html_entity_decode( $post_title, ENT_QUOTES, get_bloginfo( 'charset' ) );
    $encoded_title = rawurlencode( $decoded_title );

    $links = array(
        array(
            'key'   => 'facebook',
            'label' => __( '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M22 12.0201C22 6.46349 17.5229 1.95898 12 1.95898C6.47715 1.95898 2 6.46349 2 12.0201C2 17.0418 5.65684 21.2042 10.4375 21.959V14.9284H7.89844V12.0201H10.4375V9.8035C10.4375 7.28194 11.9305 5.8891 14.2146 5.8891C15.3088 5.8891 16.4531 6.08561 16.4531 6.08561V8.56159H15.1922C13.95 8.56159 13.5625 9.3372 13.5625 10.1329V12.0201H16.3359L15.8926 14.9284H13.5625V21.959C18.3432 21.2042 22 17.042 22 12.0201Z" fill="white" fill-opacity="0.7"/>
                            </svg>', 
                            'incredibuild' ),
            'url'   => 'https://www.facebook.com/sharer/sharer.php?u=' . $encoded_url,
        ),
        array(
            'key'   => 'twitter',
            'label' => __( '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                              <path d="M17.1761 3.95898H19.9362L13.9061 10.7364L21 19.959H15.4456L11.0951 14.3656L6.11723 19.959H3.35544L9.80517 12.7098L3 3.95898H8.69545L12.6279 9.0716L17.1761 3.95898ZM16.2073 18.3344H17.7368L7.86441 5.49826H6.2232L16.2073 18.3344Z" fill="white" fill-opacity="0.7"/>
                            </svg>', 'incredibuild' ),
            'url'   => 'https://twitter.com/intent/tweet?url=' . $encoded_url . '&text=' . $encoded_title,
        ),
        array(
            'key'   => 'linkedin',
            'label' => __( '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                               <path fill-rule="evenodd" clip-rule="evenodd" d="M4.5 2.95898C3.67157 2.95898 3 3.63055 3 4.45898V19.459C3 20.2874 3.67157 20.959 4.5 20.959H19.5C20.3284 20.959 21 20.2874 21 19.459V4.45898C21 3.63055 20.3284 2.95898 19.5 2.95898H4.5ZM8.52076 6.9617C8.52639 7.91795 7.81061 8.50717 6.96123 8.50295C6.16107 8.49873 5.46357 7.8617 5.46779 6.96311C5.47201 6.11795 6.13998 5.43873 7.00764 5.45842C7.88795 5.47811 8.52639 6.12358 8.52076 6.9617ZM12.2797 9.72074H9.75971H9.7583V18.2806H12.4217V18.0809C12.4217 17.701 12.4214 17.321 12.4211 16.9409C12.4203 15.9271 12.4194 14.9122 12.4246 13.8987C12.426 13.6526 12.4372 13.3967 12.5005 13.1618C12.7381 12.2843 13.5271 11.7176 14.4074 11.8569C14.9727 11.9454 15.3467 12.2731 15.5042 12.8061C15.6013 13.1393 15.6449 13.4979 15.6491 13.8453C15.6605 14.8929 15.6589 15.9405 15.6573 16.9882C15.6567 17.358 15.6561 17.728 15.6561 18.0978V18.2792H18.328V18.0739C18.328 17.6219 18.3278 17.17 18.3275 16.7181C18.327 15.5886 18.3264 14.4591 18.3294 13.3292C18.3308 12.8187 18.276 12.3153 18.1508 11.8217C17.9638 11.0876 17.5771 10.4801 16.9485 10.0414C16.5027 9.72917 16.0133 9.52808 15.4663 9.50558C15.404 9.50299 15.3412 9.4996 15.2781 9.49619C14.9984 9.48107 14.7141 9.46571 14.4467 9.51964C13.6817 9.67292 13.0096 10.0231 12.5019 10.6404C12.4429 10.7112 12.3852 10.7831 12.2991 10.8904L12.2797 10.9147V9.72074ZM5.68164 18.2834H8.33242V9.72631H5.68164V18.2834Z" fill="white" fill-opacity="0.7"/>
                            </svg>', 'incredibuild' ),
            'url'   => 'https://www.linkedin.com/sharing/share-offsite/?url=' . $encoded_url,
        ),
    );

    ob_start();
    ?>
    <div class="ib-share-links" aria-label="<?php echo esc_attr( $title ); ?>">
        <div class="ib-share-links__title semibold white"><?php echo esc_html( $title ); ?></div>
        <div class="ib-share-links__list socials flex align_c gap_12">
            <?php foreach ( $links as $link ) : ?>
                    <a
                        class="ib-share-links__link social_link ib-share-links__link--<?php echo esc_attr( $link['key'] ); ?>"
                        href="<?php echo esc_url( $link['url'] ); ?>"
                        target="_blank"
                        rel="noopener noreferrer"
                        aria-label="<?php echo esc_attr( sprintf( __( 'Share on %s', 'incredibuild' ), $link['label'] ) ); ?>"
                    >
                        <?php echo $link['label']; ?>
                    </a>
            <?php endforeach; ?>
        </div>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode( 'share', 'incredibuild_share_links_shortcode' );

function get_gutenberg_class() {

    $matched_class = false;

    // Load repeater data safely (no pointer movement)
    $templates = get_field('single_post_templates', 'option');

    if ( ! empty($templates) && is_array($templates) ) {
        foreach ( $templates as $template ) {

            $cpt_list = $template['cpt'] ?? ['post'];

            if ( empty($cpt_list) ) {
                $cpt_list = ['post'];
            } elseif ( ! is_array($cpt_list) ) {
                $cpt_list = [$cpt_list];
            }

            // Normalize CPTs
            $normalized_cpts = array_map(function($cpt){
                $san = sanitize_key($cpt);
                return $san === 'posts' ? 'post' : $san;
            }, $cpt_list);

            if ( ! in_array(get_post_type(), $normalized_cpts, true) ) {
                continue;
            }

            // Check if flexible content exists
            if ( ! empty($template['single_post_content']) ) {
                $matched_class = true;
            }

            if ( $matched_class ) break;
        }
    }

    // Page templates force gutenberg
    if (
        is_page_template('page-templates/flexible-page.php') ||
        is_page_template('page-templates/default-page.php') ||
        is_page_template('page-templates/fetch-page.php')
    ) {
        $matched_class = true;
    }

    // If NO ACF template matched → enable Gutenberg
    if ( ! $matched_class ) {
        $GLOBALS['is_gutenberg_body'] = true;
    }
}

add_filter('pll_the_language_link', 'my_custom_lang_links', 10, 3);
function my_custom_lang_links( $url, $slug, $locale ) {

    // Chinese
    if ( in_array( $slug, ['ch', 'zh_CN', 'zh-CN', 'zh-Hans'], true ) ) {
        return 'http://incredibuild.cn/';
    }

    // Japanese
    if ( in_array( $slug, ['ja', 'ja_JP'], true ) ) {
        return 'https://www.incredibuild.com/ja/';
    }

    return $url;
}


/**
 * One-time migration: Convert lazyblock/gatedvideo → core/embed
 */
 add_action('init', 'ib_run_lazyblock_gatedvideo_migration_once');
 function ib_run_lazyblock_gatedvideo_migration_once() {
     // Already run? Stop.
     if ( get_option('ib_lazyblock_gatedvideo_migration_done') ) {
         return;
     }
     // Only run for admins and in admin or via WP-CLI
     if ( ! is_admin() && ! ( defined( 'WP_CLI' ) && WP_CLI ) ) {
         if ( ! current_user_can( 'manage_options' ) ) {
             return;
         }
     }
     // Query ALL posts of ALL types
     $query = new WP_Query(array(
         'post_type'      => 'any',
         'post_status'    => array('publish','draft','private','pending','future'),
         'posts_per_page' => -1,
         'fields'         => 'ids',
         'no_found_rows'  => true,
     ));
     $converted_count = 0;
     $processed_count = 0;
     foreach ( $query->posts as $post_id ) {
         $processed_count++;
         $content = get_post_field('post_content', $post_id);
         if ( ! $content || empty( trim( $content ) ) ) {
             continue;
         }
         // Check if content contains the block we're looking for
         if ( false === strpos( $content, 'lazyblock/gatedvideo' ) ) {
             continue;
         }
         // Parse and convert blocks
         $blocks     = parse_blocks( $content );
      
         if ( empty( $blocks ) ) {
             continue;
         }
         $new_blocks = ib_lazyblock_recursive_convert( $blocks );
         $new_content = serialize_blocks( $new_blocks );
         // Save only if modified
         if ( $new_content !== $content ) {
             $result = wp_update_post(array(
                 'ID'           => $post_id,
                 'post_content' => $new_content,
             ), true);
             if ( ! is_wp_error( $result ) ) {
                 $converted_count++;
             }
         }
     }
     // Mark migration done
     update_option('ib_lazyblock_gatedvideo_migration_done', 1);
  
     // Log results if WP_DEBUG is enabled
     if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
         error_log( sprintf( 
             'Lazyblock migration: Processed %d posts, converted %d posts', 
             $processed_count, 
             $converted_count 
         ) );
     }
 }
 /**
  * Recursively convert lazyblock/gatedvideo blocks into core/embed blocks.
  */
 function ib_lazyblock_recursive_convert( $blocks ) {
     $new_blocks = array();
     foreach ( $blocks as $block ) {
         // Skip if block is null or invalid
         if ( empty( $block ) || ! is_array( $block ) ) {
             continue;
         }
         // Recursively process nested blocks FIRST (before checking block name)
         if ( ! empty( $block['innerBlocks'] ) && is_array( $block['innerBlocks'] ) ) {
             $block['innerBlocks'] = ib_lazyblock_recursive_convert( $block['innerBlocks'] );
         }
         // Detect Lazyblock gated video block
         if ( isset( $block['blockName'] ) && $block['blockName'] === 'lazyblock/gatedvideo' ) {
             // Extract video URL - try different possible attribute names
             $video_url = '';
             if ( isset( $block['attrs'] ) && is_array( $block['attrs'] ) ) {
                 $video_url = $block['attrs']['video-url'] ?? 
                            $block['attrs']['videoUrl'] ?? 
                            $block['attrs']['url'] ?? 
                            $block['attrs']['video_url'] ?? '';
             }
             if ( ! empty( $video_url ) ) {
                 // Detect provider from URL
                 $provider_slug = 'video';
                 $provider_class = '';
              
                 if ( preg_match( '/vimeo\.com/i', $video_url ) ) {
                     $provider_slug = 'vimeo';
                     $provider_class = 'is-provider-vimeo wp-block-embed-vimeo';
                 } elseif ( preg_match( '/youtube\.com|youtu\.be/i', $video_url ) ) {
                     $provider_slug = 'youtube';
                     $provider_class = 'is-provider-youtube wp-block-embed-youtube';
                 } elseif ( preg_match( '/dailymotion\.com/i', $video_url ) ) {
                     $provider_slug = 'dailymotion';
                     $provider_class = 'is-provider-dailymotion wp-block-embed-dailymotion';
                 }
                 // Build proper core/embed block structure matching WordPress format
                 $figure_classes = 'wp-block-embed is-type-video';
                 if ( $provider_class ) {
                     $figure_classes .= ' ' . $provider_class;
                 }
                 $embed_block = array(
                     'blockName'    => 'core/embed',
                     'attrs'        => array(
                         'url'             => esc_url_raw( $video_url ),
                         'type'            => 'video',
                         'providerNameSlug' => $provider_slug,
                     ),
                     'innerBlocks'  => array(),
                     'innerHTML'    => '<figure class="' . esc_attr( $figure_classes ) . '"><div class="wp-block-embed__wrapper">' . "\n" . esc_url( $video_url ) . "\n" . '</div></figure>',
                     'innerContent' => array(
                         '<figure class="' . esc_attr( $figure_classes ) . '"><div class="wp-block-embed__wrapper">' . "\n",
                         esc_url( $video_url ),
                         "\n" . '</div></figure>'
                     ),
                 );
                 $new_blocks[] = $embed_block;
                 continue; // Skip original block
             }
         }
         // Keep original block if not matched
         $new_blocks[] = $block;
     }
     return $new_blocks;
 }

function incredibuild_get_enable_divider_class() {
    $divider = get_sub_field('enable_divider');
    $class =  '';
    if($divider == 'top'){
        $class = 'border_top pt_64';
    } elseif($divider == 'bottom'){
        $class = 'border_bottom pb_64';
    } elseif($divider == 'both'){
        $class = 'border_top border_bottom pt_64 pb_64';
    }
    return $class;
}