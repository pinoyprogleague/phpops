<?php

/*
 * Made under PHPOps Open-Source Non-proprietary Project
 *
 * Pinoy Programmers League
 */

namespace POPS;

/**
 * Base class for types of Controller
 *
 * @author Allen
 */
class Controller implements Lang\IRoutable {

    private $routename;


    public function __construct() {
        ;
    }

    public function getRouteName() {
        return $this->routename;
    }

    public function setRouteName() {

    }

}
