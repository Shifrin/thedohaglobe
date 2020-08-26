<?php
/**
 * Template part for displaying quote of the day
 */

$query = new WP_Query( array( 'posts_per_page' => 1, 'category_name' => 'quotes' ) );

if ( $query->have_posts() ) :
    while ( $query->have_posts() ) : $query->the_post();
        $author = get_post_meta( get_the_ID(), 'author', true );
        ?>
        <div class="quote-story text-white text-center my-auto px-3">
            <h4 class="text-white h5 mb-3"><?php _e( 'Quote of the Day' ); ?></h4>

            <div class="story-image columnist-image text-center my-4">
                <?php if ( has_post_thumbnail() ) : ?>
                    <?php the_post_thumbnail( 'thumbnail', array( 'class' => 'img-fluid rounded-circle',
                        'alt' => $author ) ); ?>
                <?php else : ?>
                    <?php $pictureUrl = getTheColumnistPictureUrl( 0 ); ?>

                    <img src="<?php echo esc_url( $pictureUrl ); ?>" class="img-fluid rounded-circle"
                         alt="<?php esc_html_e( $author ); ?>">
                <?php endif; ?>
            </div>

            <blockquote class="blockquote text-center">
                <?php
                $content = get_the_content();
                $content = apply_filters( 'the_content', $content );
                ?>
                <p class="mb-2"><?php echo '"' . wp_strip_all_tags( $content, true ) . '"'; ?></p>
                <footer class="blockquote-footer font-italic text-white-50">
                    <?php esc_html_e( $author ); ?>
                </footer>
            </blockquote>
        </div>
    <?php
    endwhile;

    wp_reset_postdata();
endif;
?>
