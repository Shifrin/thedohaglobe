<?php
/**
 * Handle the posts of "placement" taxonomy.
 * "placement" taxonomy will help to show the posts on homepage in appropriate sections.
 * Here we will handle all the functions related to the "placement" taxonomy
 */

/**
 * Add custom taxonomy "placement".
 */
function addPlacementTaxonomy()
{
    register_taxonomy('placement', 'post', [
        'public'             => false, // we make this private
        'show_ui'            => true,
        'show_in_rest'       => true,
        'show_in_quick_edit' => true,
        'show_admin_column'  => true,
        // This array of options controls the labels displayed in the WordPress Admin UI
        'labels'             => [
            'name'              => _x('Placements', 'taxonomy general name'),
            'singular_name'     => _x('Placement', 'taxonomy singular name'),
            'search_items'      => __('Search Placements'),
            'all_items'         => __('All Placements'),
            'parent_item'       => __('Parent Placement'),
            'parent_item_colon' => __('Parent Placement:'),
            'edit_item'         => __('Edit Placement'),
            'update_item'       => __('Update Placement'),
            'add_new_item'      => __('Add New Placement'),
            'new_item_name'     => __('New Placement Name'),
            'menu_name'         => __('Placements'),
        ],
    ]);
}

add_action('init', 'addPlacementTaxonomy', 0);

/**
 * Add placement custom taxonomy filter to the posts table in administration
 */
add_action('restrict_manage_posts', function () {
    global $typenow;

    $postType = 'post';

    if ($typenow == $postType) {
        $selected = isset($_GET['placement']) ? $_GET['placement'] : 0;

        if (!is_numeric($selected)) {
            $term = get_term_by('slug', $_GET['placement'], 'placement');

            if ($term) {
                $selected = $term->term_id;
            }
        }

        wp_dropdown_categories([
            'show_option_all' => 'All Placements',
            'orderby'         => 'name',
            'name'            => 'placement',
            'selected'        => $selected,
            'taxonomy'        => 'placement',
        ]);
    }
});

/**
 * Filter the posts based on custom taxonomy placement in administration table list.
 */
add_filter('parse_query', function ($query) {
    if (!is_admin()) {
        return;
    }

    global $pagenow;

    $queriedPostType  = isset($query->query_vars['post_type']) ? $query->query_vars['post_type'] : '';
    $queriedGTaxonomy = isset($query->query_vars['placement']) ? $query->query_vars['placement'] : '';

    if ($pagenow == 'edit.php' && $queriedPostType == 'post' && !empty($queriedGTaxonomy)) {
        $term = get_term_by('id', $queriedGTaxonomy, 'placement');

        if ($term) {
            $query->query_vars['placement'] = $term->slug;
        }
    }
});

/**
 * Get placements posts
 *
 * @return array
 */
function getPlacementPosts()
{
    $posts = get_transient('__placement_posts');

    if (!$posts) {
        $posts = cachePlacementsPosts();
    }

    return $posts;
}

/**
 * Get placement posts IDs only.
 *
 * @return array
 */
function getPlacementPostIds()
{
    $ids = get_transient('__placement_post_ids');

    if (!$ids) {
        $ids = cachePlacementsPosts();
    }

    return $ids;
}

/**
 * Get main lead post.
 *
 * @return WP_Post|null
 */
function getMainLeadPost()
{
    $posts = getPlacementPosts();
    $lead = null;

    if (isset($posts['lead']) && !empty($posts['lead'])) {
        $lead = $posts['lead'][0];
    }

    return $lead;
}

/**
 * Get other lead posts except the main lead (lead-1).
 *
 * @return WP_Post[]|null
 */
function getLeadPosts()
{
    $posts = getPlacementPosts();
    $leads = null;

    if (isset($posts['lead']) && !empty($posts['lead'])) {
        $leads = $posts['lead'];
        unset($leads[0]);
    }

    return $leads;
}

/**
 * Get news section posts.
 *
 * @return WP_Post[]|array
 */
function getNewsSectionPosts()
{
    $posts = getPlacementPosts();
    $newsSectionPosts = null;

    if (isset($posts['news-section']) && !empty($posts['news-section'])) {
        $newsSectionPosts = $posts['news-section'];
    }

    return $newsSectionPosts;
}

/**
 * Update cache whenever post saved.
 */
add_action('save_post', function ($postID, $post) {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if ($post instanceof WP_Post && $post->post_type === 'post') {
        delete_transient('__placement_posts');
    }
}, 10, 2);

/**
 * Find and Cache the very first placement posts.
 *
 * @return array
 */
function cachePlacementsPosts()
{
    $terms = get_terms([
        'taxonomy' => 'placement',
        'hide_empty' => false,
    ]);
    $posts = [];
    $ids = [];

    foreach ($terms as $term) {
        $foundPosts = get_posts([
            'posts_per_page' => 4,
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

        foreach ($foundPosts as $foundPost) {
            $posts[$term->slug][] = $foundPost;
            $ids[] = $foundPost->ID;
        }
    }

    ksort($posts);
    set_transient('__placement_post_ids', $ids);
    set_transient('__placement_posts', $posts);

    return $posts;
}