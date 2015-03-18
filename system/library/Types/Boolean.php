<?php

/*
 * Made under PHPOps Open-Source Non-proprietary Project
 *
 * Pinoy Programmers League
 */

namespace POPS\Types;

/**
 * Strongly-typed datatype that represents boolean
 *
 * @author Allen
 */
class Boolean extends \POPS\Lang\AbstractDatatype implements \POPS\Lang\IDatatypeGeneric {

    private $value;

    public function __construct($value = NULL) {
        if (!is_bool($value)) {
            throw new \POPS\Exceptions\InvalidBooleanException($value);
        }
        $this->value = $value;
    }

    public function toString() {
        return strval($this);
    }

    public function __toString() {
        return $this->value ? "true" : "false";
    }

}
