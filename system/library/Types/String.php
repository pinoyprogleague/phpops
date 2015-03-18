<?php

/*
 * Made under PHPOps Open-Source Non-proprietary Project
 *
 * Pinoy Programmers League
 */

namespace POPS\Types;

/**
 * Datatype for string values
 */
class String extends \POPS\Lang\AbstractDatatype implements \POPS\Lang\IDatatypeGeneric {

    private $value;


    /**
     * Initialize a 'String' instance
     *
     * @param string $value The string value to be contained in this String object
     * @throws InvalidStringException   Thrown when an invalid string value was provided
     */
    public function __construct($value=NULL)
    {
        if ($value!==NULL && !is_string($value)) {
            throw new InvalidStringException();
        }
        $this->setValue($value===NULL ? '':$value);
    }



    /**
     * Append a string value to this string object
     *
     * @param string $str A string value
     *
     * @return \POPS\Types\String [reference] This instance
     */
    public function &append($str)
    {
        $this->setValue($this->getValue() . $str);
        RETURN $this;
    }


    /**
     * Get its substring value
     *
     * @param int $start If start is NON-NEGATIVE, the returned string will start at the start'th position in string, counting from zero. For instance, in the string 'abcdef', the character at position 0 is 'a', the character at position 2 is 'c', and so forth. If start is NEGATIVE, the returned string will start at the start'th character from the end of string. If string is LESS THAN OR EQUAL to start characters long, FALSE will be returned.
     * @param int $length {=NULL} If length is given and is positive, the string returned will contain at most length characters beginning from start (depending on the length of string). If length is given and is negative, then that many characters will be omitted from the end of string (after the start position has been calculated when a start is negative). If start denotes the position of this truncation or beyond, false will be returned. If length is given and is 0, FALSE or NULL an empty string will be returned. If length is omitted, the substring starting from start until the end of the string will be returned.
     *
     * @return string The extracted part of string, or FALSE on failure or empty string value
     */
    public function subString($start, $length=NULL)
    {
        RETURN substr($this->getValue(), $start, $length);
    }


    /**
     * Set its value to lower-case
     *
     * @return \POPS\Types\String [reference] This instance
     */
    public function &toLowerCase()
    {
        if ( !$this->isNull() )
        {
            $this->setValue(strtolower($this->getValue()));
        }
        RETURN $this;
    }



    /**
     * Set its value to upper-case
     *
     * @return \POPS\Types\String [reference] This instance
     */
    public function &toUpperCase()
    {
        if ( !$this->isNull() )
        {
            $this->setValue(strtoupper($this->getValue()));
        }
        RETURN $this;
    }



    /**
     * Truncate its value
     *
     * @return \POPS\Types\String [reference] This instance
     */
    public function &truncate()
    {
        $this->setValue('');
        RETURN $this;
    }


    /**
     * Get the value of this String instance
     *
     * @return string
     */
    public function getValue() {
        return parent::getValue();
    }

    function getMinLength();
    function getMaxLength();
    function isWithinRange();


}