<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'wordpress');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'root');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

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
define('AUTH_KEY',         'OqNPLqkt.~ym~51/|)GyFRv$!LzMr-V6*xg]52_K1PLOl0z=vV)%X;P.vl!G;JH]');
define('SECURE_AUTH_KEY',  'cJ<n}B*_mJH4?J%|}C{*q!2TyE8lB`XVAvW9ZrAi[u9Rc`5R;3INL!+# erXT}!F');
define('LOGGED_IN_KEY',    'p{|j2OQm@So|G1j9Kp-~1 |S-c{KN5_[2nV]-MZ0{ *>HBsW-:Y<h62qFc]9|4 ;');
define('NONCE_KEY',        'MvII]3]pT&H*AEH`|G@>$?~z@]yn>j.QKqv~IFv)>~y*r]|Y:S(*q.I],|4%-ltk');
define('AUTH_SALT',        '|vg|*R%cG+-z|=z8yV*5,uZw,*~hCSY~]:]/s+=<T#vNqmfj3mDxk9E(=pmV8~^q');
define('SECURE_AUTH_SALT', 'eA4bqKE@|P!]|S1)>$kUQ+QCsGx)Y`9}( ~c;f=!4Yz2DJ&YB._s:4pNE0&dd].Z');
define('LOGGED_IN_SALT',   '0x^7GTzD6;l=t[tN-p}7v]wiu-f~4^m,1W-A-l&#Er.PS0evz=x^1BD7.|{]qZ&r');
define('NONCE_SALT',       'z6abyYK^QVH<j_egU$9yvl+9O-z0wJSXPfqy%1$wQfE|FP-(_Hrbbj90}77_$TB7');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', '');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
