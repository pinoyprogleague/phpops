<?php

/*
 * Made under PHPOps Open-Source Non-proprietary Project
 *
 * Pinoy Programmers League
 */

namespace POPS\Exceptions;

/**
 * Exception thrown when an invalid type of item collection was supplied during the initialization of a type-based collection
 */
class InvalidCollectionItemTypeException extends \Exception
{

    /**
     * Initialize this exception
     *
     * @param \POPS\Types\Collection $object The type-based collection where given exception occured
     */
    public function __construct(\POPS\Types\Collection $object) {
        parent::__construct('Invalid type of item supplied in initialization of type-based collection `'.get_class($object).'`', 0);
    }
}