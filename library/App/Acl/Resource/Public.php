<?php

/**
 * Description of Free
 *
 * @author Judzhin Miles
 */
class App_Acl_Resource_Public implements Zend_Acl_Resource_Interface {

    public function getResourceId() {
        return App_Acl_Resources::PUBLICS;
    }

}