<?php
/**
 * The page template file
 */
?>

<?php get_header(); ?>

    <div class="container-fluid">
        <section class="page-section">
            <div class="page-center">
                <?php if ( have_posts() ) : ?>
                    <?php while ( have_posts() ) : the_post(); ?>
                        <?php theBreadcrumb(); ?>

                        <header class="page-header">
                            <h1 class="page-title"><?php the_title(); ?></h1>
                        </header>

                        <div class="row">
                            <div class="col-lg-8">
                                <?php if ( has_post_thumbnail() ) : ?>
                                    <div class="page-image">
                                        <figure class="figure">
                                            <?php the_post_thumbnail( 'wide', array(
                                                'class' => 'figure-img img-fluid rounded' ) ); ?>
                                            <figcaption class="figure-caption">
                                                <?php the_post_thumbnail_caption(); ?>
                                            </figcaption>
                                        </figure>
                                    </div>
                                <?php endif; ?>

                                <div class="page-content">
                                    <?php the_content(); ?>
                                </div>
                            </div>

                            <div class="d-none d-lg-block col-lg-4">
                                <?php //get_template_part( 'template-parts/content/trending-widget' ); ?>
                                <?php get_template_part( 'template-parts/content/offers-widget' ); ?>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else : ?>
                    <?php get_template_part( 'template-parts/content/content-none' ); ?>
                <?php endif; ?>
            </div>
        </section>
    </div>

<?php get_footer(); ?>
