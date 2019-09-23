<?php

namespace APP\CONTROLLER;

use APP\LIB\FrontController;
use APP\LIB\TEMPLATE\Template;

abstract class AbstractController
{

    /**
     * @var string $controller
     */
    protected $controller = 'index';

    /**
     * @var string $action
     */
    protected $action = 'default';

    /**
     * @var array $params
     */
    protected $params = [];

    /**
     * @var Template
     */
    protected $template;
    protected $language;
    protected $data = [];

    /**
     * Action Is Not Exists
     */
    public function NotFoundAction()
    {
        $this->view();
    }

    /**
     * @param string $controller
     */
    public function setController($controller)
    {
        $this->controller = $controller;
    }

    /**
     * @param string $action
     */
    public function setAction($action)
    {
        $this->action = $action;
    }

    /**
     * @param array $params
     */
    public function setParams($params)
    {
        $this->params = $params;
    }

    /**
     * @param mixed $template
     */
    public function setTemplate($template)
    {
        $this->template = $template;
    }

    /**
     * @param mixed $language
     */
    public function setLanguage($language)
    {
        $this->language = $language;
    }

    /**
     * View Method
     */
    public function view()
    {
        if ($this->action == FrontController::NOT_FOUND_ACTION):
            require_once APP_VIEW . 'notfound' . DS . 'notfound.view.php';
        else:
            $view = APP_VIEW . $this->controller . DS . $this->action . '.view.php';
            if (file_exists($view)):
                $this->data = array_merge_recursive($this->data, $this->language->getDictionary());
                $this->template->setActionView($view);
                $this->template->setData($this->data);
                $this->styled();
                $this->script();
                $this->template->renderApp();
            else:
                require_once APP_VIEW . 'notfound' . DS . 'noview.view.php';
            endif;
        endif;

    }

    /**
     * CSS Style
     */
    public function styled()
    {
        $view = 'css/' . $this->controller . '/' . $this->action . '.style.css';
        if (file_exists($view)):
            $view = CSS . $this->controller . '/' . $this->action . '.style.css';
            $this->template->setActionStyle($view);
            return true;
        endif;

        return false;
    }

    /**
     * JS Script
     */
    public function script()
    {
        $view = 'js/' . $this->controller . '/' . $this->action . '.script.js';
        if (file_exists($view)):
            $view = JS . $this->controller . '/' . $this->action . '.script.js';
            $this->template->setActionScript($view);
            return true;
        endif;
        return false;
    }

}