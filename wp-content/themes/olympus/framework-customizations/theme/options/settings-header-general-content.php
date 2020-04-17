<?php

if ( !defined( 'FW' ) ) {
    die( 'Forbidden' );
}

$header_menu_cart = array();

if ( class_exists( 'WooCommerce' ) ) {
    $header_menu_cart = array(
        'menu_cart_icon' => array(
            'type'         => 'switch',
            'label'        => esc_html__( 'Woocommerce cart', 'olympus' ),
            'desc'         => esc_html__( 'Cart icon with dropdown', 'olympus' ),
            'help'         => esc_html__( 'Work only if Woocommerce plugin installed', 'olympus' ),
            'right-choice'  => array(
                'value' => 'show',
                'label' => esc_html__( 'Show', 'olympus' )
            ),
            'left-choice' => array(
                'value' => 'hide',
                'label' => esc_html__( 'Hide', 'olympus' )
            ),
            'value'        => 'hide',
        ),
    );
}

$options = array(
    $header_menu_cart,
);
