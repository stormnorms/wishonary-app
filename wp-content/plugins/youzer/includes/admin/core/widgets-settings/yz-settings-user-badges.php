<?php

/**
 * # Widget Settings.
 */
function yz_user_badges_widget_settings() {

	global $Yz_Settings;

	if ( ! defined( 'myCRED_BADGE_VERSION' ) ) {

        $Yz_Settings->get_field(
            array(
                'msg_type'  => 'info',
                'type'      => 'msgBox',
                'id'        => 'yz_msgbox_user_badges_widget_notice',
                'title'     => __( 'How to activate user badges widget?', 'youzer' ),
                'msg'       => sprintf( __( 'Please install the <a href="%1s"> MyCRED Plugin</a> and <strong>MyCRED Badges Extension</strong> to activate the user badges widget.'), 'https://wordpress.org/plugins/mycred/' )
            )
        );
	} else {

    $Yz_Settings->get_field(
        array(
            'title' => __( 'general Settings', 'youzer' ),
            'type'  => 'openBox'
        )
    );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'display title', 'youzer' ),
            'id'    => 'yz_wg_user_badges_display_title',
            'desc'  => __( 'show widget title', 'youzer' ),
            'type'  => 'checkbox'
        )
    );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'widget title', 'youzer' ),
            'id'    => 'yz_wg_user_badges_title',
            'desc'  => __( 'add widget title', 'youzer' ),
            'type'  => 'text'
        )
    );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'loading effect', 'youzer' ),
            'opts'  => $Yz_Settings->get_field_options( 'loading_effects' ),
            'desc'  => __( 'how you want the widget to be loaded ?', 'youzer' ),
            'id'    => 'yz_user_badges_load_effect',
            'type'  => 'select'
        )
    );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'allowed badges number', 'youzer' ),
            'id'    => 'yz_wg_max_user_badges_items',
            'desc'  => __( 'maximum number of badges to display', 'youzer' ),
            'type'  => 'number'
        )
    );

    $Yz_Settings->get_field( array( 'type' => 'closeBox' ) );
    


    }


	
    do_action( 'yz_user_badges_widget_settings' );

}