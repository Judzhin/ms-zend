<?php

class App_Acl extends Zend_Acl {

    public function __construct() {

        // Add resources
        $resFree = new App_Acl_Resource_Free();
        $this->add($resFree);

        $resPaid = new App_Acl_Resource_Paid();
        $this->add($resPaid);

        $resAdmin = new App_Acl_Resource_Admin();
        $this->add($resAdmin);

        $resPublic = new App_Acl_Resource_Public();
        $this->add($resPublic);

        // Add roles
        $roleGuest = new App_Acl_Role_Guest();
        $this->addRole($roleGuest);

        $roleFree = new App_Acl_Role_Free();
        $this->addRole($roleFree, $roleGuest);

        $rolePaid = new App_Acl_Role_Paid();
        $this->addRole($rolePaid, $roleFree);

        $roleAdmin = new App_Acl_Role_Admin();
        $this->addRole($roleAdmin, $rolePaid);

        // Allows
        $this->allow($roleGuest, $resPublic);
        $this->allow($roleAdmin, $resAdmin);
        $this->allow($roleFree, $resFree);
        $this->allow($rolePaid, $resPaid);

        $this->deny($rolePaid, $resFree);
        $this->allow($roleAdmin, $resFree);
    }

}
