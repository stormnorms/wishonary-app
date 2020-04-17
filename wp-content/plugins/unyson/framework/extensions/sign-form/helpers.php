<?php

if ( !defined( 'FW' ) ) {
    return;
}

/**
 * Generate html markup for registration form.
 *
 * @param $redirect_to string Redirect URL
 */
function crumina_get_reg_form_html( $redirect_to_custom = '' ) {
    global $wp;
    $ext = fw_ext( 'sign-form' );

    $forms              = fw_get_db_settings_option( 'sign-form-forms', 'both' );
    $redirect           = fw_get_db_settings_option( 'sign-form-redirect', 'current' );
    $redirect_to        = filter_var( fw_get_db_settings_option( 'sign-form-redirect-to/custom/redirect_to', '' ), FILTER_VALIDATE_URL );
    $login_descr        = fw_get_db_settings_option( 'sign-form-login-descr', '' );
    $redirect_to_custom = filter_var( $redirect_to_custom, FILTER_VALIDATE_URL );

    $redirect_to = ($redirect_to && $redirect === 'custom') ? $redirect_to : home_url( $wp->request );

    if ( $redirect_to_custom ) {
        $redirect_to = $redirect_to_custom;
    }

    return $ext->get_view( 'form', array(
                'redirect_to' => $redirect_to,
                'forms'       => $forms,
                'redirect'    => $redirect,
                'login_descr' => $login_descr,
            ) );
}
