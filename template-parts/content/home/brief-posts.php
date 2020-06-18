<?php
/**
 * Template part for displaying brief posts
 */

$posts = getBriefPosts();
$categoryObj = get_category_by_slug( 'briefs' );
?>

<?php if ( $categoryObj instanceof WP_Term && !empty($posts) ) : ?>
    <h2 class="section-title">
        <a href="<?php echo esc_url( get_category_link( $categoryObj ) ); ?>">
            <i class="fas fa-caret-right"></i> <?php echo esc_html( $categoryObj->name ); ?>
        </a>
    </h2>

    <?php foreach ( $posts as $post ) : setup_postdata( $post ); ?>
        <a class="the-story d-block" href="<?php the_permalink(); ?>">
            <?php the_title(); ?>
        </a>
    <?php endforeach; ?>

    <?php wp_reset_postdata(); ?>
<?php endif; ?>