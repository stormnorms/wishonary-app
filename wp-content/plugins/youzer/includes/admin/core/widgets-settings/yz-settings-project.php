<?php

/**
 * Project Settings.
 */
function yz_project_widget_settings() {

    global $Yz_Settings;

    $Yz_Settings->get_field(
        array(
            'title' => __( 'general Settings', 'youzer' ),
            'type'  => 'openBox'
        )
    );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'widget title', 'youzer' ),
            'id'    => 'yz_wg_project_title',
            'desc'  => __( 'type widget title', 'youzer' ),
            'type'  => 'text'
        )
    );
    
    $Yz_Settings->get_field(
        array(
            'title' => __( 'Project Types', 'youzer' ),
            'id'    => 'yz_wg_project_types',
            'desc'  => __( 'add project types', 'youzer' ),
            'type'  => 'taxonomy'
        )
    );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'loading effect', 'youzer' ),
            'opts'  => $Yz_Settings->get_field_options( 'loading_effects' ),
            'desc'  => __( 'how you want the widget to be loaded?', 'youzer' ),
            'id'    => 'yz_project_load_effect',
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
            'title' => __( 'project meta', 'youzer' ),
            'desc'  => __( 'show project meta', 'youzer' ),
            'id'    => 'yz_display_prjct_meta',
            'type'  => 'checkbox'
        )
    );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'project meta icons', 'youzer' ),
            'desc'  => __( 'show project icons', 'youzer' ),
            'id'    => 'yz_display_prjct_meta_icons',
            'type'  => 'checkbox'
        )
    );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'project tags', 'youzer' ),
            'id'    => 'yz_display_prjct_tags',
            'desc'  => __( 'show project tags', 'youzer' ),
            'type'  => 'checkbox'
        )
    );

    $Yz_Settings->get_field( array( 'type' => 'closeBox' ) );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'widget styling settings', 'youzer' ),
            'class' => 'ukai-box-3cols',
            'type'  => 'openBox'
        )
    );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'type background', 'youzer' ),
            'desc'  => __( 'project type background color', 'youzer' ),
            'id'    => 'yz_wg_project_type_bg_color',
            'type'  => 'color'
        )
    );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'project type text', 'youzer' ),
            'desc'  => __( 'type text color', 'youzer' ),
            'id'    => 'yz_wg_project_type_txt_color',
            'type'  => 'color'
        )
    );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'project title', 'youzer' ),
            'desc'  => __( 'project title color', 'youzer' ),
            'id'    => 'yz_wg_project_title_color',
            'type'  => 'color'
        )
    );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'project meta', 'youzer' ),
            'id'    => 'yz_wg_project_meta_txt_color',
            'desc'  => __( 'project meta color', 'youzer' ),
            'type'  => 'color'
        )
    );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'project meta icons', 'youzer' ),
            'id'    => 'yz_wg_project_meta_icon_color',
            'desc'  => __( 'project icons color', 'youzer' ),
            'type'  => 'color'
        )
    );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'project description', 'youzer' ),
            'desc'  => __( 'project description color', 'youzer' ),
            'id'    => 'yz_wg_project_desc_color',
            'type'  => 'color'
        )
    );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'project tags', 'youzer' ),
            'id'    => 'yz_wg_project_tags_color',
            'desc'  => __( 'project tags color', 'youzer' ),
            'type'  => 'color'
        )
    );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'tags background', 'youzer' ),
            'id'    => 'yz_wg_project_tags_bg_color',
            'desc'  => __( 'tags background color', 'youzer' ),
            'type'  => 'color'
        )
    );

    $Yz_Settings->get_field(
        array(
            'title' => __( 'tags hashtag', 'youzer' ),
            'desc'  => __( 'project hashtags color', 'youzer' ),
            'id'    => 'yz_wg_project_tags_hashtag_color',
            'type'  => 'color'
        )
    );

    $Yz_Settings->get_field( array( 'type' => 'closeBox' ) );
}