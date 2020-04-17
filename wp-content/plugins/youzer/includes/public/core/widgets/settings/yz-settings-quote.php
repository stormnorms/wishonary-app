<?php

/**
 * Quote Settings.
 */
function yz_quote_widget_settings() {

    global $Yz_Settings;

    // Get Args 
    $args = yz_get_profile_widget_args( 'quote' );

    $Yz_Settings->get_field(
        array(
            'title' => yz_option( 'yz_wg_quote_title', __( 'Quote', 'youzer' ) ),
            'id'    => $args['id'],
            'icon'  => $args['icon'],
            'type'  => 'open'
        )
    );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'use background Image', 'youzer' ),
            'id'    => 'wg_quote_use_bg',
            'desc'  => __( 'use quote cover', 'youzer' ),
            'type'  => 'checkbox'
        ), true
    );

    $Yz_Settings->get_field(
        array(
            'title'  => __( 'quote background image', 'youzer' ),
            'id'     => 'wg_quote_img',
            'desc'   => __( 'upload quote cover', 'youzer' ),
            'type'   => 'image'
        ), true
    );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'quote text', 'youzer' ),
            'id'    => 'wg_quote_txt',
            'desc'  => __( 'type quote text', 'youzer' ),
            'type'  => 'textarea'
        ), true
    );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'quote owner', 'youzer' ),
            'desc'  => __( 'type quote owner', 'youzer' ),
            'id'    => 'wg_quote_owner',
            'type'  => 'text'
        ), true
    );

    $Yz_Settings->get_field( array( 'type' => 'close' ) );

}