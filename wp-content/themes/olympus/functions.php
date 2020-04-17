<?php

if ( !defined( 'ABSPATH' ) ) {
    die( 'Direct access forbidden.' );
}

/**
 * Autoload function, that include all theme classes.
 */
load_template( get_template_directory() . '/inc/classes/olympus-class-autoload.php' );

Olympus_Core::get_instance()->init();