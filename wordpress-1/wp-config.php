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
define('DB_NAME', 'finplsyu_wrdprs');

/** MySQL database username */
define('DB_USER', 'finplsyu_dbuser1');

/** MySQL database password */
define('DB_PASSWORD', 'Gr8YrwRg358d6Zv');

/** MySQL hostname */
define('DB_HOST', '127.0.0.1');

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
define('AUTH_KEY',         'MRC_rM[W#Quz.m]74/R+bv~u`,Oq~u6aR?ZI((X8B*Gi=mejhek``:>Irn2LP@Id');
define('SECURE_AUTH_KEY',  'HMdim79+65;+}X~@)j8eZ;7}e7Tu &yaX[lLa]CW-^QB4U~65k[N:5+8&,@<36x<');
define('LOGGED_IN_KEY',    '+fYmM$~car?M4Mmi4eD;?7Bs$0S>:{Jd_2Y0#BY^%.;hW+Zs}|0-cTSm#atE)D0Q');
define('NONCE_KEY',        'p&=-QF[uPA{YT|i9jo;6/>]y]%;^%Vz(x7>I8j(n@Z*Dz6b`q9A]HuDJLm>-MWsv');
define('AUTH_SALT',        'Bn;4m+|b6-x@}jSq:2~uPuT=DslbBwe2dNpdT{arW9~g{B*jJ)+*gB xMHuAMzD+');
define('SECURE_AUTH_SALT', 'Km`4sAil2Z}MEjP[?wq+R&P#67==~psO%QVGEq<,zeV1U&C`4;O*UB,):~X*7[,0');
define('LOGGED_IN_SALT',   '9}$aDXQ|q /ci-n9w|h1e`aq(B-LTRU0>P,IJpVtvm&~;&LC]!gt]|-e?{fCk)+0');
define('NONCE_SALT',       '|.v`c(Cwka|jQQnE04lL&Xr8xF8|UT6+|~:Z*uLU;l%&-Ut5|%+WX+r`Pb^cj[kE');

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
