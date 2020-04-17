<?php

/**
 * # Flickr Settings.
 */
function yz_flickr_widget_settings() {

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
            'id'    => 'yz_wg_flickr_display_title',
            'desc'  => __( 'show widget title', 'youzer' ),
            'type'  => 'checkbox'
        )
    );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'widget title', 'youzer' ),
            'id'    => 'yz_wg_flickr_title',
            'desc'  => __( 'add widget title', 'youzer' ),
            'type'  => 'text'
        )
    );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'loading effect', 'youzer' ),
            'opts'  => $Yz_Settings->get_field_options( 'loading_effects' ),
            'desc'  => __( 'how you want the widget to be loaded ?', 'youzer' ),
            'id'    => 'yz_flickr_load_effect',
            'type'  => 'select'
        )
    );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'allowed Photos number', 'youzer' ),
            'id'    => 'yz_wg_max_flickr_items',
            'desc'  => __( 'maximum allowed photos', 'youzer' ),
            'std'   => 6,
            'type'  => 'number'
        )
    );

    $Yz_Settings->get_field( array( 'type' => 'closeBox' ) );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'widget styling settings', 'youzer' ),
            'class' => 'ukai-box-2cols',
            'type'  => 'openBox'
        )
    );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'icon hover background', 'youzer' ),
            'id'    => 'yz_wg_flickr_img_icon_bg_color',
            'desc'  => __( 'zoom icon hover background color', 'youzer' ),
            'type'  => 'color'
        )
    );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'icon hover color', 'youzer' ),
            'id'    => 'yz_wg_flickr_img_icon_color',
            'desc'  => __( 'zoom icon hover color', 'youzer' ),
            'type'  => 'color'
        )
    );

    $Yz_Settings->get_field( array( 'type' => 'closeBox' ) );
}