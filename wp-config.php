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
define('DB_NAME', 'db_9bd244_moj_1');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'ASDqwe123');

/** MySQL hostname */
define('DB_HOST', '192.168.7.57');

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
define('AUTH_KEY',         '*$`p-eO^6|mXg!6C0;U,#SQI],EAS98.^<c<M[i#/qZo1CprIvS 4YcO}+{67x#%');
define('SECURE_AUTH_KEY',  '){Ix~(J{02#GF0|2QpeAPhy4gV-f.BhB[HE(|)WxwNZQ55qkJD1$g|K&ui=5+yHe');
define('LOGGED_IN_KEY',    '+cPsAhL7,GAnM1HHO10fhxLB`<[` =`th,BZ`Y,Tr+k2R|R7^G!lU?C{6n>G_/2Y');
define('NONCE_KEY',        'w9lJ1#cSNC){!{h,D@e=O.D%2n3 w?K_ur^SsCDF3jE#NF1jo@7J<(cW@6+NGTj>');
define('AUTH_SALT',        'K@M||%Vh2OBc}&:A!7Q3Ucp*4V*h*x3CAyf$^a/r#8!<u6<%?m&{bs|(VBsrz+-G');
define('SECURE_AUTH_SALT', 'qO]c/Ue77iO:#~=d#pk;P0r#l6Rw/b806.h;wf,|HBoI|U7P$31T>o0-e}G7V+-x');
define('LOGGED_IN_SALT',   ':]9s.OY|<qpvxFy~~J4q4@aI/a]FGn-)}{Dv~apz/SY^pENMeuUTLH8@l|K:n*xh');
define('NONCE_SALT',       '=tZ#,_:}HGx$w`k{LKg^g9nyE/k,=CK3B6C;=7c?#1wJQt*w:_Dd|pp`]Fjk.gU:');

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

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');