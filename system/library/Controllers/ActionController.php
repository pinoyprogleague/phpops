<?php

/*
 * Made under PHPOps Open-Source Non-proprietary Project
 *
 * Pinoy Programmers League
 */

namespace POPS\Controllers;

/**
 * Controller class for Actions
 */
class ActionController extends \POPS\Controller {

    public function __construct($name, $path, \POPS\ModuleComponent &$child, \POPS\ModuleComponent &$parent) {
        parent::__construct($name, $path, $child, $parent);
    }

}
