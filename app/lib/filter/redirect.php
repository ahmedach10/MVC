<?php

namespace APP\LIB\FILTER;

trait Redirect
{
    public static function redirect($path)
    {
        session_write_close();
        header('location: ' . $path);
        exit;
    }
}
