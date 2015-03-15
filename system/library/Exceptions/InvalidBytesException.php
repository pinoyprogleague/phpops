<?php

/*
 * Made under PHPOps Open-Source Non-proprietary Project
 *
 * Pinoy Programmers League
 */

namespace POPS\Exceptions;

/**
 * Exception throw when a set of bytes was deserialized into an incompatible type
 *
 * @author Allen
 */
class InvalidBytesException extends \Exception {

    public function __construct() {
        parent::__construct("A set of bytes was deserialized into an incompatible type");
    }

}
