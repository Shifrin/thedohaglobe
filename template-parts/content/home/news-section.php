<?php
/**
 * Template part for displaying news section posts.
 */

$posts = getNewsSectionPosts();
$x = 1;
?>

<?php if ( !empty( $posts ) ) : ?>
    <?php foreach ( $posts as $post ) : ?>
        <?php
        setPlacementPostIdForExclude($post->ID);
        setup_postdata($post);

        $categories = getTheFilteredCategories();
        ?>

        <?php echo $x % 2 == 1 ? '<div class="row mx-n2">' : ''; ?>
            <div class="col-md-6 mb-3 mb-lg-0 px-2">
                <?php if ( $x < 3 ) : ?>
                    <div class="card the-story">
                        <?php the_post_thumbnail( 'featured',
                            array( 'class' => 'img-fluid card-img-top', 'alt' => get_the_title() ) ) ?>

                        <div class="card-body d-flex flex-column">
                            <h3 class="card-title story-title mb-2">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h3>

                            <?php if ( !empty( $categories ) ) : ?>
                                <a href="<?php echo esc_url( get_category_link( $categories[0]->term_id ) ); ?>" class="story-category mt-auto card-link">
                                    <i class="fas fa-caret-right"></i> <?php echo esc_html( $categories[0]->name ); ?>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php else : ?>
                    <div class="the-story row no-gutters align-items-center p-3 h-100">
                        <div class="col-3 col-lg-4">
                            <div class="story-image mr-3">
                                <?php the_post_thumbnail( 'thumbnail', array( 'class' => 'img-fluid',
                                    'alt' => get_the_title() ) ) ?>
                            </div>
                        </div>

                        <div class="col-9 col-lg-8">
                            <div class="story-content">
                                <div class="story-head mb-1">
                                    <h3 class="story-title">
                                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                    </h3>
                                </div>

                                <?php if ( !empty( $categories ) ) : ?>
                                    <a href="<?php echo esc_url( get_category_link( $categories[0]->term_id ) ); ?>" class="story-category card-link">
                                        <i class="fas fa-caret-right"></i> <?php echo esc_html( $categories[0]->name ); ?>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endif ?>
            </div>
        <?php echo $x % 2 == 0 || $x == count( $posts ) ? '</div>' : ''; ?>

        <?php $x++; ?>
    <?php endforeach; ?>

    <?php wp_reset_postdata(); ?>
<?php endif; ?>
