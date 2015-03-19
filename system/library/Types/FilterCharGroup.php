<?php

/*
 * Made under PHPOps Open-Source Non-proprietary Project
 *
 * Pinoy Programmers League
 */

namespace POPS\Types;

/**
 * Class that represents a group of characters for filtering
 *
 * @author Allen
 */
class FilterCharGroup extends Collection {


    /**
     * Create new instance of FilterCharGroup
     */
    public function __construct()
    {
        parent::__construct();
        // Absorb indefinite parameters
        for ($x=0; $x < func_num_args(); $x++) {
            $this->add(func_get_arg($x));
        }
    }


    /**
     * Add new character to this FilterGroup
     *
     * @param mixed     $item Either a POPS\Types\Character instance, a character or single-character string
     *
     * @throws \POPS\Exceptions\InvalidCharacterException
     */
    public function add($item)
    {
        // Validate item
        if (!$this->_validateItem($item)) {
            throw new \POPS\Exceptions\InvalidCharacterException();
        }
        // Check for redundancy
        if ($this->contains($item)) {
            return;
        }
        parent::add($item instanceof Character ? $item : new Character($item));
    }


    /**
     * Returns the current item at internal pointer
     *
     * @return \POPS\Types\Character
     */
    public function current()
    {
        $ret = parent::current();
        return $ret instanceof Character ? $ret : new Character($ret);
    }


    /**
     * Get the filtered form of a string
     *
     * @param \POPS\Types\String    $str The string to be filtered
     *
     * @return \POPS\Types\String
     */
    public function filter(String $str)
    {
        $val = $str->getValue();
        for ($this->startLooping(); $this->isLooping(); $this->loops())
        {
            $current = $this->current();
            $val = str_replace($current->getValue(), "", $val);
        }
        return new String($val);
    }



    public function filterRedundant(String $str)
    {
        if ($str->getLength() > 1) {
            $newstr = new String();
            for ($prev=$str->charAt(0),$matchPosition=false,$x=1; /**/ $x < $str->getLength(); /**/ $x++)
            {
                $current = $str->charAt($x);
                $matchPosition = $this->positionOf($current);
                if ($matchPosition) {
                    if ($current->equals($prev)) {
                        $prev = $current;
                        continue;
                    }
                }
                $newstr->append($str->getValue());
                $prev = $current;
            }
        }
        else {
            return new String($str->getValue());
        }
    }


    /**
     * Gets the Character at `nth` position
     *
     * @param int $nth Position of character item
     *
     * @return \POPS\Types\Character
     */
    public function get($nth)
    {
        $ret = parent::get($nth);
        return $ret instanceof Character ? $ret : new Character($ret);
    }


    /**
     * Set the character value of a position
     *
     * @param int   $nth Position of target item
     * @param type  $newvalue New character value to be assigned
     *
     * @return Character Old value of specified position before its value was replaced
     *
     * @throws \POPS\Exceptions\InvalidCharacterException
     */
    public function set($nth, $newvalue)
    {
        if (!$this->_validateItem($newvalue)) {
            throw new \POPS\Exceptions\InvalidCharacterException();
        }
        $oldvalue = $this->get($nth);
        parent::set($nth, $newvalue instanceof Character ? $newvalue : new Character($newvalue));

        return $oldvalue;
    }


    /**
     * Validate an item if it satisfies membership in this instance
     *
     * @param \POPS\Types\Character $item The item to be validated
     *
     * @return boolean
     */
    protected function _validateItem($item)
    {
        if ($item==null || is_array($item)) {
            return false;
        }
        if (is_object($item) ? ($item instanceof Character) : strlen(strval($item))==1) {
            return true;
        }
        return false;
    }

}
