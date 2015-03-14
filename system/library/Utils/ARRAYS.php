<?php

namespace POPS\Utils;

/**
 * <b>Utility class</b> for Array manipulations
 */
final class ARRAYS {

    const KEY = 1;
    const VALUE = 2;


    /**
     * Deletes all array elements whose values match with specified string value
     * @param String $strval The string to search
     * @param String $a_targetarray (ref) Target array
     * @param Boolean $is_exact [optional=true] If exact string comparison should be implemented, otherwise,
     *      will use substring comparison
     * @param Boolean $is_casesensitive [optional=true] If comparison should be case-Sensitive
     */
    public static function DeleteAllWith($strval, &$a_targetarray, $is_exact=true, $is_casesensitive=true) {
        reset($a_targetarray);
        for ($x=0; $x<count($a_targetarray); $x++,next($a_targetarray)) {
            $value = $is_casesensitive ? current($a_targetarray) : strtolower(current($a_targetarray));
            $strval = $is_casesensitive ? $strval : strtolower($strval);
            $is_found = $is_exact ? (strcmp($value,$strval)===0) : (strpos($value, $strval)!==FALSE);
            if ($is_found) {
                unset($a_targetarray[key($a_targetarray)]);
            }
        }
        reset($a_targetarray);
    }



    /**
     * Dump the contents of an array (replaces the dumb print_r() function of PHP xD)
     *
     * @param array $array
     * @param boolean $is_child <b>Don't change value unless u want trouble *_*</b>
     * @param int $parent_index <b>Don't change value unless u want trouble *_*  </b>
     */
    public static function Dump($array, $is_child=false, $parent_index=null)
    {
        echo $is_child ? '':'<div style="border:1px solid #000;padding:2%;background-color:#fff;" align="left">';
        echo !$is_child ? '<h4>Dumping a freaking array</h4><hr>' : '';
        echo '<ul style="list-style:none;">'.PHP_EOL;
        for ( $x=0,reset($array); $x<count($array); $x++,next($array) )
        {
            $number = ($is_child ? (($parent_index+1).'.'):'').($x+1).') ';
            $current = current($array);
            $key = key($array);

            echo '<li>'.$number.PHP_EOL;
            // -----------------------------------------------------------------
            //      innerHtml start
            // -----------------------------------------------------------------
            echo '<b>'.(is_integer($key)?'[':'').key($array).(is_integer($key)?']':'').'</b> ---> ';

            // Variation of output by common data types
            if ( is_array($current) ) {
                self::Dump($current, true, $x);
            }
            else if (is_bool($current) ) {
                echo '<font color="red"><u>'.($current ? 'true':'false').'</u></font>';
            }
            else if ( is_null($current) ) {
                echo '<font color="red">NULL</font>';
            }
            else if (is_string($current) ) {
                echo '"'.$current.'" -- <i>string('.strlen($current).')</i>';
            }
            else if (!is_object($current)) {
                echo '<code>'.$current.'</code>';
            }
            else {
                echo var_export($current, true);
            }
            // -----------------------------------------------------------------
            //      innerHtml end
            // -----------------------------------------------------------------
            echo '</li>'.PHP_EOL;
        }
        echo '</ul>'.PHP_EOL;
        echo $is_child ? '':'</div>'.PHP_EOL;
    }



    /**
     * Find the matching case-insensitive key of the specified key within an array
     *
     * @param mixed $key The key to be searched for
     * @param array $array The target haystack array
     * @return mixed The <b>matched key</b>, otherwise <code>FALSE</code>
     */
    public static function FindMatchingKey($key, $array)
    {
        for ( $x=0,reset($array); $x<count($array); $x++,next($array) )
        {
            if ( strtolower(strval($key))===strtolower(strval(key($array))) )
            {
                return key($array);
            }
        }
        return FALSE;
    }



    /**
     * Get a value from an associative array <b>by index</b><br>
     * Expected result is<br>
     * <code>
     * array(<br>
     * KEY => 'key',<br>
     * VALUE => 'value'<br>
     * )
     * </code>
     *
     * @param array $array
     * @param int $index
     * @return array
     */
    public static function GetAssocAt($array, $index)
    {
        if ( $index<0 ) {
            RETURN NULL;
        }
        for ( $x=0,reset($array); $x<count($array); $x++,next($array) )
        {
            if ( $x==$index ) {
                RETURN array(
                    self::KEY => key($array),
                    self::VALUE => current($array)
                );
            }
        }
        RETURN NULL;
    }



    /**
     * Merges 2 arrays
     * @param Array $array1 [*pointer] The first array and the destination container
     * @param Array $array2 The second array
     */
    public static function Merge(&$array1, $array2) {
        foreach($array2 as $element) {
            array_push($array1, $element);
        }
    }



    /**
     * Implode an <code>associative array</code> into a string with
     *      delimiting values
     *
     * @param array $array the <code>associative array</code>
     * @param mixed $d_column A delimiting value between keys and values<br>
     *      (e.g. key=value, where <code>=</code> is the delimiting value)
     * @param mixed $d_row A delimiting value between each array element<br>
     *      (e.g. key=value&key2=value2, where <code>&</code> is the delimiting value)
     * @param boolean $no_null_dc {true} If columnar delimiting value should be omitted
     *      once a null value was detected.<br>
     *      (e.g. key=value&key2&key3=value3)
     *
     * @return string The imploded string
     */
    public static function ImplodeAssoc($array, $d_column, $d_row, $no_null_dc=true)
    {
        $ret = '';
        for ( $x=0,reset($array); $x<count($array); $x++,next($array) )
        {
            $is_nullval = is_null(current($array));
            $ret .= key($array).($no_null_dc && $is_nullval ? '':$d_column).($is_nullval ? '':current($array));
            $ret .= ($x<count($array)-1) ? $d_row : '';
        }
        return $ret;
    }



    /**
     * Insert an <code>associative array</code> row
     *
     * @param string $key Key of the row
     * @param mixed $value Value of the row
     * @param array $array [*pointer] Target array
     * @param int $index {null} Index where row will be inserted, if not defined,
     *      then row will be appended instead
     *
     * @throws Exceptions\NotArrayException
     */
    public static function InsertAssociative($key, $value, &$array, $index=NULL)
    {
        if ( !is_array($array) ) {
            // throw exception if non-array was supplied
            throw new Exceptions\NotArrayException($array);
        }

        $simarray = $array; // isolate the array memory pointer from where this method was invoked
        $newarray = array(); // prepare the output array

        $keymatch = self::FindMatchingKey($key, $simarray); // check for key matching
        // if key matched with an existing, suspend insertion and proceed
        //      with value replacement
        if ( $keymatch!==FALSE ) {
            $simarray[$keymatch] = $value;
            $array = $simarray;
        }

        for ( $x=0,reset($simarray); $x<count($simarray); $x++ ) {
            if ( $x===$index && !array_key_exists($key, $newarray) && $index!==NULL ) {
                $newarray[$key] = $value;
                $x--;
            }
            else {
                $newarray[key($simarray)] = current($simarray);
                next($simarray);
            }
        }
        if ( $index===NULL )
        {
            $newarray[$key] = $value;
        }
        $array = $newarray;
    }



    /**
     * Search for the array value which contains the specified substring value
     * @param String $str_value The substring value to search
     * @param Array|Array(assoc) $a_haystack The target array to be searched
     * @param bool $is_firstoccurence [optional=true] Boolean value if first occurence key will be returned,
     *      otherwise, last occurence key will be returned
     * @return int|string|boolean The key of the matched substring value, otherwise, FALSE
     */
    public static function SearchSubstring($str_value, &$a_haystack, $is_firstoccurence=true) {
        $occurence = -1;
        reset($a_haystack);
        for($x=0; $x<count($a_haystack); $x++, next($a_haystack)) {
            $string = strval(current($a_haystack));
            if (strpos($string, $str_value)!==FALSE) {
                if ($is_firstoccurence) {
                    return key($a_haystack);
                } else {
                    $occurence = key($a_haystack);
                }
            }
        }
        if (!$is_firstoccurence && $occurence!=-1) {
            return $occurence;
        } else {
            return FALSE;
        }
    }



    /**
     * Recompact the integer indices of a linear array (e.g. 0=>'value1', 1=>'value2', and so forth)<br>
     * If used on <code>Assoc-Arrays</code>, will indexify all values, disregarding
     *      the key relationships
     *
     * @param array $array
     * @return array
     */
    public static function Recompact($array)
    {
        $ret = array();
        for ( $x=0,reset($array); $x<count($array); $x++,next($array) )
        {
            $ret[$x] = current($array);
        }
        return $ret;
    }



    /**
     * Search an array for certain value and return the resulting key
     *
     * @param mixed $value Value to be searched
     * @param mixed $array Target array
     * @param type $is_firstoccurence {true} If true, will return the
     *      key of the first occurence, otherwise, the last occurence
     *
     * @return mixed The key of the resulting key, FALSE when nothing found
     */
    public static function SearchValue($value, $array, $is_firstoccurence=true)
    {
        $ret = NULL;
        for( $x=0,reset($array); $x<count($array); $x++,next($array) )
        {
            if ( $value===current($array) )
            {
                if ( $is_firstoccurence ) {
                    return key($array);
                }
                else {
                    $ret = key($array);
                }
            }
        }
        if ( $ret===NULL )
        {
            return false;
        }
    }



    /**
     * Check if an array is a <b>fully</b> <code>associative array</code>
     * <br>
     * Every element of this array should be 100% associative.
     *
     * @param array $array
     * @return boolean If specified array is an associative or not
     */
    public static function __IsAssociative($array)
    {
        if ( self::__IsEmpty($array) || !is_array($array) )
        {
            RETURN FALSE;
        }
        for ( $x=0,reset($array); $x<count($array); $x++,next($array) )
        {
            if ( is_integer(key($array)) ) {
                RETURN FALSE;
            }
        }
        RETURN TRUE;
    }



    /**
     * Check if an array is composed of <code>linear array</code> with
     *      <code>associative array</code> for every linear element.<br>
     *      <i>Example:</i><br>
     *      <code>
     *      array(<br>
     *      [0] => array( 'key1' => 'value1' ),<br>
     *      [1] => array( 'key2' => 'value2' )<br>
     *      )
     *      </code>
     *
     * @param type $array
     * @return boolean
     */
    public static function __IsIndexedAssociative($array)
    {
        if ( self::__IsEmpty($array) || !is_array($array) )
        {
            RETURN FALSE;
        }
        if ( !self::__IsAssociative($array) )
        {
            foreach ( $array as $row )
            {
                if ( !is_array($row) || !self::__IsAssociative($row) ) {
                    RETURN FALSE;
                }
            }
            RETURN TRUE;
        }
        RETURN FALSE;
    }



    /**
     * Check if a given array has compact indexing<br>
     * <b>Note:</b> Dedicated for <code>linear array</code> type only.<br>
     *      Using to an <code>associative array</code> will always return FALSE
     *
     * @param array $array
     * @param boolean $is_strict {true} If strict type checking will be applied
     *      for key/index comparisons
     * @return boolean
     */
    public static function __IsCompact($array, $is_strict=true)
    {
        if ( !is_array($array) ) {
            return false;
        }
        else if ( self::__IsAssociative($array) ) {
            return false;
        }
        for ( $x=0,reset($array); $x<count($array); $x++,next($array) )
        {
            if ( ($is_strict ? key($array)!==$x : key($array)!=$x) )
            {
                return false;
            }
        }
        return true;
    }



    /**
     * Check if an array is empty
     *
     * @param array $array
     * @return mixed BOOLEAN if given is an array, NULL if not array or null set
     */
    public static function __IsEmpty($array)
    {
        if ( !is_array($array) )
        {
            return NULL;
        }
        return count($array)<=0;
    }


}
