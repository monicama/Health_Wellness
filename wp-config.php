<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, and ABSPATH. You can find more information by visiting
 * {@link https://codex.wordpress.org/Editing_wp-config.php Editing wp-config.php}
 * Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */
ob_start();
// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'health_wellness');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '!:8^x@L5~w>y.,i6!+-)UhX8|UC?>Uwd8#7w>@+SU-dFT7pU<22p2Hn>MC}PGt|7');
define('SECURE_AUTH_KEY',  'SLM!l|&- !/.{v|=*doTQL6|6n^Frsc=FVm/w0O0$zser7p/G2A?-EqOB|o<=`3W');
define('LOGGED_IN_KEY',    'U?o:J$gy(-!hn1HB :@k{q3zBC=pXq/w2x8L,|}|w+~p8)ehQd<A%U`FK.r-Vk5H');
define('NONCE_KEY',        '^ox8^)DW-M Zn+1U{)*rG_>@u=$SxR%Padq!nFa6AMX19*+ET+kS/>z(9V[t{}Gf');
define('AUTH_SALT',        'PZfer+!@au4Z{#]kGDYlBS-o9o/}61L-aOLRV4)P9gB^Iq~D9lJsJ}Ks+_JcA_Eq');
define('SECURE_AUTH_SALT', 'PXsx z2ti_G$P!5j||(|+C`+_MgQ*G R)AFbJ9-zK9v!$:FSA$+$-7{1; *Vq!gN');
define('LOGGED_IN_SALT',   '2xgJ/^dV+GC@|^xsr^ba1D+G4okZ9ZsL?|wq#U## @Fkx>j![GsMF=+;S)q121hX');
define('NONCE_SALT',       '{MC2Z:H+0Tl?)u};X)h>{i_c}_4Z9Hdxc}HMX~XdX:!^ofbZ;r*J`X_$&g9eew[R');

/**#@-*/

/************************  SET USER TIME ZONE *********************************/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'hw_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

ini_set('display_errors','Off');

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

define( 'AUTOMATIC_UPDATER_DISABLED', true );

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');

@ini_set( 'upload_max_size' , '128M' );
@ini_set( 'post_max_size', '128M');
@ini_set( 'max_execution_time', '600' );