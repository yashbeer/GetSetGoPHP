<?php
// Database Constants
defined('DB_SERVER')	? null : define("DB_SERVER", "localhost");
defined('DB_USER')		? null : define("DB_USER", "root");
defined('DB_PASS')		? null : define("DB_PASS", "");
defined('DB_NAME')		? null : define("DB_NAME", "getsetgo");

//url constants
defined('BASE_URL')		? null : define("BASE_URL", "http://localhost/getsetgophp");
defined('REDIRECT_URL')	? null : define("REDIRECT_URL", BASE_URL."login.php");

// File system paths
defined('DS') ? null : define('DS', DIRECTORY_SEPARATOR);
defined('INCLUDE_PATH') ? null : define( 'INCLUDE_PATH', dirname(__FILE__) );
defined('SITE_ROOT')	? null : define( 'SITE_ROOT', str_replace(DS."includes", "", INCLUDE_PATH) );
defined('DRIVE_LETTER') ? null : define( 'DRIVE_LETTER', substr(__FILE__, 0, 1) );

// loading core files
require_once(INCLUDE_PATH.DS."session.php");
require_once(INCLUDE_PATH.DS."functions.php");
require_once(INCLUDE_PATH.DS."database.php");
require_once(INCLUDE_PATH.DS."database_object.php");

//loading helper files
require_once(INCLUDE_PATH.DS."user.php");
require_once(INCLUDE_PATH.DS."log.php");
require_once(INCLUDE_PATH.DS."upload.php");
require_once(INCLUDE_PATH.DS."phpmail.php");
?>