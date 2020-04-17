<?php

/**
 * # Skills Settings.
 */
function yz_skills_widget_settings() {

    global $Yz_Settings;

    $Yz_Settings->get_field(
        array(
            'title' => __( 'general Settings', 'youzer' ),
            'type'  => 'openBox'
        )
    );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'display title', 'youzer' ),
            'desc'  => __( 'show skills title', 'youzer' ),
            'id'    => 'yz_wg_skills_display_title',
            'type'  => 'checkbox'
        )
    );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'widget title', 'youzer' ),
            'id'    => 'yz_wg_skills_title',
            'desc'  => __( 'type widget title', 'youzer' ),
            'type'  => 'text'
        )
    );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'loading effect', 'youzer' ),
            'opts'  => $Yz_Settings->get_field_options( 'loading_effects' ),
            'desc'  => __( 'how you want the widget to be loaded?', 'youzer' ),
            'id'    => 'yz_skills_load_effect',
            'type'  => 'select'
        )
    );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'Allowed Skills Number', 'youzer' ),
            'desc'  => __( 'Maximum Allowed skills number.', 'youzer' ),
            'id'    => 'yz_wg_max_skills',
            'std'   => 3,
            'type'  => 'number'
        )
    );

    $Yz_Settings->get_field( array( 'type' => 'closeBox' ) );
}