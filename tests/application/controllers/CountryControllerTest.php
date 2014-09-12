<?php

require_once APPLICATION_PATH . '/models/Country.php';

/**
 * Description of CountryTest
 *
 * @author Judzhin Miles
 */
class CountryControllerTest extends App_ControllerTestCase {

    /**
     *
     * @var Model_Country
     */
    protected $_model;

    public function testCanAddCountry() {
        $this->_model = new Model_Country();

        $test = 'Canada';
        $this->_model->add($test);

        foreach ($this->_model->get() as $item) {
            if ($item == $test) {
                $this->assertEquals($item, $test);
            }
        }
    }
}
