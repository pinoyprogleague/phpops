<?php

/*
 * Made under PHPOps Open-Source Non-proprietary Project
 *
 * Pinoy Programmers League
 */

namespace POPS\Lang;

/**
 * Interface for classes that implements validation
 *
 * @author Allen
 */
interface IValidatable {

    function isValid();
    function isWithinRange();

}
