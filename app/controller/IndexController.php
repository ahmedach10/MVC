<?php

namespace APP\CONTROLLER;

use APP\MODEL\AdminModel;


class IndexController extends AbstractController
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