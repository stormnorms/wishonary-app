<?php

if ( !defined( 'FW' ) ) {
    die( 'Forbidden' );
}
$options = array(
    'section_footer_design' => array(
        'title'   => esc_html__( 'Footer Design', 'olympus' ),
        'options' => array(
            'footer_wide_content' => array(
                'type'         => 'switch',
                'value'        => 'container',
                'label'        => esc_html__( 'Wide content?', 'olympus' ),
                'left-choice'  => array(
                    'value' => 'container',
                    'label' => esc_html__( 'No', 'olympus' ),
                ),
                'right-choice' => array(
                    'value' => 'container-fluid',
                    'label' => esc_html__( 'Yes', 'olympus' ),
                ),
            ),
            
            'footer_text_color'   => array(
                'type'  => 'color-picker',
                'label' => esc_html__( 'Text Color', 'olympus' ),
                'help'  => esc_html__( 'Click on field to choose color or clear field for default value', 'olympus' ),
            ),
            'footer_title_color'  => array(
                'type'  => 'color-picker',
                'label' => esc_html__( 'Widget Titles Color', 'olympus' ),
                'help'  => esc_html__( 'Click on field to choose color or clear field for default value', 'olympus' ),
            ),
            'footer_link_color'   => array(
                'type'  => 'color-picker',
                'label' => esc_html__( 'Widget Links Color', 'olympus' ),
                'help'  => esc_html__( 'Click on field to choose color or clear field for default value', 'olympus' ),
            ),
            'footer_bg_color'     => array(
                'type'  => 'color-picker',
                'label' => esc_html__( 'Background Color', 'olympus' ),
                'desc'  => esc_html__( 'If you choose no image to display - that color will be set as background', 'olympus' ),
                'help'  => esc_html__( 'Click on field to choose color or clear field for default value', 'olympus' ),
            ),
            'footer_bg_image'     => array(
                'type'    => 'background-image',
                'label'   => esc_html__( 'Background image', 'olympus' ),
                'desc'    => esc_html__( 'Select one of images or upload your own pattern', 'olympus' ),
                'choices' => false,
            ),
            'footer_bg_cover'     => array(
                'type'  => 'switch',
                'label' => esc_html__( 'Expand background', 'olympus' ),
                'desc'  => esc_html__( 'Don\'t repeat image and expand it to full section background', 'olympus' ),
            ),
        ),
    ),
    'section_scroll_top'    => array(
        'title'   => esc_html__( 'Scroll Top Button', 'olympus' ),
        'options' => array(
            'totop_bg_color'   => array(
                'type'  => 'color-picker',
                'label' => esc_html__( 'Background Color', 'olympus' ),
                'help'  => esc_html__( 'Click on field to choose color or clear field for default value', 'olympus' ),
            ),
            'totop_icon_color' => array(
                'type'  => 'color-picker',
                'label' => esc_html__( 'Icon Color', 'olympus' ),
                'help'  => esc_html__( 'Click on field to choose color or clear field for default value', 'olympus' ),
            ),
        ),
    ),
);


