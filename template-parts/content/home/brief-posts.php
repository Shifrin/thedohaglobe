<?php
/**
 * Template part for displaying brief posts
 */

//$posts = getBriefPosts();
$posts       = new WP_Query([
    'posts_per_page' => 5,
    'post_type'      => 'post',
    'post_status'    => 'publish',
    'category_name'  => 'briefs',
]);
$categoryObj = get_category_by_slug('briefs');
?>

<?php if ($categoryObj instanceof WP_Term && $posts->have_posts()) : ?>
    <h2 class="section-title">
        <a href="<?php echo esc_url(get_category_link($categoryObj)); ?>">
            <i class="fas fa-caret-right"></i> <?php echo esc_html($categoryObj->name); ?>
        </a>
    </h2>

    <?php while ($posts->have_posts()) : $posts->the_post(); ?>
        <a class="the-story d-block" href="<?php the_permalink(); ?>">
            <?php the_title(); ?>
        </a>
    <?php endwhile; ?>

    <?php wp_reset_postdata(); ?>
<?php endif; ?>