<?php

/**
 * Slideshow Settings.
 */
function yz_slideshow_widget_settings() {

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
            'id'    => 'yz_wg_slideshow_display_title',
            'desc'  => __( 'show slideshow title', 'youzer' ),
            'type'  => 'checkbox'
        )
    );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'widget title', 'youzer' ),
            'id'    => 'yz_wg_slideshow_title',
            'desc'  => __( 'slideshow widget title', 'youzer' ),
            'type'  => 'text'
        )
    );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'loading effect', 'youzer' ),
            'opts'  => $Yz_Settings->get_field_options( 'loading_effects' ),
            'desc'  => __( 'how you want the slideshow to be loaded?', 'youzer' ),
            'id'    => 'yz_slideshow_load_effect',
            'type'  => 'select'
        )
    );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'allowed slides number', 'youzer' ),
            'id'    => 'yz_wg_max_slideshow_items',
            'desc'  => __( 'maximum allowed slides', 'youzer' ),
            'type'  => 'number'
        )
    );

    $Yz_Settings->get_field(
        array(
            'id'    => 'yz_slideshow_height_type',
            'title' => __( 'slides height type', 'youzer' ),
            'desc'  => __( 'set slides height type', 'youzer' ),
            'opts'  => $Yz_Settings->get_field_options( 'height_types' ),
            'type'  => 'select',
        )
    );

    $Yz_Settings->get_field( array( 'type' => 'closeBox' ) );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'slideshow styling settings', 'youzer' ),
            'class' => 'ukai-box-2cols',
            'type'  => 'openBox'
        )
    );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'pagination color', 'youzer' ),
            'desc'  => __( 'slider pagination color', 'youzer' ),
            'id'    => 'yz_wg_slideshow_pagination_color',
            'type'  => 'color'
        )
    );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'slideshow buttons', 'youzer' ),
            'desc'  => __( '"Next" & "Prev" color', 'youzer' ),
            'id'    => 'yz_wg_slideshow_np_color',
            'type'  => 'color'
        )
    );

    $Yz_Settings->get_field( array( 'type' => 'closeBox' ) );
}