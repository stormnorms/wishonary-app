<?php

$options = array(
    'title'    => 'Top Menu Panel',
    'type'     => 'tab',
    'priority' => 'high',
    'options'  => array(
        fw()->theme->get_options( 'partial-top-menu-panel-visibility' ),
    )
);

if ( class_exists( 'WooCommerce' ) ) {
    $options[ 'options' ][ 'header-general-top-customize-content' ] = array(
        'type'    => 'multi-picker',
        'label'   => false,
        'desc'    => false,
        'picker'  => array(
            'customize' => array(
                'label'        => esc_html__( 'Customize content', 'olympus' ),
                'type'         => 'switch',
                'value'        => 'no',
                'left-choice'  => array(
                    'value' => 'no',
                    'label' => esc_html__( 'No', 'olympus' ),
                ),
                'right-choice' => array(
                    'value' => 'yes',
                    'label' => esc_html__( 'Yes', 'olympus' ),
                ),
            )
        ),
        'choices' => array(
            'yes' => array(
                'header-general-content-popup' => array(
                    'type'          => 'popup',
                    'label'         => esc_html__( 'Custom Content', 'olympus' ),
                    'desc'          => esc_html__( 'Change custom content for this page', 'olympus' ),
                    'button'        => esc_html__( 'Change Content', 'olympus' ),
                    'size'          => 'medium',
                    'popup-options' => fw()->theme->get_options( 'settings-header-general-content' )
                )
            )
        )
    );
}