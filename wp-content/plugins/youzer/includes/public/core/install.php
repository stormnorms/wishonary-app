<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/*
 * Youzer Activation Hook.
 */
function youzer_activated_hook() {

    // Include Setup File.    
    require_once dirname( YOUZER_FILE ) .  '/includes/public/core/class-yz-setup.php';
    
    // Init Setup Class.
    $Youzer_Setup = new Youzer_Setup();

    // Install Youzer Options
    $Youzer_Setup->install_options();

    // Install New Version Options.
    $Youzer_Setup->install_new_version_options();

    // Build Database.
    $Youzer_Setup->build_database_tables();

    // Install Pages
    $Youzer_Setup->install_pages();

    // Install Xprofile Fields.
    // $Youzer_Setup->create_xprofile_groups();

    // Install Reset Password E-mail.
    $Youzer_Setup->register_bp_reset_password_email();

    // Add Rewrite Rule.
    add_rewrite_rule( '^yz-auth/([^/]+)/([^/]+)/?', 'index.php?yz-authentication=$matches[1]&yz-provider=$matches[2]','top' );
    
    // Flush Rewrite Rules.
    flush_rewrite_rules();

    do_action( 'youzer_activated' );

}

register_activation_hook( YOUZER_FILE, 'youzer_activated_hook' );