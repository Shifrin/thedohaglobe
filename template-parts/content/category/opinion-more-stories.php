<?php
/**
 * Template part to displaying more stories for opinion category page.
 */
?>

<?php while ( have_posts() ) : the_post(); ?>
    <?php $columnist = getTheColumnist(); ?>

    <div class="card the-story mb-4">
        <div class="card-body">
            <h4 class="card-title">
                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
            </h4>

            <p class="card-text text-muted">
                <?php echo wp_trim_words( get_the_excerpt(), 30 ); ?>
            </p>

            <?php if ( $columnist instanceof WP_Term ) : ?>
                <a href="<?php echo esc_url( get_category_link( $columnist ) ); ?>"
                   class="columnist-name"><?php echo esc_html( $columnist->name ); ?></a>
            <?php endif; ?>
        </div>
    </div>
<?php endwhile; ?>
