<?php

//------------------------------------------------------------------------------
// Core functions for user-defined functions
//
//------------------------------------------------------------------------------



/**
 * Convert function arguments into Collection
 *
 * @param array $functionArgs Array of function arguments which is a value of method `func_get_args()`
 *
 * @return \POPS\Types\Collection Resulting Collection of function arguments
 */
function core_func_ArgsToCollection(array $functionArgs) {
    $ret = new POPS\Types\Collection();
    foreach ( $functionArgs as $arg ) {
        $ret->add($arg);
    }
    RETURN $ret;
}