<?php

/*
 * Made under PHPOps Open-Source Non-proprietary Project
 *
 * Pinoy Programmers League
 */

namespace POPS\Lang;

/**
 * Interface for implementing datatypes with numeric procedures
 *
 * @author Allen
 */
interface IDatatypeNumeric {

    /**
     * Get the maximum value for this numeric datatype
     */
    function getMax();

    /**
     * Get the minimum value for this numeric datatype
     */
    function getMin();

    /**
     * If current value is within range
     */
    function isWithinRange();

}
