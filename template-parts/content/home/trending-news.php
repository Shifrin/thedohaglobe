<?php
/**
 * Template part for displaying trending news based on post views
 */

$trendingPosts = getTrendingNews( 5 );
$i = 1;
?>

<?php if ( $trendingPosts->have_posts() ) : ?>
    <div class="trending-wrap h-100">
        <div class="trending-news p-3">
            <h2 class="section-title">
                <?php displayIcon('play3') ?>
                <span class="align-middle ml-1"><?php _e('Trending'); ?></span>
            </h2>

            <?php while ( $trendingPosts->have_posts() ) : $trendingPosts->the_post(); ?>
                <a class="the-story d-block" href="<?php the_permalink(); ?>">
                    <div class="row align-items-center">
                        <div class="col-2">
                            <span class="number"><?php echo $i; ?></span>
                        </div>

                        <div class="col-10">
                            <h3 class="story-title"><?php the_title(); ?></h3>
                        </div>
                    </div>
                </a>

                <?php $i++; ?>
            <?php endwhile; ?>

            <?php wp_reset_postdata(); ?>
        </div>

        <div class="ads text-center">
            <div class="classifieds py-4">
                <?php displayIcon('list') ?>
                <span class="align-middle ml-1">Classifieds</span>
            </div>

            <div class="offers py-4">
                <?php displayIcon('gift') ?>
                <span class="align-middle ml-1">Offers</span>
            </div>
        </div>
    </div>
<?php endif; ?>