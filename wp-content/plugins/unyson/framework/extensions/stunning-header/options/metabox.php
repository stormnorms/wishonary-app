<?php

if ( !defined( 'FW' ) ) {
    die( 'Forbidden' );
}

$ext = fw_ext( 'stunning-header' );

$options = array(
    'stunning-header' => array(
        'title'    => esc_html__( 'Stunning header', 'crum-ext-stunning-header' ),
        'type'     => 'box',
        'priority' => 'high',
        'options'  => array(
            'header-stunning-visibility' => $ext->get_options( 'partials/visibility' ), // header-stunning-visibility
            'header-stunning-customize'          => array(
                'type'    => 'multi-picker',
                'picker'  => 'header-stunning-visibility',
                'choices' => array(
                    'yes' => array(
                        'header-stunning-customize-content' => array(
                            'type'    => 'multi-picker',
                            'label'   => false,
                            'desc'    => false,
                            'picker'  => array(
                                'customize' => array(
                                    'label'        => esc_html__( 'Customize content', 'crum-ext-stunning-header' ),
                                    'type'         => 'switch',
                                    'value'        => 'no',
                                    'left-choice'  => array(
                                        'value' => 'no',
                                        'label' => esc_html__( 'No', 'crum-ext-stunning-header' ),
                                    ),
                                    'right-choice' => array(
                                        'value' => 'yes',
                                        'label' => esc_html__( 'Yes', 'crum-ext-stunning-header' ),
                                    ),
                                )
                            ),
                            'choices' => array(
                                'yes' => array(
                                    'header-stunning-content-popup' => array(
                                        'type'          => 'popup',
                                        'label'         => esc_html__( 'Custom Content', 'crum-ext-stunning-header' ),
                                        'desc'          => esc_html__( 'Change custom content for this page', 'crum-ext-stunning-header' ),
                                        'button'        => esc_html__( 'Change Content', 'crum-ext-stunning-header' ),
                                        'size'          => 'medium',
                                        'popup-options' => $ext->get_options( 'partials/content' )
                                    ),
                                ),
                            ),
                        ),
                        'header-stunning-customize-styles'  => array(
                            'type'    => 'multi-picker',
                            'label'   => false,
                            'desc'    => false,
                            'picker'  => array(
                                'customize' => array(
                                    'label'        => esc_html__( 'Customize styles', 'crum-ext-stunning-header' ),
                                    'type'         => 'switch',
                                    'value'        => 'no',
                                    'left-choice'  => array(
                                        'value' => 'no',
                                        'label' => esc_html__( 'No', 'crum-ext-stunning-header' ),
                                    ),
                                    'right-choice' => array(
                                        'value' => 'yes',
                                        'label' => esc_html__( 'Yes', 'crum-ext-stunning-header' ),
                                    ),
                                )
                            ),
                            'choices' => array(
                                'yes' => array(
                                    'header-stunning-styles-popup' => array(
                                        'type'          => 'popup',
                                        'label'         => esc_html__( 'Custom Styles', 'crum-ext-stunning-header' ),
                                        'desc'          => esc_html__( 'Change custom styles for this page', 'crum-ext-stunning-header' ),
                                        'button'        => esc_html__( 'Change Styles', 'crum-ext-stunning-header' ),
                                        'size'          => 'medium',
                                        'popup-options' => $ext->get_options( 'partials/styles' )
                                    ),
                                ),
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
);

