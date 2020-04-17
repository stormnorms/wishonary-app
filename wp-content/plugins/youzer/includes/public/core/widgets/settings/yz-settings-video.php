<?php

/**
* Video Settings.
*/
function yz_video_widget_settings() {

    global $Yz_Settings;

    // Get Args 
    $args = yz_get_profile_widget_args( 'video' );

    $Yz_Settings->get_field(
        array(
            'title' => yz_option( 'yz_wg_video_title', __( 'Video', 'youzer' ) ),
            'id'    => $args['id'],
            'icon'  => $args['icon'],
            'type'  => 'open'
        )
    );

    // Get Supported Videos Url.
    $supported_videos = apply_filters( 'yz_account_supported_videos_url', 'https://en.support.wordpress.com/videos/' );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'video url', 'youzer' ),
            'desc'  => sprintf( __( "check the <a href='%s' target='_blank'>list of supported websites</a>", 'youzer' ), $supported_videos ),
            'id'    => 'wg_video_url',
            'type'  => 'text'
        ), true
    );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'video title', 'youzer' ),
            'id'    => 'wg_video_title',
            'desc'  => __( 'add video title', 'youzer' ),
            'type'  => 'text'
        ), true
    );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'video description', 'youzer' ),
            'desc'  => __( 'add video description', 'youzer' ),
            'id'    => 'wg_video_desc',
            'type'  => 'wp_editor'
        ), true
    );

    $Yz_Settings->get_field( array( 'type' => 'close' ) );

}