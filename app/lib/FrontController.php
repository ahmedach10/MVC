<?php

namespace APP\LIB;

use APP\LIB\LANGUAGE\Language;
use APP\LIB\TEMPLATE\Template;

class FrontController
{

    /**
     * @var string $controller
     */
    private $controller = 'index';

    /**
     * @var string $action
     */
    private $action = 'default';

    /**
     * @var array $params
     */
    private $params = [];

    private $template;
    private $language;

    /**
     * Not Found Controller
     */
    const NOT_FOUND_CONTROLLER = 'APP\CONTROLLER\NotFoundController';

    /**
     * Not Found Action
     */
    const NOT_FOUND_ACTION = 'notFoundAction';

    /**
     * FrontController constructor.
     * @param Template $template
     */
    public function __construct(Template $template, Language $language)
    {
        $this->language = $language;
        $this->template = $template;
        $this->parseUrl();
    }

    /**
     * Parse Url and Exploded
     */
    private function parseUrl()
    {
        $url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $url = explode('/', trim($url, '/'), 3);

        // Define Controller
        if (isset($url[0]) && $url[0] != null):
            $this->controller = $url[0];
        endif;

        // Define Action
        if (isset($url[1]) && $url[1] != null):
            $this->action = $url[1];
        endif;

        // Define Params
        if (isset($url[2]) && $url[2] != null):
            $this->params = explode('/', $url[2]);
        endif;

    }

    /**
     * Defined Controller Class
     */
    public function dispatch()
    {
        $classController = 'APP\CONTROLLER\\' . ucfirst($this->controller) . 'Controller';
        $actionName = $this->action . 'Action';

        if (!class_exists($classController)):
            $classController = self::NOT_FOUND_CONTROLLER;
        endif;

        $controller = new $classController();

        if (!method_exists($controller, $actionName)):
            $this->action = $actionName = self::NOT_FOUND_ACTION;
        endif;

        $controller->setController($this->controller);
        $controller->setAction($this->action);
        $controller->setParams($this->params);
        $controller->setTemplate($this->template);
        $controller->setLanguage($this->language);
        $controller->$actionName();
    }
}
