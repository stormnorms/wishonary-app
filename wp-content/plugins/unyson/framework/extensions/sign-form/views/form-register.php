<?php
/**
 * @var int    $rand
 * @var string $redirect_to
 * @var string $redirect
 * @var string $forms
 * @var string $login_descr
 */
$ext = fw_ext( 'sign-form' );

$classes   = array( 'content' );
$classes[] = $ext->get_config( 'selectors/formRegister' );
$classes[] = $ext->get_config( 'selectors/form' );
?>
<div class="title h6"><?php esc_html_e( 'Register in', 'crum-ext-sign-form' ); ?>&nbsp;<?php echo get_bloginfo( 'name' ); ?></div>
<form data-handler="<?php echo esc_attr( $ext->get_config( 'actions/signUp' ) ); ?>" name="registerform" class="<?php echo implode( ' ', $classes ); ?>" action="<?php echo esc_url( site_url( 'wp-login.php?action=register&type=internal', 'login_post' ) ); ?>" method="post">

    <input type="hidden" name="redirect_to" value="<?php echo esc_attr( $redirect_to ); ?>" />
    <input type="hidden" name="redirect" value="<?php echo esc_attr( $redirect ); ?>" />

    <input type="hidden" value="<?php echo wp_create_nonce( 'crumina-sign-form' ); ?>" name="_ajax_nonce" />

    <?php do_action( 'logy_before_login_fields' ); ?>

    <ul class="crumina-sign-form-messages"></ul>

    <div class="row">
        <div class="col col-12 col-xl-12 col-lg-12 col-md-12 col-sm-12">
            <div class="form-group label-floating">
                <label class="control-label"><?php esc_html_e( 'First Name', 'crum-ext-sign-form' ); ?></label>
                <input class="form-control" name="first_name" type="text">
            </div>

            <div class="form-group label-floating">
                <label class="control-label"><?php esc_html_e( 'Last Name', 'crum-ext-sign-form' ); ?></label>
                <input class="form-control" name="last_name" type="text">
            </div>

            <div class="form-group label-floating">
                <label class="control-label"><?php esc_html_e( 'Your Login', 'crum-ext-sign-form' ); ?></label>
                <input type="text" name="user_login" class="form-control" size="20" />
            </div>
            
            <div class="form-group label-floating">
                <label class="control-label"><?php esc_html_e( 'Your Email', 'crum-ext-sign-form' ); ?></label>
                <input type="email" name="user_email" class="form-control" size="25" />
            </div>
            
            <div class="form-group label-floating password-eye-wrap">
                <label class="control-label"><?php esc_html_e( 'Your Password', 'crum-ext-sign-form' ); ?></label>
                 <a href="#" class="fa fa-fw fa-eye password-eye" tabindex="-1"></a>
                <input type="password" name="user_password" class="form-control" size="25" />
            </div>
            
            <div class="form-group label-floating password-eye-wrap">
                <label class="control-label"><?php esc_html_e( 'Confirm Password', 'crum-ext-sign-form' ); ?></label>
                 <a href="#" class="fa fa-fw fa-eye password-eye" tabindex="-1"></a>
                <input type="password" name="user_password_confirm" class="form-control" size="25" />
            </div>

            <div class="gdpr form-group">
                <div class="checkbox">
                    <label>
                        <input name="gdpr" type="checkbox">
                        <?php echo $ext::getPrivacyLink(); ?>
                    </label>
                </div>

                <p><?php esc_html_e( 'I allow this website to collect and store submitted data.', 'crum-ext-sign-form' ); ?></p>
            </div>

            <button type="submit" class="btn btn-purple btn-lg full-width">
                <span><?php esc_html_e( 'Complete Registration!', 'crum-ext-sign-form' ); ?></span>
                <span><?php esc_html_e( 'Login', 'crum-ext-sign-form' ); ?></span>
                <span class="icon-loader"></span>
            </button>
        </div>
    </div>
</form>