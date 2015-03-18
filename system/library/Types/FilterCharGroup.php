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
    public function __construct() {
        parent::__construct();
    }


    /**
     * Add new character to this FilterGroup
     *
     * @param mixed     $item Either a POPS\Types\Character instance, a character or single-character string
     *
     * @throws \POPS\Exceptions\InvalidCharacterException
     */
    public function add($item) {
        if (!$this->_validateItem($item)) {
            throw new \POPS\Exceptions\InvalidCharacterException();
        }
        parent::add($item instanceof Character ? $item->getValue() : $item);
    }


    /**
     * Get the filtered form of a string
     *
     * @param \POPS\Types\String    $str The string to be filtered
     *
     * @return string
     */
    public function filter(String $str) {
        $val = $str->getValue();
        for ($this->startLooping(); $this->isLooping(); $this->loops())
        {
            $current = $this->current();
            $val = str_replace($current, "", $val);
        }
        return $val;
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
    public function set($nth, $newvalue) {
        if (!$this->_validateItem($newvalue)) {
            throw new \POPS\Exceptions\InvalidCharacterException();
        }
        $oldvalue = $this->get($nth);
        parent::set($nth, $item instanceof Character ? $item->getValue() : $item);

        return $oldvalue;
    }


    /**
     * Validate an item if it satisfies membership in this instance
     *
     * @param \POPS\Types\Character $item The item to be validated
     *
     * @return boolean
     */
    protected function _validateItem($item) {
        if ($item==null || is_array($item)) {
            return false;
        }
        if (is_object($item) ? ($item instanceof Character) : strlen(strval($item))==1) {
            return true;
        }
        return false;
    }

}
