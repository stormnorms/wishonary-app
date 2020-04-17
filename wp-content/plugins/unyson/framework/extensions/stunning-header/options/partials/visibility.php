<?php

if ( !defined( 'FW' ) ) {
    die( 'Forbidden' );
}

$options = array(
    'type'    => 'radio',
    'value'   => 'default',
    'label'   => esc_html__( 'Show stunning header', 'crum-ext-stunning-header' ),
    'choices' => array(
        'default' => esc_html__( 'Default', 'crum-ext-stunning-header' ),
        'yes'     => esc_html__( 'Yes', 'crum-ext-stunning-header' ),
        'no'      => esc_html__( 'No', 'crum-ext-stunning-header' ),
    ),
    
    'inline'  => true,
);
