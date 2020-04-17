<?php

/**
 * # Instagram Settings.
 */
function yz_instagram_widget_settings() {

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
            'id'    => 'yz_wg_instagram_display_title',
            'desc'  => __( 'show widget title', 'youzer' ),
            'type'  => 'checkbox'
        )
    );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'widget title', 'youzer' ),
            'id'    => 'yz_wg_instagram_title',
            'desc'  => __( 'add widget title', 'youzer' ),
            'type'  => 'text'
        )
    );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'loading effect', 'youzer' ),
            'opts'  => $Yz_Settings->get_field_options( 'loading_effects' ),
            'desc'  => __( 'how you want the widget to be loaded ?', 'youzer' ),
            'id'    => 'yz_instagram_load_effect',
            'type'  => 'select'
        )
    );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'allowed Photos number', 'youzer' ),
            'id'    => 'yz_wg_max_instagram_items',
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
            'title' => __( 'icon background', 'youzer' ),
            'id'    => 'yz_wg_instagram_img_icon_bg_color',
            'desc'  => __( 'icon background color', 'youzer' ),
            'type'  => 'color'
        )
    );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'icon hover color', 'youzer' ),
            'id'    => 'yz_wg_instagram_img_icon_color',
            'desc'  => __( 'icon text color', 'youzer' ),
            'type'  => 'color'
        )
    );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'icon hover background', 'youzer' ),
            'id'    => 'yz_wg_instagram_img_icon_bg_color_hover',
            'desc'  => __( 'icon hover background color', 'youzer' ),
            'type'  => 'color'
        )
    );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'icon hover color', 'youzer' ),
            'id'    => 'yz_wg_instagram_img_icon_color_hover',
            'desc'  => __( 'icon text hover color', 'youzer' ),
            'type'  => 'color'
        )
    );

    $Yz_Settings->get_field( array( 'type' => 'closeBox' ) );        

    $Yz_Settings->get_field(
        array(
            'msg_type'  => 'info',
            'type'      => 'msgBox',
            'id'        => 'yz_msgbox_instagram_wg_app_setup_steps',
            'title'     => __( 'How to get instagram keys?', 'youzer' ),
            'msg'       => implode( '<br>', yz_get_instagram_app_register_steps() )
        )
    );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'Instagram app settings', 'youzer' ),
            'type'  => 'openBox'
        )
    );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'Application ID', 'youzer' ),
            'desc'  => __( 'enter application ID', 'youzer' ),
            'id'    => 'yz_wg_instagram_app_id',
            'type'  => 'text'
        )
    );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'Application Secret', 'youzer' ),
            'desc'  => __( 'enter application secret key', 'youzer' ),
            'id'    => 'yz_wg_instagram_app_secret',
            'type'  => 'text'
        )
    );

    $Yz_Settings->get_field( array( 'type' => 'closeBox' ) );

}

/**
 * How to register an instagram application
 */
function yz_get_instagram_app_register_steps() {

    // Init Vars.
    $apps_url = 'https://www.instagram.com/developer/clients/manage/';
    $auth_url = home_url( '/yz-auth/feed/Instagram' ); 
    
    // Get Note
    $steps[] = __( '<strong><a>Note:</a> You should submit your application for review and it should be approved in order to make your website users able to use the instagram widget.</strong>', 'youzer' ) . '<br>'; 
    
    // Get Steps.
    $steps[] = sprintf( __( '1. Go to <a href="%1s">%2s</a>', 'youzer' ), $apps_url, $apps_url );
    $steps[] = __( '2. Create a new application by clicking "Register new Client".', 'youzer' );
    $steps[] = __( '3. Fill out any required fields such as the application name and description.', 'youzer' );
    $steps[] = __( '4. Put the below url as OAuth redirect_uri  Authorized Redirect URLs:', 'youzer' );
    $steps[] = sprintf( __( '5. Redirect Url: <strong><a>%s</a></strong>', 'youzer' ), $auth_url );
    $steps[] = __( '6. Once you have registered, copy the created application credentials ( Client ID and Secret ) .', 'youzer' );
    return $steps;
}