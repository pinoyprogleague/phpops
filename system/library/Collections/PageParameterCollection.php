<?php

/*
 * Made under PHPOps Open-Source Non-proprietary Project
 *
 * Pinoy Programmers League
 */

namespace POPS\Collections;

/**
 * A collection of 'PageParameter' object
 */
class PageParameterCollection extends \POPS\Types\Collection {



    /**
     * PageParameterCollection $_ [optional]
     */
    public function __construct() {
        // Find any invalid required type supplied
        $argsCollection = core_func_ArgsToCollection(func_get_args());
        for ( $argsCollection->startLooping(); $argsCollection->isLooping(); $argsCollection->loops() )
        {
            if ( !($argsCollection->current() instanceof \POPS\Requests\PageParameter) )
            {
                throw new \POPS\Exceptions\InvalidCollectionItemTypeException($this);
            }
        }
        parent::__construct($argsCollection);
    }

    /**
     * Return the current `PageParameter` at the internal pointer
     *
     * @return \POPS\Requests\PageParameter
     */
    public function current() {
        RETURN parent::current();
    }

}
