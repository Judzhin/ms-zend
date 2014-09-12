<?php

/**
 * Description of AuthControllerTest
 *
 * @author Judzhin Miles
 */
class AuthControllerTest extends App_ControllerTestCase {

    // Emulation
    protected function _doLogin($username, $password) {

        $auth = Zend_Auth::getInstance();

        // Получаем адаптер подключения к базе данных
        $authAdapter = new Zend_Auth_Adapter_DbTable(Zend_Db_Table::getDefaultAdapter());

        // указываем таблицу, где необходимо искать данные о пользователях
        // колонку, где искать имена пользователей,
        // а также колонку, где хранятся пароли
        $authAdapter->setTableName('user');
        $authAdapter->setIdentityColumn('username');
        $authAdapter->setCredentialColumn('password');

        // подставляем полученные данные из формы
        $authAdapter->setIdentity($username);
        $authAdapter->setCredential($password);

        // делаем попытку авторизировать пользователя
        $result = $auth->authenticate($authAdapter);

        if ($result->isValid()) {

            // используем адаптер для извлечения оставшихся данных о пользователе
            $identity = $authAdapter->getResultRowObject();

            // получаем доступ к хранилищу данных Zend
            $authStorage = $auth->getStorage();

            // помещаем туда информацию о пользователе,
            // чтобы иметь к ним доступ при конфигурировании Acl
            $authStorage->write($identity);
        }
    }

    // логинимся "правильным" данными
    public function testTrueUserLoginAction() {

        $request = $this->getRequest();

        // эмулируем отправку формы
        $request->setMethod('POST');
        $request->setPost(array(
            "username" => "judzhin",
            "password" => "123456"
        ));

        $this->dispatch('/auth');

        // аутентификация должна пройти успешно, идентифицироваться мы должны как user
        $this->assertEquals(Zend_Auth::getInstance()->getIdentity()->username, 'judzhin');

        // мы должны быть перенаправлены на главную страницу
        $this->assertRedirectTo('/auth');
    }

    // логинимся "неправильным" данными
    public function testFalseUserLoginAction() {
        $request = $this->getRequest();

        $request->setMethod('POST');
        $request->setPost(array(
            "username" => "anonymous",
            "password" => "123456"
        ));

        $this->dispatch('/auth');

        // ищем в доме элемент с ID="error" и контентом 'Authorization error. Please check login or/and password'
        // лучше использовать assertQueryCount
        $this->assertQueryContentContains('#error', 'Authorization error. Please check login or/and password');
    }

    // логинимся "неправильным" данными
    public function testFalseNotValidAction() {
        $request = $this->getRequest();

        $request->setMethod('POST');
        $request->setPost(array(
            "username" => "",
            "password" => ""
        ));

        $this->dispatch('/auth');

        // ищем в доме элемент с ID="error" и контентом 'Authorization error. Please check login or/and password'
        // лучше использовать assertQueryCount
        // $this->assertQueryContentContains('#error', 'Authorization error. Please check login or/and password');
    }

    public function testLogoutAction() {
        // логинимся
        $this->_doLogin('judzhin', '123456');

        // вызываем логаут
        $this->dispatch('/auth/logout');

        // теперь мы должны быть "забыты" Zend_Auth'ом
        $this->assertNull(Zend_Auth::getInstance()->getIdentity());
    }

}
