<?php

namespace APP\LIB\LANGUAGE;

class Language
{

    private $dictionary = array();

    public function laod($path)
    {
        $language = DEFAULT_LANG;

        if (isset($_SESSION['lang'])) :
            $language = $_SESSION['lang'];
        endif;

        $path_arr = explode('.', $path);
        $pathFileLang = APP_LANGUAGE . $language . DS . $path_arr[0] . DS . $path_arr[1] . '.lang.php';

        if (file_exists($pathFileLang)) :
            require $pathFileLang;
            if (isset($_) && is_array($_) && !empty($_)) :
                foreach ($_ as $key => $value) :
                    $this->dictionary[$key] = $value;
                endforeach;

            endif;
        else :
            trigger_error('This File' . $pathLang . 'is Not Exists', E_USER_WARNING);
        endif;
    }

    /**
     * @return array
     */
    public function getDictionary(): array
    {
        return $this->dictionary;
    }
}
