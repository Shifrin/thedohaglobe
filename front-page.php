<?php
/**
 * Template Name: Front Page
 */
?>

<?php get_header(); ?>

    <!-- Lead Posts -->
    <section class="section section-leads">
        <div class="container-fluid">
            <div class="row no-gutters">
                <div class="col-lg-2 d-none d-lg-block">
                    <div class="home-widgets d-flex flex-column h-100">
                        <?php get_template_part('template-parts/content/home/quote'); ?>
                    </div>
                </div>

                <div class="col-lg-7">
                    <div class="main-lead">
                        <?php get_template_part('template-parts/content/home/main-lead'); ?>
                    </div>
                </div>

                <div class="col-lg-3">
                    <div class="editor-in-chief d-none d-lg-block">
                        <?php get_template_part('template-parts/content/home/editor-in-chief'); ?>
                    </div>

                    <div class="other-leads">
                        <?php get_template_part('template-parts/content/home/other-leads'); ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Brief, News Section & Opinions Posts as Section Main -->
    <section class="section section-main">
        <div class="container-fluid">
            <div class="row no-gutters">
                <div class="col-lg-3">
                    <div class="brief h-100 d-none d-lg-block">
                        <?php get_template_part('template-parts/content/home/brief-posts'); ?>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="news-section p-lg-3 h-100">
                        <?php get_template_part('template-parts/content/home/news-section'); ?>
                    </div>
                </div>

                <div class="col-lg-3">
                    <div class="editor-in-chief d-lg-none">
                        <?php get_template_part('template-parts/content/home/editor-in-chief'); ?>
                    </div>

                    <div class="opinions">
                        <?php get_template_part('template-parts/content/home/opinion-posts'); ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- News Categories & Trending -->
    <section class="section section-category-listing mt-3 mt-lg-5">
        <div class="container-fluid">
            <div class="row no-gutters">
                <!-- Other News Section -->
                <div class="col-lg-9">
                    <?php get_template_part('template-parts/content/home/category-listing'); ?>
                </div>

                <!-- Trending News Section -->
                <div class="col-lg-3">
                    <?php get_template_part('template-parts/content/home/trending-news'); ?>
                </div>
            </div>
        </div>
    </section>

    <!-- Community Posts -->
    <section class="section section-community mt-3 mt-lg-5">
        <div class="container-fluid">
            <?php get_template_part('template-parts/content/home/community-posts'); ?>
        </div>
    </section>

<?php get_footer(); ?>