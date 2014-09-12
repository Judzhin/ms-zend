<?php

class ApiController extends Zend_Controller_Action {

    protected $_application;
    protected $_config;
    protected $_key;

    public function init() {
        $this->_helper->viewRenderer->setNoRender();
    }

    public function preDispatch() {
        $this->_config = new Zend_Config_Ini("../application/configs/access.ini", "development");

        if (!$this->accepted()) {
            throw new Exception("Private key authentication failed");
        }
    }

    /**
     * The default action - show the home page
     */
    public function indexAction() {
        
    }

    public function countrysearchAction() {
        $query = $this->getRequest()->getParam("query");
        $countryes = new App_Countries();
        echo Zend_Json_Encoder::encode($countryes->searchCountries($query));
    }

    private function accepted() {

        $this->_application = $this->getRequest()->getParam('username');
        $keys = $this->_config->api->toArray();

        $this->_key = $keys[$this->_application]['key'];
        $signature = $this->getSignature($_POST);


        if ($signature == $this->getRequest()->getParam('auth')) {
            return true;
        }

        return false;
    }

    private function getSignature($args) {

        ksort($args);

        $parameters = '';

        foreach ($args as $key => $val) {

            if ($key == 'auth') {
                continue;
            }

            $parameters .= $key . $val;
        }
        return md5($this->_key . $parameters);
    }

}