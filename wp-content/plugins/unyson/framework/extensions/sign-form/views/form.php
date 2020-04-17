<?php
/**
 * @var string $redirect_to
 * @var string $redirect
 * @var string $forms
 * @var string $login_descr
 * @var string $vcard_title
 * @var string $vcard_subtitle
 * @var string $vcard_profile_btn
 */
$ext = fw_ext( 'sign-form' );

if ( is_user_logged_in() ) {
	echo $ext->get_view( 'vcard', array(
		'ext'				 => $ext,
		'vcard_title'		 => isset( $vcard_title ) ? $vcard_title : '',
		'vcard_subtitle'	 => isset( $vcard_subtitle ) ? $vcard_subtitle : '',
		'vcard_profile_btn'	 => isset( $vcard_profile_btn ) ? $vcard_profile_btn : '',
	) );
	return;
}

$rand			 = rand( 1000, 9999 );
$can_register	 = get_option( 'users_can_register' );

if ( function_exists( 'bp_current_component' ) ) {
	if ( bp_current_component() === 'register' ) {
		$can_register = 0;
	}
}

$classes	 = array( 'registration-login-form', 'mb-0' );
$classes[]	 = $ext->get_config( 'selectors/formContainer' );
$classes[]	 = "selected-forms-{$forms}";

if ( $forms !== 'both' || !$can_register ) {
	$classes[] = 'selected-forms-single';
}
?>

<div class="<?php echo implode( ' ', $classes ); ?>">
    <!-- Nav tabs -->
	<?php if ( $can_register && $forms === 'both' ) { ?>
		<ul class="nav nav-tabs" role="tablist">
			<li class="nav-item">
				<a class="nav-link" data-toggle="tab" href="#login-panel-<?php echo esc_attr( $rand ); ?>"
				   role="tab">
					<svg class="olymp-login-icon" data-toggle="tooltip" data-placement="top" data-original-title="<?php esc_html_e( 'Login', 'crum-ext-sign-form' ); ?>">
					<use xlink:href="<?php echo get_template_directory_uri(); ?>/images/icons.svg#olymp-login-icon"></use>
					</svg>
					<span class="icon-title"><?php esc_html_e( 'Login', 'crum-ext-sign-form' ); ?></span>
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" data-toggle="tab" href="#register-panel-<?php echo esc_attr( $rand ); ?>"
				   role="tab">
					<svg class="olymp-register-icon" data-toggle="tooltip" data-placement="top" data-original-title="<?php esc_html_e( 'Registration', 'crum-ext-sign-form' ); ?>">
					<use xlink:href="<?php echo get_template_directory_uri(); ?>/images/icons.svg#olymp-register-icon"></use>
					</svg>
					<span class="icon-title"><?php esc_html_e( 'Registration', 'crum-ext-sign-form' ); ?></span>
				</a>
			</li>
		</ul>
	<?php } ?>

    <div class="tab-content">
		<?php if ( ($forms === 'login' || $forms === 'both' ) ) { ?>
			<div class="tab-pane" id="login-panel-<?php echo esc_attr( $rand ); ?>" role="tabpanel">
				<?php
				echo $ext->get_view( 'form-login', array(
					'rand'			 => $rand,
					'login_descr'	 => $login_descr,
					'redirect_to'	 => $redirect_to,
					'redirect'		 => $redirect,
					'forms'			 => $forms,
				) );
				?>
			</div>
		<?php } ?>

		<?php if ( $can_register && ($forms === 'register' || $forms === 'both') ) { ?>
			<div class="tab-pane" id="register-panel-<?php echo esc_attr( $rand ); ?>" role="tabpanel">
				<?php
				echo $ext->get_view( 'form-register', array(
					'rand'			 => $rand,
					'login_descr'	 => $login_descr,
					'redirect_to'	 => $redirect_to,
					'redirect'		 => $redirect,
					'forms'			 => $forms,
				) );
				?>
			</div>
		<?php } ?>
    </div>
</div>