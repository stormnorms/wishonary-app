<?php

/**
 * # Wall Settings.
 */

function yz_wall_settings() {

    global $Yz_Settings;

    $Yz_Settings->get_field(
        array(
            'title' => __( 'General Settings', 'youzer' ),
            'type'  => 'openBox'
        )
    );

    $Yz_Settings->get_field(
        array(
            'type'  => 'checkbox',
            'id'    => 'yz_enable_wall_url_preview',
            'title' => __( 'url live preview', 'youzer' ),
            'desc'  => __( 'display url preview in the wall form', 'youzer' ),
        )
    );

    $Yz_Settings->get_field(
        array(
            'type'  => 'checkbox',
            'id'    => 'yz_enable_wall_activity_loader',
            'title' => __( 'infinite loader', 'youzer' ),
            'desc'  => __( 'enable activity infinite loader', 'youzer' ),
        )
    );

    $Yz_Settings->get_field(
        array(
            'type'  => 'checkbox',
            'id'    => 'yz_enable_wall_activity_effects',
            'title' => __( 'Activity Loading Effect', 'youzer' ),
            'desc'  => __( 'enable activity loading effect', 'youzer' ),
        )
    );

    $Yz_Settings->get_field( array( 'type' => 'closeBox' ) );
    
    $Yz_Settings->get_field(
        array(
            'title' => __( 'Sticky Posts Settings', 'youzer' ),
            'type'  => 'openBox'
        )
    );

    // $Yz_Settings->get_field(
    //     array(
    //         'type'  => 'checkbox',
    //         'id'    => 'yz_enable_sticky_posts',
    //         'title' => __( 'Enable Sticky Posts', 'youzer' ),
    //         'desc'  => __( 'allow admins to pin/unpin posts', 'youzer' ),
    //     )
    // );

    $Yz_Settings->get_field(
        array(
            'type'  => 'checkbox',
            'id'    => 'yz_enable_groups_sticky_posts',
            'title' => __( 'Enable Groups Sticky Posts', 'youzer' ),
            'desc'  => __( 'allow admins to pin/unpin posts', 'youzer' ),
        )
    );

    $Yz_Settings->get_field(
        array(
            'type'  => 'checkbox',
            'id'    => 'yz_enable_activity_sticky_posts',
            'title' => __( 'Enable Activity Sticky Posts', 'youzer' ),
            'desc'  => __( 'allow admins to pin/unpin posts', 'youzer' ),
        )
    );

    $Yz_Settings->get_field( array( 'type' => 'closeBox' ) );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'Posting Form Settings', 'youzer' ),
            'class' => 'ukai-box-3cols',
            'type'  => 'openBox'
        )
    );

    $Yz_Settings->get_field(
        array(
            'type'  => 'checkbox',
            'id'    => 'yz_activity_privacy',
            'title' => __( 'Privacy', 'youzer' ),
            'desc'  => __( 'Enable activity posts privacy', 'youzer' ),
        )
    );

    $Yz_Settings->get_field(
        array(
            'type'  => 'checkbox',
            'id'    => 'yz_activity_mood',
            'title' => __( 'Feeling / Activity', 'youzer' ),
            'desc'  => __( 'Enable posts feeling and activity', 'youzer' ),
        )
    );

    $Yz_Settings->get_field(
        array(
            'type'  => 'checkbox',
            'id'    => 'yz_activity_tag_friends',
            'title' => __( 'Tag Friends', 'youzer' ),
            'desc'  => __( 'Enable tagging friends in posts', 'youzer' ),
        )
    );

    $Yz_Settings->get_field( array( 'type' => 'closeBox' ) );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'Filters Settings', 'youzer' ),
            'type'  => 'openBox'
        )
    );

    // $Yz_Settings->get_field(
    //     array(
    //         'type'  => 'checkbox',
    //         'id'    => 'yz_enable_youzer_activity_filter',
    //         'title' => __( 'Enable Youzer Activity Filter', 'youzer' ),
    //         'desc'  => __( 'use youzer activity filter', 'youzer' ),
    //     )
    // );

    $Yz_Settings->get_field(
        array(
            'type'  => 'checkbox',
            'id'    => 'yz_enable_wall_filter_bar',
            'title' => __( 'Display Wall Filter', 'youzer' ),
            'desc'  => __( 'show wall filter bar', 'youzer' ),
        )
    );

    $Yz_Settings->get_field(
        array(
            'type'  => 'checkbox',
            'id'    => 'yz_enable_activity_directory_filter_bar',
            'title' => __( 'Display Activity Filter', 'youzer' ),
            'desc'  => __( 'show global activity page filter bar', 'youzer' ),
        )
    );

    $Yz_Settings->get_field( array( 'type' => 'closeBox' ) );
    
    $Yz_Settings->get_field(
        array(
            'title' => __( 'Posts Embeds Settings', 'youzer' ),
            'class' => 'ukai-box-2cols',
            'type'  => 'openBox'
        )
    );

    $Yz_Settings->get_field(
        array(
            'type'  => 'checkbox',
            'id'    => 'yz_enable_wall_posts_embeds',
            'title' => __( 'Enable Posts Embeds', 'youzer' ),
            'desc'  => __( 'activate Embeds inside posts', 'youzer' ),
        )
    );
    
    $Yz_Settings->get_field(
        array(
            'type'  => 'checkbox',
            'id'    => 'yz_enable_wall_comments_embeds',
            'title' => __( 'Enable Comments Embeds', 'youzer' ),
            'desc'  => __( 'activate Embeds inside comments', 'youzer' ),
        )
    );
    
    $Yz_Settings->get_field( array( 'type' => 'closeBox' ) );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'Posts Buttons Settings', 'youzer' ),
            'class' => 'ukai-box-2cols',
            'type'  => 'openBox'
        )
    );

    $Yz_Settings->get_field(
        array(
            'type'  => 'checkbox',
            'id'    => 'yz_enable_wall_posts_likes',
            'title' => __( 'Enable Likes', 'youzer' ),
            'desc'  => __( 'allow users to like posts', 'youzer' ),
        )
    );

    $Yz_Settings->get_field(
        array(
            'type'  => 'checkbox',
            'id'    => 'yz_enable_wall_posts_deletion',
            'title' => __( 'Enable Deletion', 'youzer' ),
            'desc'  => __( 'enable posts delete button', 'youzer' ),
        )
    );

    $Yz_Settings->get_field(
        array(
            'type'  => 'checkbox',
            'id'    => 'yz_enable_wall_posts_comments',
            'title' => __( 'Enable Comments', 'youzer' ),
            'desc'  => __( 'allow posts comments', 'youzer' ),
        )
    );

    $Yz_Settings->get_field(
        array(
            'type'  => 'checkbox',
            'id'    => 'yz_enable_wall_posts_reply',
            'title' => __( 'Enable Comments Replies', 'youzer' ),
            'desc'  => __( 'allow posts comments replies', 'youzer' ),
        )
    );

    $Yz_Settings->get_field( array( 'type' => 'closeBox' ) );
    
    $Yz_Settings->get_field(
        array(
            'title' => __( 'Activity Attachments Settings', 'youzer' ),
            'type'  => 'openBox'
        )
    );

    $Yz_Settings->get_field(
        array(
            'type'  => 'number',
            'id'    => 'yz_attachments_max_nbr',
            'title' => __( 'Max Attachments Number', 'youzer' ),
            'desc'  => __( 'Slideshow and photos max number per post', 'youzer' ),
        )
    );

    $Yz_Settings->get_field(
        array(
            'type'  => 'number',
            'id'    => 'yz_attachments_max_size',
            'title' => __( 'Max File Size', 'youzer' ),
            'desc'  => __( 'attachment max size by megabytes', 'youzer' ),
        )
    );
    
    $Yz_Settings->get_field(
        array(
            'type'  => 'taxonomy',
            'id'    => 'yz_atts_allowed_images_exts',
            'title' => __( 'Image extensions', 'youzer' ),
            'desc'  => __( 'allowed image extensions', 'youzer' ),
        )
    );
    
    $Yz_Settings->get_field(
        array(
            'type'  => 'taxonomy',
            'id'    => 'yz_atts_allowed_videos_exts',
            'title' => __( 'Video extensions', 'youzer' ),
            'desc'  => __( 'allowed video extensions', 'youzer' ),
        )
    );
    
    $Yz_Settings->get_field(
        array(
            'type'  => 'taxonomy',
            'id'    => 'yz_atts_allowed_audios_exts',
            'title' => __( 'Audio extensions', 'youzer' ),
            'desc'  => __( 'allowed audio extensions', 'youzer' ),
        )
    );
    
    $Yz_Settings->get_field(
        array(
            'type'  => 'taxonomy',
            'id'    => 'yz_atts_allowed_files_exts',
            'title' => __( 'Files extensions', 'youzer' ),
            'desc'  => __( 'allowed files extensions', 'youzer' ),
        )
    );
    
    $Yz_Settings->get_field( array( 'type' => 'closeBox' ) );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'Comments Attachments Settings', 'youzer' ),
            'type'  => 'openBox'
        )
    );

    $Yz_Settings->get_field(
        array(
            'type'  => 'checkbox',
            'id'    => 'yz_wall_comments_attachments',
            'title' => __( 'Comments Attachments', 'youzer' ),
            'desc'  => __( 'enable comments attachments', 'youzer' ),
        )
    );

    $Yz_Settings->get_field(
        array(
            'type'  => 'taxonomy',
            'id'    => 'yz_wall_comments_attachments_extensions',
            'title' => __( 'Allowed Extensions', 'youzer' ),
            'desc'  => __( 'allowed extensions list', 'youzer' ),
        )
    );

    $Yz_Settings->get_field(
        array(
            'type'  => 'number',
            'id'    => 'yz_wall_comments_attachments_max_size',
            'title' => __( 'Max File Size', 'youzer' ),
            'desc'  => __( 'attachment max size by megabytes', 'youzer' ),
        )
    );

    $Yz_Settings->get_field( array( 'type' => 'closeBox' ) );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'Activity Moderation Settings', 'youzer' ),
            'type'  => 'openBox'
        )
    );

    $Yz_Settings->get_field(
        array(
            'type'  => 'taxonomy',
            'id'    => 'yz_moderation_keys',
            'title' => __( 'Forbidden Community Words', 'youzer' ),
            'desc'  => __( 'Add a list of forbidden words that cannot be used on the activity posts and comments.', 'youzer' ),
        )
    );

    $Yz_Settings->get_field( array( 'type' => 'closeBox' ) );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'Posts Per Page Settings', 'youzer' ),
            'type'  => 'openBox'
        )
    );

    $Yz_Settings->get_field(
        array(
            'type'  => 'number',
            'id'    => 'yz_profile_wall_posts_per_page',
            'title' => __( 'Profile - Posts Per Page', 'youzer' ),
            'desc'  => __( 'profile wall posts per page', 'youzer' ),
        )
    );

    $Yz_Settings->get_field(
        array(
            'type'  => 'number',
            'id'    => 'yz_groups_wall_posts_per_page',
            'title' => __( 'Groups - Posts Per Page', 'youzer' ),
            'desc'  => __( 'groups wall posts per page', 'youzer' ),
        )
    );

    $Yz_Settings->get_field(
        array(
            'type'  => 'number',
            'id'    => 'yz_activity_wall_posts_per_page',
            'title' => __( 'Activity - Posts Per Page', 'youzer' ),
            'desc'  => __( 'global activity wall posts per page', 'youzer' ),
        )
    );

    $Yz_Settings->get_field( array( 'type' => 'closeBox' ) );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'Control Wall Posts Visibility', 'youzer' ),
            'class' => 'ukai-box-3cols',
            'type'  => 'openBox'
        )
    );

    $post_types = yz_activity_post_types();
    
    // Get Unallowed Types.
    $unallowed_types = array_flip( get_option( 'yz_unallowed_activities', array() ) );

    if ( isset( $unallowed_types['friendship_accepted,friendship_created'] ) ) {
        $unallowed_types['friendship_accepted'] = 'on';
        $unallowed_types['friendship_created'] = 'on';
    }

    foreach ( $post_types as $post_type => $name ) {

        $Yz_Settings->get_field(
            array(
                'type'  => 'checkbox',
                'std'   => isset( $unallowed_types[ $post_type ] ) ? 'off' : 'on',
                'id'    => $post_type,
                'title' => $name,
                'desc'  => sprintf( __( 'enable activity %s posts', 'youzer' ), $name ),
            ), false, 'yz_unallowed_activities'
        );

    }

    do_action( 'yz_wall_posts_visibility_settings' );

    $Yz_Settings->get_field( array( 'type' => 'closeBox' ) );

}