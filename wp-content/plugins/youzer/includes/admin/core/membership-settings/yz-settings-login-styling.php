<?php

/**
 * Styling Settings
 */
function logy_login_styling_settings() {

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
            'id'    => 'logy_login_title_color',
            'type'  => 'color'
        )
    );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'form subtitle', 'youzer' ),
            'desc'  => __( 'form subtitle color', 'youzer' ),
            'id'    => 'logy_login_subtitle_color',
            'type'  => 'color'
        )
    );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'cover title background', 'youzer' ),
            'desc'  => __( 'cover title background color', 'youzer' ),
            'id'    => 'logy_login_cover_title_bg_color',
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
            'id'    => 'logy_login_label_color',
            'type'  => 'color'
        )
    );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'placeholder', 'youzer' ),
            'desc'  => __( 'form labels color', 'youzer' ),
            'id'    => 'logy_login_placeholder_color',
            'type'  => 'color'
        )
    );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'inputs text', 'youzer' ),
            'desc'  => __( 'inputs text color', 'youzer' ),
            'id'    => 'logy_login_inputs_txt_color',
            'type'  => 'color'
        )
    );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'inputs background', 'youzer' ),
            'desc'  => __( 'inputs background color', 'youzer' ),
            'id'    => 'logy_login_inputs_bg_color',
            'type'  => 'color'
        )
    );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'inputs border', 'youzer' ),
            'desc'  => __( 'inputs border color', 'youzer' ),
            'id'    => 'logy_login_inputs_border_color',
            'type'  => 'color'
        )
    );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'icons', 'youzer' ),
            'desc'  => __( 'fields icons color', 'youzer' ),
            'id'    => 'logy_login_fields_icons_color',
            'type'  => 'color'
        )
    );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'icons background', 'youzer' ),
            'desc'  => __( 'fields icons background color', 'youzer' ),
            'id'    => 'logy_login_fields_icons_bg_color',
            'type'  => 'color'
        )
    );

    $Yz_Settings->get_field( array( 'type' => 'closeBox' ) );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'Remember Me Styling Settings', 'youzer' ),
            'class' => 'ukai-box-3cols',
            'type'  => 'openBox'
        )
    );

    $Yz_Settings->get_field(
        array(
            'title' => __( '"remember me" color', 'youzer' ),
            'desc'  => __( 'form "remember me" color', 'youzer' ),
            'id'    => 'logy_login_remember_color',
            'type'  => 'color'
        )
    );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'checkbox border', 'youzer' ),
            'desc'  => __( 'form checkbox border color', 'youzer' ),
            'id'    => 'logy_login_checkbox_border_color',
            'type'  => 'color'
        )
    );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'checkbox icon', 'youzer' ),
            'desc'  => __( 'form checkbox icon color', 'youzer' ),
            'id'    => 'logy_login_checkbox_icon_color',
            'type'  => 'color'
        )
    );

    $Yz_Settings->get_field( array( 'type' => 'closeBox' ) );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'Buttons Styling Settings', 'youzer' ),
            'class' => 'ukai-box-3cols',
            'type'  => 'openBox'
        )
    );

    $Yz_Settings->get_field(
        array(
            'title' => __( '"lost password" color', 'youzer' ),
            'desc'  => __( 'form "lost password" color', 'youzer' ),
            'id'    => 'logy_login_lostpswd_color',
            'type'  => 'color'
        )
    );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'login button color', 'youzer' ),
            'desc'  => __( 'login button background color', 'youzer' ),
            'id'    => 'logy_login_submit_bg_color',
            'type'  => 'color'
        )
    );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'login button text', 'youzer' ),
            'desc'  => __( 'login button text color', 'youzer' ),
            'id'    => 'logy_login_submit_txt_color',
            'type'  => 'color'
        )
    );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'register button color', 'youzer' ),
            'desc'  => __( 'register button background color', 'youzer' ),
            'id'    => 'logy_login_regbutton_bg_color',
            'type'  => 'color'
        )
    );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'register button text', 'youzer' ),
            'desc'  => __( 'register button text color', 'youzer' ),
            'id'    => 'logy_login_regbutton_txt_color',
            'type'  => 'color'
        )
    );

    $Yz_Settings->get_field( array( 'type' => 'closeBox' ) );
}

