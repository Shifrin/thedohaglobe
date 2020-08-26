<?php
/**
 * Template part to displaying more stories in the category page.
 */
?>

<?php while ( have_posts() ) : the_post(); ?>
    <div class="card the-story mb-4">
        <?php if ( has_post_thumbnail() ) : ?>
            <div class="row no-gutters">
                <div class="col-md-4">
                    <?php the_post_thumbnail( 'featured', array( 'class' => 'card-img img-fluid h-100',
                        'alt' => get_the_title() ) ); ?>
                </div>

                <div class="col-md-8">
                    <div class="card-body">
                        <h4 class="card-title">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h4>

                        <p class="card-text text-muted">
                            <?php echo wp_trim_words( get_the_excerpt(), 30 ); ?>
                        </p>
                    </div>
                </div>
            </div>
        <?php else : ?>
            <div class="card-body">
                <h4 class="card-title">
                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                </h4>

                <p class="card-text text-muted">
                    <?php echo wp_trim_words( get_the_excerpt(), 30 ); ?>
                </p>
            </div>
        <?php endif; ?>
    </div>
<?php endwhile; ?>
