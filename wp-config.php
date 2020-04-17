<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'wishonary');

/** MySQL database username */
define( 'DB_USER', 'dbmasteruser' );

/** MySQL database password */
define( 'DB_PASSWORD', 'A$qQ]L&Du+:7qu*5Tlh&aB#smM9QY&6m');

/** MySQL hostname */
define( 'DB_HOST', 'ls-81242c5ea89fea2e10e8029998f7a31437747640.c13099vsjhcx.ap-south-1.rds.amazonaws.com:3306' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY', '28f21e90fd4039ade9e626f1583a28b2cd43515e43b17a0c5376c58cc6301562');
define('SECURE_AUTH_KEY', '4851062c2d96cb4ac45d5cdd64a4830a9464980e66fd2ac79176b48f3ae6b917');
define('LOGGED_IN_KEY', '0d93937d32419d8390924c92b48649e0e3b592469113e4aa04e3756faf36adf5');
define('NONCE_KEY', '7e3e93b7445f1b201daadc420bafcd62eca82ac46387e08f7dd738743cad36f2');
define('AUTH_SALT', 'a1103f4aba2f34f038cd353113680ee35ef1d443eb195fefe667ef256d22afd5');
define('SECURE_AUTH_SALT', 'a39befa7971f0dc552b13d459b059f111399549cf5bf1a6412fd3e9e1c064b9d');
define('LOGGED_IN_SALT', '07eb86e37f96da88250a679f7e4fac0deb2e4ec2dcbbe505fc3a0d71645786df');
define('NONCE_SALT', 'ef3cbedcf4544ee08c559b1aa09c327f6ba3f3e63f37b42558ffdce7416f2733');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define( 'WP_DEBUG', false );
/* That's all, stop editing! Happy publishing. */

define('FS_METHOD', 'direct');

/**
 * The WP_SITEURL and WP_HOME options are configured to access from any hostname or IP address.
 * If you want to access only from an specific domain, you can modify them. For example:
 *  define('WP_HOME','https://example.com');
 *  define('WP_SITEURL','https://example.com');
 *
*/

if ( defined( 'WP_CLI' ) ) {
    $_SERVER['HTTP_HOST'] = 'localhost';
}

define('WP_SITEURL','https://' . $_SERVER['HTTP_HOST'] . '/');
define('WP_HOME','https://' . $_SERVER['HTTP_HOST'] . '/');


/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once( ABSPATH . 'wp-settings.php' );

define('WP_TEMP_DIR', '/opt/bitnami/apps/wordpress/tmp');


//  Disable pingback.ping xmlrpc method to prevent Wordpress from participating in DDoS attacks
//  More info at: https://docs.bitnami.com/general/apps/wordpress/troubleshooting/xmlrpc-and-pingback/

if ( !defined( 'WP_CLI' ) ) {
    // remove x-pingback HTTP header
    add_filter('wp_headers', function($headers) {
        unset($headers['X-Pingback']);
        return $headers;
    });
    // disable pingbacks
    add_filter( 'xmlrpc_methods', function( $methods ) {
            unset( $methods['pingback.ping'] );
            return $methods;
    });
    add_filter( 'auto_update_translation', '__return_false' );
}
