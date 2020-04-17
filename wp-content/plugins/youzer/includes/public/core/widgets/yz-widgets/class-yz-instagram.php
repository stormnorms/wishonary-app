<?php

class YZ_Instagram {

    /**
     * Constructor
     */
    function __construct() {

        // Actions.
        add_filter( 'yz_is_widget_visible', array( $this, 'is_widget_visible' ), 10, 2 );
        add_filter( 'yz_profile_widget_visibility', array( $this, 'display_widget' ), 10, 2 );

    }

    /**
     * Fields.
     */
    function fields( $fields ) {
        
        $fields['instagram'] = array(
            'id' => 'wg_instagram_account_token',
            'title' => __( 'User Instagram', 'youzer' )
        );

        return apply_filters( 'yz_instagram_widget_fields', $fields );
    }

    /**
     * # Display Widget.
     */
    function is_widget_visible( $visibility, $widget_name ) {

        if ( 'instagram' != $widget_name ) {
            return $visibility;
        }

        // Get Instagram Account.
        $app_id = yz_option( 'yz_wg_instagram_app_id' );
        $app_secret = yz_option( 'yz_wg_instagram_app_secret' );

        if ( empty( $app_id ) || empty( $app_secret ) ) {
            return false;
        }

        return true;

    }

    /**
     * # Display Widget.
     */
    function display_widget( $visibility, $widget_name ) {

        if ( 'instagram' != $widget_name ) {
            return $visibility;
        }

        if ( ! $this->is_widget_visible( false, 'instagram' ) ) {
            return false;
        }

        // Get Instagram Account.
        $instagram = yz_data( 'wg_instagram_account_token' );

        if ( empty( $instagram ) ) {
            return false;
        }

        return true;

    }

    /**
     * # Content.
     */
    function widget() {

        // Get User Data
        $user_id = bp_displayed_user_id();
        $photos_number = yz_option( 'yz_wg_max_instagram_items', 9 );

        // Get Instagram Photos
        $instagram_photos = $this->get_instagram_photos( $user_id, $photos_number );
        
        if ( empty( $instagram_photos ) ) {
            return;
        }

        // Check if images Not working.
        // if ( yz_get_image_size( $instagram_photos[0]['full'] ) == array( 0, 0 ) ) {

        //     // Delete Transient.
        //     delete_transient( 'yz_instagram_feed_' . $user_id );

        //     // Re-call Instagram Images.
        //     $instagram_photos = $this->get_instagram_photos( $user_id, $photos_number );

        //     if ( empty( $instagram_photos ) ) {
        //         return;
        //     }

        // }

        ?>

        <ul class="yz-portfolio-content yz-instagram-photos">

        <?php foreach ( $instagram_photos as $photo ) : ?>

        <li>
            <figure class="yz-project-item">
                <div class="yz-projet-img" style="background-image: url(<?php echo $photo['full']; ?>)" ></div>
                <figcaption class="yz-pf-buttons">
                        <a class="yz-pf-url" rel="nofollow noopener" href="<?php echo $photo['link']; ?>" target="_blank" >
                            <i class="fas fa-link"></i>
                        </a>
                        <a class="yz-pf-zoom"><i class="fas fa-search"></i></a>
                        <a class="yz-lightbox-img" rel="nofollow noopener" href="<?php echo $photo['full']; ?>" data-lightbox="yz-instagram" <?php if ( ! empty( $photo['title'] ) ) { echo "data-title='" . esc_attr( $photo['title'] ) . "'"; } ?>></a>
                </figcaption>
            </figure>
        </li>

        <?php endforeach; ?>

        </ul>

        <?php
    }

    /**
     * Get Instagram Photos By Username
     */
    function get_instagram_photos( $user_id, $limit = 6 ) {

        // Init Vars.
        $images = array();
       
        // Get Data
        $instagram_data = $this->get_data( $user_id, $limit );

        // if data is empty return false.
        if ( empty( $instagram_data['data'] ) ) {
            return false;
        }

        foreach ( $instagram_data['data'] as $data ) :
            // Get Image Data.
            $image = array(
                'type'      => $data['type'],
                'full'      => $data['images']['standard_resolution']['url'],
                'original'  => $data['images']['standard_resolution']['url'],
                'small'     => $data['images']['thumbnail']['url'],
                'thumbnail' => $data['images']['thumbnail']['url'],
                'time'      => $data['created_time'],
                'likes'     => $data['likes']['count'],
                'comments'  => $data['comments']['count'],
                'title'     => $data['attribution'],
                'link'      => $data['link'],
            );

            // Fill Images with the new image item.
            array_push( $images, $image );

        endforeach;

        return $images;
    }

    /**
     * Check if account is working.
     */
    function get_data( $user_id = null, $limit = 6 ) {

        // Get Transient ID.
        $transient_id = 'yz_instagram_feed_' . $user_id;
        
        // Get Feed.
        $feed = apply_filters( 'yz_instagram_widget_get_transient', get_transient( $transient_id ) );
        
        if ( false === $feed ) {

            // Get Access Token
            $token = yz_data( 'wg_instagram_account_token', $user_id );
            
            if ( empty( $token ) ) {
                return false;
            }

            // Get User Images Feed
            $profile_url = 'https://api.instagram.com/v1/users/self/media/recent?access_token=' . $token . '&count=' . $limit;

            $remote = wp_remote_get( $profile_url );

            // Check if remote is returning a false answer
            if ( is_wp_error( $remote ) ) {
                return false;
            }

            // Check If Url Is working.
            if ( 200 != wp_remote_retrieve_response_code( $remote ) ) {
               return false;
            }

            // GET User Data.
            $response = wp_remote_retrieve_body( $remote );
            if ( $response === false ) {
                return false;
            }
            
            // Decode Data.
            $feed = json_decode( $response, true );

            if ( $feed === null ) {
                return false;
            }

            // Set Cache.
            set_transient( $transient_id, $feed, HOUR_IN_SECONDS );

        }

        return $feed;
    }

}