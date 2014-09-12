<?php

/**
 * Description of Free
 *
 * @author Judzhin Miles
 */
class App_Acl_Resource_Paid implements Zend_Acl_Resource_Interface {

    public function getResourceId() {
        return App_Acl_Resources::PAID;
    }

}