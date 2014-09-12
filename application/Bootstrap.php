<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap {

    /**
     * Init Namespace
     * @return type
     */
    protected function _initAutoload() {

        $options = array(
            'namespace' => '',
            'basePath' => APPLICATION_PATH,
        );

        $module = new Zend_Application_Module_Autoloader($options);

        $autoloader = Zend_Loader_Autoloader::getInstance();
        $autoloader->registerNamespace('App');
        $autoloader->registerNamespace('Doctrine');
        return $autoloader;
    }

    /**
     * 
     */
    protected function _initControllerPlugins() {
        $front = Zend_Controller_Front::getInstance();
        $front->registerPlugin(new App_Controller_Plugin_AssetGrabber());
    }

    /**
     * 
     */
    protected function _initActionHelpers() {
        Zend_Controller_Action_HelperBroker::addHelper(new App_Controller_Action_Helper_Logger());
        //Zend_Controller_Action_HelperBroker::addPrefix("App_Controller_Action_Helper");
    }

    public function _initDoctrine() {
        
        //Get a Zend Autoloader instance
        $loader = Zend_Loader_Autoloader::getInstance();
        
        //Autoload all the Doctrine files
        $loader->pushAutoloader(array('Doctrine', 'autoload'));

        //Get the Doctrine settings from application.ini
        $config = $this->getOption('doctrine');

        //Get a Doctrine Manager instance so we can set some settings
        $manager = Doctrine_Manager::getInstance();

        //set models to be autoloaded and not included (Doctrine_Core::MODEL_LOADING_AGGRESSIVE)
        $manager->setAttribute(
                Doctrine::ATTR_MODEL_LOADING, Doctrine::MODEL_LOADING_CONSERVATIVE
        );

        //enable ModelTable classes to be loaded automatically
        $manager->setAttribute(
                Doctrine_Core::ATTR_AUTOLOAD_TABLE_CLASSES, true
        );

        //enable validation on save()
        $manager->setAttribute(
                Doctrine_Core::ATTR_VALIDATE, Doctrine_Core::VALIDATE_ALL
        );

        //enable sql callbacks to make SoftDelete and other behaviours work transparently
        $manager->setAttribute(
                Doctrine_Core::ATTR_USE_DQL_CALLBACKS, true
        );

        //not entirely sure what this does :)
        $manager->setAttribute(
                Doctrine_Core::ATTR_AUTO_ACCESSOR_OVERRIDE, true
        );

        //enable automatic queries resource freeing
        $manager->setAttribute(
                Doctrine_Core::ATTR_AUTO_FREE_QUERY_OBJECTS, true
        );
        
        Doctrine::loadModels($config['models_path']);
        
        //connect to database
        $manager->openConnection($config['dsn']);

        //set to utf8
        $manager->connection()->setCharset('utf8');

        return $manager;
    }

}

