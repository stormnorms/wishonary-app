<?php
if ( !defined( 'ABSPATH' ) ) {
    die( '-1' );
}
/**
 * Shortcode attributes
 * @var $atts
 * @var $content - shortcode content
 * Shortcode class
 * @var $this WPBakeryShortCode_VC_Cta
 */
$modal_content           = 'text';
$btn_link                = $btn_el_id               = $btn_el_class            = $btn_custom_onclick_code = '';

extract( $atts );
$link = vc_build_link( $btn_link );
if ( empty( $link[ 'url' ] ) && ((!empty( $content ) && $modal_content === 'text' ) || $modal_content === 'reg_form') && empty( $btn_custom_onclick_code ) ) {
    if ( isset( $atts[ 'btn_el_class' ] ) ) {
        $atts[ 'btn_el_class' ] .= ' cta-btn-modal';
    } else {
        $atts[ 'btn_el_class' ] = 'cta-btn-modal';
    }

    if ( empty( $btn_el_id ) ) {
        $atts[ 'btn_el_id' ] = $btn_el_id           = 'cta-btn-' . rand( 111, 999 );
    }

    add_action( 'wp_footer', function() use ($btn_el_id, $content, $modal_content) {
        ?>
        <div class="modal fade" id="<?php echo esc_attr( "modal-for-{$btn_el_id}" ); ?>" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-fixed-width modal-lg" role="document">
                <div class="modal-content">
                    <a href="#" class="close icon-close" data-dismiss="modal" aria-label="Close">
                        <svg class="olymp-close-icon"><use xlink:href="<?php echo get_template_directory_uri(); ?>/images/icons.svg#olymp-close-icon"></use></svg>
                    </a>
                    <div class="modal-body <?php echo esc_attr( $modal_content === 'reg_form' ? 'no-padding' : ''  ); ?>">
                        <?php
                        if ( $modal_content === 'reg_form' ) {
                            if ( function_exists( 'crumina_get_reg_form_html' ) ) {
                                echo crumina_get_reg_form_html();
                            } else {
                                esc_html_e('Crumina Sign in Form extension required', 'olympus');
                            }
                        } else {
                            echo wpb_js_remove_wpautop( $content, true );
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <?php
    } );
}

$init_atts      = $atts;
$atts           = vc_map_get_attributes( $this->getShortcode(), $atts );
$this->buildTemplate( $atts, '' );
$containerClass = trim( 'vc_cta3-container ' . esc_attr( implode( ' ', $this->getTemplateVariable( 'container-class' ) ) ) );
$cssClass       = trim( 'vc_general ' . esc_attr( implode( ' ', $this->getTemplateVariable( 'css-class' ) ) ) );
$show_actions   = true;
if ( empty( $btn_custom_onclick_code ) && $modal_content === 'reg_form' && is_user_logged_in() ) {
    $show_actions = false;
}
$wrapper_attributes = array();
if ( !empty( $atts[ 'el_id' ] ) ) {
    $wrapper_attributes[] = 'id="' . esc_attr( $atts[ 'el_id' ] ) . '"';
}
?>
<section class="<?php echo esc_attr( $containerClass ); ?>" <?php echo implode( ' ', $wrapper_attributes ); ?>>
    <div class="<?php echo esc_attr( $cssClass ); ?>"<?php
    if ( $this->getTemplateVariable( 'inline-css' ) ) {
        olympus_render( ' style="' . esc_attr( implode( ' ', $this->getTemplateVariable( 'inline-css' ) ) ) . '"' );
    }
    ?>>
             <?php olympus_render( $this->getTemplateVariable( 'icons-top' ) ); ?>
             <?php olympus_render( $this->getTemplateVariable( 'icons-left' ) ); ?>
        <div class="vc_cta3_content-container">
            <?php
            if ( $show_actions ) {
                olympus_render( $this->getTemplateVariable( 'actions-top' ) );
                olympus_render( $this->getTemplateVariable( 'actions-left' ) );
            }
            ?>
            <div class="vc_cta3-content">
                <header class="vc_cta3-content-header">
                    <?php olympus_render( $this->getTemplateVariable( 'heading1' ) ); ?>
                    <?php olympus_render( $this->getTemplateVariable( 'heading2' ) ); ?>
                </header>
                <?php olympus_render( isset( $init_atts[ 'description' ] ) ? wpb_js_remove_wpautop( $init_atts[ 'description' ], true ) : ''  ); ?>
            </div>
            <?php
            if ( $show_actions ) {
                olympus_render( $this->getTemplateVariable( 'actions-bottom' ) );
                olympus_render( $this->getTemplateVariable( 'actions-right' ) );
            }
            ?>
        </div>
        <?php olympus_render( $this->getTemplateVariable( 'icons-bottom' ) ); ?>
        <?php olympus_render( $this->getTemplateVariable( 'icons-right' ) ); ?>
    </div>
</section>

<!--$content-->