<?php

namespace APP;

use APP\LIB\FrontController;
use APP\LIB\LANGUAGE\Language;
use APP\LIB\SESSION\SessionManager;
use APP\LIB\TEMPLATE\Template;

if (!defined('DS')) :
    define('DS', DIRECTORY_SEPARATOR);
endif;

// Import Autoload File && Config File
require_once '..' . DS . 'app' . DS . 'config' . DS . 'config.php';
require_once '..' . DS . 'app' . DS . 'lib' . DS . 'AutoLoad.php';
$temp_res = require_once '..' . DS . 'app' . DS . 'config' . DS . 'template_res.php';

$session = new SessionManager();
if (!isset($session->lang)) {
    $session->lang = DEFAULT_LANG;
}

var_dump($session->lang);

$template = new Template($temp_res);
$lang = new Language();

$c = new FrontController($template, $lang);
$c->dispatch();