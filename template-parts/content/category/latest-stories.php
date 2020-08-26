<?php
/**
 * Template part for displaying latest stories section in category pages
 */

$i = 1;
$category = get_queried_object();
$query = new WP_Query( array( 'cat' => get_queried_object_id(), 'posts_per_page' => 5 ) );
?>

<?php if ( $query->have_posts() ) : ?>
    <div class="latest-stories">
        <div class="row mx-n2">
            <?php while ( $query->have_posts() ) : $query->the_post(); ?>
                <?php if ( $i <= 1 ) : ?>
                    <div class="col-lg-7 px-2">
                        <div class="card the-story h-100">
                            <?php the_post_thumbnail( 'featured', array(
                                'class' => 'card-img-top img-fluid', 'alt' => get_the_title() ) ); ?>

                            <div class="card-body">
                                <h3 class="card-title">
                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>

                                <p class="card-text text-muted lead">
                                    <?php echo wp_trim_words( get_the_excerpt(), 40 ); ?>
                                </p>
                            </div>
                        </div>
                    </div>
                <?php else : ?>
                    <?php echo $i == 2 ? '<div class="col-lg-5 px-2 mt-3 mt-lg-0"><div class="card-deck mx-n2">' : ''; ?>

                    <div class="card the-story mx-2">
                        <?php the_post_thumbnail( 'featured', array(
                            'class' => 'card-img-top img-fluid', 'alt' => get_the_title() ) ); ?>

                        <div class="card-body">
                            <h4 class="card-title<?php echo $category->slug == 'opinion' ? '' : ' mb-0'; ?>">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                        </div>
                    </div>

                    <?php echo $i % 3 == 0 ? '<div class="d-none d-sm-block w-100 my-2"></div>' : ''; ?>

                    <?php echo $i == $query->post_count ? '</div></div>' : ''; ?>
                <?php endif; ?>

                <?php $i++; ?>
            <?php endwhile; ?>

            <?php wp_reset_postdata(); ?>
        </div>
    </div>
<?php endif; ?>