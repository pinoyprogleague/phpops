<?php

/*
 * Made under PHPOps Open-Source Non-proprietary Project
 *
 * Pinoy Programmers League
 */

namespace POPS\Lang;

/**
 * Interface class for enabling full type matching per element of `Collection` objects
 */
interface ICollectionTypeMatchable {

    function typeMatch($type);

}
