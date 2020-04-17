<?php

if ( !defined( 'FW' ) ) {
    return;
}
$ext = fw_ext( 'post-share' );

/**
 * Register post share JS script
 */

wp_register_script( 'sharer', $ext->locate_URI( '/static/js/sharer.min.js' ), array(), '0.3.8', true );
