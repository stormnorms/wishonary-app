<?php
/**
 * @var $bg_image
 * @var $bg_animate
 * @var $title_show
 * @var $title_text
 * @var $breadcrumbs_show
 * @var $text
 * @var $bottom_image
 * @var $classes
 * @var $bg_animate_type
 */
?>

<?php
$ext = fw_ext( 'stunning-header' );
?>

<section id="stunning-header" class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>" data-animate-type="<?php echo $bg_animate_type; ?>">
    <?php
    if ( $bg_image && $bg_image !== 'none' ) {
        $bg_classes = array( 'crumina-heading-background' );
        ?>

        <div class="<?php echo esc_attr( implode( ' ', $bg_classes ) ); ?>"></div>
    <?php } ?>

    <div class="container">

        <div class="stunning-header-content-wrap">

            <div class="stunning-content-item">
                <?php
                if ( $title_show === 'yes' ) {
                    echo $ext->get_view( 'title', array(
                        'title_text' => $title_text
                    ) );
                }
                ?>
            </div>

            <div class="stunning-content-item">
                <div class="stunning-header-text">
                    <?php
                    if ( !empty( $text ) ) {
                        global $allowedtags;
                        echo wp_kses( do_shortcode($text), $allowedtags );
                    } else if ( is_category() ) {
                        echo category_description();
                    }
                    ?>
                </div>
            </div>

            <div class="stunning-content-item">
                <?php
                if ( 'yes' === $breadcrumbs_show && function_exists( 'fw_ext_breadcrumbs' ) ) {
                    fw_ext_breadcrumbs( '/' );
                }
                ?>
            </div>

        </div>

        <div class="stunning-header-img-bottom">
            <?php if ( $bottom_image ) { ?>
                <img src="<?php echo esc_attr( $bottom_image ); ?>" alt="<?php esc_attr_e( 'Bottom image', 'crum-ext-stunning-header' ); ?>">
            <?php } ?>
        </div>

    </div>

</section>




