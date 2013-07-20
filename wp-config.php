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
define('AUTH_KEY',         'uPcB|C4/]@C,Vms&]Q$+[u1O.qd+9arqcN)kQdCQlH]2d( `{)_:BdXx<P2a?7@E');
define('SECURE_AUTH_KEY',  'T0,N^RE)Xr#!Ra(cS(1g8CudjBaIimW 7]m88iZX|<8c;f_k6O~:Ui%KKuU%w)3z');
define('LOGGED_IN_KEY',    'EX`{%; DNIt}l]~GBug(_nNK!~ jAwD)_q{y`j>-bJFzTCW|%!b%7P_Nm>!~;;}q');
define('NONCE_KEY',        '-V+bjSX}r#Y>t(E]!MD1txO}{,S^h=_x${5m Mi zyjnUp^0M~-hHA|`DT $g|^_');
define('AUTH_SALT',        '?[`SqCKTsb|!a0ECv+be`zY^JNd}|%2=<bL.|mr`@YL+I+]|DSu+^lPU|NvaBsE7');
define('SECURE_AUTH_SALT', 'a7tO?B%<h]q1rI6 ,Z_Mef[sHMLP|-o8bYFmQ1IgF97lw<Q&pKpC G1f@S)U/LuJ');
define('LOGGED_IN_SALT',   '/V&3-@szOrF4a,9=|G%%:f(!cN9`MmLljiSHLOlx(RX?M|r[>3LM)jc;-wbU,%$7');
define('NONCE_SALT',       '8=MY=-%2Jg:r(]uK%j|JNY63$[ZIBDRp8!c Ol)gezcNFpj[s6/,wxBn>6Z}g4<j');

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
