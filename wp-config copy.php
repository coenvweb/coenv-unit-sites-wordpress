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

/**
 * Environmental check for db host and multisite url (see below)
 */
//define('WP_CACHE', true); //Added by WP-Cache Manager
$coenv_host = $_SERVER['HTTP_HOST'];
$coenv_host_dev = strpos($coenv_host,'.local');
$coenv_host_staging = strpos($coenv_host,'beta.');
$coenv_host_atmos = strpos($coenv_host,'atmos');
if($coenv_host_staging === 0) {
    $coenv_host_staging = TRUE;
}
if($coenv_host_atmos === 0) {
    $coenv_host_atmos = TRUE;
}


// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
if($coenv_host_atmos && $coenv_host_dev) {
    define('DB_NAME', 'coenv_atmos'); // local atmos development
} elseif($coenv_host_atmos) { // live atmos server
    define('DB_NAME', 'wp_atmos');
} else {
    define('DB_NAME', 'coenv_multi');
}

/** MySQL database username */

/** MySQL database password */
if($coenv_host_atmos && $coenv_host_dev) {
    define('DB_USER', 'root');
    define('DB_PASSWORD', 'root'); 
} elseif($coenv_host_staging) {
    define('DB_USER', 'coenv_multi');
    define('DB_PASSWORD', '3kB9BWXGjnajVj');
} elseif($coenv_host_dev) {
    define('DB_USER', 'root');
    define('DB_PASSWORD', 'root');
} elseif($coenv_host_atmos) {
    define('DB_USER', 'coenvweb');
    define('DB_PASSWORD', 'j3GAgMrm1wxUEUSN');
} else {
    define('DB_USER', 'coenv_multi');
    define('DB_PASSWORD', 'pYVNY2WPdrMpdWju');
}


/** MySQL hostname */
if($coenv_host_atmos && $coenv_host_dev) {
  define('DB_HOST', 'localhost'); 
} elseif ($coenv_host_dev || $coenv_host_staging)  {
  define('DB_HOST', 'localhost');
} else {
  define('DB_HOST', '127.0.0.1');
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
define('AUTH_KEY',         '<q@I+):B w[ SUW+BM-Qo}aNu9A{`rs[O*BV~F.[ozFu8K|jcQPgJSz%sAWeFPSY');
define('SECURE_AUTH_KEY',  '1+F#.$<,Z{h^`#l?6.TZ%=f}]tpQomY[Da28*0ng]BSHnZ3zxrR5V?<etdYufG{r');
define('LOGGED_IN_KEY',    '~9e0d0J(-VD,Uio{+XNO9x=:KoGQ@+!rO+?-8x:Nv=tZD1=leY]{jw77z!?@6J>y');
define('NONCE_KEY',        '2GX*6QpgAI-&MOQokqL,XfXU+tr1rc.>v^8HdW]W?^az_bRxNwBY=jY#||Qo|tRj');
define('AUTH_SALT',        'Zw@PAF5+,uywHl`])s,[sH98iGn2uMo5|63mSZJH_lsDk_l8g*8O~RDZ8Wo-B=wH');
define('SECURE_AUTH_SALT', '<26sgV:|Q-i%ci6:=5JG1ibLk|mHT_mOMIAA>DR`5^~$(6rjT12GXfRh.B.yvR=}');
define('LOGGED_IN_SALT',   'gtz9h[P{%x?j)ZW/(-/=i|@s!pgW8JE:(.>,ELO66=Ad-D-J&RB|,Wv}BSYK( JA');
define('NONCE_SALT',       'Nb09=ry.]Omy^#/vyvcM>HveN!-2_8l}XfC%xs*GhP|-G3p;Zcyv|i]2|@BeGudD');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'FpKp_';

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
/* Multisite */
if($coenv_host_atmos) {
} else {
    define( 'WP_ALLOW_MULTISITE', true );
    define('MULTISITE', true);
    define('SUBDOMAIN_INSTALL', false);
}

if ($coenv_host_atmos && $coenv_host_dev) {
  define('DOMAIN_CURRENT_SITE', 'atmos.uw.local');
  define('PATH_CURRENT_SITE', '/');
} elseif ($coenv_host_dev)  {
  define('DOMAIN_CURRENT_SITE', 'cms.coenv.uw.local');
  define('PATH_CURRENT_SITE', '/');
  define('SITE_ID_CURRENT_SITE', 1);
  define('BLOG_ID_CURRENT_SITE', 1);
} elseif ($coenv_host_staging) {
  define('DOMAIN_CURRENT_SITE', 'beta.multi.environment.uw.edu');
  define('PATH_CURRENT_SITE', '/');
  define('SITE_ID_CURRENT_SITE', 1);
  define('BLOG_ID_CURRENT_SITE', 1);
} else {
  define('DOMAIN_CURRENT_SITE', 'cms.coenv.uw.edu');
  define('PATH_CURRENT_SITE', '/');
  define('SITE_ID_CURRENT_SITE', 1);
  define('BLOG_ID_CURRENT_SITE', 1);
}


// set max post revisions    
define('WP_POST_REVISIONS', 5);
if ($coenv_host_dev || $coenv_host_staging)  {
	define('FORCE_SSL_ADMIN', false);
} else {
	define('FORCE_SSL_ADMIN', true);
}

/* Testing */
// Enable WP_DEBUG mode
if ($coenv_host_dev || $coenv_host_staging)  {
    define('WP_DEBUG', true);
    define('WP_DEBUG_LOG', false);
    define('WP_DEBUG_DISPLAY', true); 
    define('WP_MEMORY_LIMIT', '96M');
    $db = new PDO('mysql:dbname='.DB_NAME.';host='.DB_HOST, DB_USER, DB_PASSWORD);
    $stmt = $db->prepare("UPDATE FpKp_sitemeta SET meta_value = 0 WHERE meta_key = 'shibboleth_default_login';");
    $stmt->execute();
} else {
    define('WP_DEBUG', false);
    define('WP_DEBUG_LOG', false);
    define('WP_DEBUG_DISPLAY', false); 
    define('WP_MEMORY_LIMIT', '96M');
}

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');
if(!$coenv_host_atmos) {
	/** Sunrise for domain mapping **/
	define( 'SUNRISE', 'on' );
}
/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
