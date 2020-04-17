<?php

/**
 * # Add BBpress Settings Tab
 */
function yz_bbpress_settings() {

    global $Yz_Settings;

    $Yz_Settings->get_field(
        array(
            'title' => __( 'general settings', 'youzer' ),
            'type'  => 'openBox'
        )
    );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'BBpress Integration', 'youzer' ),
            'desc'  => __( 'enable Bbpress integration', 'youzer' ),
            'id'    => 'yz_enable_bbpress',
            'type'  => 'checkbox'
        )
    );

    $Yz_Settings->get_field( array( 'type' => 'closeBox' ) );

}