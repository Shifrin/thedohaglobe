<?php
/**
 * Display the pagination
 *
 * @param WP_Query|null $wp_query
 * @param array|bool    $params An array of query args to add default false
 *
 * @return string the pagination links as list or empty
 */
function thePagination(WP_Query $wp_query = null, $params = false)
{
    if (null === $wp_query) {
        global $wp_query;
    }

    $pages = paginate_links([
            'base'      => preg_replace('/\?.*/', '/', get_pagenum_link(1)) . '%_%',
            'format'    => '?paged=%#%',
            'current'   => max(1, get_query_var('paged')),
            'total'     => $wp_query->max_num_pages,
            'type'      => 'array',
            'show_all'  => false,
            'end_size'  => 3,
            'mid_size'  => 1,
            'prev_next' => true,
            'add_args'  => $params,
            'prev_text' => __('Previous'),
            'next_text' => __('Next'),
        ]
    );

    if (is_array($pages)) {
        $pagination = '<nav class="pagination-wrapper mt-3" aria-label="Pagination">
            <ul class="pagination justify-content-center mb-0">';

        foreach ($pages as $page) {
            $pagination .= '<li class="page-item">' . str_replace('page-numbers', 'page-link', $page)
                . '</li>';
        }

        $pagination .= '</ul></nav>';

        echo $pagination;
    }

    echo '';
}