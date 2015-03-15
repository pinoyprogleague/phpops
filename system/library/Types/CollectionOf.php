<?php

/*
 * Made under PHPOps Open-Source Non-proprietary Project
 *
 * Pinoy Programmers League
 */

namespace POPS\Types;

/**
 * NOT YET FOR USE (wag matigas ang ulo!)
 */
class CollectionOf extends Collection {

    private $type;

    public function __construct($type, Collection $collection) {
        // Check if $type is a string
        if (!is_string($type)) {
            throw new InvalidStringException();
        }
        $reflectionClass = new \ReflectionClass(strval($type));
        if ( $collection->typeMatch($type) ) {
            parent::__construct($collection);
        }
        trigger_error('Invalid data type');
    }

}
