<?php
/**
 * Template part for displaying offers.
 */
$categoryObj = get_category_by_slug('offers');
?>

<?php if ($categoryObj instanceof WP_Term) : ?>
    <?php $query = new WP_Query(['category_name' => 'offers', 'posts_per_page' => 4]); ?>

    <?php if ($query->have_posts()) : ?>
        <div class="offers offers-widget">
            <h2 class="section-title">
                <a href="<?php echo esc_url(get_category_link($categoryObj)); ?>">
                    <?php displayIcon('play3') ?>
                    <span class="align-middle ml-1"><?php echo esc_html($categoryObj->name); ?></span>
                </a>
            </h2>

            <?php while ($query->have_posts()) : $query->the_post(); ?>
                <a href="<?php the_permalink(); ?>" class="the-story d-block">
                    <div class="row no-gutters align-items-center">
                        <div class="col-4 col-sm-2 col-lg-4">
                            <div class="story-image">
                                <?php the_post_thumbnail('medium', [
                                	'class' => 'img-fluid',
                                	'alt'   => get_the_title()
                                ]); ?>
                            </div>
                        </div>

                        <div class="col-8 col-sm-10 col-lg-8">
                            <div class="story-content d-flex flex-column h-100 ml-3">
                                <div class="story-head">
                                    <h2 class="story-title">
                                        <?php the_title(); ?>
                                    </h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            <?php endwhile; ?>
        </div>
    <?php endif; ?>

    <?php wp_reset_postdata(); ?>
<?php endif; ?>