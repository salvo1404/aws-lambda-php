<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'wordpress');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'wordpressless');

/** MySQL hostname */
define('DB_HOST', 'lamba-wordpress.ca0p04e65fz8.ap-southeast-2.rds.amazonaws.com');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

define('WP_CONTENT_URL', 'https://s3-ap-southeast-2.amazonaws.com/wordpress-lambda/www/wp-content');
define('WP_HOME', 'https://4yloot81ub.execute-api.ap-southeast-2.amazonaws.com/FOUNDRY/wpless');
define('WP_SITEURL', 'https://4yloot81ub.execute-api.ap-southeast-2.amazonaws.com/FOUNDRY/wpless');



/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '88e65a1d7522300508c7b8b05c47c660b30e2170');
define('SECURE_AUTH_KEY',  'c9ddb48f8315089dcb4c9f95ce805d1bedf85ab5');
define('LOGGED_IN_KEY',    '1d9bece43c2b1dd8043df1d4a6424640765258dc');
define('NONCE_KEY',        '7ec91f523be7d957c36c2323420ed766814985f9');
define('AUTH_SALT',        '9a9093c75a151c7969c301310b3b5d3c5b53ae07');
define('SECURE_AUTH_SALT', '1d39ddeca1dac35a3a0905866e03086cd6ecac37');
define('LOGGED_IN_SALT',   '6a3512def1ac8c5d86846df0d1803ff4469f6630');
define('NONCE_SALT',       '0744fd87756a2185c8a923eae4bd0670997944d1');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

// If we're behind a proxy server and using HTTPS, we need to alert Wordpress of that fact
// see also http://codex.wordpress.org/Administration_Over_SSL#Using_a_Reverse_Proxy
if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') {
	$_SERVER['HTTPS'] = 'on';
}

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
