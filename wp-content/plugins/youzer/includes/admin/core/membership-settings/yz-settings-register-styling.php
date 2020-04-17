<?php

/**
 * Styling Settings
 */
function logy_register_styling_settings() {

    global $Yz_Settings;

    $Yz_Settings->get_field(
        array(
            'title' => __( 'Header Styling Settings', 'youzer' ),
            'class' => 'ukai-box-3cols',
            'type'  => 'openBox'
        )
    );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'form title', 'youzer' ),
            'desc'  => __( 'form title color', 'youzer' ),
            'id'    => 'logy_signup_title_color',
            'type'  => 'color'
        )
    );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'form subtitle', 'youzer' ),
            'desc'  => __( 'form subtitle color', 'youzer' ),
            'id'    => 'logy_signup_subtitle_color',
            'type'  => 'color'
        )
    );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'cover title background', 'youzer' ),
            'desc'  => __( 'cover title background color', 'youzer' ),
            'id'    => 'logy_signup_cover_title_bg_color',
            'type'  => 'color'
        )
    );

    $Yz_Settings->get_field( array( 'type' => 'closeBox' ) );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'Fields Styling Settings', 'youzer' ),
            'class' => 'ukai-box-3cols',
            'type'  => 'openBox'
        )
    );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'labels', 'youzer' ),
            'desc'  => __( 'form labels color', 'youzer' ),
            'id'    => 'logy_signup_label_color',
            'type'  => 'color'
        )
    );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'placeholder', 'youzer' ),
            'desc'  => __( 'form labels color', 'youzer' ),
            'id'    => 'logy_signup_placeholder_color',
            'type'  => 'color'
        )
    );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'inputs text', 'youzer' ),
            'desc'  => __( 'inputs text color', 'youzer' ),
            'id'    => 'logy_signup_inputs_txt_color',
            'type'  => 'color'
        )
    );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'inputs background', 'youzer' ),
            'desc'  => __( 'inputs background color', 'youzer' ),
            'id'    => 'logy_signup_inputs_bg_color',
            'type'  => 'color'
        )
    );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'inputs border', 'youzer' ),
            'desc'  => __( 'inputs border color', 'youzer' ),
            'id'    => 'logy_signup_inputs_border_color',
            'type'  => 'color'
        )
    );

    $Yz_Settings->get_field( array( 'type' => 'closeBox' ) );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'Buttons Styling Settings', 'youzer' ),
            'class' => 'ukai-box-2cols',
            'type'  => 'openBox'
        )
    );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'register button color', 'youzer' ),
            'desc' => __( 'submit button background', 'youzer' ),
            'id'    => 'logy_signup_submit_bg_color',
            'type'  => 'color'
        )
    );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'register button text', 'youzer' ),
            'desc'  => __( 'register button text color', 'youzer' ),
            'id'    => 'logy_signup_submit_txt_color',
            'type'  => 'color'
        )
    );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'login button color', 'youzer' ),
            'desc'  => __( 'register button background color', 'youzer' ),
            'id'    => 'logy_signup_loginbutton_bg_color',
            'type'  => 'color'
        )
    );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'login button text', 'youzer' ),
            'desc'  => __( 'register button text color', 'youzer' ),
            'id'    => 'logy_signup_loginbutton_txt_color',
            'type'  => 'color'
        )
    );

    $Yz_Settings->get_field( array( 'type' => 'closeBox' ) );
}