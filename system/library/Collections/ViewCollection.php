<?php

/*
 * Made under PHPOps Open-Source Non-proprietary Project
 *
 * Pinoy Programmers League
 */

namespace POPS\Collections;

/**
 * A collection of view
 *
 * @author Allen
 */
class ViewCollection extends \POPS\Types\Collection {



    /**
     * PageParameterCollection $_ [optional]
     */
    public function __construct() {
        // Find any invalid required type supplied
        $argsCollection = core_func_ArgsToCollection(func_get_args());
        for ( $argsCollection->startLooping(); $argsCollection->isLooping(); $argsCollection->loops() )
        {
            if ( !($argsCollection->current() instanceof \POPS\View) )
            {
                throw new \POPS\Exceptions\InvalidCollectionItemTypeException($this);
            }
        }
        parent::__construct($argsCollection);
    }

    /**
     * Return the current `View` object at the current internal pointer
     *
     * @return \POPS\View
     */
    public function current() {
        RETURN parent::current();
    }

}
