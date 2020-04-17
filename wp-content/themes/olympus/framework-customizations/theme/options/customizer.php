<?php

if ( !defined( 'FW' ) ) {
	die( 'Forbidden' );
}
/**
 * Customizer options
 *
 * @var array $options Fill this array with options to generate theme style from frontend Customizer
 */
$options = array(
	'panel_typo'		 => array(
		'title'		 => esc_html__( 'Typography', 'olympus' ),
		'options'	 => array(
			fw()->theme->get_options( 'customizer-typography' ),
		),
	),
	'panel_header_top'	 => array(
		'title'		 => esc_html__( 'Top Headers', 'olympus' ),
		'options'	 => array(
			fw()->theme->get_options( 'settings-header-social-styles' ),
			fw()->theme->get_options( 'settings-header-general-styles' ),
			'header_top_sticky' => array(
				'label'		 => esc_html__( 'Sticky social header', 'olympus' ),
				'type'		 => 'radio',
				'value'		 => 'enable-sticky-standard-header',
				'inline'	 => true,
				'choices'	 => array(
					'disable-sticky-both-header'	 => esc_html__( 'Disable both sticky headers', 'olympus' ),
					'enable-sticky-standard-header'	 => esc_html__( 'Enable standard sticky header', 'olympus' ),
					'enable-sticky-social-header'	 => esc_html__( 'Enable social sticky header', 'olympus' ),
				),
			),
		),
	),
	'panel_footer'		 => array(
		'title'		 => esc_html__( 'Footer options', 'olympus' ),
		'options'	 => array(
			fw()->theme->get_options( 'customizer-footer' ),
		),
	),
	'custom_js'			 => array(
		'title'		 => esc_html__( 'Additional JS', 'olympus' ),
		'options'	 => array(
			'custom-js' => array(
				'type'	 => 'textarea',
				'value'	 => '',
				'label'	 => esc_html__( 'JS code field', 'olympus' ),
				'desc'	 => wp_kses( esc_html__( 'without &lt;script&gt; tags', 'olympus' ), array(
					'&lt;'	 => array(),
					'&gt;'	 => array(),
				) ),
				'attr'	 => array(
					'class'			 => 'large-textarea',
					'placeholder'	 => 'jQuery( document ).ready(function() {  SOME CODE  });',
					'rows'			 => 20,
				),
			),
		),
	),
);
