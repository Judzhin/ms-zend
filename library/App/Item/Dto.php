<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ItemDto
 *
 * @author Judzhin
 */
class App_Item_Dto {

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $description;

    /**
     * Id
     * @var int
     */
    public $id;

    public function __construct($name, $description, $id) {
        $this->name = $name;
        $this->description = $description;
        $this->id = $id;
    }

}