<?php

/**
 * Link Settings.
 */
function yz_link_widget_settings() {

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
            'id'    => 'yz_wg_link_display_title',
            'desc'  => __( 'show widget title', 'youzer' ),
            'type'  => 'checkbox'
        )
    );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'widget title', 'youzer' ),
            'id'    => 'yz_wg_link_title',
            'desc'  => __( 'type widget title', 'youzer' ),
            'type'  => 'text'
        )
    );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'loading effect', 'youzer' ),
            'opts'  => $Yz_Settings->get_field_options( 'loading_effects' ),
            'desc'  => __( 'how you want the widget to be loaded?', 'youzer' ),
            'id'    => 'yz_link_load_effect',
            'type'  => 'select'
        )
    );

    $Yz_Settings->get_field( array( 'type' => 'closeBox' ) );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'widget Styling widget', 'youzer' ),
            'class' => 'ukai-box-2cols',
            'type'  => 'openBox'
        )
    );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'link icon background', 'youzer' ),
            'desc'  => __( 'icon background color', 'youzer' ),
            'id'    => 'yz_wg_link_icon_bg',
            'type'  => 'color'
        )
    );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'link icon', 'youzer' ),
            'id'    => 'yz_wg_link_icon',
            'desc'  => __( 'link icon color', 'youzer' ),
            'type'  => 'color'
        )
    );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'link description', 'youzer' ),
            'id'    => 'yz_wg_link_txt',
            'desc'  => __( 'link description color', 'youzer' ),
            'type'  => 'color'
        )
    );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'link url', 'youzer' ),
            'id'    => 'yz_wg_link_url',
            'desc'  => __( 'choose link color', 'youzer' ),
            'type'  => 'color'
        )
    );

    $Yz_Settings->get_field( array( 'type' => 'closeBox' ) );
}