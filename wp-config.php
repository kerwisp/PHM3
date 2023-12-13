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
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', "wifud_phmtest1" );

/** Database username */
define( 'DB_USER', "wifud_userphmtest" );

/** Database password */
define( 'DB_PASSWORD', "wn102030wn" );

/** Database hostname */
define( 'DB_HOST', "localhost" );

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
define( 'AUTH_KEY',         'be^vK$,C)pE)x7Z/v~&V4vnjd.P?>TP_|r<nFhEOD`t<|^isNg5s#mJ$QsKXR<+e' );
define( 'SECURE_AUTH_KEY',  'k;l%i+||i4;2.^+bs9SNLy/{v}M{rm !^eE)`uF:.8-J(h3WBGe5k$>kJ`,{(y%q' );
define( 'LOGGED_IN_KEY',    'fk=7M3AFQVnjrONWiuN`ILjv$  E )O0B0byZbhTO3z<w!Ek3I`W<P:u2DLN7z N' );
define( 'NONCE_KEY',        '-5{^#RVTu6I4klu&E#>l$PcWgrXyR=kP,GbC) =Tzb23,Hbs3~yj&kC^o/Lq9IIx' );
define( 'AUTH_SALT',        'FUDu[woTCzIB1D#2@%tkf^?9zf}Y<[CL=*hQV4zHq>!39 EKX$%mXKa$pn}]lB2#' );
define( 'SECURE_AUTH_SALT', '>=XttVBE5~=`1}/SN6}uiUV$.XVKL9V>wY::Qw7c&Opk -}bNZYEs[n9F,qfoe~T' );
define( 'LOGGED_IN_SALT',   '{L:RAYOhs2/h~e*,zmb;MA_(o}-Fn$_Ui8gKI*/p0FGudoG_hsj>y_0RiIhC2I w' );
define( 'NONCE_SALT',       'B#H|i>>+(}<FfGFBsEe~4OfrqYQNrym8RfvL.<n*XKL^XxY<|`C>fX-@KkG7Z.~x' );

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
 * @link https://wordpress.org/documentation/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname(__FILE__) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
