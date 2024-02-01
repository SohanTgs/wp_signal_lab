<?php

namespace Viserlab\Controllers;

use Viserlab\BackOffice\CoreController;

class Controller extends CoreController
{

    public $viewPath = '';
    public $pageTitle;

    public function __construct()
    {
        $this->viewPath = VISERLAB_ROOT . 'views';

        add_filter('wp_title',function($title, $sep){
            return esc_html($this->pageTitle) . ' '.$sep.' '. $title;
        }, 10, 2);
    }
}



