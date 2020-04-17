<?php
/**
 * The template for displaying archive pages
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package olympus
 */
$olympus         = Olympus_Options::get_instance();
$post_style      = $olympus->get_option_final( 'blog_style', 'classic' );
$layout          = olympus_sidebar_conf( $post_style === 'list' ? true : false );
$main_class      = 'full' !== $layout[ 'position' ] ? 'site-main content-main-sidebar' : 'site-main content-main-full';
$container_width = 'container';
?>

<?php get_header(); ?>

<div id="primary" class="<?php echo esc_attr( $container_width ) ?>">
    <div class="row primary-content-wrapper">
        <?php
        if ( is_author() ) {
            get_template_part( 'templates/header/author' );
        }
        ?>
        <div class="<?php echo esc_attr( $layout[ 'content-classes' ] ) ?>">
            <main id="main" class="<?php echo esc_attr( $main_class ) ?>">
                <?php $stunning_visibility = $olympus->get_option_final( 'header-stunning-visibility', 'yes' ); ?>
                <?php if ( is_archive() && !is_author() && $stunning_visibility !== 'yes' ) { ?>
                    <div class="ui-block post mt-3">
                        <h1 class="entry-title"><?php the_archive_title(); ?></h1>
                    </div>
                <?php } ?>

                <?php get_template_part( 'templates/loop/standard' ); ?>

            </main><!-- #main -->
        </div>
        <?php if ( 'full' !== $layout[ 'position' ] ) { ?>
            <div class="<?php echo esc_attr( $layout[ 'sidebar-classes' ] ) ?>">
                <?php get_sidebar(); ?>
            </div>
        <?php } ?>
    </div><!-- #row -->
</div><!-- #primary -->

<?php get_footer(); ?>