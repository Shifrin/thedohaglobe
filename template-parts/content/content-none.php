<?php
/**
 * Template part for displaying a message if no content available
 */
?>

<header class="page-header py-5 my-5">
    <h1 class="page-title"><?php _e( 'No Content Found' ); ?></h1>

    <p class="lead">
        <?php _e( 'Sorry, We are still in the beginning stage and therefore we cannot find any content 
        for your request at the moment. We promise you that we will bring you great content soon. Please stay tuned.' ) ?>
    </p>

    <p class="text-muted">
        <?php _e( 'You may give a try by searching, go to ' ) ?> <a href="<?php esc_url( home_url( '/search' ) ) ?>">
            <?php _e( 'search' ) ?></a>
    </p>
</header>