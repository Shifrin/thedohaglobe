<?php
/**
 * Template part to displaying infographics posts in the home page.
 */

$categoryObj  = get_category_by_slug('infographics');
$excludePosts = getPlacementPostIdForExclude();
?>

<?php if ($categoryObj instanceof WP_Term) : ?>
    <div class="media-posts">
        <h2 class="section-title">
            <a href="<?php echo esc_url(get_category_link($categoryObj)); ?>">
                <?php displayIcon('play3') ?>
                <span class="align-middle ml-1"><?php echo esc_html($categoryObj->name); ?></span>
            </a>
        </h2>

        <?php $posts = new WP_Query([
            'category_name'  => $categoryObj->slug,
            'posts_per_page' => 2,
            'post__not_in'   => $excludePosts
        ]); ?>

        <?php if ($posts->have_posts()) : ?>
            <div class="row mx-n2">
                <?php while ($posts->have_posts()) : $posts->the_post(); ?>
                    <div class="col-sm-6 col-lg px-2">
                        <a href="<?php the_permalink(); ?>" class="card text-center the-story h-100 rounded-0">
                            <?php the_post_thumbnail('featured', [
                                'class' => 'card-img-top img-fluid rounded-0',
                                'alt'   => get_the_title()
                            ]); ?>

                            <div class="card-body">
                                <h3 class="card-title story-title">
                                    <?php the_title(); ?>
                                </h3>
                            </div>
                        </a>
                    </div>
                <?php endwhile; ?>

                <?php wp_reset_postdata(); ?>
            </div>
        <?php endif; ?>
    </div>
<?php endif; ?>
