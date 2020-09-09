<?php
/**
 * The page template file for contact us page
 */
?>

<?php get_header(); ?>

    <div class="container-fluid">
        <section class="page-section">
            <div class="page-center">
                <?php if (have_posts()) : ?>
                    <?php while (have_posts()) : the_post(); ?>
                        <?php theBreadcrumb(); ?>

                        <header class="page-header">
                            <h1 class="page-title"><?php the_title(); ?></h1>
                        </header>

                        <div class="row">
                            <div class="col-lg-8">
                                <?php if (has_post_thumbnail()) : ?>
                                    <div class="page-image">
                                        <figure class="figure">
                                            <?php the_post_thumbnail('featured', [
                                            	'class' => 'figure-img img-fluid rounded']); ?>
                                            <figcaption class="figure-caption">
                                                <?php the_post_thumbnail_caption(); ?>
                                            </figcaption>
                                        </figure>
                                    </div>
                                <?php endif; ?>

                                <div class="page-content">
                                    <?php the_content(); ?>

                                    <hr class="my-5">

                                    <div id="alert" role="alert"></div>

                                    <form action="" class="form" id="contactform" method="post" novalidate>
                                        <div class="form-group sender">
                                            <label for="sender"><?php _e('Name'); ?></label>
                                            <input type="text" class="form-control" id="sender" name="sender">
                                        </div>

                                        <div class="form-group email">
                                            <label for="email"><?php _e('Email'); ?></label>
                                            <input type="text" class="form-control" id="email" name="email" aria-describedby="emailHelp">
                                        </div>

                                        <div class="form-group subject">
                                            <label for="subject"><?php _e('Subject'); ?></label>
                                            <input type="text" class="form-control" id="subject" name="subject">
                                        </div>

                                        <div class="form-group message">
                                            <label for="message"><?php _e('Message'); ?></label>
                                            <textarea class="form-control" id="message" name="message" rows="7"></textarea>
                                        </div>

                                        <div class="form-group mb-0">
                                            <button type="submit" class="btn btn-success btn-lg btn-block" id="submit" name="submit">
                                                <svg class="spinner d-none" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                                                    <circle cx="50" cy="50" r="45"/>
                                                </svg>
                                                <span><?php _e('Submit'); ?></span>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <div class="d-none d-lg-block col-lg-4">
                                <?php get_template_part( 'template-parts/content/trending-widget' ); ?>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else : ?>
                    <?php get_template_part('template-parts/content/content-none'); ?>
                <?php endif; ?>
            </div>
        </section>
    </div>

<?php get_footer(); ?>