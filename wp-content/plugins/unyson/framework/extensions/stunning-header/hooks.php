<?php

add_action( 'customize_controls_enqueue_scripts', 'FW_Extension_Stunning_Header::customizerScripts' );

//Update visibility option on settings page
add_filter( 'crumina_options_stunning_header_visibility', '_filter_crumina_options_stunning_header_visibility', 10, 2 );

function _filter_crumina_options_stunning_header_visibility( $options ) {
    unset( $options[ 'choices' ][ 'default' ] );
    $options[ 'value' ] = 'yes';

    return $options;
}

//Add prefixes to plugins tabs
add_filter( 'crumina_options_stunning_header_plugin_tab', '_filter_crumina_options_stunning_header_plugin_tab', 10, 2 );

function _filter_crumina_options_stunning_header_plugin_tab( $options, $tab ) {
    $filtered = array();

    foreach ( $options as $key => $option ) {
        if ( isset( $option[ 'picker' ] ) && is_string( $option[ 'picker' ] ) ) {
            $option[ 'picker' ] = "{$tab}_{$option[ 'picker' ]}";
        }
        $filtered[ "{$tab}_{$key}" ] = $option;
    }

    return $filtered;
}

//Disable stunning on same pages
add_filter( 'fw_ext_stunning_header_visibility', '_filter_fw_ext_stunning_header_visibility' );

function _filter_fw_ext_stunning_header_visibility( $visibility ) {
    $ext = fw_ext( 'stunning-header' );

    if ( function_exists( 'bp_is_group' ) && bp_is_group() ) {
        $visibility = false;
    }

    if ( function_exists( 'bp_is_user' ) && bp_is_user() ) {
        $visibility = false;
    }

    $post_style = $ext->get_option_final( 'single_post_style', 'classic' );
    if ( is_single() && get_post_type() === 'post' && $post_style === 'modern' ) {
        $visibility = false;
    }

    return $visibility;
}

//Add options to metaboxes
add_filter( 'fw_post_options', '_filter_fw_ext_stunning_header_crumina_metabox', 999, 2 );
add_filter( 'fw_taxonomy_options', '_filter_fw_ext_stunning_header_crumina_metabox', 999, 2 );

function _filter_fw_ext_stunning_header_crumina_metabox( $options ) {
    $ext = fw_ext( 'stunning-header' );

    return array_merge( $options, $ext->get_options( 'metabox' ) );
}

//Add options to settings page
add_filter( 'fw_settings_options', '_filter_fw_ext_stunning_header_crumina_settings', 999, 1 );

function _filter_fw_ext_stunning_header_crumina_settings( $options ) {
    $ext = fw_ext( 'stunning-header' );

    return array_merge( $options, $ext->get_options( 'settings' ) );
}

//Add options to customizer
add_filter( 'fw_customizer_options', '_filter_fw_ext_stunning_header_crumina_customizer', 999, 1 );

function _filter_fw_ext_stunning_header_crumina_customizer( $options ) {
    $ext = fw_ext( 'stunning-header' );

    return array_merge( $options, $ext->get_options( 'customizer' ) );
}

//Render stunning header in page template
add_action( 'crumina_body_start', '_filter_fw_ext_stunning_header_render' );

function _filter_fw_ext_stunning_header_render() {
    $ext = fw_ext( 'stunning-header' );
    $ext->render();
}

//Fix for old stunning options
add_filter( 'admin_footer', '_filter_fw_ext_stunning_header_resave_options' );

function _filter_fw_ext_stunning_header_resave_options() {
    if ( get_current_screen()->parent_base === 'edit' || !function_exists( 'fw_set_db_post_option' ) ) {
        return;
    }

    $resaved = get_option( 'fw_ext_stunning_header_resaved' );
    if ( $resaved ) {
        return;
    }

    $pages = get_pages( array(
        'hierarchical' => 0
            ) );

    $ext     = fw_ext( 'stunning-header' );
    $options = fw_get_options_values_from_input( $ext->get_options( 'metabox' ) );

    foreach ( $pages as $page ) {

        foreach ( $options as $key => $option ) {
            fw_set_db_post_option( $page->ID, $key, $option );
        }
    }

    update_option( 'fw_ext_stunning_header_resaved', 1 );
}

add_filter( 'body_class', '_filter_fw_ext_stunning_header_body_class', 10, 2 );

function _filter_fw_ext_stunning_header_body_class( $classes, $class ) {
    $ext = fw_ext( 'stunning-header' );

    if ( !$ext->is_visible() ) {
        $classes[] = 'no-stunning-header';
    }

    return $classes;
}
