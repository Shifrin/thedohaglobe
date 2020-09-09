<?php
/**
 * Template part for displaying opinion posts
 *
 * TODO: Should add links later to the opinion page and the author's page
 */

$opinion = get_category_by_slug( 'opinion' );
$editorInChiefObj = get_category_by_slug( 'khalid-al-sayed' );
?>

<?php if ( $opinion instanceof WP_Term ) : ?>
    <h2 class="section-title">
        <a href="<?php echo esc_url( get_category_link( $opinion ) ); ?>" class="text-white">
            <?php displayIcon('play3') ?>
            <span class="align-middle ml-1"><?php echo esc_html($opinion->name); ?></span>
        </a>
    </h2>

    <?php
    // Exclude editor in chief posts from opinion section in home page
    $cat = $editorInChiefObj instanceof WP_Term ? "{$opinion->term_id},-$editorInChiefObj->term_id" :
        $opinion->term_id;
    $opinionsPosts = new WP_Query( array( 'cat' => $cat, 'posts_per_page' => 3 ) );
    ?>

    <?php if ( $opinionsPosts->have_posts() ) : ?>
        <?php while ( $opinionsPosts->have_posts() ) : $opinionsPosts->the_post(); ?>
            <?php
            $columnist = getTheColumnist();
            $pictureUrl = getTheColumnistPictureUrl( $columnist );
            $columnistName = $columnist instanceof WP_Term ? $columnist->name : __( 'Columnist' );
            ?>

            <div class="media the-story">
                <img src="<?php echo esc_url( $pictureUrl ); ?>" class="align-self-center mr-3"
                     alt="<?php echo esc_html( $columnistName ); ?>" width="75" height="75">

                <div class="media-body">
                    <a href="<?php echo esc_url( get_category_link( $columnist ) ); ?>" class="columnist-name">
                        <?php echo esc_html( $columnistName ); ?>
                    </a>

                    <h3 class="mt-2 mt-sm-2 story-title">
                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </h3>
                </div>
            </div>
        <?php endwhile; ?>

        <?php wp_reset_postdata(); ?>
    <?php endif; ?>
<?php endif; ?>