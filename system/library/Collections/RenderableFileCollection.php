<?php

/*
 * Made under PHPOps Open-Source Non-proprietary Project
 *
 * Pinoy Programmers League
 */

namespace POPS\Collections;

/**
 * Description of RenderableFileCollection
 *
 * @author Allen
 */
class RenderableFileCollection extends \POPS\Types\Collection {



    /**
     * \POPS\Types\RenderableFile $_ [optional]
     */
    public function __construct() {
        // Find any invalid required type supplied
        $argsCollection = core_func_ArgsToCollection(func_get_args());
        for ( $argsCollection->startLooping(); $argsCollection->isLooping(); $argsCollection->loops() )
        {
            if ( !($argsCollection->current() instanceof \POPS\Types\RenderableFile) )
            {
                throw new \POPS\Exceptions\InvalidCollectionItemTypeException($this);
            }
        }
        parent::__construct($argsCollection);
    }



    /**
     * Return the current `RenderableFile` object at the current internal pointer
     *
     * @return \POPS\Types\RenderableFile
     */
    public function current() {
        RETURN parent::current();
    }

}
