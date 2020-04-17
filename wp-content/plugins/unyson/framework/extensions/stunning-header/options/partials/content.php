<?php

if ( !defined( 'FW' ) ) {
    die( 'Forbidden' );
}

$ext = fw_ext( 'stunning-header' );

$options = apply_filters( 'crumina_options_stunning_header_content', array(
    'stunning_title_show'       => array(
        'type'         => 'multi-picker',
        'label'        => false,
        'desc'         => false,
        'picker'       => array(
            'show' => array(
                'label'        => esc_html__( 'Show title', 'crum-ext-stunning-header' ),
                'type'         => 'switch',
                'value'        => 'yes',
                'left-choice'  => array(
                    'value' => 'no',
                    'label' => esc_html__( 'No', 'crum-ext-stunning-header' ),
                ),
                'right-choice' => array(
                    'value' => 'yes',
                    'label' => esc_html__( 'Yes', 'crum-ext-stunning-header' ),
                ),
            ),
        ),
        'choices'      => array(
            'yes' => array(
                'title' => array(
                    'type'  => 'text',
                    'value' => '',
                    'label' => esc_html__( 'Custom title text', 'crum-ext-stunning-header' ),
                    'desc'  => esc_html__( 'Show post title, if that empty', 'crum-ext-stunning-header' ),
                ),
            ),
        ),
        'show_borders' => false,
    ),
    'stunning_breadcrumbs_show' => array(
        'label'        => esc_html__( 'Show breadcrumbs', 'crum-ext-stunning-header' ),
        'type'         => 'switch',
        'value'        => 'yes',
        'left-choice'  => array(
            'value' => 'no',
            'label' => esc_html__( 'No', 'crum-ext-stunning-header' ),
        ),
        'right-choice' => array(
            'value' => 'yes',
            'label' => esc_html__( 'Yes', 'crum-ext-stunning-header' ),
        ),
    ),
    'stunning_text'             => array(
        'type'  => 'textarea',
        'label' => esc_html__( 'Text', 'crum-ext-stunning-header' ),
        'desc'  => esc_html__( 'This text will be displayed under the heading', 'crum-ext-stunning-header' ),
    ),
        ) );
