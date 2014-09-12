<?php

class CountryController extends Zend_Controller_Action {

    public function init() {
        $this->_helper->viewRenderer->setNoRender();
        //$this->_helper->getHelper('layout')->disableLayout();
    }

    public function indexAction() {
        $service = new App_Http_Client("judzhin", "mys3cr3tk3y");
        $response = $service->call("countrysearch", array("query" => "am"));
        Zend_Debug::dump($response);
    }

}

