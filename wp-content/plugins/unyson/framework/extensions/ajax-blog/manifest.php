<?php

if ( !defined( 'FW' ) ) {
    die( 'Forbidden' );
}

$manifest = array();

$manifest[ 'name' ]         = esc_html__( 'Ajax blog', 'crum-ext-ajax-blog' );
$manifest[ 'description' ]  = esc_html__( 'Ajax blog', 'crum-ext-ajax-blog' );
$manifest[ 'remote' ]       = 'https://up.crumina.net/extensions/versions/';
$manifest[ 'thumbnail' ]    = plugins_url( 'unyson/framework/extensions/ajax-blog/static/img/thumbnail.png' );
$manifest[ 'version' ]      = '1.1';
$manifest[ 'display' ]      = true;
$manifest[ 'standalone' ]   = false;
$manifest[ 'requirements' ] = array(
    'extensions' => array(
        'post-reaction' => array(),
    )
);
