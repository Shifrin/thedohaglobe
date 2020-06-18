<?php
/**
 * Template part for displaying main lead post
 */

$posts = getLeadPosts();

if ( !empty($posts) ) :
    foreach ( $posts as $post ) : setup_postdata( $post );
        $imgUrl = get_the_post_thumbnail_url( get_the_ID(), 'featured' );

        setExcludedPostsFromPlacements( get_the_ID() );
        ?>
        <article class="main-lead-story d-lg-none d-xl-none">
            <?php the_post_thumbnail( 'wide', array( 'class' => 'img-fluid', 'alt' => get_the_title() ) ) ?>

            <div class="story-head mt-2">
                <h2 class="story-title">
                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                </h2>

                <p class="lead story-intro mb-0">
                    <?php echo wp_trim_words( get_the_excerpt(), 30 ); ?>
                </p>
            </div>
        </article>

        <article class="main-lead-story d-none d-lg-block" style="background-image: url('<?php echo $imgUrl; ?>')">
            <div class="story-head">
                <h2 class="story-title">
                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                </h2>

                <p class="lead story-intro mb-0">
                    <?php echo wp_trim_words( get_the_excerpt(), 30 ); ?>
                </p>
            </div>
        </article>
        <?php
        break;
    endforeach;

    wp_reset_postdata();
endif;
?>


