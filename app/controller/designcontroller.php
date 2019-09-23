<?php

namespace APP\CONTROLLER;

class DesignController extends AbstractController
{
    public function defaultAction()
    {
        $this->language->laod('template.common');
        $this->view();
    }

    public function addAction()
    {
        $this->view();
    }


}