<?php
defined('BASEPATH') or exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
defined('SHOW_DEBUG_BACKTRACE') or define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
defined('FILE_READ_MODE')  or define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') or define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE')   or define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE')  or define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/
defined('FOPEN_READ')                           or define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE')                     or define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE')       or define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE')  or define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE')                   or define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE')              or define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT')            or define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT')       or define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

define('DATE', date('Y-m-d'));
define('DATE_TIME', date('Y-m-d H:i:s'));


/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
*/
defined('EXIT_SUCCESS')        or define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR')          or define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG')         or define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE')   or define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS')  or define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') or define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     or define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE')       or define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN')      or define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      or define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code


define('DB_SERVER', 'localhost:3306	');
define('DB_USER', 'root');
define('DB_PASS', 'prabhs226');
define('DB_DATABASE', 'delivery_eztakeout');
define('DOMAIN_URL', 'http://localhost:88/deliveryripple/');  //http://localhost/deliveryripple/
define('DOMAIN_BASE_URL', $_SERVER['DOCUMENT_ROOT'] . '/deliveryripple');
define('BASE_URL', $_SERVER['DOCUMENT_ROOT'] . '/deliveryripple/admin/');
define('PHP_PATH', 'php');


define('SITE_URL', DOMAIN_URL . 'admin');
define("ADMIN_INCLUDE_PATH", BASE_URL . 'include');
define('UPLOAD_PATH', DOMAIN_BASE_URL . '/upload/');
define('UPLOAD_URL', DOMAIN_URL . 'upload/');
define('CURRENCY', '$');

define("TBL_PREFIX", "tbl_");
define('TBL_ADMIN', TBL_PREFIX . "admin");
define("TBL_CUISINE", TBL_PREFIX . "cuisine");
define("TBL_CATEGORIES", TBL_PREFIX . "categories");
define("TBL_STORE_CATEGORIES", TBL_PREFIX . "grocerycategories");
define("TBL_SUBCATEGORIES", TBL_PREFIX . "subcategories");
define("TBL_STORE_SUBCATEGORIES", TBL_PREFIX . "subgrocery");
define("TBL_SIDES", TBL_PREFIX . "sides");
define("TBL_ADDON", TBL_PREFIX . "addon");
define("TBL_CITY", TBL_PREFIX . 'city');
define("TBL_STATE", TBL_PREFIX . 'state');
define("TBL_COUNTRY", TBL_PREFIX . 'country');
define("TBL_USERS", TBL_PREFIX . 'users');
define("TBL_OWNERS", TBL_PREFIX . 'owner');
define("TBL_STORE_OWNERS", TBL_PREFIX . 'store_owner');
define("TBL_RESTAURANTS", TBL_PREFIX . 'restaurants');
define("TBL_STORES", TBL_PREFIX . 'grocerystores');
define("TBL_NOTIFICATION", TBL_PREFIX . 'notification');
define("TBL_ORDERS", TBL_PREFIX . 'orders');
define("TBL_ADDRESS", TBL_PREFIX . 'user_addresses');
define("TBL_ORDERDETAIL", TBL_PREFIX . 'order_details');
define("TBL_DEVICE_TOKENS", TBL_PREFIX . 'device_token');
define("TBL_SETTINGS", TBL_PREFIX . 'settings');
define("TBL_COUPONS", TBL_PREFIX . 'coupons');

define("ASSETSPATH", SITE_URL . '/assets/');
define("LOGIN_PATH", SITE_URL . '/login');
define("FORGET_PASSWORD", LOGIN_PATH . '/forgot_password');
define("CUSTOMER_PATH", SITE_URL . '/customers');
define("OWNER_PATH", SITE_URL . '/owners');
define("STORE_OWNER_PATH", SITE_URL . '/StoreOwners');
define("CUISINE_PATH", SITE_URL . '/cuisine');
define("CATEGORY_PATH", SITE_URL . '/categories');
define("STORE_CATEGORY_PATH", SITE_URL . '/storecategories');
define("SUBCATEGORY_PATH", SITE_URL . '/subcategories');
define("STORE_SUBCATEGORY_PATH", SITE_URL . '/storesubcategories');
define("SIDES_PATH", SITE_URL . '/sides');
define("ADDON_PATH", SITE_URL . '/addon');
define("RESTAURANTS_PATH", SITE_URL . '/restaurants');
define("STORES_PATH", SITE_URL . '/stores');
define("NOTIFICATION_PATH", SITE_URL . '/notification');
define("LOGOUT_PATH", SITE_URL . '/logout');
define("ERROR_PATH", SITE_URL . '/errors');
define("DASHBOARD_PATH", SITE_URL . '/dashboard');
define("SETTINGS_PATH", SITE_URL . '/settings');
define("TBL_EARNINGS", TBL_PREFIX . 'earnings');
define("TBL_ORDER_DRIVERS", TBL_PREFIX . 'driver_orders');

define("COUNTRY_PATH", SITE_URL . '/country');
define("STATE_PATH", SITE_URL . '/state');
define("CITY_PATH", SITE_URL . '/city');
define("ORDER_PATH", SITE_URL . '/orders');
define("PROFILE_PATH", SITE_URL . '/profile');
define("DRIVERS_PATH", SITE_URL . '/drivers');
define("COUPONS_PATH", SITE_URL . '/coupons');
