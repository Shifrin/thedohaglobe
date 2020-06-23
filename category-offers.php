<?php
/**
 * The category offers page template file
 */
$i = 1;
?>

<?php get_header(); ?>

    <div class="container-fluid">
        <div class="category-page-section offers-page">
            <header class="page-header d-inline-block">
                <h1 class="page-title mb-0"><?php single_cat_title(); ?></h1>
            </header>

            <div class="page-content">
                <?php if (have_posts()) : ?>
                    <div class="row">
                        <?php while (have_posts()) : the_post(); ?>
                            <div class="col-lg-3">
                                <div class="card the-story h-100">
                                    <?php the_post_thumbnail('wide', [
                                    	'class' => 'card-img-top img-fluid',
                                    	'alt'   => get_the_title()
                                    ]); ?>

                                    <div class="card-body">
                                        <h4 class="card-title">
                                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                        </h4>
                                    </div>
                                </div>
                            </div>

                            <?php echo $i % 4 == 0 ? '<div class="d-none d-sm-block w-100 my-2"></div>' : ''; ?>
                            <?php $i++; ?>
                        <?php endwhile; ?>

                        <?php wp_reset_postdata(); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

<?php get_footer(); ?>
