<?php
/**
 * Breadcrumbs partial.
 *
 * Outputs breadcrumb navigation that covers pages, posts, CPTs, archives, search, and 404 contexts.
 *
 * Usage: include this partial wherever breadcrumbs should appear.
 *
 * @package Incredibuild
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( is_front_page() ) {
    return;
}

// $cpt = get_queried_object();
$breadcrumbs = array();
$home_url    = home_url( '/' );
$home_icon   = get_template_directory_uri() . '/assets/images/breadcrumb-home.svg';
$divider_icon = get_template_directory_uri() . '/assets/images/arrow-right-white-30.svg';
$post_type = '';

if ( isset( $args['cpt_name'] ) && ! empty( $args['cpt_name'] ) ) {
    $cpt_name_arg = $args['cpt_name'];

    if ( is_array( $cpt_name_arg ) ) {
        $cpt_name_arg = reset( $cpt_name_arg );
    }

    if ( is_string( $cpt_name_arg ) ) {
        $post_type = sanitize_key( $cpt_name_arg );
    }
}

if ( 'posts' === $post_type ) {
    $post_type = 'post';
}

if ( empty( $post_type ) ) {
    $post_type = get_post_type();
}

$breadcrumbs[] = array(
    'label' => '<img src="' . esc_url( $home_icon ) . '" alt="' . esc_attr__( 'Home', 'incredibuild' ) . '" class="breadcrumbs__home-icon" />',
    'url'   => $home_url,
    'is_html' => true,
);

// Static "Resources" crumb directly after Home
$breadcrumbs[] = array(
    'label' => __( 'Resources', 'incredibuild' ),
    'url'   => '',
);

$page_for_posts = (int) get_option( 'page_for_posts' );

if ( is_home() ) {
    if ( $page_for_posts ) {
        $breadcrumbs[] = array(
            'label' => get_the_title( $page_for_posts ),
            'url'   => '',
        );
    } else {
        $breadcrumbs[] = array(
            'label' => __( 'Blog', 'incredibuild' ),
            'url'   => '/blog/',
        );
    }
} elseif ( is_singular() ) {
    global $post;

    $post_type = $post_type ? $post_type : get_post_type( $post );
    $post_type_obj = get_post_type_object( $post_type );

    if ( 'post' === $post_type ) {
        if ( $page_for_posts ) {
            $breadcrumbs[] = array(
                'label' => get_the_title( $page_for_posts ),
                'url'   => get_permalink( $page_for_posts ),
            );
        } else {
            $breadcrumbs[] = array(
                'label' => __( 'Blog', 'incredibuild' ),
                'url'   => '/blog/'
            );
        }

        // $categories = get_the_category( $post->ID );
        // if ( ! empty( $categories ) ) {
        //     $primary_category = $categories[0];
        //     $ancestors = array_reverse( get_ancestors( $primary_category->term_id, 'category' ) );
        //     foreach ( $ancestors as $ancestor_id ) {
        //         $ancestor = get_term( $ancestor_id, 'category' );
        //         if ( ! $ancestor || is_wp_error( $ancestor ) ) {
        //             continue;
        //         }
        //         $breadcrumbs[] = array(
        //             'label' => $ancestor->name,
        //             'url'   => get_term_link( $ancestor ),
        //         );
        //     }
        //     $breadcrumbs[] = array(
        //         'label' => $primary_category->name,
        //         'url'   => get_term_link( $primary_category ),
        //     );
        // }
    } 
    elseif ( $post_type_obj && ! in_array( $post_type, array( 'page', 'attachment' ), true ) ) {
        if ( $post_type_obj->has_archive ) {
            $breadcrumbs[] = array(
                'label' => $post_type_obj->labels->name,
                'url'   => get_post_type_archive_link( $post_type ),
            );
        }
    }

    if ( is_post_type_hierarchical( $post_type ) ) {
        $ancestors = get_post_ancestors( $post );
        if ( ! empty( $ancestors ) ) {
            $ancestors = array_reverse( $ancestors );
            foreach ( $ancestors as $ancestor_id ) {
                $breadcrumbs[] = array(
                    'label' => get_the_title( $ancestor_id ),
                    'url'   => get_permalink( $ancestor_id ),
                );
            }
        }
    }

    $breadcrumbs[] = array(
        'label' => get_the_title( $post ),
        'url'   => '',
    );
} elseif ( is_category() || is_tag() || is_tax() ) {
    $term = get_queried_object();

    if ( $term && ! is_wp_error( $term ) ) {
        if ( 'post' === $term->taxonomy && $page_for_posts ) {
            $breadcrumbs[] = array(
                'label' => get_the_title( $page_for_posts ),
                'url'   => get_permalink( $page_for_posts ),
            );
        } elseif ( ! empty( $term->taxonomy ) ) {
            $tax = get_taxonomy( $term->taxonomy );
            if ( $tax && $tax->object_type ) {
                $primary_post_type = $tax->object_type[0];
                $post_type_obj     = get_post_type_object( $primary_post_type );
                if ( $post_type_obj && $post_type_obj->has_archive ) {
                    $breadcrumbs[] = array(
                        'label' => $post_type_obj->labels->name,
                        'url'   => get_post_type_archive_link( $primary_post_type ),
                    );
                }
            }
        }

        $ancestors = array();
        if ( is_taxonomy_hierarchical( $term->taxonomy ) && $term->parent ) {
            $ancestors = array_reverse( get_ancestors( $term->term_id, $term->taxonomy ) );
        }

        foreach ( $ancestors as $ancestor_id ) {
            $ancestor = get_term( $ancestor_id, $term->taxonomy );
            if ( ! $ancestor || is_wp_error( $ancestor ) ) {
                continue;
            }
            $breadcrumbs[] = array(
                'label' => $ancestor->name,
                'url'   => get_term_link( $ancestor ),
            );
        }

        $breadcrumbs[] = array(
            'label' => $term->name,
            'url'   => '',
        );
    }
} elseif ( is_search() ) {
    $breadcrumbs[] = array(
        'label' => sprintf( __( 'Search results for "%s"', 'incredibuild' ), get_search_query() ),
        'url'   => '',
    );
} elseif ( is_404() ) {
    $breadcrumbs[] = array(
        'label' => __( '404 Not Found', 'incredibuild' ),
        'url'   => '',
    );
} elseif ( is_post_type_archive() ) {
    $post_type = get_query_var( 'post_type' );
    if ( is_array( $post_type ) ) {
        $post_type = reset( $post_type );
    }
    $post_type_obj = get_post_type_object( $post_type );
    if ( $post_type_obj ) {
        $breadcrumbs[] = array(
            'label' => $post_type_obj->labels->name,
            'url'   => '',
        );
    }
} elseif ( is_author() ) {
    $author = get_queried_object();
    if ( $author ) {
        $breadcrumbs[] = array(
            'label' => sprintf( __( 'Articles by %s', 'incredibuild' ), $author->display_name ),
            'url'   => '',
        );
    }
} elseif ( is_date() ) {
    if ( is_year() ) {
        $breadcrumbs[] = array(
            'label' => get_the_date( _x( 'Y', 'yearly archives date format', 'incredibuild' ) ),
            'url'   => '',
        );
    } elseif ( is_month() ) {
        $breadcrumbs[] = array(
            'label' => get_the_date( _x( 'F Y', 'monthly archives date format', 'incredibuild' ) ),
            'url'   => '',
        );
    } elseif ( is_day() ) {
        $breadcrumbs[] = array(
            'label' => get_the_date( _x( 'F j, Y', 'daily archives date format', 'incredibuild' ) ),
            'url'   => '',
        );
    }
}

if ( count( $breadcrumbs ) <= 1 ) {
    return;
}

?>
<nav class="breadcrumbs links_uppercase flex align_c gap_12">
        <?php
        $last_index = count( $breadcrumbs ) - 1;
        foreach ( $breadcrumbs as $index => $crumb ) :
            $label = isset( $crumb['label'] ) ? $crumb['label'] : '';
            $url   = isset( $crumb['url'] ) ? $crumb['url'] : '';
            $is_last = ( $index === $last_index );
            $is_html = ! empty( $crumb['is_html'] );
            ?>
            <div class="breadcrumbs__item<?php echo $is_last ? ' breadcrumbs__item--current' : ''; ?>">
                <?php if ( $url && ! $is_last ) : ?>
                    <a class="breadcrumbs__link" href="<?php echo esc_url( $url ); ?>">
                        <?php echo $is_html ? $label : esc_html( $label ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                    </a>
                <?php else : ?>
                    <span class="breadcrumbs__text"<?php echo $is_last ? ' aria-current="page"' : ''; ?>><?php echo esc_html( $label ); ?></span>
                <?php endif; ?>
            </div>
            <?php if ( ! $is_last ) : ?>
                <div class="breadcrumbs__divider" aria-hidden="true">
                    <img src="<?php echo esc_url( $divider_icon ); ?>" alt="" />
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
</nav>
