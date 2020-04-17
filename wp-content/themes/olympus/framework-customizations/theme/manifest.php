<?php

/**
 * Unyson theme manifest
 *
 * @package olympus-wp
 */
if ( !defined( 'FW' ) ) {
    die( 'Forbidden' );
}

$manifest = array();

$manifest[ 'id' ] = 'olympus';

$manifest[ 'supported_extensions' ] = array(
    'breadcrumbs'     => array(),
    'megamenu'        => array(),
    'sidebars'        => array(),
    'backups'         => array(),
    'contact-form'    => array(),
    'ajax-blog'       => array(),
    'post-reaction'   => array(),
    'post-share'      => array(),
    'stunning-header' => array(),
    'sign-form'       => array(),
    //'extended-search'       => array(), TODO: Improve extended search and enable plugin
);
$manifest[ 'requirements' ]         = array(
    'wordpress'  => array(
        'min_version' => '4.9',
    ),
    'extensions' => array(
        'sidebars'        => array(),
        'megamenu'        => array(),
    ),
);
$manifest[ 'server_requirements' ]  = array(
    'server' => array(
        'wp_memory_limit'          => '128M', // use M for MB, G for GB
        'php_version'              => '5.6',
        'post_max_size'            => '8M',
        'php_time_limit'           => '120',
        'php_max_input_vars'       => '2500',
        'suhosin_post_max_vars'    => '2500',
        'suhosin_request_max_vars' => '2500',
        'mysql_version'            => '5.0',
        'max_upload_size'          => '8M',
    ),
);
