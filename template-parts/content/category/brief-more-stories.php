<?php
/**
 * Template part to displaying more stories in the category page.
 */
?>

<?php while ( have_posts() ) : the_post(); ?>
    <div class="card the-story">
        <div class="card-body">
            <h4 class="card-title mb-0">
                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
            </h4>
        </div>
    </div>
<?php endwhile; ?>
