<?php

/*
 * Made under PHPOps Open-Source Non-proprietary Project
 *
 * Pinoy Programmers League
 */

namespace POPS\Lang;

/**
 * Interface class for List or Collection type objects
 */
interface IListable {

    function add($item);
    function count();
    function get($nth);
    function remove($nth);
    function set($nth, $newvalue);

}
