<?php

namespace APP\LIB\FILTER;

trait Validate
{

    /**
     * @var array Patterns
     */
    private $regExpPatterns = [
        'num'       =>'/^[0-9]+(?:\.[0-9]+)?$/',
        'int'       => '/^[0-9]+$/',
        'float'     => '/^[0-9]+(\.[0-9]+)$/',
        'alpha'     => '/^[a-zA-Z\p{Arabic}]+$/u',
        'alphanum'  => '/^[a-zA-Z\p{Arabic}0-9]+$/u'
    ];

    /**
     * Should Be Not Empty
     * @param $value
     * @return bool
     */
    public function req($value)
    {
        return '' != $value || empty($value);
    }

    /**
     * Should Be Number
     * @param $num
     * @return bool
     */
    public function num($num)
    {
        return (bool) preg_match($this->regExpPatterns['num'], $num);
    }

    /**
     * Should Be Float
     * @param $float
     * @return bool
     */
    public function float($float)
    {
        return (bool) preg_match($this->regExpPatterns['float'], $float);
    }

    /**
     * Should Be Alpha
     * @param $alpha
     * @return bool
     */
    public function alpha($alpha)
    {
        return (bool) preg_match($this->regExpPatterns['alpha'], $alpha);
    }

    /**
     * Should Be Alpha Numeric
     * @param $alphanum
     * @return bool
     */
    public function alphaNum($alphanum)
    {
        return (bool) preg_match($this->regExpPatterns['alphanum'], $alphanum);
    }
}