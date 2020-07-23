<?php
/**
 * The category page template file
 */

global $query_string;
query_posts( $query_string . '&posts_per_page=12' );
?>

<?php get_header(); ?>

<div class="container-fluid">
    <div class="category-page-section">
        <header class="page-header d-inline-block">
            <h1 class="page-title mb-0"><?php single_cat_title(); ?></h1>
        </header>

        <div class="page-content">
            <div class="row">
                <?php if (have_posts()) : ?>
                    <?php while (have_posts()) : the_post(); ?>
                        <div class="col-lg-4 mb-4">
                            <div class="card the-story">
                                <div class="card-body">
                                    <h4 class="card-title mb-0">
                                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                    </h4>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php endif; ?>

                <?php wp_reset_postdata(); ?>
            </div>

            <?php thePagination(); ?>
        </div>
    </div>
</div>

<?php get_footer(); ?>
