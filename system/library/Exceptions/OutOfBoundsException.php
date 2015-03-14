<?php

/*
 * Made under PHPOps Open-Source Non-proprietary Project
 *
 * Pinoy Programmers League
 */

namespace POPS\Exceptions;

/**
 * Exception when a pointer was out of array or collection bounds
 */
class OutOfBoundsException extends \Exception {

    /**
     * Construct new instance of OutOfBoundsException
     */
    public function __construct() {
        parent::__construct('Current pointer was out of array or collection bounds');
    }

}
