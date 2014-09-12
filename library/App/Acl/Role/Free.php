<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Guest
 *
 * @author Judzhin Miles
 */
class App_Acl_Role_Free implements Zend_Acl_Role_Interface {

    public function getRoleId() {
        return App_Acl_Roles::FREE;
    }

}
