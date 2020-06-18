<?php
/**
 * Template part for displaying main lead post
 */

$posts = getLeadPosts();

if ( !empty( $posts ) ) :
    foreach ( array_slice( $posts, 1 ) as $post ) : setup_postdata( $post );
        setExcludedPostsFromPlacements( get_the_ID() );
        ?>
        <div class="the-story p-lg-3 py-3">
            <div class="row no-gutters align-items-center">
                <div class="col-3 col-sm-2 col-lg-3">
                    <div class="story-image">
                        <?php the_post_thumbnail( 'square', array( 'class' => 'img-fluid',
                            'alt' => get_the_title() ) ); ?>
                    </div>
                </div>

                <div class="col-9 col-sm-10 col-lg-9">
                    <div class="story-content d-flex flex-column h-100 ml-3">
                        <div class="story-head">
                            <h2 class="story-title">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h2>
                        </div>

                        <?php $category = getTheFilteredCategories(); ?>

                        <?php if ( !empty( $category ) ) : ?>
                            <a href="<?php echo esc_url( get_category_link( $category[0]->term_id ) ); ?>"
                               class="story-category mt-1">
                                <i class="fas fa-caret-right"></i> <?php echo esc_html( $category[0]->name ); ?>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <?php
    endforeach;

    wp_reset_postdata();
endif;
?>


