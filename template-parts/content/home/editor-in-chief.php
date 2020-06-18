<?php
/**
 * Template part for displaying editor in chief posts
 *
 * TODO: Should add editor in chief page link later
 */

$query = new WP_Query( array( 'posts_per_page' => 1, 'category_name' => 'khalid-al-sayed' ) );

if ( $query->have_posts() ) :
    while ( $query->have_posts() ) : $query->the_post();
        $columnist = getTheColumnist();
        $pictureUrl = getTheColumnistPictureUrl( $columnist );
        ?>
        <div class="the-story p-3">
            <div class="row no-gutters align-items-center">
                <div class="col-2 col-sm-3">
                    <div class="story-image columnist-image">
                        <img src="<?php echo esc_url( $pictureUrl ); ?>" class="img-fluid rounded-circle"
                             alt="<?php echo esc_html( $columnist->name ); ?>">
                    </div>
                </div>

                <div class="col-10 col-sm-9">
                    <div class="story-content d-flex flex-column h-100 ml-3">
                        <div class="story-head">
                            <h2 class="story-title mb-2 mb-sm-3">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h2>
                        </div>

                        <div class="chief-name mt-auto">
                            <a href="<?php echo esc_url( get_category_link( $columnist ) ); ?>" class="d-block">
                                <?php echo esc_html( $columnist->name ); ?>
                            </a>

                            <small class="d-block"><?php _e( 'Editor-in-Chief' ); ?></small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
    endwhile;

    wp_reset_postdata();
endif;
?>
