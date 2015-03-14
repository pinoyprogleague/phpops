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

    public function __construct($type, Collection $collection) {
        if ( $collection->typeMatch($type) ) {
            parent::__construct($collection);
        }
        trigger_error('Invalid data type');
    }

}
