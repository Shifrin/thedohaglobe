<?php
/**
 * The single post page template file for videos category.
 */
?>

<?php get_header(); ?>

    <div class="container-fluid">
        <section class="page-section">
            <div class="page-center">
                <?php while (have_posts()) : the_post(); ?>
                    <?php
					$columnist         = getTheColumnist();
					$columnistPicture  = getTheColumnistPictureUrl($columnist);
					$author            = getPostAuthorName();
					$authorDisplayName = isEditorInChief($author) ? $author . ', Editor-In-Chief' : $author;
					$category = get_the_category();
					?>

                    <?php theBreadcrumb(); ?>

                    <header class="page-header">
                        <h1 class="page-title"><?php the_title(); ?></h1>

                        <?php if (!isPostInBrief()) : ?>
                            <p class="lead story-intro text-muted mb-0">
                                <?php echo get_the_excerpt(); ?>
                            </p>
                        <?php endif; ?>

                        <div class="media page-meta mt-3">
                            <img src="<?php echo esc_url($columnistPicture); ?>"
                                 class="align-self-center author-image rounded-circle mr-3"
                                 alt="<?php echo esc_html($author); ?>" width="50" height="50">

                            <div class="media-body">
                                <span class="story-author d-block">
                                    <?php if ($columnist instanceof WP_Term) : ?>
                                        <strong><a href="<?php echo esc_url(get_category_link($columnist)); ?>">
                                                <?php echo esc_html($authorDisplayName); ?></a></strong>
                                    <?php else: ?>
                                        <strong><?php echo esc_html($authorDisplayName); ?></strong>
                                    <?php endif; ?>
                                </span>

                                <time class="story-date published" datetime="<?php echo esc_attr(get_the_date('C')); ?>" itemprop="datePublished">
                                    <?php echo esc_html(get_the_date('l F j, Y')); ?>
                                </time>
                            </div>
                        </div>

                        <div class="page-share mt-2">
                            <?php echo do_shortcode('[addtoany]'); ?>
                        </div>
                    </header>

                    <div class="page-content">
                        <?php if ($category[0]->slug !== 'videos') : ?>
                            <?php $images = get_attached_media('image'); ?>

                            <div class="row row-cols-1 row-cols-md-3 post-gallery">
                                <?php foreach ($images as $image) : ?>
                                    <?php
                                    $fullSrc = wp_get_attachment_image_src($image->ID, 'full');
                                    $wideSrc = wp_get_attachment_image_src($image->ID, 'wide');
                                    ?>

                                    <div class="col mb-4">
                                        <a href="<?php echo $fullSrc[0]; ?>" class="card">
                                            <img src="<?php echo $wideSrc[0]; ?>" class="d-block w-100" alt="<?php the_title(); ?>">
                                        </a>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>

                        <div class="row">
                            <div class="col-lg-8 offset-lg-2">
                                <?php the_content(); ?>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </section>
    </div>

<?php get_footer();?>
