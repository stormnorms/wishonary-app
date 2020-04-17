<?php

if ( !defined( 'FW' ) ) {
    die( 'Forbidden' );
}

$ext = fw_ext( 'stunning-header' );

$options = array(
    'stunning-header' => array(
        'title'    => esc_html__( 'Stunning header', 'crum-ext-stunning-header' ),
        'type'     => 'tab',
        'priority' => 'high',
        'options'  => array(
            'general'     => array(
                'title'    => esc_html__( 'General', 'crum-ext-stunning-header' ),
                'type'     => 'tab',
                'priority' => 'high',
                'options'  => $ext->get_options( 'partials/settings-tab' ),
            ),
            'woocommerce' => array(
                'title'    => esc_html__( 'WooCommerce', 'crum-ext-stunning-header' ),
                'type'     => 'tab',
                'priority' => 'high',
                'options'  => apply_filters( 'crumina_options_stunning_header_plugin_tab', $ext->get_options( 'partials/settings-tab' ), 'woocommerce' ),
            ),
            'buddypress'  => array(
                'title'    => esc_html__( 'BuddyPress', 'crum-ext-stunning-header' ),
                'type'     => 'tab',
                'priority' => 'high',
                'options'  => apply_filters( 'crumina_options_stunning_header_plugin_tab', $ext->get_options( 'partials/settings-tab' ), 'buddypress' ),
            ),
            'bbpress'      => array(
                'title'    => esc_html__( 'bbPress', 'crum-ext-stunning-header' ),
                'type'     => 'tab',
                'priority' => 'high',
                'options'  => apply_filters( 'crumina_options_stunning_header_plugin_tab', $ext->get_options( 'partials/settings-tab' ), 'bbpress' ),
            ),
            'events'      => array(
                'title'    => esc_html__( 'Events', 'crum-ext-stunning-header' ),
                'type'     => 'tab',
                'priority' => 'high',
                'options'  => apply_filters( 'crumina_options_stunning_header_plugin_tab', $ext->get_options( 'partials/settings-tab' ), 'events' ),
            ),
        ),
    ),
);
