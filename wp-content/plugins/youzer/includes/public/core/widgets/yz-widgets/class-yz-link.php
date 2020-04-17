<?php

class YZ_Link {

    /**
     * # Content.
     */
    function widget() {

        // Get Widget Data
        $link_url = esc_url( yz_data( 'wg_link_url' ) );

        if ( empty( $link_url ) ) {
            return;
        }

        $use_bg      = yz_data( 'wg_link_use_bg' );
        $img_data    = yz_data( 'wg_link_img' );
        $link_img    = yz_get_file_url( $img_data );
        $link_txt    = sanitize_text_field( yz_data( 'wg_link_txt' ) );
        $link_bg     = "style='background-image:url( $link_img );'";

        ?>

        <div class="yz-link-content link-with-img">
            <?php if ( $link_img && 'on' == $use_bg ) : ?>
                <div class="yz-link-cover" <?php echo $link_bg; ?>></div>
            <?php endif; ?>
            <div class="yz-link-main-content">
                <div class="yz-link-inner-content">
                    <div class="yz-link-icon"><i class="fas fa-link"></i></div>
                    <?php if ( $link_txt ) : ?>
                        <p><?php echo $link_txt; ?></p>
                    <?php endif; ?>
                    <a href="<?php echo $link_url; ?>" class="yz-link-url" target="_blank" rel="nofollow noopener"><?php echo yz_esc_url( $link_url ); ?></a>
                </div>
            </div>
        </div>

        <?php

    }

}