<?php

namespace POPS\Types;


/**
 * Exception for invalid string values
 */
class InvalidStringException extends \Exception {

    public function __construct() {
        parent::__construct('Invalid string exception');
    }

}