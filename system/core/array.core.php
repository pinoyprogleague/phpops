<?php


/**
 * Count all elements in an array
 *
 * @param mixed $array_or_countable
 * @param int $mode {=COUNT_NORMAL} If set to COUNT_RECURSIVE, all elements in child array/countable elements will also be counted
 *
 * @return int
 */
function core_array_count($array_or_countable, $mode=COUNT_NORMAL)
{
    RETURN count($array_or_countable, $mode);
}


/**
 * Check if an array is empty
 *
 * @param mixed $array_or_countable An array or countable object
 *
 * @return boolean
 */
function core_array_empty($array_or_countable)
{
    RETURN core_array_count($array_or_countable)===0;
}


/**
 * Search for an array's values. Will also search for child arrays' values inside
 *
 * @param mixed $search Search needle
 * @param array $array Search haystack
 * @param boolean $is_exact {=true} If value to be searched must be exact (data type and value), otherwise, looks for an occurence of a string
 * @param boolean $is_casesensitive {=false} If value to be searched is case sensitive (for string search only)
 *
 * @return mixed The array key of occurence
 */
function core_array_search($search, $array, $is_exact=TRUE, $is_casesensitive=FALSE)
{
    for ( $x=0,reset($array); $x<count($array); $x++,next($array) )
    {
        if ( is_array(current($array)) ) {
            RETURN core_array_search($search, $array, $is_exact);
        }
        else {
            $search = $is_casesensitive ? $search : (is_string($search)?strtolower($search):$search);
            $value = current($array);
            $value = $is_casesensitive ? $value : (is_string($value)?strtolower($array):$value);
            $ret = !$is_exact && is_string($search) ?
                    (strpos($value, $search)!==FALSE?key($array):FALSE)
                  : ($search===$value ? key($array):FALSE);
            if ( $ret!==FALSE ) {
                RETURN $ret;
            }
            CONTINUE;
        }
    }
}