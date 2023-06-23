<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'online_school_db' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', 'root' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'uA,8TwgD]iwj&Sm12+`EdZ,e*HiK7CL%G%b9By%+{=zVYv@zWzPW2SNDM&(&4p{y' );
define( 'SECURE_AUTH_KEY',  '?S0R6kxgFCn;pAuu&74Y&8,#J [biNX-flNQ=@AN:2EdAYt**IJu=`%7>bq+I0h.' );
define( 'LOGGED_IN_KEY',    '5hC2RW`P%mhSv31&B!-:$L:*f 9A4EIQs#W!Ok3}OV=H%(s|j_r9,i>MoH0,dG{$' );
define( 'NONCE_KEY',        '*(%QK2{U@ZTcJ:&I1VLe hHE?#P-WIT^vGR5!fiUByr`s#@0szn5i<PXu`eW@RK*' );
define( 'AUTH_SALT',        '?^_HiPDiQ8$C.-99Iu[hA!3ybsB[$|M+sn>>@K/Mu5vitrvJA-Gcw<`HR3C;c1{H' );
define( 'SECURE_AUTH_SALT', 'Wic4&edd#a[#F$m]CMa{w}rijGyE`gi6m;4U_/|,?~iNwEW+d{c.>GXEO*&2/~?f' );
define( 'LOGGED_IN_SALT',   'g8S/~YMl*5Nvy]K>8VNyS)XxGs7U~KEP&4kmj/ZlI>o#Q1PGG&+-) :w*M*Bj]0_' );
define( 'NONCE_SALT',       '$Wf<B&j^,h/FF-cLXO:._{M<(CFu{dXv3E::0p3n2Cse_D%L?pu1-,BgUoq5ev>!' );

/**#@-*/

/**
 * WordPress database table prefix.
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
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', true );
define( 'WP_DEBUG_DISPLAY', false);
define( 'WP_ENVIRONMENT_TYPE', 'local' ); // DON't FORGET TO COMMENT!!!

// Enable Debug logging to the /wp-content/debug.log file
define( 'WP_DEBUG_LOG', true );

// Set memory for php
define( 'WP_MEMORY_LIMIT', '200M' );

// Set language
define('WPLANG', 'ru_RU');
/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
