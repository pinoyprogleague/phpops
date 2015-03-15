<?php

/*
 * Made under PHPOps Open-Source Non-proprietary Project
 *
 * Pinoy Programmers League
 */

namespace POPS\Exceptions;

/**
 * Description of InvalidBooleanException
 *
 * @author Allen
 */
class InvalidBooleanException extends \Exception {

    public function __construct($value) {
        parent::__construct(sprintf("Invalid boolean value: %s", $value));
    }

}
