<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AclTest
 *
 * @author Judzhin Miles
 */
class App_AclTest extends App_ControllerTestCase {

    /**
     *
     * @var App_Acl
     */
    protected $_acl;

    public function setUp() {
        parent::setUp();
        $this->_acl = new App_Acl();
    }

    public function testAdminAccess() {
        $role = new App_Acl_Role_Admin();
        $this->assertTrue($this->_acl->isAllowed($role, App_Acl_Resources::PUBLICS));
        $this->assertTrue($this->_acl->isAllowed($role, App_Acl_Resources::FREE));
        $this->assertTrue($this->_acl->isAllowed($role, App_Acl_Resources::PAID));
        $this->assertTrue($this->_acl->isAllowed($role, App_Acl_Resources::ADMIN));
    }

    public function testGuestAccess() {
        $role = new App_Acl_Role_Guest();
        $this->assertFalse($this->_acl->isAllowed($role, App_Acl_Resources::ADMIN));
        $this->assertFalse($this->_acl->isAllowed($role, App_Acl_Resources::PAID));
        $this->assertFalse($this->_acl->isAllowed($role, App_Acl_Resources::FREE));
        $this->assertTrue($this->_acl->isAllowed($role, App_Acl_Resources::PUBLICS));
    }

    public function testPaidAccess() {
        $role = new App_Acl_Role_Paid();
        $this->assertFalse($this->_acl->isAllowed($role, App_Acl_Resources::ADMIN));
        $this->assertTrue($this->_acl->isAllowed($role, App_Acl_Resources::PAID));
        $this->assertFalse($this->_acl->isAllowed($role, App_Acl_Resources::FREE));
        $this->assertTrue($this->_acl->isAllowed($role, App_Acl_Resources::PUBLICS));
    }

}
