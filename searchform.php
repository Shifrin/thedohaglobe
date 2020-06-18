<?php
/**
 * Template file for displaying search form
 */

$text = isset( $_GET[ 'text' ] ) ? sanitize_text_field( $_GET[ 'text' ] ) : '';
$filter = isset( $_GET[ 'filter_by' ] ) ? sanitize_text_field( $_GET[ 'filter_by' ] ) : '';
?>

<form method="get" action="<?php echo esc_url( home_url( '/search' ) ) ?>" class="search-form">
    <div class="form-row align-items-center">
        <?php $categories = getFilteredCategories( array(
            'orderby' => 'name',
            'order' => 'ASC',
            'hierarchical' => false,
            'childless' => true,
            'hide_empty' => false
        ) ); ?>

        <div class="col-md-7 my-1 my-md-0">
            <label class="sr-only" for="searchInput">Name</label>
            <input type="text" class="form-control form-control-lg"
                   id="searchInput" name="text" value="<?php echo esc_html( $text ); ?>">
        </div>

        <div class="col-md-3 my-1 my-md-0">
            <label class="sr-only" for="filterSelect">
                <?php _e( 'Choose Filter...' ); ?>
            </label>

            <select class="custom-select custom-select-lg" id="filterSelect" name="filter_by">
                <option value="" <?php selected( $filter, '' ); ?>>
                    <?php _e( 'Choose Filter' ); ?>
                </option>

                <?php foreach ( $categories as $category ) : ?>
                    <option value="<?php echo $category->term_id; ?>" <?php selected( $filter, $category->term_id ); ?>>
                        <?php echo esc_html( $category->name ); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="col-md-2 my-1 my-md-0">
            <button type="submit" class="btn btn-success btn-block btn-lg">
                <?php _e( 'Search' ); ?>
            </button>
        </div>
    </div>
</form>
