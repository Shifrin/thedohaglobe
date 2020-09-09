<?php
/**
 * The template for displaying the header
 */
$logoUrl = get_stylesheet_directory_uri() . '/img/logo.png';
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
    <head>
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-139391419-1"></script>
        <script>
            window.dataLayer = window.dataLayer || [];

            function gtag() {
                dataLayer.push(arguments);
            }

            gtag('js', new Date());

            gtag('config', 'UA-139391419-1');
        </script>

        <!-- Required meta tags -->
        <meta charset="<?php bloginfo('charset'); ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <?php wp_head(); ?>
    </head>

    <body <?php body_class(); ?>>
        <header class="main-header">
            <div class="container-fluid">
                <div class="header-top">
                    <div class="row align-items-center">
                        <div class="col-lg-6">
                            <div class="datetime">
                                <span class="badge badge-secondary">
                                    <?php displayIcon('calendar') ?>
                                    <span class="align-middle ml-1"><?php echo date('l, j F Y'); ?></span>
                                </span>
                                <span id="clock" class="badge badge-dark ml-2">
                                    <?php displayIcon('clock') ?>
                                    <span class="align-middle ml-1"></span>
                                </span>
                            </div>
                        </div>

                        <div class="col-lg-6 d-none d-lg-block">
                            <div class="administrative-links">
                                <nav class="nav justify-content-end">
                                    <?php if (is_user_logged_in()) : ?>
                                        <a href="<?php echo esc_url(wp_logout_url()); ?>" class="nav-link link-login">
                                            <?php displayIcon('exit') ?>
                                            <span class="align-middle ml-1"><?php _e('Sign Out'); ?></span>
                                        </a>
                                    <?php else : ?>
                                        <a href="<?php echo esc_url(wp_login_url()); ?>" class="nav-link link-login">
                                            <?php displayIcon('enter') ?>
                                            <span class="align-middle ml-1"><?php _e('Sign In'); ?></span>
                                        </a>
                                    <?php endif; ?>

                                    <a href="<?php echo esc_url(home_url('/search')); ?>" class="nav-link link-search">
                                        <?php displayIcon('search') ?>
                                        <span class="align-middle ml-1"><?php _e('Search'); ?></span>
                                    </a>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="header-middle my-2 text-center">
                    <a href="<?php echo esc_url(home_url()); ?>" class="d-inline-block logo mx-auto text-center">
                        <img src="<?php echo esc_url($logoUrl) ?>" alt="The Doha Globe Logo"
                             class="logo-image img-fluid" width="400">
                    </a>
                </div>
            </div>
        </header>

        <nav class="navbar navbar-expand-lg navbar-light bg-white" id="navbar">
            <div class="container-fluid">
                <a class="navbar-brand d-none" href="<?php echo esc_url(home_url()); ?>">
                    <img src="<?php echo esc_url($logoUrl); ?>" width="150" alt="<?php bloginfo('name'); ?>">
                </a>

                <button class="navbar-toggler" type="button" data-toggle="collapse"
                        data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup"
                        aria-expanded="false" aria-label="Toggle navigation">
                    <?php displayIcon('menu2') ?>
                </button>

                <nav class="navbar-nav administrative-links ml-auto flex-row d-lg-none d-xl-none">
                    <?php if (is_user_logged_in()) : ?>
                        <a href="<?php echo esc_url(wp_logout_url()); ?>" class="nav-item nav-link link-login">
                            <?php displayIcon('exit') ?>
                        </a>
                    <?php else : ?>
                        <a href="<?php echo esc_url(wp_login_url()); ?>" class="nav-item nav-link link-login">
                            <?php displayIcon('enter') ?>
                        </a>
                    <?php endif; ?>

                    <a href="<?php echo esc_url(home_url('/search')); ?>" class="nav-item nav-link link-search">
                        <?php displayIcon('search') ?>
                    </a>
                </nav>

                <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                    <?php
                    wp_nav_menu([
                        'theme_location' => 'primary',
                        'depth'          => 2,
                        'container'      => 'ul',
                        'menu_class'     => 'navbar-nav primary-nav',
                        'fallback_cb'    => 'WP_Bootstrap_Navwalker::fallback',
                        'walker'         => new WP_Bootstrap_Navwalker(),
                    ]);
                    ?>

                    <?php displaySocialMediaLinks('navbar-nav social-links'); ?>
                </div>
            </div>
        </nav>

        <main class="main-content" role="main">