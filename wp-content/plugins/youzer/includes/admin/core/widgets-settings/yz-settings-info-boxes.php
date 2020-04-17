<?php

/**
 * Info Boxes Settings.
 */
function yz_info_boxes_widget_settings() {

    global $Yz_Settings;


    $Yz_Settings->get_field(
        array(
            'title' => __( 'Email settings', 'youzer' ),
            'class' => 'ukai-box-2cols',
            'type'  => 'openBox'
        )
    );

    $Yz_Settings->get_field(
        array(

            'title' => __( 'E-mail field', 'youzer' ),
            'desc'  => __( 'select the email box field', 'youzer' ),
            'opts'  => yz_get_panel_profile_fields(),
            'id'    => 'yz_email_info_box_field',
            'type'  => 'select'
        )
    );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'email loading effect', 'youzer' ),
            'opts'  => $Yz_Settings->get_field_options( 'loading_effects' ),
            'desc'  => __( 'email loading effect', 'youzer' ),
            'id'    => 'yz_email_load_effect',
            'type'  => 'select'
        )
    );
    $Yz_Settings->get_field(
        array(
            'title' => __( 'background left', 'youzer' ),
            'desc'  => __( 'gradient background color', 'youzer' ),
            'id'    => 'yz_ibox_email_bg_left',
            'type'  => 'color'
        )
    );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'background right', 'youzer' ),
            'desc'  => __( 'gradient background color', 'youzer' ),
            'id'    => 'yz_ibox_email_bg_right',
            'type'  => 'color'
        )
    );

    $Yz_Settings->get_field( array( 'type' => 'closeBox' ) );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'address Styling settings', 'youzer' ),
            'class' => 'ukai-box-2cols',
            'type'  => 'openBox'
        )
    );

    $Yz_Settings->get_field(
        array(

            'title' => __( 'Address field', 'youzer' ),
            'desc'  => __( 'select the address box field', 'youzer' ),
            'opts'  => yz_get_panel_profile_fields(),
            'id'    => 'yz_address_info_box_field',
            'type'  => 'select'
        )
    );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'address loading effect', 'youzer' ),
            'opts'  => $Yz_Settings->get_field_options( 'loading_effects' ),
            'desc'  => __( 'address loading effect', 'youzer' ),
            'id'    => 'yz_address_load_effect',
            'type'  => 'select'
        )
    );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'background left', 'youzer' ),
            'desc'  => __( 'gradient background color', 'youzer' ),
            'id'    => 'yz_ibox_address_bg_left',
            'type'  => 'color'
        )
    );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'background right', 'youzer' ),
            'desc'  => __( 'gradient background color', 'youzer' ),
            'id'    => 'yz_ibox_address_bg_right',
            'type'  => 'color'
        )
    );

    $Yz_Settings->get_field( array( 'type' => 'closeBox' ) );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'website Styling settings', 'youzer' ),
            'class' => 'ukai-box-2cols',
            'type'  => 'openBox'
        )
    );

    $Yz_Settings->get_field(
        array(

            'title' => __( 'Website field', 'youzer' ),
            'desc'  => __( 'select the website box field', 'youzer' ),
            'opts'  => yz_get_panel_profile_fields(),
            'id'    => 'yz_website_info_box_field',
            'type'  => 'select'
        )
    );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'website loading effect', 'youzer' ),
            'desc'  => __( 'website loading effect?', 'youzer' ),
            'opts'  => $Yz_Settings->get_field_options( 'loading_effects' ),
            'id'    => 'yz_website_load_effect',
            'type'  => 'select'
        )
    );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'background left', 'youzer' ),
            'desc'  => __( 'gradient background color', 'youzer' ),
            'id'    => 'yz_ibox_website_bg_left',
            'type'  => 'color'
        )
    );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'background right', 'youzer' ),
            'desc'  => __( 'gradient background color', 'youzer' ),
            'id'    => 'yz_ibox_website_bg_right',
            'type'  => 'color'
        )
    );

    $Yz_Settings->get_field( array( 'type' => 'closeBox' ) );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'phone number Styling settings', 'youzer' ),
            'class' => 'ukai-box-2cols',
            'type'  => 'openBox'
        )
    );

    $Yz_Settings->get_field(
        array(

            'title' => __( 'phone field', 'youzer' ),
            'desc'  => __( 'select the phone box field', 'youzer' ),
            'opts'  => yz_get_panel_profile_fields(),
            'id'    => 'yz_phone_info_box_field',
            'type'  => 'select'
        )
    );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'phone loading effect', 'youzer' ),
            'desc'  => __( 'phone number loading effect?', 'youzer' ),
            'opts'  => $Yz_Settings->get_field_options( 'loading_effects' ),
            'id'    => 'yz_phone_load_effect',
            'type'  => 'select'
        )
    );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'background left', 'youzer' ),
            'desc'  => __( 'gradient background color', 'youzer' ),
            'id'    => 'yz_ibox_phone_bg_left',
            'type'  => 'color'
        )
    );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'background right', 'youzer' ),
            'desc'  => __( 'gradient background color', 'youzer' ),
            'id'    => 'yz_ibox_phone_bg_right',
            'type'  => 'color'
        )
    );

    $Yz_Settings->get_field( array( 'type' => 'closeBox' ) );
}