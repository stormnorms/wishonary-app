<?php

if ( !defined( 'FW' ) ) {
    die( 'Forbidden' );
}

$options = apply_filters( 'crumina_section_single_post_elements', array(
    'single_featured_show' => array(
        'label'        => esc_html__( 'Featured media', 'olympus' ),
        'desc'         => esc_html__( 'Featured image or other media on top of post', 'olympus' ),
        'type'         => 'switch',
        'left-choice' => array(
	        'value' => 'no',
	        'label' => esc_html__( 'Disable', 'olympus' )
        ),
        'right-choice'  => array(
            'value' => 'yes',
            'label' => esc_html__( 'Enable', 'olympus' )
        ),
        'value'        => 'yes',
    ),
    'single_meta_show'     => array(
        'label'        => esc_html__( 'Post meta', 'olympus' ),
        'desc'         => esc_html__( 'Post time, post author, etc', 'olympus' ),
        'type'         => 'switch',
        'left-choice' => array(
	        'value' => 'no',
	        'label' => esc_html__( 'Disable', 'olympus' )
        ),
        'right-choice'  => array(
	        'value' => 'yes',
	        'label' => esc_html__( 'Enable', 'olympus' )
        ),
        'value'        => 'yes',
    ),
    'single_share_show'    => array(
        'label'        => esc_html__( 'Share post buttons?', 'olympus' ),
        'desc'         => esc_html__( 'Show icons that share post on social networks', 'olympus' ),
        'type'         => 'switch',
        'left-choice' => array(
	        'value' => 'no',
	        'label' => esc_html__( 'Disable', 'olympus' )
        ),
        'right-choice'  => array(
	        'value' => 'yes',
	        'label' => esc_html__( 'Enable', 'olympus' )
        ),
        'value'        => 'yes',
    ),
    'single_related_show'  => array(
        'type'    => 'multi-picker',
        'label'   => false,
        'desc'    => false,
        'picker'  => array(
            'show' => array(
                'label'        => esc_html__( 'Related posts section', 'olympus' ),
                'type'         => 'switch',
                'left-choice' => array(
	                'value' => 'no',
	                'label' => esc_html__( 'Disable', 'olympus' )
                ),
                'right-choice'  => array(
	                'value' => 'yes',
	                'label' => esc_html__( 'Enable', 'olympus' )
                ),
                'value'        => 'yes',
            ),
        ),
        'choices' => array(
            'yes' => array(
                'meta'    => array(
                    'label'        => esc_html__( 'Post meta (In related item)', 'olympus' ),
                    'desc'         => esc_html__( 'Post time, post author, etc', 'olympus' ),
                    'type'         => 'switch',
                    'left-choice' => array(
	                    'value' => 'no',
	                    'label' => esc_html__( 'Disable', 'olympus' )
                    ),
                    'right-choice'  => array(
	                    'value' => 'yes',
	                    'label' => esc_html__( 'Enable', 'olympus' )
                    ),
                    'value'        => 'yes',
                ),
                'excerpt' => array(
                    'label'        => esc_html__( 'Post excerpt (In related item)', 'olympus' ),
                    'desc'         => esc_html__( 'Short post description', 'olympus' ),
                    'type'         => 'switch',
                    'left-choice' => array(
	                    'value' => 'no',
	                    'label' => esc_html__( 'Disable', 'olympus' )
                    ),
                    'right-choice'  => array(
	                    'value' => 'yes',
	                    'label' => esc_html__( 'Enable', 'olympus' )
                    ),
                    'value'        => 'yes',
                ),
            ),
        ),
    ),
) );
