<?php

/* Proudly made with Netbeans 8.0.1
 * This file is created under PHPOps open-source non-profit project
 *
 * Pinoy Programmers League
 */

namespace POPS\Exceptions;

/**
 * Exception for supplying non-array objects
 *
 * 
 */
class NotArrayException extends \Exception
{
    public function __construct($object) {
        parent::__construct('Non-array exception. Dumping ' . var_dump($object), 0);
    }
}