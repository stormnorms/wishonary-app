<?php

/**
 * Project Settings.
 */
function yz_project_widget_settings() {

    // Call Scripts.
    wp_enqueue_script( 'yz-ukaitags', YZ_PA .'js/ukaitag.min.js', array( 'jquery' ), YZ_Version, true );

    global $Yz_Settings;

    // Get Args 
    $args = yz_get_profile_widget_args( 'project' );

    $Yz_Settings->get_field(
        array(
            'title' => yz_option( 'yz_wg_project_title', __( 'Project', 'youzer' ) ),
            'id'    => $args['id'],
            'icon'  => $args['icon'],
            'type'  => 'open'
        )
    );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'Project Type', 'youzer' ),
            'id'    => 'wg_project_type',
            'desc'  => __( 'choose project type', 'youzer' ),
            'opts'  => yz_get_select_options( 'yz_wg_project_types' ),
            'type'  => 'select'
        ), true
    );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'title', 'youzer' ),
            'id'    => 'wg_project_title',
            'desc'  => __( 'type project title', 'youzer' ),
            'type'  => 'text'
        ), true
    );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'project thumbnail', 'youzer' ),
            'id'    => 'wg_project_thumbnail',
            'desc'  => __( 'upload project thumbnail', 'youzer' ),
            'type'  => 'image'
        ), true
    );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'project link', 'youzer' ),
            'id'    => 'wg_project_link',
            'desc'  => __( 'add project link', 'youzer' ),
            'type'  => 'text'
        ), true
    );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'project description', 'youzer' ),
            'id'    => 'wg_project_desc',
            'desc'  => __( 'add project description', 'youzer' ),
            'type'  => 'wp_editor'
        ), true
    );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'Project Categories', 'youzer' ),
            'desc'  => __( 'write category name and hit "Enter" to add it.', 'youzer' ),
            'id'    => 'wg_project_categories',
            'type'  => 'taxonomy'
        ), true
    );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'Project tags', 'youzer' ),
            'id'    => 'wg_project_tags',
            'desc'  => __( 'write tag name and hit "Enter" to add it.', 'youzer' ),
            'type'  => 'taxonomy'
        ), true
    );

    $Yz_Settings->get_field( array( 'type' => 'close' ) );

}