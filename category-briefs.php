<?php
/**
 * The category page template file
 */
?>

<?php get_header(); ?>

    <div class="container-fluid">
        <div class="category-page-section">
            <header class="page-header d-inline-block">
                <h1 class="page-title mb-0"><?php single_cat_title(); ?></h1>
            </header>

            <div class="page-content">
                <div class="card-columns" id="moreStories">
                    <?php if ( have_posts() ) : ?>
                        <?php while ( have_posts() ) : the_post(); ?>
                            <div class="card the-story">
                                <div class="card-body">
                                    <h4 class="card-title mb-0">
                                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                    </h4>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    <?php endif; ?>
                </div>

                <?php if ( get_next_posts_link() ) : ?>
                    <button type="button" class="btn btn-block btn-outline-dark btn-load-more mx-auto w-25" id="loadMore">
                        <i class="fas fa-circle-notch fa-spin d-none"></i>
                        <span><?php _e( 'Load More' ) ?></span>
                    </button>
                <?php endif; ?>
            </div>
        </div>
    </div>

<?php get_footer(); ?>
