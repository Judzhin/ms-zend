<?php

class IndexControllerTest extends App_ControllerTestCase {

    public function testIndexNoMessageAction() {
        $this->dispatch('/index');
        $this->assertController('index');
        $this->assertAction('index');
        $this->assertResponseCode(200);
    }

    public function testPhpinfoAction() {
        $this->dispatch('/index/phpinfo');
        $this->assertController('index');
        $this->assertAction('phpinfo');
        $this->assertResponseCode(200);
    }

    /**
     * Проверяем поведение экшена по умолчанию
     */
    public function testAboutNoMessageAction() {
        $this->dispatch('/index/about');
        $this->assertModule('default');
        $this->assertController('index');
        $this->assertAction('about');
        $this->assertResponseCode(200);

        // на странице должен присутствовать элемент с ID="messages" в количестве 1 штука
        $this->assertQueryCount('#message', 1);

        // и в нем должен быть текст "no message"
        $this->assertQueryContentContains('#message', 'No message');
    }

    // проверяем поведение экшена при входящих параметрах
    public function testAboutWithMessageAction() {
        $this->dispatch('/index/about/m/true-lya-lya');
        $this->assertModule('default');
        $this->assertController('index');
        $this->assertAction('about');
        $this->assertResponseCode(200);

        // на странице должен присутствовать элемент с ID="messages" в количестве 1 штука
        $this->assertQueryCount('#message', 1);

        // текст теперь должен быть "true-lya-lya"
        $this->assertQueryContentContains('#message', 'true-lya-lya');
    }

    // альтернативный способ передачи параметров в реквест
    // данный тест дублирует предыдущий
    public function testAboutWithMessageAltAction() {

        $request = $this->getRequest();

        $request->setParams(array('m' => 'true-lya-lya'));
        $request->setMethod('GET');

        $this->dispatch('/index/about/');
        $this->assertModule('default');
        $this->assertController('index');
        $this->assertAction('about');
        $this->assertResponseCode(200);

        // на странице должен присутствовать элемент с ID="messages" в количестве 1 штука
        $this->assertQueryCount('#message', 1);

        // текст теперь должен быть "true-lya-lya"
        $this->assertQueryContentContains('#message', 'true-lya-lya');
    }

}

