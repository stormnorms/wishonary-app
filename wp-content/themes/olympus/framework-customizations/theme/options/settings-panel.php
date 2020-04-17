<?php

if ( !defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$options = array(
	'panels-option' => array(
		'title'		 => esc_html__( 'Panels', 'olympus' ),
		'type'		 => 'tab',
		'options'	 => array(
			//Header settings
			'top-menu-panel-tab'	 => array(
				'title'		 => esc_html__( 'Top Menu Panel', 'olympus' ),
				'type'		 => 'tab',
				'options'	 => array_merge(
						apply_filters( 'crumina_option_top_menu_panel_visibility', fw()->theme->get_options( 'partial-top-menu-panel-visibility' ) ), fw()->theme->get_options( 'settings-header-general-content' )
				),
			),
			'top-user-panel-tab'	 => array(
				'title'		 => esc_html__( 'Top User Panel', 'olympus' ),
				'type'		 => 'tab',
				'options'	 => array(
					apply_filters( 'crumina_option_top_user_panel_visibility', fw()->theme->get_options( 'partial-top-user-panel-visibility' ) ),
					'top-panel-search'			 => array(
						'label'			 => esc_html__( 'Search', 'olympus' ),
						'desc'			 => esc_html__( 'Enable search.', 'olympus' ),
						'type'			 => 'switch',
						'right-choice'	 => array(
							'value'	 => 'yes',
							'label'	 => esc_html__( 'Enable', 'olympus' ),
						),
						'left-choice'	 => array(
							'value'	 => 'no',
							'label'	 => esc_html__( 'Disable', 'olympus' ),
						),
						'value'			 => 'yes',
					),
					'top-panel-friend-requests'	 => array(
						'label'			 => esc_html__( 'Friend requests', 'olympus' ),
						'desc'			 => esc_html__( 'Enable friend requests. BuddyPress is required!', 'olympus' ),
						'type'			 => 'switch',
						'left-choice'	 => array(
							'value'	 => 'no',
							'label'	 => esc_html__( 'Disable', 'olympus' )
						),
						'right-choice'	 => array(
							'value'	 => 'yes',
							'label'	 => esc_html__( 'Enable', 'olympus' )
						),
						'value'			 => 'yes',
					),
					'top-panel-messages'		 => array(
						'label'			 => esc_html__( 'Messages', 'olympus' ),
						'desc'			 => esc_html__( 'Enable messages. BuddyPress is required!', 'olympus' ),
						'type'			 => 'switch',
						'left-choice'	 => array(
							'value'	 => 'no',
							'label'	 => esc_html__( 'Disable', 'olympus' )
						),
						'right-choice'	 => array(
							'value'	 => 'yes',
							'label'	 => esc_html__( 'Enable', 'olympus' )
						),
						'value'			 => 'yes',
					),
					'top-panel-notifications'	 => array(
						'label'			 => esc_html__( 'Notifications', 'olympus' ),
						'desc'			 => esc_html__( 'Enable notifications. BuddyPress is required!', 'olympus' ),
						'type'			 => 'switch',
						'left-choice'	 => array(
							'value'	 => 'no',
							'label'	 => esc_html__( 'Disable', 'olympus' )
						),
						'right-choice'	 => array(
							'value'	 => 'yes',
							'label'	 => esc_html__( 'Enable', 'olympus' )
						),
						'value'			 => 'yes',
					),
					'top-panel-users-menu'		 => array(
						'label'			 => esc_html__( 'Users menu', 'olympus' ),
						'desc'			 => esc_html__( 'Enable users menu', 'olympus' ),
						'type'			 => 'switch',
						'left-choice'	 => array(
							'value'	 => 'no',
							'label'	 => esc_html__( 'Disable', 'olympus' )
						),
						'right-choice'	 => array(
							'value'	 => 'yes',
							'label'	 => esc_html__( 'Enable', 'olympus' )
						),
						'value'			 => 'yes',
					),
				),
			),
			'left-panel-fixed-tab'	 => apply_filters( 'crumina_option_left_panel_fixed_tab', fw()->theme->get_options( 'partial-left-panel-fixed-tab' ) )
		),
	),
);
