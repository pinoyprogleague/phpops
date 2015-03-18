<?php

namespace POPS\Exceptions;


/**
 * Exception for invalid string values
 */
class InvalidStringException extends \Exception {

    public function __construct() {
        parent::__construct('Not valid string was provided');
    }

}