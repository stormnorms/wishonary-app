<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link    https://pluginsware.com
 * @since   1.0.0
 *
 * @package Advanced_Classifieds_And_Directory_Pro
 */

// Exit if accessed directly
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * ACADP_Admin Class.
 *
 * @since 1.0.0
 */
class ACADP_Admin {

	/**
	 * Check and update plugin options to the latest version.
	 *
	 * @since 1.5.6
	 */
	public function manage_upgrades() {
		if ( ACADP_VERSION_NUM !== get_option( 'acadp_version' ) ) {
			$general_settings = get_option( 'acadp_general_settings' );
			$email_settings   = get_option( 'acadp_email_settings' );
			$page_settings    = get_option( 'acadp_page_settings' );

			// Update general settings
			if ( version_compare( ACADP_VERSION_NUM, '1.7.3', '<=' ) ) {
				$is_update_found = 0;

				if ( ! array_key_exists( 'show_phone_number_publicly', $general_settings ) ) {									
					$general_settings['show_phone_number_publicly'] = 1;
					$is_update_found = 1;
				}

				if ( ! array_key_exists( 'show_email_address_publicly', $general_settings ) ) {					
					$general_settings['show_email_address_publicly'] = ! empty( $email_settings['show_email_address_publicly'] ) ? 1 : 0;
					$is_update_found = 1;
				}			

				if ( $is_update_found ) {
					update_option( 'acadp_general_settings', $general_settings );
				}
			}

			// Update page settings			
			if ( ! array_key_exists( 'login_form', $page_settings ) ) {			
				$pages = acadp_insert_custom_pages();
				update_option( 'acadp_page_settings', $pages );				
			}
			
			// Update plugin version
			update_option( 'acadp_version', ACADP_VERSION_NUM );		
		}
	}
	
	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since 1.0.0
	 */
	public function enqueue_styles() {
		wp_enqueue_style( 'wp-color-picker' );

		wp_enqueue_style( 
			ACADP_PLUGIN_NAME, 
			ACADP_PLUGIN_URL . 'admin/css/acadp-admin.css', 
			array(), 
			ACADP_VERSION_NUM, 
			'all' 
		);
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since 1.0.0
	 */
	public function enqueue_scripts() {
		$map_settings = get_option( 'acadp_map_settings' );
		$screen = get_current_screen();	
		
		wp_enqueue_media();	
		wp_enqueue_script( 'wp-color-picker' );	
			
		if ( 'acadp_listings' == $screen->post_type ) {
			$map_api_key = ! empty( $map_settings['api_key'] ) ? '&key=' . $map_settings['api_key'] : '';

			wp_enqueue_script( 
				ACADP_PLUGIN_NAME . '-google-map', 
				'https://maps.googleapis.com/maps/api/js?v=3.exp' . $map_api_key 
			);
		}
		
		wp_enqueue_script( 
			ACADP_PLUGIN_NAME, 
			ACADP_PLUGIN_URL . 'admin/js/acadp-admin.js', 
			array( 'jquery' ), 
			ACADP_VERSION_NUM, 
			false 
		);
		
		wp_localize_script( 
			ACADP_PLUGIN_NAME, 
			'acadp', 
			array(
				'ajax_nonce'         => wp_create_nonce( 'acadp_ajax_nonce' ),
				'edit'               => __( 'Edit', 'advanced-classifieds-and-directory-pro' ),
				'delete_permanently' => __( 'Delete Permanently', 'advanced-classifieds-and-directory-pro' ),
				'zoom_level'         => $map_settings['zoom_level'],
				'i18n'               => array(
					'no_issues_slected' => __( 'Please select at least one issue.', 'advanced-classifieds-and-directory-pro' )
				)
			)
		);
	}	

	/**
	 * Manage form submissions.
	 *
	 * @since 1.7.3
	 */
	public function admin_init() {
		if ( 'POST' == $_SERVER['REQUEST_METHOD'] && ! empty( $_POST['issues'] ) && isset( $_POST['acadp_fix_issues_nonce'] ) ) {
			// Verify that the nonce is valid
    		if ( wp_verify_nonce( $_POST['acadp_fix_issues_nonce'], 'acadp_fix_issues' ) ) {
				$redirect_url = admin_url( 'admin.php?page=advanced-classifieds-and-directory-pro&tab=issues' );

				// Fix Issues
				if ( __( 'Apply Fix', 'advanced-classifieds-and-directory-pro' ) == $_POST['action']) {
					$this->fix_issues();

					$redirect_url = add_query_arg( 
						array( 
							'section' => 'found',
							'success' => 1
						), 
						$redirect_url 
					);
				}

				// Ignore Issues
				if ( __( 'Ignore', 'advanced-classifieds-and-directory-pro' ) == $_POST['action']) {
					$this->ignore_issues();

					$redirect_url = add_query_arg( 
						array( 
							'section' => 'ignored',
							'success' => 1
						), 
						$redirect_url 
					);
				}

				// Redirect
				wp_redirect( $redirect_url );
        		exit;
			}
		}		
	}
	
	/**
	 * Add plugin menu.
	 *
	 * @since 1.7.3
	 */
	public function admin_menu() {	
		add_menu_page(
            __( 'Advanced Classifieds and Directory Pro', 'advanced-classifieds-and-directory-pro' ),
            __( 'Classifieds & Directory', 'advanced-classifieds-and-directory-pro' ),
            'edit_others_acadp_listings',
            'advanced-classifieds-and-directory-pro',
            array( $this, 'display_dashboard_content' ),
            'dashicons-welcome-widgets-menus',
            5
		);	
		
		add_submenu_page(
			'advanced-classifieds-and-directory-pro',
			__( 'Advanced Classifieds and Directory Pro - Dashboard', 'advanced-classifieds-and-directory-pro' ),
			__( 'Dashboard', 'advanced-classifieds-and-directory-pro' ),
			'edit_others_acadp_listings',
			'advanced-classifieds-and-directory-pro',
			array( $this, 'display_dashboard_content' )
		);
	}

	/**
	 * Display dashboard page content.
	 *
	 * @since 1.7.3
	 */
	public function display_dashboard_content() {
		$general_settings = get_option( 'acadp_general_settings' );

		// Tabs
		$tabs = array(
			'getting-started'   => __( 'Getting Started', 'advanced-classifieds-and-directory-pro' ),
			'shortcode-builder' => __( 'Shortcode Builder', 'advanced-classifieds-and-directory-pro' ),
			'faq'               => __( 'FAQ', 'advanced-classifieds-and-directory-pro' )
		);		

		$active_tab = isset( $_GET['tab'] ) ? sanitize_text_field( $_GET['tab'] ) : 'getting-started';

		// Issues
		$issues = $this->check_issues();

		if ( count( $issues['found'] ) || 'issues' == $active_tab  ) {
			$tabs['issues'] = __( 'Issues Detected', 'advanced-classifieds-and-directory-pro' );
		}		

		require_once ACADP_PLUGIN_DIR . 'admin/partials/dashboard/dashboard.php';	
	}

	/**
	 * Check for new issues and return it.
	 *
	 * @since  1.7.3
	 * @return array $issues Array of detected issues.
	 */
	public function check_issues() {
		$issues = array(
			'found'   => array(),
			'ignored' => array()
		);

		$_issues = get_option( 'acadp_issues', $issues );
		$ignored = $_issues['ignored'];		

		// Check: users_cannot_register
		if ( ! get_option( 'users_can_register' ) ) { // If user registration disabled
			if ( in_array( 'users_cannot_register', $ignored ) ) { // If issue ignored by the admin
				$issues['ignored'][] = 'users_cannot_register';
			} else {
				$issues['found'][] = 'users_cannot_register';
			}
		}

		// Check: pages_misconfigured
		$page_settings = get_option( 'acadp_page_settings' );
		$pages = acadp_get_custom_pages_list();

		foreach ( $pages as $key => $page ) {
			$post_id = $page_settings[ $key ];

			$issue_detected = 0;

			if ( $post_id > 0 ) {
				$post = get_post( $post_id );

				if ( empty( $post ) || 'publish' != $post->post_status ) {
					$issue_detected = 1;
				} elseif ( ! empty( $pages[ $key ]['content'] ) && false === strpos( $post->post_content, $pages[ $key ]['content'] ) ) {
					$issue_detected = 1;				
				}
			} else {
				$issue_detected = 1;
			}

			if ( $issue_detected ) {
				if ( in_array( 'pages_misconfigured', $ignored ) ) {
					$issues['ignored'][] = 'pages_misconfigured';
				} else {
					$issues['found'][] = 'pages_misconfigured';
				}

				break;
			}			
		}		

		// Update
		update_option( 'acadp_issues', $issues );

		// Return
		return $issues;
	}	

	/**
	 * Apply fixes.
	 *
	 * @since 1.7.3
	 */
	public function fix_issues() {		
		$fixed = array();

		// Apply the fixes
		$_issues = acadp_sanitize_array( $_POST['issues'] );

		foreach ( $_issues as $issue ) {
			switch ( $issue ) {
				case 'users_cannot_register':					
					update_option( 'users_can_register', 1 );

					$fixed[] = $issue;
					break;
				case 'pages_misconfigured':	
					global $wpdb;

					$page_settings = get_option( 'acadp_page_settings' );

					$pages = acadp_get_custom_pages_list();
					$issue_detected = 0;

					foreach ( $pages as $key => $page ) {
						$post_id = $page_settings[ $key ];			
			
						if ( $post_id > 0 ) {
							$post = get_post( $post_id );
			
							if ( empty( $post ) || 'publish' != $post->post_status ) {
								$issue_detected = 1;
							} elseif ( ! empty( $pages[ $key ]['content'] ) && false === strpos( $post->post_content, $pages[ $key ]['content'] ) ) {
								$issue_detected = 1;		
							}
						} else {
							$issue_detected = 1;
						}	
						
						if ( $issue_detected ) {
							$insert_id = 0;

							if ( ! empty( $pages[ $key ]['content'] ) ) {
								$query = $wpdb->prepare(
									"SELECT ID FROM {$wpdb->posts} WHERE `post_content` LIKE %s",
									sanitize_text_field( $pages[ $key ]['content'] )
								);

								$ids = $wpdb->get_col( $query );
							} else {
								$ids = array();
							}

							if ( ! empty( $ids ) ) {
								$insert_id = $ids[0];

								if ( 'publish' != get_post_status( $insert_id ) ) {
									wp_update_post(
										array(
											'ID'          => $insert_id,
											'post_status' => 'publish'
										)
									);
								}
							} else {
								$insert_id = wp_insert_post(
									array(
										'post_title'     => $pages[ $key ]['title'],
										'post_content'   => $pages[ $key ]['content'],
										'post_status'    => 'publish',
										'post_author'    => 1,
										'post_type'      => 'page',
										'comment_status' => 'closed'
									)
								);
							}

							$page_settings[ $key ] = $insert_id;
						}
					}

					update_option( 'acadp_page_settings', $page_settings );

					$fixed[] = $issue;
					break;
			}
		}

		// Update
		$issues = get_option( 'acadp_issues', array(
			'found'   => array(),
			'ignored' => array()
		));

		foreach ( $issues['found'] as $index => $issue ) {
			if ( in_array( $issue, $fixed ) ) {
				unset( $issues['found'][ $index ] );
			}
		}

		foreach ( $issues['ignored'] as $index => $issue ) {
			if ( in_array( $issue, $fixed ) ) {
				unset( $issues['ignored'][ $index ] );
			}
		}

		update_option( 'acadp_issues', $issues );
	}

	/**
	 * Ignore issues.
	 *
	 * @since 1.7.3
	 */
	public function ignore_issues() {
		$ignored = array();

		// Ignore the issues
		$_issues = acadp_sanitize_array( $_POST['issues'] );		

		foreach ( $_issues as $issue ) {
			switch ( $issue ) {
				case 'users_cannot_register':					
				case 'pages_misconfigured':					
					$ignored[] = $issue;
					break;
			}
		}

		// Update
		$issues = get_option( 'acadp_issues', array(
			'found'   => array(),
			'ignored' => array()
		));

		foreach ( $issues['found'] as $index => $issue ) {
			if ( in_array( $issue, $ignored ) ) {
				unset( $issues['found'][ $index ] );
			}
		}

		$issues['ignored'] = array_merge( $issues['ignored'], $ignored );

		update_option( 'acadp_issues', $issues );
	}	

	/**
	 * Get details of the given issue.
	 *
	 * @since  1.7.3
	 * @param  string $issue Issue code.
	 * @return array         Issue details.
	 */
	public function get_issue_details( $issue ) {
		$issues = array(
			'users_cannot_register' => array(
				'title'       => __( 'User Account Registration Disabled', 'advanced-classifieds-and-directory-pro' ),
				'description' => __( 'User account registration is disabled on your website. You must enable this option to allow new users to register on your website and submit their listings through your site front-end.', 'advanced-classifieds-and-directory-pro' )
			),
			'pages_misconfigured' => array(
				'title'       => __( 'Pages Misconfigured', 'advanced-classifieds-and-directory-pro' ),
				'description' => sprintf(
					__( 'During activation, our plugin adds few <a href="%s" target="_blank">pages</a> dynamically on your website that are required for the internal logic of the plugin. We found some of those pages are missing, misconfigured or having a wrong shortcode.', 'advanced-classifieds-and-directory-pro' ),
					esc_url( admin_url( 'admin.php?page=acadp_settings&tab=misc&section=acadp_pages_settings' ) )
				)
			)
		);
	
		return isset( $issues[ $issue ] ) ? $issues[ $issue ] : '';
	}	
	
	/**
	 * Delete an attachment.
	 *
	 * @since 1.5.4
	 */
	public function ajax_callback_delete_attachment() {	
		check_ajax_referer( 'acadp_ajax_nonce', 'security' );

		if ( isset( $_POST['attachment_id'] ) ) {
			wp_delete_attachment( (int) $_POST['attachment_id'], true );
		}
		
		wp_die();	
	}

}
