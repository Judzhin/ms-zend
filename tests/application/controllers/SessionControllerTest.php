<?php

class SessionControllerTest extends App_ControllerTestCase {

    public function testIndexAction() {
        $this->dispatch('/session');
        $this->assertModule('default');
        $this->assertController('session');
        $this->assertAction('index');
    }
}

