<?php

namespace APP\LIB\TEMPLATE;

class Template
{
    /**
     * @var array
     */
    private $file_res;
    private $action_view;
    private $action_style;
    private $action_script;
    private $data = [];


    /**
     * Template constructor.
     * @param array $file_res
     */
    public function __construct(array $file_res)
    {
        $this->setFileRes($file_res);
    }

    /**
     * @param mixed $action_script
     */
    public function setActionScript($action_script)
    {
        $this->action_script = $action_script;
    }

    /**
     * @param mixed $action_style
     */
    public function setActionStyle($action_style)
    {
        $this->action_style = $action_style;
    }

    /**
     * @param array $file_res
     */
    public function setFileRes($file_res)
    {
        $this->file_res = $file_res;
    }

    /**
     * @param mixed $action_view
     */
    public function setActionView($action_view)
    {
        extract($this->data);
        $this->action_view = $action_view;
    }

    /**
     * @param mixed $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }

    /**
     * Render All File Application
     */
    public function renderApp()
    {
        extract($this->data);
        $this->renderHtmlStart();
        $this->renderStyle();
        $this->renderBodyStart();
        $this->renderView();
        $this->renderScript();
        $this->renderBodyEnd();
        $this->renderHtmlEnd();
    }

    /**
     * Render ActionView
     */
    public function renderView()
    {
        if (!key_exists('template', $this->file_res)):
            echo 'Nothing';
        else:
            $v = $this->file_res['template'];
            if (!empty($v)):
                extract($this->data);
                foreach ($v as $name => $files):
                    if ($name == '__view'):
                        require_once $this->action_view;
                    else:
                        require_once $files;
                    endif;
                endforeach;
            else:
                echo 'File Empty';
            endif;
        endif;
    }

    /**
     * Render ActionStyled
     */
    public function renderStyle()
    {
        if (!key_exists('header_res', $this->file_res)):
            echo 'Nothing';
        else:
            $v = $this->file_res['header_res'];
            if (!empty($v)):
                foreach ($v as $name => $files):
                    if ($name == 'css'):
                        foreach ($files as $css => $style):
                            if ($css == '__css'):
                                echo '<link rel="stylesheet" href="'. $this->action_style . '">';
                            else:
                                echo '<link rel="stylesheet" href="'. $style . '">';
                            endif;
                        endforeach;
                    elseif ($name == 'js'):
                       foreach ($files as $script):
                        echo '<script src="'. $script .'"></script>';
                       endforeach;
                    endif;
                endforeach;
            else:
                echo 'File Empty';
            endif;
        endif;
    }

    /**
     * Render ActionScript
     */
    public function renderScript()
    {
        if (!key_exists('footer_res', $this->file_res)):
            echo 'Nothing';
        else:
            $v = $this->file_res['footer_res'];
            if (!empty($v)):
               foreach($v as $js => $script):
                   if ($js == '__js'):
                        echo  '<script src="'. $this->action_script . ' "></script>';
                   else:
                       echo  '<script src="'. $script . ' "></script>';
                   endif;
               endforeach;
            else:
                echo 'File Empty';
            endif;
        endif;
    }

    /**
     * Import Files from Template Folder
     */
    private function renderHtmlStart()
    {
        extract($this->data);
        require_once APP_TEMPLATE . 'html_start.php';
    }

    private function renderHtmlEnd()
    {
        extract($this->data);
        require_once APP_TEMPLATE . 'html_end.php';
    }

    private function renderBodyStart()
    {
        extract($this->data);
        require_once APP_TEMPLATE . 'body_start.php';
    }

    private function renderBodyEnd()
    {
        extract($this->data);
        require_once APP_TEMPLATE . 'body_end.php';
    }

}

