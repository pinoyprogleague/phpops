<?php

/*
 * Made under PHPOps Open-Source Non-proprietary Project
 *
 * Pinoy Programmers League
 */

namespace POPS\Lang;

/**
 * Interface for implementing Datatype classes
 */
interface IDatatypeString {

    function __construct($value=NULL);
    function getLength();
    function getValue();
    function isNull();
    function setValue($value);

}
