<?php

/**
 * Services Settings.
 */
function yz_services_widget_settings() {

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
            'id'    => 'yz_wg_services_display_title',
            'desc'  => __( 'show services title', 'youzer' ),
            'type'  => 'checkbox'
        )
    );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'widget title', 'youzer' ),
            'id'    => 'yz_wg_services_title',
            'type'  => 'text'
        )
    );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'loading effect', 'youzer' ),
            'opts'  => $Yz_Settings->get_field_options( 'loading_effects' ),
            'desc'  => __( 'how you want the widget to be loaded ?', 'youzer' ),
            'id'    => 'yz_services_load_effect',
            'type'  => 'select'
        )
    );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'allowed services number', 'youzer' ),
            'desc'  => __( 'maximum allowed services number', 'youzer' ),
            'id'    => 'yz_wg_max_services',
            'type'  => 'number'
        )
    );

    $Yz_Settings->get_field( array( 'type' => 'closeBox' ) );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'Services Box Layouts', 'youzer' ),
            'type'  => 'openBox'
        )
    );

    $Yz_Settings->get_field(
        array(
            'id'    =>  'yz_wg_services_layout',
            'desc'  => __( 'services widget layouts', 'youzer' ),
            'opts'  => $Yz_Settings->get_field_options( 'services_layout' ),
            'type'  => 'imgSelect',
        )
    );

    $Yz_Settings->get_field( array( 'type' => 'closeBox' ) );

    // $Yz_Settings->get_field(
    //     array(
    //         'title' => __( 'services icon background style', 'youzer' ),
    //         'type'  => 'openBox'
    //     )
    // );

    // $Yz_Settings->get_field(
    //     array(
    //         'id'    => 'yz_wg_service_icon_bg_format',
    //         'type'  => 'imgSelect',
    //         'opts'  => $Yz_Settings->get_field_options( 'image_formats' )
    //     )
    // );

    // $Yz_Settings->get_field( array( 'type' => 'closeBox' ) );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'widget visibility setting', 'youzer' ),
            'class' => 'ukai-box-3cols',
            'type'  => 'openBox'
        )
    );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'service icon', 'youzer' ),
            'desc'  => __( 'show services icon', 'youzer' ),
            'id'    => 'yz_display_service_icon',
            'type'  => 'checkbox'
        )
    );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'service title', 'youzer' ),
            'desc'  => __( 'show services title', 'youzer' ),
            'id'    => 'yz_display_service_title',
            'type'  => 'checkbox'
        )
    );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'service description', 'youzer' ),
            'id'    => 'yz_display_service_text',
            'desc'  => __( 'show services description', 'youzer' ),
            'type'  => 'checkbox'
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
            'title' => __( 'service icon', 'youzer' ),
            'id'    => 'yz_wg_service_icon_color',
            'desc'  => __( 'service icon color', 'youzer' ),
            'type'  => 'color'
        )
    );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'service icon background', 'youzer' ),
            'id'    => 'yz_wg_service_icon_bg_color',
            'desc'  => __( 'service icon background', 'youzer' ),
            'type'  => 'color'
        )
    );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'service title', 'youzer' ),
            'id'    => 'yz_wg_service_title_color',
            'desc'  => __( 'service title color', 'youzer' ),
            'type'  => 'color'
        )
    );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'service description', 'youzer' ),
            'desc'  => __( 'service description color', 'youzer' ),
            'id'    => 'yz_wg_service_text_color',
            'type'  => 'color'
        )
    );

    $Yz_Settings->get_field( array( 'type' => 'closeBox' ) );
}