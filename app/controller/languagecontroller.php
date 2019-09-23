<?php

namespace APP\CONTROLLER;

use APP\LIB\FILTER\Redirect;

class LanguageController extends AbstractController
{
    use Redirect;

    public function defaultAction()
    {
        if ($_SESSION['lang'] == 'ar') :
            $_SESSION['lang'] = 'en';
        else :
            $_SESSION['lang'] = 'ar';
        endif;

        // Redirect::redirect($_SERVER['HTTP_REFERER']);
    }
}
