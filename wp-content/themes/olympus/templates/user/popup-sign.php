<div class="modal fade" id="registration-login-form-popup" tabindex="-1" role="dialog" aria-labelledby="registration-login-form-popup" aria-hidden="true">
    <div class="modal-dialog window-popup registration-login-form-popup" role="document">
        <div class="modal-content">
            <a href="#" class="close icon-close" data-dismiss="modal" aria-label="Close">
                <svg class="olymp-close-icon"><use xlink:href="<?php echo get_template_directory_uri(); ?>/images/icons.svg#olymp-close-icon"></use></svg>
            </a>
            <div class="modal-body no-padding">
                <?php
                if ( function_exists( 'crumina_get_reg_form_html' ) ) {
                    echo crumina_get_reg_form_html();
                } else {
                    esc_html_e( 'Crumina Sign in Form extension required', 'olympus' );
                }
                ?>
            </div>
        </div>
    </div>
</div>