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


/** Disable those wasteful revisions. */
define('WP_POST_REVISIONS', 0);

/** Determine Hostname. */
if ( !empty($_SERVER["SERVER_NAME"]) )
    $host = strtolower($_SERVER["SERVER_NAME"]);
else if ( !empty($_SERVER["HOSTNAME"]) )
    $host = strtolower($_SERVER["HOSTNAME"]);
else if ( !empty($_SERVER["COMPUTERNAME"]) )
    $host = strtolower($_SERVER["COMPUTERNAME"]);
else
    $host = trim(`hostname`);

/** Define remote development server and/or remote live server. */
$domain = '';

/** Define server-specific constants for localhost, remote development servers and remote live server. */
switch ( $host )
{
	case "Fleetwood-Mac.local":
	case "host_name_here":
		define('LOCAL', true );
		define('DB_NAME', 'database_name_here');
		define('DB_USER', 'db');
		define('DB_PASSWORD', 'db');
		define('DB_HOST', 'localhost');
	break;   
	
	case $domain:
	case 'www'.$domain:
		define('LOCAL', false );
		define('DB_NAME', 'database_name_here');
		define('DB_USER', '');
		define('DB_PASSWORD', '');
		define('DB_HOST', 'localhost');
	break;
	
	default:
	die("<p>Server not recognized - system definitions must be updated. El servo rooto.</p>");
	break;
}

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
define('AUTH_KEY',         ' /J,MHbDvugvXq[wa0:fu#8izq_;IV`1?F!N*sV_1 FlFa-XP3A11R6-D~fs>SgD');
define('SECURE_AUTH_KEY',  '@B-]HkiQEwz4HXrgv_U0w 7CnzHMAJy92)S_~UiY.@Qo/AbTAc$[Rq7wJ0VrB|hS');
define('LOGGED_IN_KEY',    'f46-b,w7w)1(N{<?bXX,5ZIKoJoC.3nf*{Asy_}0,8SBjSQxVN`KocBQ[R&MHbEY');
define('NONCE_KEY',        'FJ>Ag(<lucSf;;$x.082<8Y79~>^w.hG.@CbeOUljoE~eb%KeE|IS<oLx~=OWf{6');
define('AUTH_SALT',        'O];1`~lC0+4+Fz!mn4r4I=|>)m(1s:q]1}l=.|3_z3!=XUW.OTj7Nf%PLT56^QVX');
define('SECURE_AUTH_SALT', 'uv.c~ 7[G-RsFIUI}2_Pow<T-*7=[[_,&co/IC:y/qErTS]JtI0NR.hmWORf9>4R');
define('LOGGED_IN_SALT',   'sC/ItQB8 3VQ)Ia4NvjEW3=) -`oCGsm{*6IuBq |m9LZNr~XT2!%JQ1%M,o5+m=');
define('NONCE_SALT',       'bLZ);?uh}(NHSlqKdU 8fR80wcVM9HltYPJ9Dqk5i$/4RP>>cx`m=mGyc{H!t+[+');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'prefix_here';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress.  A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de.mo to wp-content/languages and set WPLANG to 'de' to enable German
 * language support.
 */
define ('WPLANG', '');

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
