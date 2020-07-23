<?php
/**
 * The search page template file
 */

$text = isset( $_GET[ 'text' ] ) ? $_GET[ 'text' ] : '';
$filter = isset( $_GET[ 'filter_by' ] ) ? $_GET[ 'filter_by' ] : '';
$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

if ( !empty( $text ) || !empty( $filter ) ) {
    $queryArgs = array( 'text' => $text, 'filter_by' => $filter );
    $results = new WP_Query( array(
        'post_type' => 'post',
        'posts_per_page' => 10,
        'orderby' => 'date',
        'cat' => $filter,
        's' => $text,
        'paged' => $paged,
    ) );
}
?>

<?php get_header(); ?>

<div class="container-fluid">
    <section class="page-section page-search">
        <?php theBreadcrumb(); ?>

        <header class="page-header">
            <h1 class="page-title">
                <?php _e( 'Search' ); ?>
            </h1>
        </header>

        <?php get_search_form(); ?>

        <hr>

        <div class="row">
            <div class="col-lg-8">
                <div class="page-content" id="searchResults">
                    <?php if ( isset( $results ) ) : ?>
                        <?php if ( $results->have_posts() ) : ?>
                            <?php while ( $results->have_posts() ) : $results->the_post(); ?>
                                <div class="card the-story mb-4">
                                    <?php if ( has_post_thumbnail() ) : ?>
                                        <div class="row no-gutters">
                                            <div class="col-md-4">
                                                <?php the_post_thumbnail( 'wide', array(
                                                    'class' => 'card-img img-fluid h-100'
                                                ) ); ?>
                                            </div>

                                            <div class="col-md-8">
                                                <div class="card-body">
                                                    <h4 class="card-title">
                                                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                                    </h4>

                                                    <p class="card-text text-muted">
                                                        <?php echo wp_trim_words( get_the_excerpt(), 30 ); ?>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    <?php else : ?>
                                        <div class="card-body">
                                            <h4 class="card-title">
                                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                            </h4>

                                            <p class="card-text text-muted">
                                                <?php echo wp_trim_words( get_the_excerpt(), 30 ); ?>
                                            </p>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php endwhile; ?>

                            <?php if ( get_next_posts_link( null, $results->max_num_pages ) ) : ?>
                                <button type="button" class="btn btn-block btn-outline-dark btn-load-more mx-auto w-25" id="loadMore">
                                    <i class="fas fa-circle-notch fa-spin d-none"></i>
                                    <span><?php _e( 'Load More' ) ?></span>
                                </button>
                            <?php endif; ?>

                            <?php wp_reset_postdata(); ?>
                        <?php else: ?>
                            <p class="lead text-muted">
                                <?php _e( 'Oops, no results were found for your search.' ) ?>
                            </p>
                        <?php endif; ?>
                    <?php else: ?>
                        <p class="lead text-muted">
                            <?php _e( 'Search something or choose any filter to find some great stories.' ) ?>
                        </p>
                    <?php endif; ?>
                </div>
            </div>

            <div class="d-none d-lg-block col-lg-4">
                <?php get_template_part( 'template-parts/content/trending-widget' ); ?>
            </div>
        </div>
    </section>
</div>

<?php if ( isset( $results ) && get_next_posts_link( null, $results->max_num_pages ) ) : ?>
    <?php if ( isset( $results->query_vars['search_orderby_title'] ) ) {
        unset( $results->query_vars['search_orderby_title'] );
    } ?>

    <script async type="text/javascript">
        jQuery( document ).ready( function ($) {
            var page = 2, maxPage = <?php echo $results->max_num_pages; ?>;

            $( 'body' ).on( 'click', '#loadMore', function () {
                var $button = $( this ),
                    data = {
                        action: 'load_more_posts_search',
                        query: '<?php echo json_encode( $results->query_vars ); ?>',
                        page: page
                    };

                $.ajax( {
                    url: '<?php echo admin_url( 'admin-ajax.php' ); ?>',
                    data: data,
                    type: 'POST',
                    beforeSend: function () {
                        $button.find( 'span' ).addClass( 'd-none' );
                        $button.find( 'i' ).removeClass( 'd-none' );
                        $button.prop( 'disabled', true );
                    },
                    success: function (response) {
                        $button.find( 'span' ).removeClass( 'd-none' );
                        $button.find( 'i' ).addClass( 'd-none' );
                        $button.prop( 'disabled', false );

                        if ( response ) {
                            if ( page >= maxPage ) {
                                $button.remove();
                            }

                            $( '#searchResults' ).append( response );
                            page++;
                        } else {
                            $button.remove();
                        }
                    }
                } );
            } );
        } );
    </script>
<?php endif; ?>

<?php get_footer(); ?>
