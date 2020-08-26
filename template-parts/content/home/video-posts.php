<?php
/**
 * Template part to displaying videos posts in the home page.
 */

$i            = 1;
$categoryObj  = get_category_by_slug('videos');
$excludePosts = getPlacementPostIds();
?>

<?php if ($categoryObj instanceof WP_Term) : ?>
    <div class="media-posts">
        <h2 class="section-title">
            <a href="<?php echo esc_url(get_category_link($categoryObj)); ?>">
                <i class="fas fa-caret-right"></i> <?php echo esc_html($categoryObj->name); ?>
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
                                <img src="<?php echo get_template_directory_uri() . '/img/video.svg'; ?>"
                                     alt="Video Post"
                                     class="card-icon shadow" width="50">

                                <h3 class="card-title story-title">
                                    <?php the_title(); ?>
                                </h3>
                            </div>
                        </a>
                    </div>

                    <?php echo $i !== $posts->post_count ? '<div class="d-block d-sm-none w-100 my-2"></div>' : ''; ?>

                    <?php echo $i % 2 == 0 ? '<div class="d-none d-sm-block d-lg-none w-100 my-2"></div>' : ''; ?>

                    <?php $i++; ?>
                <?php endwhile; ?>

                <?php wp_reset_postdata(); ?>
            </div>
        <?php else: ?>
            <p class="lead text-center my-5">
                This section will be updated soon.
            </p>
        <?php endif; ?>
    </div>
<?php endif; ?>
