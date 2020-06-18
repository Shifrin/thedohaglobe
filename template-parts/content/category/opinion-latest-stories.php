<?php
/**
 * Template part for displaying latest stories section for the opinion category page
 */

$i = 1;
$query = new WP_Query( array( 'cat' => get_queried_object_id(), 'posts_per_page' => 3 ) );
?>

<?php if ( $query->have_posts() ) : ?>
    <div class="columnist-latest-stories">
        <div class="row">
            <?php while ( $query->have_posts() ) : $query->the_post(); ?>
                <?php $columnist = getTheColumnist(); ?>

                <div class="col-lg-4">
                    <div class="card the-story h-100">
                        <div class="card-body">
                            <h3 class="card-title">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>

                            <p class="card-text text-muted">
                                <?php echo wp_trim_words( get_the_excerpt(), 20 ); ?>
                            </p>

                            <?php if ( $columnist instanceof WP_Term ) : ?>
                                <a href="<?php echo esc_url( get_category_link( $columnist ) ); ?>"
                                   class="columnist-name"><?php echo esc_html( $columnist->name ); ?></a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <?php echo $i !== $query->post_count ? '<div class="d-block d-lg-none w-100 my-3"></div>' : ''; ?>

                <?php $i++; ?>
            <?php endwhile; ?>

            <?php wp_reset_postdata(); ?>
        </div>
    </div>
<?php endif; ?>