<?php
/**
 * The columnist category page template file for displaying columnist's profile page
 */
$columnist = get_queried_object();

// If the page is not for columnist page then redirect to 404
if ($columnist instanceof WP_Term && !verifyColumnist($columnist->name)) {
	wp_redirect(home_url('/404'));
	exit();
}

$columnistPictureUrl = getTheColumnistPictureUrl($columnist);
?>

<?php get_header(); ?>

    <div class="container-fluid">
        <div class="columnist-page-section">
            <header class="page-header w-75 mx-auto">
                <div class="media the-columnist">
                    <img src="<?php echo esc_url($columnistPictureUrl); ?>" width="150" height="150"
                         class="align-self-center mr-3 rounded-circle" alt="<?php echo esc_html($columnist->name); ?>">

                    <div class="media-body">
                        <h1 class="columnist-name"><?php single_cat_title(); ?></h1>

                        <?php if (isEditorInChief($columnist)) : ?>
                            <p class="lead text-muted"><?php _e('Editor-in-Chief'); ?></p>
                        <?php endif; ?>

                        <?php echo category_description(); ?>
                    </div>
                </div>
            </header>

            <div class="page-content">
                <?php get_template_part('template-parts/content/category/columnist-latest-stories'); ?>

                <?php if (have_posts()) : ?>
                    <h2 class="category-more-title mt-5 mb-4"><?php single_cat_title('More from '); ?></h2>

                    <div class="row">
                        <div class="col-lg-8">
                            <div class="more-stories" id="moreStories">
                                <?php get_template_part('template-parts/content/category/columnist-more-stories'); ?>
                            </div>

                            <?php if (get_next_posts_link()) : ?>
                                <button type="button" class="btn btn-block btn-outline-dark btn-load-more mx-auto w-25" id="loadMore">
                                    <svg class="spinner d-none" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="50" cy="50" r="45"/>
                                    </svg>
                                    <span><?php _e('Load More') ?></span>
                                </button>
                            <?php endif; ?>
                        </div>

                        <div class="d-none d-lg-block col-lg-4">
                            <?php get_template_part( 'template-parts/content/trending-widget' );?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

<?php get_footer(); ?>
