<?php

/*
 * Made under PHPOps Open-Source Non-proprietary Project
 *
 * Pinoy Programmers League
 */

namespace POPS\Exceptions;

/**
 * Exception thrown if a key does not exist in a Dictionary object
 *
 * @author Allen
 */
class DictionaryKeyException extends \Exception {

    /**
     * Create a new Dictionary key exception
     *
     * @param string    $key The key specified to be invalid or non-existent
     */
    public function __construct($key) {
        parent::__construct("Specified key " . $key . " does not exist");
    }

}
