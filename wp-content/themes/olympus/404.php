<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package olympus
 */

get_header(); ?>
    <section class="padding40">
        <div class="container">
            <div class="row">
                <div class="col-xl-6 m-auto col-lg-6 col-md-12 col-sm-12 col-xs-12">
                    <div class="page-404-content">
                        <img src="<?php echo get_template_directory_uri() ?>/images/404.png" alt="<?php esc_attr_e( 'Not found', 'olympus' ); ?>">
                        <div class="crumina-module crumina-heading align-center">
                            <h2 class="h1 heading-title"><?php esc_html_e('A wild ghost appears! Sadly, not what you were looking for...', 'olympus' ); ?></h2>
                            <p class="heading-text">
	                            <?php esc_html_e( 'Sorry! The page you were looking for has been moved or doesn\'t exist. If you like, you can return to our homepage, or try a search?', 'olympus' ); ?>
                            </p>
                        </div>

	                    <?php get_search_form(); ?>

                        <div class="padding40">
                            <a href="<?php echo home_url();?>" class="btn btn-primary btn-lg"><?php esc_html_e( 'Go to Homepage', 'olympus' ); ?></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php
get_footer();