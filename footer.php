<?php
/**
 * The template for displaying the footer
 */

$logoUrl = get_stylesheet_directory_uri() . '/img/logo-fade.png?' . filemtime(
        get_stylesheet_directory() . '/img/logo-fade.png');
?>

        </main><!-- .main-content -->

        <footer class="main-footer text-white">
            <div class="footer-top py-3">
                <div class="container-fluid">
                    <div class="row align-self-center">
                        <div class="col-lg-6">
                            <img src="<?php echo esc_url( $logoUrl ) ?>" class="logo-image img-fluid"
                                 alt="<?php bloginfo( 'name' ); ?>">
                        </div>

                        <div class="col-lg-6">
                            <?php displaySocialMediaLinks('nav social-links justify-content-lg-end'); ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="footer-content">
                <div class="container-fluid">
                    <div class="site-info-links">
                        <?php
                        wp_nav_menu(array(
                            'theme_location'    => 'footer',
                            'depth'             => 2,
                            'container'         => 'ul',
                            'menu_class'        => 'nav footer-nav justify-content-center',
                            'fallback_cb'       => 'WP_Bootstrap_Navwalker::fallback',
                            'walker'            => new WP_Bootstrap_Navwalker(),
                        ));
                        ?>
                    </div>

                    <div class="site-info text-center" role="contentinfo">
                        <?php printf( __( '&copy; %1$s %2$s', 'bt' ), date('Y'),
                            get_bloginfo('name') . ', All Rights Reserved' ); ?>
                    </div>
                </div>
            </div>
        </footer>

        <?php wp_footer(); ?>
    </body>
</html>
