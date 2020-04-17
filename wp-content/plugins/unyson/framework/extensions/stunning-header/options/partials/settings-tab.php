<?php

if ( !defined( 'FW' ) ) {
    die( 'Forbidden' );
}

$ext = fw_ext( 'stunning-header' );

$options = array(
    'header-stunning-visibility' => apply_filters( 'crumina_options_stunning_header_visibility', $ext->get_options( 'partials/visibility' ) ),
    'header-stunning-content'  => array(
        'type'    => 'multi-picker',
        'picker'  => 'header-stunning-visibility',
        'choices' => array(
            'yes' => array(
                $ext->get_options( 'partials/content' )
            )
        )
    )
);
