<?php

/*
 * Made under PHPOps Open-Source Non-proprietary Project
 *
 * Pinoy Programmers League
 */

namespace POPS\Exceptions;

/**
 * Exception thrown when tried to access a null property in an object
 *
 * @author Allen
 */
class NullPropertyException extends \Exception {

    public function __construct() {
        parent::__construct("Tried to access a null property in an object");
    }

}
