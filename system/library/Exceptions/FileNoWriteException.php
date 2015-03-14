<?php

/*
 * Made under PHPOps Open-Source Non-proprietary Project
 *
 * Pinoy Programmers League
 */

namespace POPS\Exceptions;

/**
 * Exception when a file is not writable
 */
class FileNoWriteException extends \Exception {

    public function __construct($path, $code=0) {
        parent::__construct('Cannot write to file ' . $path, $code);
    }

}
