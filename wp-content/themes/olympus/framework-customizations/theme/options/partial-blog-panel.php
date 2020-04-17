<?php

if ( !defined( 'FW' ) ) {
    die( 'Forbidden' );
}

$options = apply_filters( 'crumina_option_blog_sort_panel', array(
    'blog_sort_panel' => array(
        'type'         => 'multi-picker',
        'label'        => false,
        'desc'         => false,
        'picker'       => array(
            'type' => array(
                'label'   => esc_html__( 'Blog posts sorting panel', 'olympus' ),
                'desc'    => esc_html__( 'Panel with sorting and search functions', 'olympus' ),
                'type'    => 'radio',
                'value'   => 'hide',
                'choices' => array(
                    'hide'       => esc_html__( 'Hide', 'olympus' ),
                    'panel-cats' => esc_html__( 'Categories', 'olympus' ),
                ),
            ),
        ),
        'show_borders' => false,
    ),
) );
