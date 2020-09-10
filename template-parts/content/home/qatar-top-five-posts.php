<?php
/**
 * Template part to displaying pictures posts in the home page.
 */

$categoryObj  = get_category_by_slug('qatar-top-five');
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
            'posts_per_page' => 1,
        ]); ?>

        <?php if ($posts->have_posts()) : ?>
            <?php while ($posts->have_posts()) : $posts->the_post(); ?>
                <a href="<?php the_permalink(); ?>" class="card text-center the-story rounded-0 mx-auto">
                    <?php the_post_thumbnail('full', [
                        'class' => 'card-img-top img-fluid rounded-0',
                        'alt'   => get_the_title()
                    ]); ?>

                    <div class="card-body">
                        <h3 class="card-title story-title">
                            <?php the_title(); ?>
                        </h3>
                    </div>
                </a>
            <?php endwhile; ?>

            <?php wp_reset_postdata(); ?>
        <?php else: ?>
            <p class="lead text-center my-5">
                This section will be updated soon.
            </p>
        <?php endif; ?>
    </div>
<?php endif; ?>
