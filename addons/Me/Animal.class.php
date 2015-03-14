<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Me;

/**
 * Description of Animal
 *
 * 
 */
class Animal {

    public $type;

    public function __construct($type)
    {
        $this->type = $type;
    }

    public function getType()
    {
        RETURN $this->type;
    }

}
