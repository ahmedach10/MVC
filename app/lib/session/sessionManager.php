<?php

namespace APP\LIB\SESSION;

class SessionManager extends \SessionHandler
{
    // Session Information
    private $sessionName = S_NAME;
    private $sessionMaxLifeTime = S_LIFE_TIME;
    private $sessionHTTPOnly = S_HTTP_ONLY;
    private $sessionSSL = S_SECURE;
    private $sessionPath = S_PATH;
    private $sessionDomain = S_DOMIN;

    // Session Save Path 
    private $sessionSavePath = S_SAVE_PATH;

    // Session Cipher Algorithms
    private $sessionCipherAlgo =  "AES-128-ECB";
    private $sessionCipherKey =  "MYCRYPT0K3Y@2019";

    // Time Generate Session
    private $ttl = 15;


    public function __construct()
    {
        ini_set("session.use_cookies", 1);
        ini_set("session.use_only_cookies", 1);
        ini_set("session.use_trans_sid", 0);
        ini_set("session.save_handler", 'files');

        session_name($this->sessionName);
        session_save_path($this->sessionSavePath);

        session_set_cookie_params(
            $this->sessionMaxLifeTime,
            $this->sessionPath,
            $this->sessionDomain,
            $this->sessionSSL,
            $this->sessionHTTPOnly
        );


        $this->sessionStart();
    }

    /**
     * Check Session Version
     */
    private function sessionVersion()
    {
        /**
         * If PHP version Greater Then or Equal 7.0.0
         */
        if (version_compare(PHP_VERSION, '7.0.0') >= 0) :
            if (session_status() == PHP_SESSION_NONE) :
                return session_start(array(
                    'cache_limiter' => 'private',
                    'read_and_close' => false
                ));
            endif;

            /**
             * If PHP version Greater Then 5.4.0
             */
        elseif (version_compare(PHP_VERSION, '5.4.0') >= 0) :
            if (session_status() == PHP_SESSION_NONE) :
                return session_start();
            endif;

            /**
             * If PHP version Lase Then 5.4.0
             */
        else :
            if (session_id() == '') :
                return session_start();
            endif;

        endif;
    }

    /* 
    * Session Start
    */
    public function sessionStart()
    {
        if ($this->sessionVersion()) {
            $this->setSessionStartTime();
            $this->checkSessionValidity();
        }
    }

    /**
     * Set Session Start Time
     */
    private function setSessionStartTime()
    {
        if (!isset($this->timeStartSession)) {
            $this->timeStartSession = time();
        }
        return true;
    }

    private function checkSessionValidity()
    {
        if ((time() - $this->timeStartSession) > ($this->ttl * 60)) {
            $this->renewSession();
            $this->generateFingerPrint();
        }

        return true;
    }

    private function renewSession()
    {
        $this->timeStartSession = time();
        return session_regenerate_id(true);
    }

    /**
     * Read Session
     */
    public function read($id)
    {
        return openssl_decrypt(parent::read($id), $this->sessionCipherAlgo, $this->sessionCipherKey);
    }

    /**
     * Write Data in Session File
     */
    public function write($session_id, $session_data)
    {
        return parent::write($session_id, openssl_encrypt($session_data, $this->sessionCipherAlgo, $this->sessionCipherKey));
    }


    public function __get($key)
    {
        return (false !== $_SESSION[$key]) ? $_SESSION[$key] : false;
    }


    public function __set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public function __isset($key)
    {
        return isset($_SESSION[$key]) ? true : false;
    }

    /**
     * Destroy Session and Delete Cookie
     */
    public function destroySession()
    {
        session_unset();

        /* Delete Cookie */
        setcookie(
            $this->sessionName,
            '',
            (time() - 1000),
            $this->sessionPath,
            $this->sessionDomain,
            $this->sessionSSL,
            $this->sessionHTTPOnly
        );

        session_destroy();
    }

    private function generateFingerPrint()
    {
        $userAgentId = $_SERVER['HTTP_USER_AGENT'];
        $this->cipherKey = rand(20, 10000);
        $sessionId = session_id();
        $this->fingerPrint = md5($userAgentId . $this->cipherKey . $sessionId);
    }

    public function isValidFingerPrint()
    {
        if (!isset($this->fingerPrint)) {
            $this->generateFingerPrint();
        }

        $fingerPrint = md5($_SERVER['HTTP_USER_AGENT'] . $this->cipherKey . session_id());

        if ($fingerPrint === $this->fingerPrint) {
            return true;
        }

        return false;
    }
}
