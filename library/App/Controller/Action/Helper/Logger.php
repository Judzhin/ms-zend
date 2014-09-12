<?php

/**
 * Logger helper class
 * 
 * @author 
 * @version
 *
 */
class App_Controller_Action_Helper_Logger extends Zend_Controller_Action_Helper_Abstract {

    /**
     * Logger instance
     *
     * @var Zend_Log The logger
     */
    private $logger;

    /**
     * Constructor: initialize plugin loader with logger instance 
     * depending on if configuration allows it
     * @return void
     */
    public function __construct() {
        $writer = new Zend_Log_Writer_Firebug();
        $this->logger = new Zend_Log($writer);
    }
    
    function direct($message, $priority) {
        if ($this->logger)
            $this->logger->log($message, $priority);
    }

    function __call($name, $arguments) {
        if ($this->logger) {
            $this->logger->$name($arguments[0]);
        }
    }

}
