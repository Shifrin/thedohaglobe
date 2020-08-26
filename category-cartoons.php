<?php
/**
 * The category cartoons page template file
 */
$i = 1;
?>

<?php get_header(); ?>

<div class="container-fluid">
    <div class="category-page-section section-infographics">
        <header class="page-header d-inline-block">
            <h1 class="page-title mb-0"><?php single_cat_title(); ?></h1>
        </header>

        <div class="page-content">
            <?php if (have_posts()) : ?>
                <div class="row">
                    <?php while (have_posts()) : the_post(); ?>
                        <div class="col-lg-3">
                            <a href="<?php the_permalink(); ?>" class="card text-center the-story h-100 rounded-0">
                                <?php the_post_thumbnail('featured', [
                                    'class' => 'card-img-top img-fluid rounded-0',
                                    'alt'   => get_the_title()
                                ]); ?>

                                <div class="card-body">
                                    <img src="<?php echo get_template_directory_uri() . '/img/infographic.svg'; ?>"
                                         alt="Picture Post" class="card-icon shadow" width="50">

                                    <h3 class="card-title story-title">
                                        <?php the_title(); ?>
                                    </h3>
                                </div>
                            </a>
                        </div>

                        <?php echo $i % 4 == 0 ? '<div class="d-none d-sm-block w-100 my-2"></div>' : ''; ?>
                        <?php $i++; ?>
                    <?php endwhile; ?>

                    <?php wp_reset_postdata(); ?>
                </div>
            <?php endif; ?>

            <?php thePagination(); ?>
        </div>
    </div>
</div>

<?php get_footer(); ?>
