<?php

if ( !defined( 'FW' ) ) {
	die( 'Forbidden' );
}

class FW_Extension_Sign_Form extends FW_Extension {

	protected function _init() {
		add_shortcode( $this->get_config( 'builderComponent' ), array( $this, 'builderComponent' ) );
		add_shortcode( $this->get_config( 'registerLinkSC' ), array( $this, 'registerLinkSC' ) );
		add_shortcode( $this->get_config( 'currentUserSC' ), array( $this, 'currentUserSC' ) );
	}

	public function builderComponent( $atts ) {
		global $wp;

		$builder_type = isset( $atts[ 'builder_type' ] ) ? $atts[ 'builder_type' ] : '';

		if ( $builder_type !== 'kc' && function_exists( 'vc_map_get_attributes' ) ) {
			$atts = vc_map_get_attributes( $this->get_config( 'builderComponent' ), $atts );
		}

		$atts = self::prepareAtts( shortcode_atts( array(
					'forms'				 => 'both',
					'redirect'			 => 'current',
					'redirect_to'		 => '',
					'login_descr'		 => '',
					'vcard_title'		 => '',
					'vcard_subtitle'	 => '',
					'vcard_profile_btn'	 => '',
								), $atts ) );

		$redirect_to = filter_var( $atts[ 'redirect_to' ], FILTER_VALIDATE_URL );

		if ( $redirect_to && $atts[ 'redirect' ] === 'custom' ) {
			$atts[ 'redirect_to' ] = $redirect_to;
		} else {
			$atts[ 'redirect_to' ] = home_url( $wp->request );
		}

		wp_localize_script( 'sign-form', 'signFormParams', array(
			'nonce'	 => wp_create_nonce( 'sign-form-nonce' ),
			'ext'	 => $this,
			'atts'	 => $atts,
		) );

		return $this->render_view( 'form', $atts );
	}

	public function registerLinkSC( $atts ) {
		$atts = shortcode_atts( array(
			'url'	 => '',
			'text'	 => '',
				), $atts );

		$atts[ 'url' ] = filter_var( $atts[ 'url' ], FILTER_VALIDATE_URL );

		$url	 = $atts[ 'url' ] ? $atts[ 'url' ] : esc_url( wp_registration_url() );
		$text	 = $atts[ 'text' ] ? $atts[ 'text' ] : esc_html__( 'Register Now!', 'crum-ext-sign-form' );

		return "<a href='{$url}'>{$text}</a>";
	}

	public function currentUserSC() {
		$user_ID = get_current_user_id();

		if ( !$user_ID ) {
			return;
		}

		if ( self::useBuddyPress() ) {
			$author_url	 = bp_core_get_user_domain( $user_ID );
			$author_name = bp_activity_get_user_mentionname( $user_ID );
		} else {
			$author_url	 = get_author_posts_url( $user_ID );
			$author_name = wp_get_current_user()->display_name;
		}

		return '<a href="' . esc_url( $author_url ) . '" class="author-name">' . $author_name . '</a>';
	}

	/**
	 * @param string $name View file name (without .php) from <extension>/views directory
	 * @param  array $view_variables Keys will be variables names within view
	 * @param   bool $return In some cases, for memory saving reasons, you can disable the use of output buffering
	 * @return string HTML
	 */
	final public function get_view( $name, $view_variables = array(), $return = true ) {
		$full_path = $this->locate_path( '/views/' . $name . '.php' );

		if ( !$full_path ) {
			trigger_error( 'Extension view not found: ' . $name, E_USER_WARNING );
			return;
		}

		return fw_render_view( $full_path, $view_variables, $return );
	}

	public static function useBuddyPress() {
		if ( function_exists( 'bp_core_get_user_domain' ) && function_exists( 'bp_activity_get_user_mentionname' ) && function_exists( 'bp_attachments_get_attachment' ) && function_exists( 'bp_loggedin_user_domain' ) && function_exists( 'bp_is_active' ) && function_exists( 'bp_get_activity_slug' ) && function_exists( 'bp_is_active' ) && function_exists( 'bp_get_notifications_unread_permalink' ) && function_exists( 'bp_loggedin_user_domain' ) && function_exists( 'bp_get_settings_slug' ) ) {
			return true;
		}

		return false;
	}

	/**
	 * This functions prepares attributes to use in template
	 * Converts back escaped characters
	 *
	 * @param $atts
	 *
	 * @return array
	 */
	public static function prepareAtts( $atts ) {
		$returnAttributes = array();
		if ( is_array( $atts ) ) {
			foreach ( $atts as $key => $val ) {
				$returnAttributes[ $key ] = str_replace( array(
					'`{`',
					'`}`',
					'``',
						), array(
					'[',
					']',
					'"',
						), $val );
			}
		}

		return $returnAttributes;
	}

	public static function signIn() {
//        check_ajax_referer( 'crumina-sign-form' );

		$errors = array();

		$log		 = filter_input( INPUT_POST, 'log' );
		$pwd		 = filter_input( INPUT_POST, 'pwd' );
		$rememberme	 = filter_input( INPUT_POST, 'rememberme' );
		$redirect	 = filter_input( INPUT_POST, 'redirect' );
		$redirect_to = filter_input( INPUT_POST, 'redirect_to', FILTER_VALIDATE_URL );

		if ( !$log ) {
			$errors[ 'log' ] = esc_html__( 'Login is required', 'crum-ext-sign-form' );
		}

		if ( !$pwd ) {
			$errors[ 'pwd' ] = esc_html__( 'Password is required', 'crum-ext-sign-form' );
		}

		if ( !empty( $errors ) ) {
			wp_send_json_error( array(
				'errors' => $errors,
			) );
		}

		$user = wp_signon( array(
			'user_login'	 => $log,
			'user_password'	 => $pwd,
			'remember'		 => $rememberme,
				) );

		if ( is_wp_error( $user ) ) {
			wp_send_json_error( array(
				'message' => $user->get_error_message(),
			) );
		}

		if ( $redirect === 'profile' && function_exists( 'bp_core_get_user_domain' ) ) {
			$redirect_to = bp_core_get_user_domain( $user->ID );
		}

		wp_send_json_success( array(
			'redirect_to' => $redirect_to ? $redirect_to : ''
		) );
	}

	public static function signUp() {
//        check_ajax_referer( 'crumina-sign-form' );

		$errors = array();

		$user_login	 = filter_input( INPUT_POST, 'user_login' );
		$user_email	 = filter_input( INPUT_POST, 'user_email', FILTER_VALIDATE_EMAIL );
		$first_name	 = filter_input( INPUT_POST, 'first_name' );
		$last_name	 = filter_input( INPUT_POST, 'last_name' );
		$redirect_to = filter_input( INPUT_POST, 'redirect_to', FILTER_VALIDATE_URL );
		$redirect	 = filter_input( INPUT_POST, 'redirect' );
		$gdpr		 = filter_input( INPUT_POST, 'gdpr' );

		$user_password			 = trim( filter_input( INPUT_POST, 'user_password' ) );
		$user_password_confirm	 = filter_input( INPUT_POST, 'user_password_confirm' );

		if ( !$user_login ) {
			$errors[ 'user_login' ] = esc_html__( 'Login is required', 'crum-ext-sign-form' );
		}

		if ( !$user_email ) {
			$errors[ 'user_email' ] = esc_html__( 'Email is required', 'crum-ext-sign-form' );
		}

		if ( !$first_name ) {
			$errors[ 'first_name' ] = esc_html__( 'First name is required', 'crum-ext-sign-form' );
		}

		if ( !$last_name ) {
			$errors[ 'last_name' ] = esc_html__( 'Last name is required', 'crum-ext-sign-form' );
		}

		if ( strlen( $user_password ) < 6 ) {
			$errors[ 'user_password' ] = esc_html__( 'Minimum password length is 6 characters', 'crum-ext-sign-form' );
		} else if ( $user_password !== $user_password_confirm ) {
			$errors[ 'user_password_confirm' ] = esc_html__( 'Password and confirm password does not match', 'crum-ext-sign-form' );
		}

		if ( !$gdpr ) {
			$errors[ 'gdpr' ] = esc_html__( 'Please, accept privacy policy', 'crum-ext-sign-form' );
		}

		if ( !empty( $errors ) ) {
			wp_send_json_error( array(
				'errors' => $errors,
			) );
		}

		$user_id = self::register_new_user( $user_login, $user_email, $user_password );

		if ( is_wp_error( $user_id ) ) {
			wp_send_json_error( array(
				'message' => $user_id->get_error_message(),
			) );
		}

		// Authorize user
		wp_set_auth_cookie( $user_id, true );

		if ( $redirect === 'profile' && function_exists( 'bp_core_get_user_domain' ) ) {
			$redirect_to = bp_core_get_user_domain( $user_id );
		}

		wp_send_json_success( array(
			'redirect_to' => $redirect_to ? $redirect_to : ''
		) );
	}

	/**
	 * Handles registering a new user.
	 *
	 * @param string $user_login User's username for logging in
	 * @param string $user_email User's email address to send password and add
	 * @param string $user_pass User's email address to send password and add
	 * @return int|WP_Error Either user's ID or error on failure.
	 */
	public static function register_new_user( $user_login, $user_email, $user_pass ) {
		$errors = new WP_Error();

		$sanitized_user_login	 = sanitize_user( $user_login );
		/**
		 * Filters the email address of a user being registered.
		 *
		 * @since 2.1.0
		 *
		 * @param string $user_email The email address of the new user.
		 */
		$user_email				 = apply_filters( 'user_registration_email', $user_email );

		// Check the username
		if ( $sanitized_user_login === '' ) {
			$errors->add( 'empty_username', __( '<strong>ERROR</strong>: Please enter a username.' ) );
		} elseif ( !validate_username( $user_login ) ) {
			$errors->add( 'invalid_username', __( '<strong>ERROR</strong>: This username is invalid because it uses illegal characters. Please enter a valid username.' ) );
			$sanitized_user_login = '';
		} elseif ( username_exists( $sanitized_user_login ) ) {
			$errors->add( 'username_exists', __( '<strong>ERROR</strong>: This username is already registered. Please choose another one.' ) );
		} else {
			/** This filter is documented in wp-includes/user.php */
			$illegal_user_logins = array_map( 'strtolower', (array) apply_filters( 'illegal_user_logins', array() ) );
			if ( in_array( strtolower( $sanitized_user_login ), $illegal_user_logins ) ) {
				$errors->add( 'invalid_username', __( '<strong>ERROR</strong>: Sorry, that username is not allowed.' ) );
			}
		}

		// Check the email address
		if ( $user_email === '' ) {
			$errors->add( 'empty_email', __( '<strong>ERROR</strong>: Please type your email address.' ) );
		} elseif ( !is_email( $user_email ) ) {
			$errors->add( 'invalid_email', __( '<strong>ERROR</strong>: The email address isn&#8217;t correct.' ) );
			$user_email = '';
		} elseif ( email_exists( $user_email ) ) {
			$errors->add( 'email_exists', __( '<strong>ERROR</strong>: This email is already registered, please choose another one.' ) );
		}

		// Check the password
		if ( $user_pass === '' ) {
			$errors->add( 'empty_pass', __( '<strong>ERROR</strong>: Please type your password.' ) );
		} elseif ( strlen( $user_pass ) < 6 ) {
			$errors->add( 'invalid_pass', __( '<strong>ERROR</strong>: The minimum password length is 6 characters.' ) );
		}

		/**
		 * Fires when submitting registration form data, before the user is created.
		 *
		 * @since 2.1.0
		 *
		 * @param string   $sanitized_user_login The submitted username after being sanitized.
		 * @param string   $user_email           The submitted email.
		 * @param WP_Error $errors               Contains any errors with submitted username and email,
		 *                                       e.g., an empty field, an invalid username or email,
		 *                                       or an existing username or email.
		 */
		do_action( 'register_post', $sanitized_user_login, $user_email, $errors );

		/**
		 * Filters the errors encountered when a new user is being registered.
		 *
		 * The filtered WP_Error object may, for example, contain errors for an invalid
		 * or existing username or email address. A WP_Error object should always returned,
		 * but may or may not contain errors.
		 *
		 * If any errors are present in $errors, this will abort the user's registration.
		 *
		 * @since 2.1.0
		 *
		 * @param WP_Error $errors               A WP_Error object containing any errors encountered
		 *                                       during registration.
		 * @param string   $sanitized_user_login User's username after it has been sanitized.
		 * @param string   $user_email           User's email.
		 */
		$errors = apply_filters( 'registration_errors', $errors, $sanitized_user_login, $user_email );

		if ( $errors->has_errors() ) {
			return $errors;
		}

		$user_id = wp_create_user( $sanitized_user_login, $user_pass, $user_email );
		if ( !$user_id || is_wp_error( $user_id ) ) {
			$errors->add( 'registerfail', sprintf( __( '<strong>ERROR</strong>: Couldn&#8217;t register you&hellip; please contact the <a href="mailto:%s">webmaster</a> !' ), get_option( 'admin_email' ) ) );
			return $errors;
		}

		update_user_option( $user_id, 'default_password_nag', true, true ); //Set up the Password change nag.

		/**
		 * Fires after a new user registration has been recorded.
		 *
		 * @since 4.4.0
		 *
		 * @param int $user_id ID of the newly registered user.
		 */
		do_action( 'register_new_user', $user_id );

		return $user_id;
	}

	public static function getPrivacyLink() {

		$privacy_policy_page_link = get_privacy_policy_url();

		if ( $privacy_policy_page_link ) {
			return sprintf( '%s <a href="%s" target="_blank">%s</a>', esc_html__( 'Accept', 'crum-ext-sign-form' ), esc_url( $privacy_policy_page_link ), esc_html__( 'Privacy Policy', 'crum-ext-sign-form' ) );

		}

		return esc_html__( 'Accept Privacy Policy', 'crum-ext-sign-form' );
	}

	public static function kc_mapping() {
		$builderComponent = fw_ext( 'sign-form' )->get_config( 'builderComponent' );

		if ( function_exists( 'kc_add_map' ) ) {
			kc_add_map( array(
				$builderComponent => array(
					'name'		 => esc_html__( 'Sign in Form', 'crum-ext-sign-form' ),
					'category'	 => esc_html__( 'Crumina', 'crum-ext-sign-form' ),
					'icon'		 => 'kc-sign-form-icon',
					'params'	 => array(
						array(
							'type'	 => 'hidden',
							'name'	 => 'builder_type',
							'value'	 => 'kc'
						)
					)
				)
			) );
		}
	}

	public static function vc_mapping() {
		$ext				 = fw_ext( 'sign-form' );
		$builderComponent	 = $ext->get_config( 'builderComponent' );

		if ( function_exists( 'vc_map' ) ) {
			vc_map( array(
				'base'		 => $builderComponent,
				'name'		 => esc_html__( 'Sign in Form', 'sign-form' ),
				'category'	 => esc_html__( 'Crumina', 'sign-form' ),
				'icon'		 => $ext->locate_URI( '/static/img/builder-ico.svg' ),
				'params'	 => array(
					array(
						'heading'	 => esc_html__( 'Display', 'crum-ext-sign-form' ),
						'param_name' => 'forms',
						'type'		 => 'dropdown',
						'value'		 => array(
							esc_html__( 'Both', 'crum-ext-sign-form' )		 => 'both',
							esc_html__( 'Login', 'crum-ext-sign-form' )		 => 'login',
							esc_html__( 'Register', 'crum-ext-sign-form' )	 => 'register',
						),
						'std'		 => 'both',
						'group'		 => esc_html__( 'General', 'crum-ext-sign-form' ),
					),
					array(
						'heading'	 => esc_html__( 'Redirect to', 'crum-ext-sign-form' ),
						'param_name' => 'redirect',
						'type'		 => 'dropdown',
						'value'		 => array(
							esc_html__( 'Current page', 'crum-ext-sign-form' )	 => 'current',
							esc_html__( 'Profile page', 'crum-ext-sign-form' )	 => 'profile',
							esc_html__( 'Custom page', 'crum-ext-sign-form' )	 => 'custom',
						),
						'std'		 => 'current',
						'group'		 => esc_html__( 'General', 'crum-ext-sign-form' ),
					),
					array(
						'heading'	 => esc_html__( 'Redirect URL', 'crum-ext-sign-form' ),
						'param_name' => 'redirect_to',
						'type'		 => 'textfield',
						'dependency' => array(
							'element'	 => 'redirect',
							'value'		 => 'custom',
						),
						'group'		 => esc_html__( 'General', 'crum-ext-sign-form' ),
					),
					array(
						'heading'		 => esc_html__( 'vCard title', 'crum-ext-sign-form' ),
						'param_name'	 => 'vcard_title',
						'type'			 => 'textfield',
						'description'	 => sprintf( esc_html__( 'You can use [%s] shortcode', 'crum-ext-sign-form' ), $ext->get_config( 'currentUserSC' ) ),
						'group'			 => esc_html__( 'Strings Options', 'crum-ext-sign-form' ),
					),
					array(
						'heading'	 => esc_html__( 'vCard subtitle', 'crum-ext-sign-form' ),
						'param_name' => 'vcard_subtitle',
						'type'		 => 'textfield',
						'group'		 => esc_html__( 'Strings Options', 'crum-ext-sign-form' ),
					),
					array(
						'heading'	 => esc_html__( 'vCard profile button', 'crum-ext-sign-form' ),
						'param_name' => 'vcard_profile_btn',
						'type'		 => 'textfield',
						'group'		 => esc_html__( 'Strings Options', 'crum-ext-sign-form' ),
					),
					array(
						'heading'		 => esc_html__( 'Login form description', 'crum-ext-sign-form' ),
						'param_name'	 => 'login_descr',
						'type'			 => 'textarea',
						'description'	 => sprintf( esc_html__( 'You can use [%s text="" url=""] shortcode', 'crum-ext-sign-form' ), $ext->get_config( 'registerLinkSC' ) ),
						'dependency'	 => array(
							'element'	 => 'forms',
							'value'		 => array( 'both', 'login' ),
						),
						'group'			 => esc_html__( 'Strings Options', 'crum-ext-sign-form' ),
					),
					array(
						'type'		 => 'hidden',
						'param_name' => 'builder_type',
						'value'		 => 'vc',
						'group'		 => esc_html__( 'General', 'crum-ext-sign-form' ),
					)
				)
			) );
		}
	}

	public static function prepareMmIconPrm( $meta = '' ) {
		$parsed = (array) json_decode( urldecode( $meta ) );

		if ( $meta && !$parsed ) {
			$parsed = array(
				'type'		 => 'icon-font',
				'icon-class' => $meta
			);
		}

		return array_merge( array(
			'type'			 => '',
			'icon-class'	 => '',
			'attachment-id'	 => '',
			'url'			 => ''
				), $parsed );
	}

	public static function embedCustomSvg( $svg_url, $extra_class = '', $atts = '' ) {

		$svg_url = str_replace( 'https://', 'http://', $svg_url );


		$svg_file = wp_remote_get( esc_url_raw( $svg_url ) );
		if ( is_wp_error( $svg_file ) ) {
			$svg_file = '';
		} else {
			$response_code = wp_remote_retrieve_response_code( $svg_file );
			if ( 200 === $response_code ) {
				$svg_file = wp_remote_retrieve_body( $svg_file );
			}
		}

		if ( !is_string( $svg_file ) ) {
			$svg_file = '';
		}

		$svg_file_new	 = '';
		$find_string	 = '<svg';

// Remove dimensions
		$svg_file = preg_replace( "/(width|height)=\".*?\"/", "", $svg_file );

// Add class if needed
		$svg_file = str_replace( $find_string, $find_string . ' class="' . esc_attr( $extra_class ) . '" ', $svg_file );

// Add atts if needed
		$svg_file = str_replace( $find_string, $find_string . ' ' . $atts, $svg_file );

		$position		 = strpos( $svg_file, $find_string );
		$svg_file_new	 = substr( $svg_file, $position );

		return $svg_file_new;
	}

}
