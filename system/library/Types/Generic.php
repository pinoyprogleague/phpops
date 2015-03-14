<?php

/*
 * Made under PHPOps Open-Source Non-proprietary Project
 *
 * Pinoy Programmers League
 */

namespace POPS\Types;

/**
 * Data type for Generic purposes or any kind of data
 */
class Generic extends \POPS\Lang\AbstractDatatype implements \POPS\Lang\IDatatype {

    private $value;

    public function __construct($value = NULL) {
        $this->value = $value;
    }


}
