<?php
/**
 * Template part for displaying posts by categories of local, international & business
 */
$categories   = ['local', 'international', 'business'];
$excludePosts = getPlacementPostIdForExclude();
?>

<div class="category-listing p-3 h-100">
    <div class="row">
        <?php foreach ($categories as $key => $category) : ?>
            <div class="col-lg-4">
                <?php
				$categoryObj = get_category_by_slug($category);
				$i           = 1;
				?>

                <?php if ($categoryObj instanceof WP_Term) : ?>
                    <h2 class="section-title<?php echo $key !== 0 ? ' mt-4 mt-lg-0' : ''; ?>">
                        <a href="<?php echo esc_url(get_category_link($categoryObj)); ?>">
                            <?php displayIcon('play3') ?>
                            <span class="align-middle ml-1"><?php echo esc_html($categoryObj->name); ?></span>
                        </a>
                    </h2>

                    <?php $posts = new WP_Query([
                    	'category_name' => $categoryObj->slug,
                    	'posts_per_page'=> 5,
                    	'post__not_in'  => $excludePosts
                    ]); ?>

                    <?php if ($posts->have_posts()) : ?>
                        <?php while ($posts->have_posts()) : $posts->the_post(); ?>
                            <?php if ($i == 1) : ?>
                                <a href="<?php the_permalink(); ?>" class="card the-story">
                                    <?php the_post_thumbnail('featured', [
                                    	'class' => 'card-img-top img-fluid', 'alt' => get_the_title()]); ?>

                                    <div class="card-body">
                                        <h3 class="card-title story-title">
                                            <?php the_title(); ?>
                                        </h3>
                                    </div>
                                </a>
                            <?php else : ?>
                                <?php echo $i == 2 ? '<div class="row">' : ''; ?>
                                    <div class="col-12 col-md-6 col-lg-12">
                                        <a href="<?php the_permalink(); ?>" class="the-story d-block mt-3">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col-2 col-md-3">
                                                    <?php the_post_thumbnail('thumbnail', [
                                                    	'class' => 'img-fluid story-image', 'alt' => get_the_title()]); ?>
                                                </div>

                                                <div class="col-10 col-md-9">
                                                    <h3 class="card-title story-title text-white ml-3"><?php the_title(); ?></h3>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                <?php echo $i == 5 || $i == $posts->found_posts ? '</div>' : ''; ?>
                            <?php endif; ?>

                            <?php $i++ ?>
                        <?php endwhile; ?>

                        <?php wp_reset_postdata(); ?>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        <?php endforeach ?>
    </div>
</div>