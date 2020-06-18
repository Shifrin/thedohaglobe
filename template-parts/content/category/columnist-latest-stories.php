<?php
/**
 * Template part for displaying latest stories section for the columnist profile page
 */

$columnist = get_queried_object();
$query = new WP_Query( array( 'cat' => get_queried_object_id(), 'posts_per_page' => 3 ) );
?>

<?php if ( $query->have_posts() ) : ?>
    <div class="columnist-latest-stories">
        <div class="row">
            <?php while ( $query->have_posts() ) : $query->the_post(); ?>
                <div class="col-lg-4">
                    <div class="card the-story h-100">
                        <div class="card-body">
                            <h3 class="card-title">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>

                            <p class="card-text text-muted">
                                <?php echo wp_trim_words( get_the_excerpt(), 20 ); ?>
                            </p>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>

            <?php wp_reset_postdata(); ?>
        </div>
    </div>
<?php endif; ?>