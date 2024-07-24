<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'bitcoin_db' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

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
define( 'AUTH_KEY',         'Wc%$|ua^ylO<sk#Bi0Ng.drTOUL!d=~?,@Edo:+$t5=VR.^?cTOpD5d5:[xq(g@?' );
define( 'SECURE_AUTH_KEY',  '_^N!P~UI:VF+1Bi1APBvg{$xk^:]~7SrU7SfAC;Xvomq.A>s1{Pl9:Y|$hI8KfMX' );
define( 'LOGGED_IN_KEY',    '.pW^w[cyO]>JESUW(s]Bd7>i73<0Yo4+fBr&I8+JHW%$gAw[=7vBC@hYE[fNN3Nz' );
define( 'NONCE_KEY',        '6xgtRz_>Ss/A4E$Bj`A:wq?LHV:Q(Jb~<vS.,]t$-FdT7ysawyl1|/ q@X5E!bPW' );
define( 'AUTH_SALT',        'FH=RvR!$ Zq H-{=CsX=$$Pa7;`.4&/wP[`fO;mUj</.Y]hPPbUiny]>R%W4Ng.#' );
define( 'SECURE_AUTH_SALT', 'eb@#0T$<7&uCrfQj2h!h{+)2Ad] C|em7u|6AXiXrRY-}|R|/J^TrQ2ewd}Ca@Jf' );
define( 'LOGGED_IN_SALT',   'oNr:>~$jTQY_9so/ga]Ovd)m=8#1N H)cZJGg[ NDnZ1mtL}H/{0OF]f<)k!%o i' );
define( 'NONCE_SALT',       'm0jH~TW.!Z;0)!,H*g/`aRQmWf2tgk)eJ(+J`Ol^#rqHwR:!U SRYi?t`/{2vZs<' );

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
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
