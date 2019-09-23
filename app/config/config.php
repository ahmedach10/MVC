<?php


if (!defined('DS')) :
    define('DS', DIRECTORY_SEPARATOR);
endif;

// Real Path
define('APP_PATH', dirname(realpath(__FILE__)) . DS . '..' . DS);

// Folder Path
define('APP_VIEW', APP_PATH . 'view' . DS);
define('APP_MODEL', APP_PATH . 'model' . DS);
define('APP_TEMPLATE', APP_PATH . 'template' . DS);
define('APP_LANGUAGE', APP_PATH . 'language' . DS);

define('CSS', '/css/');
define('JS', '/js/');

// Database Informations
defined('DATABASE_HOST_NAME') ? null : define('DATABASE_HOST_NAME', 'www.mvc.com');
defined('DATABASE_DB_NAME') ? null : define('DATABASE_DB_NAME', 'any');
defined('DATABASE_USER_NAME') ? null : define('DATABASE_USER_NAME', 'root');
defined('DATABASE_PASSWORD') ? null : define('DATABASE_PASSWORD', '');
defined('DATABASE_CNN_DRIVER') ? null : define('DATABASE_CNN_DRIVER', 1);



// Session Information
define('S_NAME', 'APP_ACH');
define('S_HTTP_ONLY', true);
define('S_SAVE_PATH', APP_PATH  . '..' . DS . 'session' . DS);
define('S_PATH', '/');
define('S_DOMIN', '.mvc.com');
define('S_SECURE', false);
define('S_LIFE_TIME', 0);

// Language
define('DEFAULT_LANG', 'ar');
