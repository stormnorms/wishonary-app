<?php

/**
 * Portfolio Settings.
 */
function yz_portfolio_widget_settings() {

    // Call Scripts
    wp_enqueue_script( 'yz-portfolio', YZ_PA . 'js/yz-portfolio.min.js', array( 'jquery', 'yz-builder' ), YZ_Version, true );
    wp_localize_script( 'yz-portfolio', 'Yz_Portfolio', array(  
        'upload_photo' => __( 'upload photo', 'youzer' ),
        'photo_title'  => __( 'photo title', 'youzer' ),
        'photo_link'   => __( 'photo link', 'youzer' ),
        'items_nbr'    => __( 'The number of items allowed is ', 'youzer' ),
        'no_items'     => __( 'No items found!', 'youzer' )
    ) );
    
    global $Yz_Settings;

    // Get Args 
    $args = yz_get_profile_widget_args( 'portfolio' );

    $Yz_Settings->get_field(
        array(
            'title'          => yz_option( 'yz_wg_portfolio_title', __( 'Portfolio', 'youzer' ) ),
            'button_id'      => 'yz-portfolio-button',
            'button_text'    => __( 'add new photo', 'youzer' ),
            'id'             => $args['id'],
            'icon'           => $args['icon'],
            'widget_section' => true,
            'type'           => 'open'
        )
    );

    $Yz_Settings->get_field(
        array(
            'id'   => 'yz-portfolio-data',
            'type' => 'hidden'
        ), false, 'yz_data'
    );
   
    $i = 0;

    $photos = yz_data( 'youzer_portfolio' );

    // Options titles
    $photo_link   = __( 'PHOTO LINK', 'youzer' );
    $photo_title  = __( 'PHOTO TITLE', 'youzer' );
    $photo_button = __( 'upload photo', 'youzer' );

    echo '<ul class="yz-wg-opts yz-wg-portfolio-options yz-cphoto-options">';

        if ( ! empty( $photos ) ) :

        foreach ( $photos as $photo ) :

            // Get Photo Url
            $item_img = yz_get_file_url( $photo );

            // init Variables.
            $item_title = $photo['title'];
            $item_link  = esc_url( $photo['link'] );

            $i++;

        ?>

        <li class="yz-wg-item" data-wg="portfolio">
            <div class="yz-wg-container">
                <div class="yz-cphoto-content">
                    <div class="uk-option-item">
                        <div class="yz-uploader-item">
                            <div class="yz-photo-preview" style="background-image: url(<?php echo $item_img; ?>);"></div>
                            <label for="yz_portfolio_<?php echo $i; ?>" class="yz-upload-photo" ><?php echo $photo_button; ?></label>
                            <input id="yz_portfolio_<?php echo $i; ?>" type="file" name="yz_portfolio_<?php echo $i; ?>" class="yz_upload_file" accept="image/*" />
                            <input type="hidden" name="youzer_portfolio[<?php echo $i; ?>][original]" value="<?php echo $photo['original']; ?>" class="yz-photo-url">
                            <input type="hidden" name="youzer_portfolio[<?php echo $i; ?>][thumbnail]" value="<?php echo $photo['thumbnail']; ?>" class="yz-photo-thumbnail">
                        </div>
                    </div>
                    <div class="uk-option-item">
                        <div class="option-content">
                            <input type="text" name="youzer_portfolio[<?php echo $i; ?>][title]" value="<?php echo $item_title; ?>" placeholder="<?php echo $photo_title; ?>">
                        </div>
                    </div>
                    <div class="uk-option-item">
                        <div class="option-content">
                            <input type="text" name="youzer_portfolio[<?php echo $i; ?>][link]" value="<?php echo $item_link; ?>" placeholder="<?php echo $photo_link; ?>">
                        </div>
                    </div>
                </div>
            </div>
            <a class="yz-delete-item"></a>
        </li>

        <?php endforeach; endif; ?>

        <script>
            var yz_pf_nextCell = <?php echo $i+1; ?>,
                yz_max_portfolio_img = <?php echo yz_option( 'yz_wg_max_portfolio_items', 9 ); ?>;
        </script>

        <?php

    echo '</ul>';

    $Yz_Settings->get_field( array( 'type' => 'close' ) );

}