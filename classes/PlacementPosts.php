<?php

/**
 * Class PlacementPosts.
 * It's a helper class to create catch and update catch for the placement taxonomy posts while creating or updating
 * a post.
 */
class PlacementPosts
{
    private static $_cacheKeys = [
        'Lead'         => 'placement_lead_posts',
        'News Section' => 'placement_news_section_posts',
        'Brief'        => 'placement_brief_posts',
    ];

    private $_placement;

    public function __construct()
    {
        // Add in to the post save action to remove the cache
        add_action('save_post', [$this, 'removeFromCache'], 10, 2);
    }

    public function setPlacement($value)
    {
        $this->_placement = $value;

        return $this;
    }

    public function getPlacement()
    {
        return $this->_placement;
    }

    public function cache($placement, $posts)
    {
        if (isset(self::$_cacheKeys[$placement])) {
            set_transient(self::$_cacheKeys[$placement], $posts);
        }
    }

    public function removeFromCache($postID, $post)
    {
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        if ($post instanceof WP_Post && $post->post_type == 'post') {
            foreach (self::$_cacheKeys as $cacheKey) {
                delete_transient($cacheKey);
            }
        }
    }

    public function getPosts()
    {
        $placement = $this->_placement;
        $terms     = get_terms(['taxonomy' => 'placement', 'name__like' => $placement]);
        $thePosts  = [];

        foreach ($terms as $term) {
            $posts   = get_posts([
                'posts_per_page' => 1,
                'post_type'      => 'post',
                'post_status'    => 'publish',
                'tax_query'      => [
                    [
                        'taxonomy' => 'placement',
                        'field'    => 'term_id',
                        'terms'    => $term->term_id
                    ]
                ]
            ]);
            $replace = sanitize_title($placement);
            $key     = str_replace($replace . '-', '', $term->slug);

            if (!empty($posts)) {
                $thePosts[$key] = $posts[0];
            }
        }

        ksort($thePosts); // Sorting the array to keep the order of posts
        $this->cache($placement, $thePosts); // Cache the posts

        return $thePosts;
    }
}

new PlacementPosts();