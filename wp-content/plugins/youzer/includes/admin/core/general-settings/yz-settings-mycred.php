<?php

/**
 * # Add Mycred Settings Tab
 */
function yz_mycred_settings() {

    global $Yz_Settings;

    $Yz_Settings->get_field(
        array(
            'title' => __( 'general settings', 'youzer' ),
            'type'  => 'openBox'
        )
    );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'MyCred Integration', 'youzer' ),
            'desc'  => __( 'enable MyCred integration', 'youzer' ),
            'id'    => 'yz_enable_mycred',
            'type'  => 'checkbox'
        )
    );

    $Yz_Settings->get_field( array( 'type' => 'closeBox' ) );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'members directory Settings', 'youzer' ),
            'type'  => 'openBox'
        )
    );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'enable badges', 'youzer' ),
            'desc'  => __( 'enable cards badges', 'youzer' ),
            'id'    => 'yz_enable_cards_mycred_badges',
            'type'  => 'checkbox'
        )
    );
    
    $Yz_Settings->get_field(
        array(
            'title' => __( 'Max badges', 'youzer' ),
            'desc'  => __( 'max badges per card', 'youzer' ),
            'id'    => 'yz_wg_max_card_user_badges_items',
            'type'  => 'number'
        )
    );

    $Yz_Settings->get_field( array( 'type' => 'closeBox' ) );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'Author Box Settings', 'youzer' ),
            'type'  => 'openBox'
        )
    );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'enable badges', 'youzer' ),
            'desc'  => __( 'enable author box badges', 'youzer' ),
            'id'    => 'yz_enable_author_box_mycred_badges',
            'type'  => 'checkbox'
        )
    );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'Max badges', 'youzer' ),
            'desc'  => __( 'max badges per author box', 'youzer' ),
            'id'    => 'yz_author_box_max_user_badges_items',
            'type'  => 'number'
        )
    );

    $Yz_Settings->get_field( array( 'type' => 'closeBox' ) );

}