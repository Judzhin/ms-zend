<?php

class ExcelController extends Zend_Controller_Action {

    public function init() {
        $this->_helper->viewRenderer->setNoRender();
        // $this->_helper->getHelper('layout')->disableLayout();
    }

    public function preDispatch() {
        $autoload = $this->getFrontController()->getParam('bootstrap')->getResource('autoload');
        $autoload->registerNamespace('PHPExcel_');
    }

    public function indexAction() {

        //$excel = new PHPExcel();
        $file = PHPExcel_IOFactory::load(APPLICATION_PATH . '/../data/courts.xls');
        //Zend_Debug::dump($file);
        $writer = new Zend_Log_Writer_Firebug();
        $logger = new Zend_Log($writer);

        foreach ($file->getWorksheetIterator() as $worksheet) {

            $title = $worksheet->getTitle();
            $rows = $worksheet->getHighestRow(); // количество строк
            $column = $worksheet->getHighestColumn(); // колонок
            $index = PHPExcel_Cell::columnIndexFromString($column);
            $columns = ord($column) - 64;

            for ($row = 2; $row <= $rows; ++$row) {
                $court = trim($worksheet->getCellByColumnAndRow(1, $row)->getValue());
                $code = trim($worksheet->getCellByColumnAndRow(6, $row)->getValue());
            }
        }
        
    }

}