<?php

$extension = fw()->extensions->get( 'post-reaction' );
$img_path  = $extension->locate_URI( '/static/img' );

$options = array(
    'general' => array(
        'title'   => __( 'General', 'fw' ),
        'type'    => 'box',
        'options' => array(
            'show-reactions'      => array(
                'type'  => 'checkbox',
                'label' => __( 'Show Reactions', 'fw' ),
                'value' => true,
            ),
            'available-reactions' => array(
                'type'            => 'addable-box',
                'label'           => __( 'Available reactions', 'fw' ),
                'value'           => array(
                    array(
                        'title' => 'Amazed',
                        'ico'   => 'crumina-reaction-amazed',
                    ),
                    array(
                        'title' => 'Anger',
                        'ico'   => 'crumina-reaction-anger',
                    ),
                    array(
                        'title' => 'Bad',
                        'ico'   => 'crumina-reaction-bad',
                    ),
                    array(
                        'title' => 'Cool',
                        'ico'   => 'crumina-reaction-cool',
                    ),
                    array(
                        'title' => 'Joy',
                        'ico'   => 'crumina-reaction-joy',
                    ),
                    array(
                        'title' => 'Like',
                        'ico'   => 'crumina-reaction-like',
                    ),
                    array(
                        'title' => 'Lol',
                        'ico'   => 'crumina-reaction-lol',
                    ),
                ),
                'box-options'     => array(
                    'title' => array( 'type' => 'text' ),
                    'ico'   => array(
                        'type'    => 'image-picker',
                        'blank'   => true,
                        'choices' => array(
                            'crumina-reaction-amazed' => "{$img_path}/crumina-reaction-amazed.png",
                            'crumina-reaction-anger'  => "{$img_path}/crumina-reaction-anger.png",
                            'crumina-reaction-bad'    => "{$img_path}/crumina-reaction-bad.png",
                            'crumina-reaction-cool'   => "{$img_path}/crumina-reaction-cool.png",
                            'crumina-reaction-joy'    => "{$img_path}/crumina-reaction-joy.png",
                            'crumina-reaction-like'   => "{$img_path}/crumina-reaction-like.png",
                            'crumina-reaction-lol'    => "{$img_path}/crumina-reaction-lol.png",
                        )
                    ),
                ),
                'template'        => '{{- title }}',
                'limit'           => 0,
                'add-button-text' => __( 'Add', 'fw' ),
                'sortable'        => true,
            )
        ),
    ),
);
