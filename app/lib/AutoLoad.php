<?php

namespace APP\LIB;

class AutoLoad
{
    public static function autoload($class)
    {
        $class = str_replace('APP', '', $class);
        $class = str_replace('\\', '/', $class);
        $class = APP_PATH . strtolower($class) . '.php';

        if (file_exists($class)) :
            require_once $class;
        endif;
    }
}

spl_autoload_register(__NAMESPACE__ . '\AutoLoad::autoload');