<?php
/** 
 * The base configurations of the WordPress.
 *
 **************************************************************************
 * Do not try to create this file manually. Read the README.txt and run the 
 * web installer.
 **************************************************************************
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. 
 *
 * This file is used by the wp-config.php creation script during the
 * installation.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'enfoqw_db1');

/** MySQL database username */
define('DB_USER', 'enfoqw_1');

/** MySQL database password */
define('DB_PASSWORD', 'Tc1BkV18');

/** MySQL hostname */
define('DB_HOST', 'dedi630.your-server.de');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');
define('VHOST', 'yes'); 
$base = '/';
define('DOMAIN_CURRENT_SITE', 'enfoque19.com' );
define('PATH_CURRENT_SITE', '/' );
define('SITE_ID_CURRENT_SITE', 1);
define('BLOGID_CURRENT_SITE', '1' );

/**#@+
 * Authentication Unique Keys.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/ WordPress.org secret-key service}
 *
 * @since 2.6.0
 */
define('AUTH_KEY', '9dc7e625d8422fe20c9ab29f839b06ebeee1f68b342265c7a6b7260a26249dfc');
define('SECURE_AUTH_KEY', 'edb6797d42fdbd1e55250efec03de69a9685f8b1dfc07d127e4959eeadf12926');
define('LOGGED_IN_KEY', '0e4161e6695746d47fe9f095412943027a5068b8e713d441b8f16615a1b4e876');
define('NONCE_KEY', '2eb3d93d6476bd63949d89be43d54b847da84b7eacf9c9fe24b1ddcb2ce744da');
define('AUTH_SALT', '16e32826394590ad3069c557a93ad5102b7349806c575418113c23d9e4440496');
define('LOGGED_IN_SALT', '5c7b06daf521ad80ec3be0cfd4bc020a1584dfdf23101844efeeb4f92636495e');
define('SECURE_AUTH_SALT', '73c82247f3f9d2ec01828178b556ae23103fcaed701c699ce78cc4b99629d239');
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
 * Change this to localize WordPress.  A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de.mo to wp-content/languages and set WPLANG to 'de' to enable German
 * language support.
 */
define ('WPLANG', '');

// double check $base
if( $base == 'BASE' )
	die( 'Problem in wp-config.php - $base is set to BASE when it should be the path like "/" or "/blogs/"! Please fix it!' );

// uncomment this to enable wp-content/sunrise.php support
//define( 'SUNRISE', 'on' );

// uncomment to move wp-content/blogs.dir to another relative path
// remember to change WP_CONTENT too.
// define( "UPLOADBLOGSDIR", "fileserver" );

// If VHOST is 'yes' uncomment and set this to a URL to redirect if a blog does not exist or is a 404 on the main blog. (Useful if signup is disabled)
// For example, the browser will redirect to http://examples.com/ for the following: define( 'NOBLOGREDIRECT', 'http://example.com/' );
// Set this value to %siteurl% to redirect to the root of the site
// define( 'NOBLOGREDIRECT', '' );
// On a directory based install you must use the theme 404 handler.

// Location of mu-plugins
// define( 'WPMU_PLUGIN_DIR', '' );
// define( 'WPMU_PLUGIN_URL', '' );
// define( 'MUPLUGINDIR', 'wp-content/mu-plugins' );

// Uncomment to disable the site admin bar
//define( 'NOADMINBAR', 1 );

define( "WP_USE_MULTIPLE_DB", false );

/* That's all, stop editing! Happy blogging. */

/** WordPress absolute path to the Wordpress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
?>
