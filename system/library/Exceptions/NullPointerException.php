<?php

/*
 * Made under PHPOps Open-Source Non-proprietary Project
 *
 * Pinoy Programmers League
 */

namespace POPS\Exceptions;

/**
 * Exception when a pointer points to null or is negative
 */
class NullPointerException extends \Exception {

    /**
     * Construct new instance of NullPointerException
     */
    public function __construct() {
        parent::__construct('Null pointer or out of minimum bound');
    }

}
