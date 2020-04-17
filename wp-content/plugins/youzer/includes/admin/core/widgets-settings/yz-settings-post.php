<?php

/**
 * Post Settings.
 */
function yz_post_widget_settings() {

    global $Yz_Settings;

    $Yz_Settings->get_field(
        array(
            'title' => __( 'general Settings', 'youzer' ),
            'type'  => 'openBox'
        )
    );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'post types', 'youzer' ),
            'id'    => 'yz_wg_post_types',
            'desc'  => __( 'add post types', 'youzer' ),
            'type'  => 'taxonomy'
        )
    );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'loading effect', 'youzer' ),
            'opts'  => $Yz_Settings->get_field_options( 'loading_effects' ),
            'desc'  => __( 'how you want the widget to be loaded ?', 'youzer' ),
            'id'    => 'yz_post_load_effect',
            'type'  => 'select'
        )
    );

    $Yz_Settings->get_field( array( 'type' => 'closeBox' ) );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'widget visibility settings', 'youzer' ),
            'class' => 'ukai-box-3cols',
            'type'  => 'openBox'
        )
    );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'widget title', 'youzer' ),
            'id'    => 'yz_wg_post_title',
            'desc'  => __( 'type widget title', 'youzer' ),
            'type'  => 'text'
        )
    );
    
    $Yz_Settings->get_field(
        array(
            'title' => __( 'post meta', 'youzer' ),
            'id'    => 'yz_display_wg_post_meta',
            'desc'  => __( 'show post meta', 'youzer' ),
            'type'  => 'checkbox'
        )
    );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'post meta icons', 'youzer' ),
            'desc'  => __( 'show meta icons', 'youzer' ),
            'id'    => 'yz_display_wg_post_meta_icons',
            'type'  => 'checkbox'
        )
    );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'post date', 'youzer' ),
            'id'    => 'yz_display_wg_post_date',
            'desc'  => __( 'show post date', 'youzer' ),
            'type'  => 'checkbox'
        )
    );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'post comments', 'youzer' ),
            'id'    => 'yz_display_wg_post_comments',
            'desc'  => __( 'show post comments', 'youzer' ),
            'type'  => 'checkbox'
        )
    );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'post excerpt', 'youzer' ),
            'id'    => 'yz_display_wg_post_excerpt',
            'desc'  => __( 'show post excerpt', 'youzer' ),
            'type'  => 'checkbox'
        )
    );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'post tags', 'youzer' ),
            'id'    => 'yz_display_wg_post_tags',
            'desc'  => __( 'show post tags', 'youzer' ),
            'type'  => 'checkbox'
        )
    );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'read more', 'youzer' ),
            'id'    => 'yz_display_wg_post_readmore',
            'desc'  => __( 'show read more button', 'youzer' ),
            'type'  => 'checkbox'
        )
    );

    $Yz_Settings->get_field( array( 'type' => 'closeBox' ) );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'Styling widget', 'youzer' ),
            'class' => 'ukai-box-3cols',
            'type'  => 'openBox'
        )
    );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'post type background', 'youzer' ),
            'id'    => 'yz_wg_post_type_bg_color',
            'desc'  => __( 'post type background', 'youzer' ),
            'type'  => 'color'
        )
    );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'post type text', 'youzer' ),
            'id'    => 'yz_wg_post_type_txt_color',
            'desc'  => __( 'type text color ', 'youzer' ),
            'type'  => 'color'
        )
    );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'title', 'youzer' ),
            'id'    => 'yz_wg_post_title_color',
            'desc'  => __( 'post title color', 'youzer' ),
            'type'  => 'color'
        )
    );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'meta', 'youzer' ),
            'id'    => 'yz_wg_post_meta_txt_color',
            'desc'  => __( 'post meta color', 'youzer' ),
            'type'  => 'color'
        )
    );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'meta icons', 'youzer' ),
            'id'    => 'yz_wg_post_meta_icon_color',
            'desc'  => __( 'meta icons color', 'youzer' ),
            'type'  => 'color'
        )
    );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'excerpt', 'youzer' ),
            'id'    => 'yz_wg_post_text_color',
            'desc'  => __( 'post excerpt color', 'youzer' ),
            'type'  => 'color'
        )
    );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'tags', 'youzer' ),
            'id'    => 'yz_wg_post_tags_color',
            'desc'  => __( 'post tags color', 'youzer' ),
            'type'  => 'color'
        )
    );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'tags background', 'youzer' ),
            'id'    => 'yz_wg_post_tags_bg_color',
            'desc'  => __( 'tags background color', 'youzer' ),
            'type'  => 'color'
        )
    );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'tags hashtag', 'youzer' ),
            'id'    => 'yz_wg_post_tags_hashtag_color',
            'desc'  => __( 'post hashtags color', 'youzer' ),
            'type'  => 'color'
        )
    );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'read more', 'youzer' ),
            'id'    => 'yz_wg_post_rm_color',
            'desc'  => __( 'read more text color', 'youzer' ),
            'type'  => 'color'
        )
    );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'read more background', 'youzer' ),
            'id'    => 'yz_wg_post_rm_bg_color',
            'desc'  => __( 'read more background color', 'youzer' ),
            'type'  => 'color'
        )
    );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'read more icon', 'youzer' ),
            'id'    => 'yz_wg_post_rm_icon_color',
            'desc'  => __( 'read more icon color', 'youzer' ),
            'type'  => 'color'
        )
    );

    $Yz_Settings->get_field( array( 'type' => 'closeBox' ) );

}