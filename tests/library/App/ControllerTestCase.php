<?php

/**
 * Description of ControllerTestCase
 *
 * @author Judzhin Miles
 */
class App_ControllerTestCase extends Zend_Test_PHPUnit_ControllerTestCase {

    public function setUp() {
        $this->bootstrap = new Zend_Application(APPLICATION_ENV, APPLICATION_PATH . '/configs/application.ini');
        parent::setUp();
    }

}
