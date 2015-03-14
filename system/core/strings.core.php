<?php

/*
 * Made under PHPOps Open-Source Non-proprietary Project
 *
 * Pinoy Programmers League
 *
 * -----------------------------------------------------------------------------
 * String helpers
 *
 * This includes core helpers for additional string manipulations
 */



/**
 * Remove redundant consecutive occurences of characters in a string
 *
 * @param string $string Target string
 * @param POPS\Types\Character $char {=NULL} Optional character filter for consecutive occurences
 *
 * @return string
 */
function core_str_RemoveConsecutive($string, POPS\Types\Character $char=NULL)
{
    $newstring = '';
    for ( $x=0,$prev=NULL,$match=is_null($char)?NULL:$char->getValue(); $x<strlen($string); $x++ )
    {
        if ( !(($match!==NULL && $match==$prev && $string[$x]==$match)  || ($prev!==NULL && $string[$x]==$prev)) )
        {
            $newstring .= $string[$x];
        }
        $prev = $string[$x];
    }
    RETURN $newstring;
}



/**
 * Remove redundant consecutive occurences of characters in a string
 *
 * @param string $string Target string
 * @param POPS\Types\Collection $characters Collection of characters
 *
 * @return string
 */
function core_str_RemoveConsecutives($string, POPS\Types\Collection $characters)
{
    $result = $string;
    for ( $characters->rewind(); $characters->getIndex() < $characters->count(); $x++,$characters->next() )
    {
        $result = core_str_RemoveConsecutive($result, $characters->current());
    }
    RETURN $result;
}