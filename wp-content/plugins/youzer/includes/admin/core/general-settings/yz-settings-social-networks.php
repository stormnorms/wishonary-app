<?php

/**
 * # Admin Settings.
 */
function yz_social_networks_settings() {

    wp_enqueue_script( 'yz-networks', YZ_AA . 'js/yz-networks.min.js', array( 'jquery' ), YZ_Version, true );
    wp_localize_script( 'yz-networks', 'Yz_Networks', array(
        'update_network' => __( 'update network', 'youzer' ),
        'no_networks' => __( 'No social networks Found !', 'youzer' )
    ) );

    global $Yz_Settings;

    // Network Args
    $modal_args = array(
        'id'        => 'yz-networks-form',
        'title'     => __( 'add new social network', 'youzer' ),
        'button_id' => 'yz-add-network'
    );

    // Get 'Create new ad' Form.
    yz_panel_modal_form( $modal_args, 'yz_add_new_network_form' );

    // Get Available Social Networks.
    yz_get_social_network();

    $Yz_Settings->get_field(
        array(
            'title' => __( 'Social Networks Settings', 'youzer' ),
            'class' => 'ukai-box-2cols',
            'type'  => 'openBox'
        )
    );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'networks type', 'youzer' ),
            'id'    => 'yz_navbar_sn_bg_type',
            'desc'  => __( 'networks background type', 'youzer' ),
            'type'  => 'select',
            'opts'  => $Yz_Settings->get_field_options( 'icons_colors' )
        )
    );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'networks style', 'youzer' ),
            'id'    => 'yz_navbar_sn_bg_style',
            'desc'  => __( 'networks background style', 'youzer' ),
            'type'  => 'select',
            'opts'  => $Yz_Settings->get_field_options( 'border_styles' )
        )
    );

    $Yz_Settings->get_field( array( 'type' => 'closeBox' ) );
}

/**
 *  Add New Network Form
 */
function yz_add_new_network_form() {

    // Get Data.
    global $Yz_Settings;

    $Yz_Settings->get_field(
        array(
            'type'  => 'openDiv',
            'class' => 'yz-networks-form'
        )
    );

    $Yz_Settings->get_field(
        array(
            'title'        => __( 'network icon', 'youzer' ),
            'desc'         => __( 'select network icon', 'youzer' ),
            'id'           => 'yz_network_icon',
            'std'          => 'share-alt',
            'type'         => 'icon',
            'icons_type'   => 'social-networks',
            'no_options'   => true
        )
    );

    $Yz_Settings->get_field(
        array(
            'title'        => __( 'network color', 'youzer' ),
            'desc'         => __( 'choose network color', 'youzer' ),
            'id'           => 'yz_network_color',
            'type'         => 'color',
            'no_options'   => true
        )
    );

    $Yz_Settings->get_field(
        array(
            'title'        => __( 'network name', 'youzer' ),
            'desc'         => __( 'add network name', 'youzer' ),
            'id'           => 'yz_network_name',
            'type'         => 'text',
            'no_options'   => true
        )
    );

    // Add Hidden Input
    $Yz_Settings->get_field(
        array(
            'id'         => 'yz_networks_form',
            'class'      => 'yz-keys-name',
            'type'       => 'hidden',
            'std'        => 'yz_networks',
            'no_options' => true
        )
    );

    $Yz_Settings->get_field( array( 'type' => 'closeDiv' ) );

}

/**
 *  Get Networks
 */
function yz_get_social_network() {

    // Get Social Networks Items
    $social_networks = yz_option( 'yz_social_networks' );

    // Unserialize data
    if ( is_serialized( $social_networks ) ) {
        $social_networks = unserialize( $social_networks );
    }

    // Next Social Network ID
    $yz_nextSN = yz_option( 'yz_next_snetwork_nbr' );
    
    $yz_nextSN = ! empty( $yz_nextSN ) ? $yz_nextSN : 1;

    ?>

    <script> var yz_nextSN = <?php echo $yz_nextSN; ?>; </script>

    <div class="yz-custom-section">
        <div class="yz-cs-head">
            <div class="yz-cs-buttons">
                <button class="yz-md-trigger yz-networks-button" data-modal="yz-networks-form">
                    <i class="fas fa-plus-circle"></i>
                    <?php _e( 'add new network', 'youzer' ); ?>
                </button>
            </div>
        </div>
    </div>

    <ul id="yz_networks" class="yz-cs-content">

    <?php

        // Show No Networks Found .
        if ( empty( $social_networks ) ) {
            echo "<p class='yz-no-content yz-no-networks'>" . __( 'No social networks Found !', 'youzer' ) . "</p></ul>";
            return false;
        }

        foreach ( $social_networks as $network => $data ) {

            // Get Widget Data
            $name     = $data['name'];
            $icon     = apply_filters( 'yz_panel_networks_icon', $data['icon'] );
            $color    = $data['color'];
            $sn_name  = "yz_networks[$network]";

            ?>

            <!-- Network Item -->
            <li class="yz-network-item" data-network-name="<?php echo $network;?>">
                <h2 class="yz-network-name" style="border-color: <?php echo $color; ?>;">
                    <i class="fab yz-network-icon <?php echo $icon; ?>"></i>
                    <span><?php echo $name; ?></span>
                </h2>
                <input type="hidden" name="<?php echo $sn_name; ?>[name]" value="<?php echo $name; ?>">
                <input type="hidden" name="<?php echo $sn_name; ?>[icon]" value="<?php echo $icon; ?>">
                <input type="hidden" name="<?php echo $sn_name; ?>[color]" value="<?php echo $color; ?>">
                <a class="yz-edit-item yz-edit-network"></a>
                <a class="yz-delete-item yz-delete-network"></a>
            </li>

         <?php } ?>

    </ul>

    <?php
}