<?php

/**
 * Link Settings.
 */
function yz_link_widget_settings() {

    global $Yz_Settings;

    // Get Args 
    $args = yz_get_profile_widget_args( 'link' );

    $Yz_Settings->get_field(
        array(
            'title' => yz_option( 'yz_wg_link_title', __( 'Link', 'youzer' ) ),
            'id'    => $args['id'],
            'icon'  => $args['icon'],
            'type'  => 'open'
        )
    );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'use background Image', 'youzer' ),
            'id'    => 'wg_link_use_bg',
            'desc'  => __( 'use link cover', 'youzer' ),
            'type'  => 'checkbox'
        ), true
    );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'link background image', 'youzer' ),
            'id'    => 'wg_link_img',
            'desc'  => __( 'upload link cover', 'youzer' ),
            'type'  => 'image'
        ), true
    );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'link description', 'youzer' ),
            'id'    => 'wg_link_txt',
            'desc'  => __( 'add link description', 'youzer' ),
            'type'  => 'textarea'
            ), true
    );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'link url', 'youzer' ),
            'desc'  => __( 'add your link', 'youzer' ),
            'id'    => 'wg_link_url',
            'type'  => 'text'
        ), true
    );

    $Yz_Settings->get_field( array( 'type' => 'close' ) );

}