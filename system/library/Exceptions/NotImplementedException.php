<?php

/* Proudly made with Netbeans 8.0.1
 *
 * Pinoy Programmers League
 */

namespace POPS\Exceptions;

/**
 * Exception for not overriding a method/function from an inherited class
 */
class NotImplementedException extends \Exception
{
    public function __construct($className, $functionName) {
        parent::__construct('Method "'.$className.'::'.$functionName.'" was not overridden or might still have been parent-invoked even after being overridden', 0);
    }
}