<?php
/**
 * Template part to displaying more stories from a columnist in their profile page.
 */

$columnist = get_queried_object();
?>

<?php while ( have_posts() ) : the_post(); ?>
    <div class="card the-story mb-4">
        <div class="card-body">
            <h4 class="card-title">
                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
            </h4>

            <p class="card-text text-muted">
                <?php echo wp_trim_words( get_the_excerpt(), 30 ); ?>
            </p>
        </div>
    </div>
<?php endwhile; ?>
