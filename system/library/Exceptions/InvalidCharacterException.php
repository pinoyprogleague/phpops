<?php

/*
 * Made under PHPOps Open-Source Non-proprietary Project
 *
 * Pinoy Programmers League
 */

namespace POPS\Exceptions;

/**
 * Exception for supplying non-character value
 */
class InvalidCharacterException extends \Exception
{
    public function __construct($object) {
        parent::__construct('Invalid character value: '.strval($object), 0);
    }
}