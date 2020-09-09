<?php
/**
 * The opinion category page template file
 */
?>

<?php get_header(); ?>

    <div class="container-fluid">
        <div class="category-page-section">
            <header class="page-header d-inline-block">
                <h1 class="page-title mb-0"><?php single_cat_title(); ?></h1>
            </header>

            <div class="page-content">
                <?php get_template_part( 'template-parts/content/category/opinion-latest-stories' ); ?>

                <?php if ( have_posts() ) : ?>
                    <h2 class="category-more-title mt-5 mb-4"><?php single_cat_title( __( 'More ' ) ); ?></h2>

                    <div class="row">
                        <div class="col-lg-8">
                            <div class="more-stories" id="moreStories">
                                <?php get_template_part( 'template-parts/content/category/opinion-more-stories' ); ?>
                            </div>

                            <?php if ( get_next_posts_link() ) : ?>
                                <button type="button" class="btn btn-block btn-outline-dark btn-load-more mx-auto w-25" id="loadMore">
                                    <svg class="spinner d-none" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="50" cy="50" r="45"/>
                                    </svg>
                                    <span><?php _e( 'Load More' ) ?></span>
                                </button>
                            <?php endif; ?>
                        </div>

                        <div class="d-none d-lg-block col-lg-4">
                            <?php get_template_part( 'template-parts/content/trending-widget' ); ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

<?php get_footer(); ?>
