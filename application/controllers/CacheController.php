<?php

class CacheController extends Zend_Controller_Action {

    public function indexAction() {

        $frontendOptions = array(
            'lifetime' => 30,
            'automatic_serialization' => true
        );

        $backendOptions = array(
            'cache_dir' => APPLICATION_PATH . '/../cache/'
        );

        $cache = Zend_Cache::factory('Core', 'File', $frontendOptions, $backendOptions);

        $mapper = new Application_Model_GuestbookMapper();

        if (!$result = $cache->load('gueastbook')) {

            $db = $mapper->getDbTable()->getAdapter();

            $sql = 'SELECT * FROM guestbook WHERE id = ?';
            $result = $db->fetchAll($sql, 1);

            $cache->save($result, 'gueastbook');
        } else {
            echo "This one is from cache!<br />";
        }

        $cacheTmp = Zend_Cache::factory('Output', 'File', $frontendOptions, $backendOptions);

        if (!$cacheTmp->start('hellopage')) {

            echo 'Hello world!<br />';
            echo 'This is cached (' . time() . ')<br />';

            $cacheTmp->end();
        }

        echo 'This is never cached (' . time() . ').<br />';
    }

}