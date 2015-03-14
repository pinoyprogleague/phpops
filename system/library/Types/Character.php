<?php

/*
 * Made under PHPOps Open-Source Non-proprietary Project
 *
 * Pinoy Programmers League
 */

namespace POPS\Types;

/**
 * Character types
 *
 *
 */
class Character extends \POPS\Lang\AbstractDatatype implements \POPS\Lang\IDatatype {

    protected $value;

    public function __construct($value=NULL) {

        if ( $value!==NULL && strlen($value)>1 ) {
            throw new \POPS\Exceptions\InvalidCharacterException($value);
        }
        $this->value = $value;

    }


    
    public function isValid() {

    }

}
