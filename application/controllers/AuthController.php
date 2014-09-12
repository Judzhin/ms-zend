<?php

class AuthController extends Zend_Controller_Action {

    public function indexAction() {

        $this->view->login = false;

        /**
         * Получаем экземпляр Zend_Auth
         */
        $auth = Zend_Auth::getInstance();

        if (!$auth->hasIdentity()) {

            // Get Form
            $form = new Zend_Form();
            $form->setAction('#');
            $form->setMethod('post');
            $form->setName('auth');

            // Get Username Text Input
            $username = new Zend_Form_Element_Text('username');
            $username->setLabel('Username:');
            $username->setRequired(true);
            $username->addFilter(new Zend_Filter_StripTags());
            $username->addFilter(new Zend_Filter_StringTrim());
            $username->addValidator(new Zend_Validate_Alnum());
            $username->addValidator(new Zend_Validate_StringLength(array(
                        'min' => 3,
                        'max' => 24,
                    )));

            $form->addElement($username);

            $password = new Zend_Form_Element_Password('password');
            $password->setLabel('Password:');
            $password->setRequired(true);
            $password->addValidator(new Zend_Validate_StringLength(array(
                        'min' => 6
                    )));

            $form->addElement($password);

            $submit = new Zend_Form_Element_Submit('Submit');

            $form->addElement($submit);
            $this->view->form = $form;

            if ($this->getRequest()->isPost()) {

                $allParams = $this->getAllParams();

                if ($form->isValid($allParams)) {

                    // Получаем адаптер подключения к базе данных
                    $authAdapter = new Zend_Auth_Adapter_DbTable(Zend_Db_Table::getDefaultAdapter());

                    // указываем таблицу, где необходимо искать данные о пользователях
                    // колонку, где искать имена пользователей,
                    // а также колонку, где хранятся пароли
                    $authAdapter->setTableName('user');
                    $authAdapter->setIdentityColumn('username');
                    $authAdapter->setCredentialColumn('password');

                    // получаем введённые данные
                    // $username = $this->getParam('username');
                    $username = $form->getValue('username');
                    // $password = md5($this->getParam('password'));
                    $password = md5($form->getValue('password'));

                    // подставляем полученные данные из формы
                    $authAdapter->setIdentity($username);
                    $authAdapter->setCredential($password);

                    // делаем попытку авторизировать пользователя
                    $result = $auth->authenticate($authAdapter);

                    if ($result->isValid()) {

                        // Zend_Session::rememberMe(60 * 60 * 24 * 14); # two week
                        // используем адаптер для извлечения оставшихся данных о пользователе
                        $identity = $authAdapter->getResultRowObject();

                        // получаем доступ к хранилищу данных Zend
                        $authStorage = $auth->getStorage();

                        // помещаем туда информацию о пользователе,
                        // чтобы иметь к ним доступ при конфигурировании Acl
                        $authStorage->write($identity);
                        $this->_redirect('/auth');
                    } else {
                        $this->view->error = 'Authorization error. Please check login or/and password';
                    }
                } else {
                    $form->populate($allParams);
                }
            }
        } else {

            $this->view->login = true;
            $this->view->username = $auth->getIdentity()->username;
        }
    }

    // разлогиниваемся
    public function logoutAction() {
        Zend_Auth::getInstance()->clearIdentity();
        $this->_redirect('/');
    }

}