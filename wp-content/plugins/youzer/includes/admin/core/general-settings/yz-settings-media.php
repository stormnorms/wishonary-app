<?php

/**
 * # Media Settings.
 */

function yz_media_settings() {

    global $Yz_Settings;

    $Yz_Settings->get_field(
        array(
            'title' => __( 'Groups Media Tab settings', 'youzer' ),
            'type'  => 'openBox'
        )
    );


    $Yz_Settings->get_field(
        array(
            'title' => __( 'enable groups media', 'youzer' ),
            'id'    => 'yz_enable_groups_media',
            'desc'  => __( 'activate groups media', 'youzer' ),
            'type'  => 'checkbox'
        )
    );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'items per page', 'youzer' ),
            'id'    => 'yz_group_media_tab_per_page',
            'desc'  => __( 'how many items per page on the all media page ?', 'youzer' ),
            'type'  => 'number'
        )
    );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'Layout', 'youzer' ),
            'opts'  => $Yz_Settings->get_field_options( 'media_layouts' ),
            'desc'  => __( 'select media items layout', 'youzer' ),
            'id'    => 'yz_group_media_tab_layout',
            'type'  => 'select'
        )
    );

    $Yz_Settings->get_field( array( 'type' => 'closeBox' ) );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'Groups Media Subtabs settings', 'youzer' ),
            'type'  => 'openBox'
        )
    );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'items per page', 'youzer' ),
            'id'    => 'yz_group_media_subtab_per_page',
            'desc'  => __( 'how many items per page on the media subtabs ?', 'youzer' ),
            'type'  => 'number'
        )
    );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'Layout', 'youzer' ),
            'opts'  => $Yz_Settings->get_field_options( 'media_layouts' ),
            'desc'  => __( 'select media subtabs items layout', 'youzer' ),
            'id'    => 'yz_group_media_subtab_layout',
            'type'  => 'select'
        )
    );


    $Yz_Settings->get_field( array( 'type' => 'closeBox' ) );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'Groups Media types visibility', 'youzer' ),
            'class' => 'ukai-box-2cols',
            'type'  => 'openBox'
        )
    );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'photos', 'youzer' ),
            'id'    => 'yz_show_group_media_tab_photos',
            'desc'  => __( 'show media photos', 'youzer' ),
            'type'  => 'checkbox'
        )
    );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'videos', 'youzer' ),
            'id'    => 'yz_show_group_media_tab_videos',
            'desc'  => __( 'show media videos', 'youzer' ),
            'type'  => 'checkbox'
        )
    );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'audios', 'youzer' ),
            'id'    => 'yz_show_group_media_tab_audios',
            'desc'  => __( 'show media audios', 'youzer' ),
            'type'  => 'checkbox'
        )
    );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'files', 'youzer' ),
            'id'    => 'yz_show_group_media_tab_files',
            'desc'  => __( 'show media files', 'youzer' ),
            'type'  => 'checkbox'
        )
    );

    $Yz_Settings->get_field( array( 'type' => 'closeBox' ) );
}