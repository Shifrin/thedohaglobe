<?php
/**
 * The page template file
 */
?>

<?php get_header(); ?>

    <div class="container-fluid">
        <section class="page-section">
            <div class="page-center col-9 mx-auto">
                <header class="page-header py-5">
                    <h1 class="page-title">
                        <span class="display-1 d-block">404</span> <?php _e( 'Not Found' ); ?>
                    </h1>

                    <p class="lead text-muted">
                        <?php _e( 'Oops, the page you are looking we cannot find it.' ); ?>
                    </p>

                    <p class="text-muted">
                        <?php _e( 'You may give a try by searching, go to ' ) ?> <a href="<?php echo esc_url( home_url( '/search' ) ) ?>">
                            <?php _e( 'search' ) ?></a>
                    </p>
                </header>
            </div>
        </section>
    </div>

<?php get_footer(); ?>