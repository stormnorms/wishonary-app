<?php
if ( !empty( $title_text ) ) {
    echo '<h1 class="stunning-header-title">' . esc_html( $title_text ) . '</h1>';
} elseif ( is_home() ) {
    ?>
    <h1 class="stunning-header-title"><?php esc_html_e( 'Latest posts', 'crum-ext-stunning-header' ); ?></h1>
<?php } elseif ( is_search() ) { ?>
    <span class="stunning-header-title h1 page-title">
        <?php printf( esc_html__( 'Search Results for: %s', 'crum-ext-stunning-header' ), '<h1 class="stunning-header-title d-inline">"' . get_search_query() . '"</h1>' ); ?>
    </span>
<?php } elseif ( is_404() ) { ?>
    <h1 class="stunning-header-title"><?php esc_html_e( '404 Error Page', 'crum-ext-stunning-header' ); ?></h1>
    <?php
} elseif ( function_exists( 'is_shop' ) && is_shop() ) {
    if ( is_shop() && apply_filters( 'woocommerce_show_page_title', true ) ) {
        ?>
        <h2 class="stunning-header-title h1"><?php woocommerce_page_title(); ?></h2>
    <?php } elseif ( is_product() ) { ?>
        <h2 class="stunning-header-title h1"><?php esc_html_e( 'Product Details', 'crum-ext-stunning-header' ); ?></h2>
        <?php
    } elseif ( is_cart() || is_checkout() || is_checkout_pay_page() ) {
        the_title( '<h1 class="stunning-header-title h1">', '</h1>' );
    }
} elseif ( is_page() || is_singular( 'fw-portfolio' ) || is_singular( 'post' ) ) {
    the_title( '<h1 class="stunning-header-title">', '</h1>' );
} elseif ( function_exists( 'tribe_is_event_query' ) && tribe_is_event_query() ) {
    ?>
    <h1 class="stunning-header-title"><?php esc_html_e( 'Events', 'crum-ext-stunning-header' ); ?></h1>
    <?php
} elseif ( is_archive() ) {
    ?>
    <h1 class="stunning-header-title"><?php the_archive_title(); ?></h1>
    <?php
} elseif ( is_tax() ) {
    echo '<h1 class="stunning-header-title">' . esc_html( get_queried_object()->name ) . '</h1>';
} else {
    the_title( '<h1 class="stunning-header-title">', '</h1>' );
}