<?php

/* Proudly made with Netbeans 8.0.1
 * This file is created under PHPOps open-source non-profit project
 *
 * Pinoy Programmers League
 */

namespace POPS\Exceptions;

/**
 * Exception for supplying invald file paths (directory, not-found, etc.)
 */
class NotFileException extends \Exception
{
    public function __construct($path) {
        parent::__construct('Specified path is not a file ' . $path, 0);
    }
}