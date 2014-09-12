<?php

class FirebugController extends Zend_Controller_Action {

    public function indexAction() {
        $this->_helper->Logger->emerg('Emerg!', Zend_Log::EMERG);
        $this->_helper->Logger->alert('Alert!', Zend_Log::ALERT);
        $this->_helper->Logger->crit('Crit!', Zend_Log::CRIT);
        $this->_helper->Logger->err('Error!', Zend_Log::ERR);
        $this->_helper->Logger->warn('Warn!', Zend_Log::WARN);
        $this->_helper->Logger->notice('Notice!', Zend_Log::NOTICE);
        $this->_helper->Logger->info('Information!', Zend_Log::INFO);
        $this->_helper->Logger->debug('Debug!', Zend_Log::DEBUG);
        
        $this->_helper->Logger(new Zend_Exception("Some Error Happen Here "), Zend_Log::ALERT);

        //$profiler = new Zend_Db_Profiler_Firebug();
        //$profiler->setEnabled(true);

        //$guestbookMapper = new Application_Model_GuestbookMapper();
        //$guestbookMapper->getDbTable()->getAdapter()->setProfiler($profiler);

        //$db = $guestbookMapper->getDbTable()->getAdapter();
        //$sql = 'SELECT * FROM guestbook WHERE id = ?';
        //$db->fetchAll($sql, 1);
        //$guestbookMapper->fetchAll();
    }

    public function helperAction() {
        $this->_helper->Logger("App Log Via Helper :)", Zend_Log::ALERT);
        $this->_helper->Logger($this->getRequest()->getControllerName(), Zend_Log::DEBUG);
        $this->_helper->Logger($this->getRequest()->getActionName(), Zend_Log::DEBUG);

        $this->_helper->Logger->err("err Via __call function ");
        $this->_helper->Logger->info("info Via __call function ");
        $this->_helper->Logger->warn("warning Via __call function ");

        /* throw an Exception to firebug console 
         * you should use try catch clause 
         * this is just example
         *  @ Zend_Exception Class 
         */
        $this->_helper->Logger(new Zend_Exception("Some Error Happen Here "), Zend_Log::ALERT);
    }

}

