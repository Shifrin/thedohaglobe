<?php
/**
 * Display the breadcrumb
 * @param  string|boolean $custom_home_icon [OPTIONAL] Insert html tag (like Fontawesome <i class="fa fa-xx"></li>)
 * @param  array|boolean $custom_post_types [OPTIONAL] Prevent custom post types with hierarchical structure
 */
function theBreadcrumb( $custom_home_icon = false, $custom_post_types = false )
{
    wp_reset_query();

    global $post;

    // TODO: Should customize if it's provide any strange behaviours for custom post type
    $is_custom_post = $custom_post_types ? is_singular( $custom_post_types ) : false;

    if ( !is_front_page() && !is_home() ) {
        echo '<nav aria-label="breadcrumb">';
            echo '<ol class="breadcrumb">';

            $homeIcon = $custom_home_icon ? $custom_home_icon : displayIcon('home', false);
            $homePage = $homeIcon . 'Front Page';

            echo '<li class="breadcrumb-item"><a href="' . get_home_url() . '">' . $homePage . '</a></li>';

            if ( is_category() ) {
                echo '<li class="breadcrumb-item active" aria-current="page">'
                    . single_cat_title( '', false ) . '</li>';
            }

            if ( is_single() ) {
                $categories = getTheFilteredCategories();

                if ( !empty( $categories ) ) {
                    echo '<li class="breadcrumb-item"><a href="' . esc_url( get_category_link( $categories[0] ) ) . '">'
                        . $categories[0]->name . '</a></li>';
                }

                echo '<li class="breadcrumb-item active" aria-current="page">'
                    . get_the_title( $post ) . '</li>';
            }

            if ( is_page() ) {
                $home = get_post( get_option('page_on_front') );

                if ( $post->post_parent ) {
                    for ( $i = count( $post->ancestors ) - 1; $i >= 0; $i-- ) {
                        if ( ($home->ID ) != ( $post->ancestors[$i] ) ) {
                            echo '<li class="breadcrumb-item"><a href="' . get_permalink( $post->ancestors[$i] ) . '">'
                                . get_the_title( $post->ancestors[$i] ) . '</a></li>';
                        }
                    }
                }

                echo '<li class="breadcrumb-item active" aria-current="page">' . get_the_title( $post ) . '</li>';
            }

            if ( is_404() ) {
                echo '<li class="breadcrumb-item active" aria-current="page">' . __( '404' ) . '</li>';
            }

            echo '</ol>';
        echo '</nav>';
    }
}