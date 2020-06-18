<?php
/**
 * Created by PhpStorm.
 * User: shifr
 * Date: 4/14/2019
 * Time: 11:26 AM
 */

class PlacementPosts
{

    private static $_cacheKeys = array(
        'Lead' => 'placement_lead_posts',
        'News Section' => 'placement_news_section_posts',
        'Brief' => 'placement_brief_posts',
    );

    private $_placement;

    public function __construct( $placement )
    {
        $this->_placement = $placement;
    }

    public function cache($placement, $posts )
    {
        set_transient( self::$_cacheKeys[ $placement ],  $posts);
    }

    public static function removeFromCache($postID, $post )
    {
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return;
        }

        if ( $post->post_type == 'post' ) {
            foreach ( self::$_cacheKeys as $cacheKey ) {
                delete_transient( $cacheKey );
            }
        }
    }

    public function getPosts()
    {
        $placement = $this->_placement;
        $terms = get_terms( array( 'taxonomy' => 'placement', 'name__like' => $placement ) );
        $thePosts = array();

        foreach ( $terms as $term ) {
            $posts = get_posts( array( 'posts_per_page' => 1, 'post_type' => 'post', 'post_status' => 'publish',
                'tax_query' => array( array(
                    'taxonomy' => 'placement', 'field' => 'term_id', 'terms' => $term->term_id
                ) )
            ) );
            $replace = sanitize_title( $placement );
            $key = str_replace( $replace . '-', '', $term->slug );

            if ( !empty( $posts ) ) {
                $thePosts[ $key ] = $posts[0];
            }
        }

        ksort( $thePosts ); // Sorting the array to keep the order of posts
        $this->cache( $placement, $thePosts ); // Cache the posts

        return $thePosts;
    }

}

// Add in to the post save action to remove the cache
add_action( 'save_post', array( 'PlacementPosts', 'removeFromCache' ), 10, 2 );