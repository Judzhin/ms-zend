<?php

class IndexController extends Zend_Controller_Action {

    public function init() {
        /* Initialize action controller here */
    }

    public function indexAction() {
        // action body
    }

    public function phpinfoAction() {
        phpinfo();
    }

    public function aboutAction() {
        
        $message = $this->getParam('m');

        if ($message) {
            $this->view->message = $message;
        } else {
            $this->view->message = "No message";
        }
    }

}