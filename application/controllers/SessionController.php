<?php

class SessionController extends Zend_Controller_Action {

    /**
     * @var Zend_Session_Namespace
     */
    protected $session = null;

    /**
     * Before action
     */
    public function preDispatch() {

        $this->session = new Zend_Session_Namespace('Default');


        if (isset($this->session->counter)) {
            $this->session->counter++;
        } else {
            $this->session->counter = 0;
        }
    }

    public function indexAction() {
        $this->view->message = $this->session->counter;
    }

    public function pagetwoAction() {
        $this->session->counter += 10;
        $this->view->message = $this->session->counter;
    }

}