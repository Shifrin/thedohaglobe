<?php
/**
 * Partial template for displaying other lead posts.
 */

$posts = getLeadPosts();

if (!empty($posts)) : ?>
    <div class="row">
        <?php foreach ($posts as $post) : setup_postdata($post); ?>
            <div class="col-12 col-md-6 col-lg-12">
                <div class="the-story p-lg-3 py-3">
                    <div class="row no-gutters align-items-center">
                        <div class="col-2 col-lg-3">
                            <div class="story-image">
                                <?php the_post_thumbnail('thumbnail', [
                                    'class' => 'img-fluid',
                                    'alt'   => get_the_title()
                                ]); ?>
                            </div>
                        </div>

                        <div class="col-10 col-lg-9">
                            <div class="story-content d-flex flex-column h-100 ml-3">
                                <div class="story-head">
                                    <h2 class="story-title">
                                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                    </h2>
                                </div>

                                <?php $category = getTheFilteredCategories(); ?>

                                <?php if (!empty($category)) : ?>
                                    <a href="<?php echo esc_url(get_category_link($category[0]->term_id)); ?>"
                                       class="story-category mt-1">
                                        <i class="fas fa-caret-right"></i> <?php echo esc_html($category[0]->name); ?>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php
        endforeach;
        ?>
    </div>

    <?php
    wp_reset_postdata();
endif;
?>


