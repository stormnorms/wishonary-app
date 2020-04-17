<?php

class YZ_Quote {
    
    /**
     * # Content.
     */
    function widget() {

        // Get User Data
        $quote_txt = sanitize_textarea_field( yz_data( 'wg_quote_txt' ) );

        if ( empty( $quote_txt ) ) {
            return;
        }

        $img_data = yz_data( 'wg_quote_img' );
        $quote_img = yz_get_file_url( $img_data );


        yz_styling()->gradient_styling( array(
            'selector'      => 'body .quote-with-img:before',
            'left_color'    => 'yz_wg_quote_gradient_left_color',
            'right_color'   => 'yz_wg_quote_gradient_right_color'
            )
        );

        ?>

        <div class="yz-quote-content quote-with-img">
            <?php if ( ! empty( $quote_img ) && 'on' == yz_data( 'wg_quote_use_bg' ) ) : ?>
                <div class="yz-quote-cover" <?php echo "style='background-image:url( $quote_img );'"; ?>></div>
            <?php endif; ?>
            <div class="yz-quote-main-content">
                <div class="yz-quote-icon"><i class="fas fa-quote-right"></i></div>
                <blockquote><?php echo nl2br( $quote_txt ); ?></blockquote>
                <h3 class="yz-quote-owner"><?php echo yz_data( 'wg_quote_owner' ); ?></h3>
            </div>
        </div>

        <?php

    }

}