<?php

// Define path to application directory
defined('APPLICATION_PATH')
        || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../application'));

// Define application environment
defined('APPLICATION_ENV')
        || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'testing'));

// Ensure library/ is on include_path
set_include_path(implode(PATH_SEPARATOR, array(
            realpath(APPLICATION_PATH . '/../library'),
            get_include_path(),
        )));

require_once 'Zend/Loader/Autoloader.php';
Zend_Loader_Autoloader::getInstance();

require_once 'library/App/ControllerTestCase.php';

///**
// * Doctrine Test
// */
//require_once 'Zend/Application.php';
//
//// Create application, bootstrap, and run
//$application = new Zend_Application(
//                APPLICATION_ENV,
//                APPLICATION_PATH . '/configs/application.ini'
//);
//
//// Init not all resourse
//$application->bootstrap(array(
//    'autoload', 'doctrine'
//));
//
///**
// * Doctrine CLI script
// */
//// set aggressive loading to make sure migrations are working
//Doctrine_Manager::getInstance()->setAttribute(
//        Doctrine::ATTR_MODEL_LOADING, Doctrine_Core::MODEL_LOADING_AGGRESSIVE
//);
//
//$options = $application->getBootstrap()->getOption('doctrine');
//$cli = new Doctrine_Cli($options);
//// $cli->run(array('doctrine', 'create-db'));
//// $cli->run(array('doctrine', 'build-all-reload'));