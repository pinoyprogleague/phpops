<?php

/*
 * Made under PHPOps Open-Source Non-proprietary Project
 *
 * Pinoy Programmers League
 */

namespace POPS\Exceptions;

/**
 * Exception for non-valid integer values
 */
class InvalidIntegerException extends \Exception {

    public function __construct() {
        parent::__construct('Non-integer value was supplied');
    }

}
