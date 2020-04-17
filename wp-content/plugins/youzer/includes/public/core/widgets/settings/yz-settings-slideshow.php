<?php

/**
 * Slideshow Settings.
 */
function yz_slideshow_widget_settings() {

    // Call Script
    wp_enqueue_script( 'yz-slideshow', YZ_PA . 'js/yz-slideshow.min.js', array( 'jquery', 'yz-builder' ), YZ_Version, true );
    wp_localize_script( 'yz-slideshow', 'Yz_Slideshow', array(
        'upload_photo' => __( 'upload photo', 'youzer' ),
        'no_items'     => __( 'No items found!', 'youzer' ),
        'items_nbr'    => __( 'The number of items allowed is ', 'youzer' )
    ));

    global $Yz_Settings;

    // Get Args 
    $args = yz_get_profile_widget_args( 'slideshow' );

    $Yz_Settings->get_field(
        array(
            'title'          => yz_option( 'yz_wg_slideshow_title', __( 'Slideshow', 'youzer' ) ),
            'button_text'    => __( 'add new slide', 'youzer' ),
            'button_id'      => 'yz-slideshow-button',
            'id'             => $args['id'],
            'icon'           => $args['icon'],
            'widget_section' => true,
            'type'           => 'open'
        )
    );

    $Yz_Settings->get_field(
        array(
            'id'    => 'yz-slideshow-data',
            'type'  => 'hidden'
        ), false, 'yz_data'
    );

    echo '<ul class="yz-wg-opts yz-wg-slideshow-options yz-cphoto-options">';

    $i = 0;
    $slides = yz_data( 'youzer_slideshow' );

    if ( ! empty( $slides ) ) :

    foreach ( $slides as $slide ) :

        // Get Slide Image Url
        $item_img = yz_get_file_url( $slide );

        // echo $item_img;
        // Check Slide Image Existence
        if ( ! yz_is_image_exists( $item_img ) ) {
            continue;
        }

        $i++;

    ?>

    <li class="yz-wg-item" data-wg="slideshow">
        <div class="yz-wg-container">
            <div class="yz-cphoto-content">
                <div class="uk-option-item">
                    <div class="yz-uploader-item">
                        <div class="yz-photo-preview" style="background-image: url(<?php echo $item_img; ?>);"></div>
                        <label for="yz_slideshow_<?php echo $i; ?>" class="yz-upload-photo" ><?php _e( 'upload photo', 'youzer' ); ?></label>
                        <input id="yz_slideshow_<?php echo $i; ?>" type="file" name="yz_slideshow_<?php echo $i; ?>" class="yz_upload_file" accept="image/*" />
                        <input type="hidden" name="youzer_slideshow[<?php echo $i; ?>][original]" value="<?php echo $slide['original']; ?>" class="yz-photo-url">
                        <input type="hidden" name="youzer_slideshow[<?php echo $i; ?>][thumbnail]" value="<?php echo $slide['thumbnail']; ?>" class="yz-photo-thumbnail">
                    </div>
                </div>
            </div>
        </div>
        <a class="yz-delete-item"></a>
    </li>

    <?php endforeach; endif; ?>

    <script>
        var yz_ss_nextCell = <?php echo $i+1; ?>,
            yz_max_slideshow_img = <?php echo yz_option( 'yz_wg_max_slideshow_items', 3 ); ?>;
    </script>

    <?php

    echo '</ul>';

    $Yz_Settings->get_field( array( 'type' => 'close' ) );

}