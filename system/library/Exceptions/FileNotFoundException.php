<?php

/*
 * Made under PHPOps Open-Source Non-proprietary Project
 *
 * Pinoy Programmers League
 */

namespace POPS\Exceptions;

/**
 * Exception thrown when a file does not exist
 */
class FileNotFoundException extends \Exception {

    public function __construct($path) {
        parent::__construct('Specified path ' . $path . ' was not found', 0);
    }

}
