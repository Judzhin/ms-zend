<?php

class App_Http_Client {

    const URI = 'http://zend.local:81/api';
    const HTTP_METHOD = 'POST';

    /**
     *
     * @var Zend_Http_Client
     */
    protected $_client;
    protected $_username;
    protected $_key;

    public function __construct($username, $key) {
        $this->_client = new Zend_Http_Client();

        $this->_username = $username;
        $this->_key = $key;
    }

    public function call($method, $args) {
        $this->_client->setUri(self::URI . '/' . $method);

        $this->_client->setParameterPost('username', $this->_username);

        foreach ($args as $key => $val) {
            $this->_client->setParameterPost($key, $val);
        }

        $this->_client->setParameterPost('auth', $this->getParameters($args));

        $result = $this->_client->request(self::HTTP_METHOD);

        return Zend_Json_Decoder::decode($result->getBody());
    }

    /**
     * 
     * @param array $args
     * @return type
     */
    private function getParameters($args) {

        $args['username'] = $this->_username;

        ksort($args);

        $parameters = '';

        foreach ($args as $key => $val) {
            $parameters .= $key . $val;
        }

        return md5($this->_key . $parameters);
    }

}
