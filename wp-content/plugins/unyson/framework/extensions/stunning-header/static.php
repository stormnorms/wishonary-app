<?php

$ext = fw_ext( 'stunning-header' );

if ( !is_admin() ) {
    wp_enqueue_style( 'crumina-stunning-header', $ext->locate_URI( '/static/css/stunning-header.css' ), array(), $ext->manifest->get_version() );
    wp_enqueue_script( 'crumina-stunning-header', $ext->locate_URI( '/static/js/stunning-header.js' ), array( 'jquery' ), $ext->manifest->get_version() );

    $prefix = '';
    if ( function_exists( 'is_woocommerce' ) && is_woocommerce() ) {
        $prefix = 'woocommerce_';
    } elseif ( function_exists( 'tribe_is_event_query' ) && tribe_is_event_query() ) {
        $prefix = 'events_';
    } elseif ( function_exists( 'bp_current_component' ) && bp_current_component() ) {
        $prefix = 'buddypress_';
    } elseif(function_exists( 'is_bbpress' ) && is_bbpress()){
        $prefix = 'bbpress_';
    }

    // Stuning header
    $css                              = '';
    $header_stunning_visibility       = $ext->get_option_final( "header-stunning-visibility", 'default', array( 'final-source' => 'current-type' ) );
    $header_stunning_customize_styles = $ext->get_option_final( 'header-stunning-customize/yes/header-stunning-customize-styles', array() );

    if ( fw_akg( 'customize', $header_stunning_customize_styles, 'no' ) === 'yes' && $header_stunning_visibility !== 'default' ) {
        $sh_text_color     = fw_akg( 'yes/header-stunning-styles-popup/stunning_text_color', $header_stunning_customize_styles, '#fff' );
        $sh_padding_top    = fw_akg( 'yes/header-stunning-styles-popup/stunning_padding_top', $header_stunning_customize_styles, '125px' );
        $sh_padding_bottom = fw_akg( 'yes/header-stunning-styles-popup/stunning_padding_bottom', $header_stunning_customize_styles, '125px' );
        $sh_bg_cover       = fw_akg( 'yes/header-stunning-styles-popup/stunning_bg_animate_picker/no/stunning_bg_cover', $header_stunning_customize_styles, 'no' );
        $sh_bg_color       = fw_akg( 'yes/header-stunning-styles-popup/stunning_bg_color', $header_stunning_customize_styles, '#FF5E3A' );
        $sh_bg_image       = fw_akg( 'yes/header-stunning-styles-popup/stunning_bg_image/data/css/background-image', $header_stunning_customize_styles, 'url(' . get_template_directory_uri() . '/images/header-stunning-1.png)' );
    } else {
        $customizer = $ext->get_option( "{$prefix}header-stunning-customizer", array(), 'customizer' );

        $sh_text_color     = fw_akg( 'yes/stunning_text_color', $customizer, '#fff' );
        $sh_padding_top    = fw_akg( 'yes/stunning_padding_top', $customizer, '125px' );
        $sh_padding_bottom = fw_akg( 'yes/stunning_padding_bottom', $customizer, '125px' );
        $sh_bg_cover       = fw_akg( 'yes/stunning_bg_animate_picker/no/stunning_bg_cover', $customizer, 'no' );
        $sh_bg_color       = fw_akg( 'yes/stunning_bg_color', $customizer, '#FF5E3A' );
        $sh_bg_image       = fw_akg( 'data/css/background-image', fw_akg( 'yes/stunning_bg_image', $customizer, '' ), 'url(' . get_template_directory_uri() . '/images/header-stunning-1.png)' );
    }

    if ( $sh_text_color ) {
        $css .= "#stunning-header {color:{$sh_text_color};}";
        $css .= "#stunning-header .stunning-header-content-wrap {color:{$sh_text_color};}";
        $css .= "#stunning-header .stunning-header-content-wrap * {color:{$sh_text_color};}";
    }

    if ( $sh_padding_top ) {
        $css .= "#stunning-header {padding-top:{$sh_padding_top};}";
    }

    if ( $sh_padding_bottom ) {
        $css .= "#stunning-header {padding-bottom:{$sh_padding_bottom};}";
    }

    if ( 'yes' === $sh_bg_cover ) {
        $css .= "#stunning-header .crumina-heading-background {background-size: cover;}";
    }

    if ( $sh_bg_image && $sh_bg_image !== 'none' ) {
        $css .= "#stunning-header .crumina-heading-background {background-image: " . $sh_bg_image . ";}";
    }

    if ( $sh_bg_color ) {
        $css .= "#stunning-header {background-color:{$sh_bg_color};}";
    }

    wp_add_inline_style( 'crumina-stunning-header', $css );
}