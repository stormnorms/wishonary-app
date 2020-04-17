<?php

/**
 * About Me Settings.
 */
function yz_about_me_widget_settings() {

    global $Yz_Settings;

    $args = yz_get_profile_widget_args( 'about_me' );

    $Yz_Settings->get_field(
        array(
            'title' => yz_option( 'yz_wg_aboutme_title', __( 'About Me', 'youzer' ) ),
            'id'    => $args['id'],
            'icon'  => $args['icon'],
            'type'  => 'open'
        )
    );

    $Yz_Settings->get_field(
        array(
            'id'    => 'wg_about_me_photo',
            'title' => __( 'Upload photo', 'youzer' ),
            'desc'  => __( 'upload about me photo', 'youzer' ),
            'type'  => 'image'
        ), true
    );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'title', 'youzer' ),
            'id'    => 'wg_about_me_title',
            'desc'  => __( 'type your full name', 'youzer' ),
            'type'  => 'text'
        ), true
    );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'description', 'youzer' ),
            'desc'  => __( 'type your position', 'youzer' ),
            'id'    => 'wg_about_me_desc',
            'type'  => 'text'
        ), true
    );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'biography', 'youzer' ),
            'id'    => 'wg_about_me_bio',
            'desc'  => __( 'add your biography', 'youzer' ),
            'type'  => 'wp_editor'
        ), true
    );

    $Yz_Settings->get_field( array( 'type' => 'close' ) );

}