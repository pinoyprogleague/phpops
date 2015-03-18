<?php

/*
 * Made under PHPOps Open-Source Non-proprietary Project
 *
 * Pinoy Programmers League
 */

namespace POPS\Collections;

/**
 * A collection of Key-Value pairs
 *
 * @author Allen
 */
class Dictionary extends \POPS\Types\Collection {


    /**
     * Create a new Dictionary instance
     */
    public function __construct()
    {
        parent::__construct();
    }


    /**
     * Add a KeyValue pair to this Dictionary
     *
     * @param \POPS\Elements\KeyValuePair $kv
     */
    public function add(\POPS\Elements\KeyValuePair $kv, $is_noredundantkey)
    {
        if ($this->containsKey($kv->getKey())) {

        }
        parent::add($kv);
    }


    /**
     * Get the current KeyValue pair item in current internal pointer
     *
     * @return \POPS\Elements\KeyValuePair      The current KeyValue pair item in current internal pointer
     */
    public function current()
    {
        return parent::current();
    }


    /**
     * Check if this dictionary contains a certain key
     *
     * @param mixed     $key The key to be looked up
     * @param boolean   $is_casesensitive {=false} If value specified is a string and should be case-sensitive
     *
     * @return boolean  If this dictionary contains the specified key
     */
    public function containsKey($key, $is_casesensitive=false)
    {
        for ($this->startLooping(); $this->isLooping(); $this->loops()) {
            $current = $this->current();
            if ($is_casesensitive ? $current->getKey() == $key
                    : (is_string($current->getKey()) ? strtolower($current->getKey()) == strtolower($key) : false)) {
                return true;
            }
        }
        return false;
    }


    /**
     * Check if this dictionary contains a certain value
     *
     * @param mixed     $value The value to be looked up
     * @param boolean   $is_casesensitive {=false} If value specified is a string and should be case-sensitive
     *
     * @return boolean  If this dictionary contains a certain value
     */
    public function containsValue($value, $is_casesensitive=false)
    {
        for ($this->startLooping(); $this->isLooping(); $this->loops()) {
            $current = $this->current();
            if ($is_casesensitive ? $current->getValue() === $value
                    : (is_string($current->getValue()) ? strtolower($current->getValue()) === strtolower($value)
                        : false)) {
                return true;
            }
        }
        return false;
    }


    /**
     * Gets the KeyValue pair object at `nth` position
     *
     * @param int   $nth Position of item
     *
     * @return \POPS\Elements\KeyValuePair
     */
    public function get($nth)
    {
        return parent::get($nth);
    }


    /**
     * Get the position of a key, otherwise, returns FALSE if key was not found
     *
     * @param string    $key The key to look up
     *
     * @return mixed
     */
    public function getKeyPosition($key)
    {
        for ($this->startLooping(); $this->isLooping(); $this->loops()) {
            $current = $this->current();
            if ($current instanceof \POPS\Elements\KeyValuePair) {
                if ($current->getKey()==$key) {
                    return $this->getPosition();
                }
            }
        }
        return false;
    }


    /**
     * Get the value of the specified key, otherwise, FALSE if key does not exist
     *
     * @param string    $key The key
     *
     * @return mixed    The value of the specified key, otherwise, FALSE if key does not exist
     */
    public function getValue($key)
    {
        $kv = $this->getKV($key);
        if ($kv instanceof \POPS\Elements\KeyValuePair) {
            return $kv->getValue();
        }
        else {
            return false;
        }
    }


    /**
     * Set a value in `nth` position
     *
     * @param int                           $nth Position of target item
     * @param \POPS\Elements\KeyValuePair   $newvalue New value to be assigned
     *
     * @return mixed The old value before new value assignment has been made
     */
    public function set($nth, \POPS\Elements\KeyValuePair $newvalue)
    {
        parent::set($nth, $newvalue);
    }


    public function setValue($key, $value)
    {
        if (!$this->containsKey($key)) {
            throw new \POPS\Exceptions\DictionaryKeyException($key);
        }

    }


    //--------------------------------------------------------------------------
    //  Static functions
    //--------------------------------------------------------------------------


    /**
     * Create a dictionary from an array
     *
     * @param array     $array The array which a dictionary will be created from
     *
     * @return \POPS\Collections\Dictionary     The resulting Dictionary instance
     */
    static public function CreateFromArray($array) {
        parent::CreateFromArray($array);
        $result = new Dictionary();
        $keys = array_keys($array);
        foreach ($keys as $key) {
            $result->add(new \POPS\Elements\KeyValuePair($key, $array[$key]));
        }
        return $result;
    }

    /**
     * Create an instance of Dictionary from bytes buffer
     *
     * @param string    $buffer The bytes stream in string
     *
     * @return \POPS\Collections\Dictionary     The resulting Dictionary instance
     * @throws \POPS\Exceptions\InvalidBytesException
     */
    static public function CreateFromBytes($buffer) {
        parent::CreateFromBytes($buffer);
        $unserialized = unserialize($buffer);
        if ($unserialized instanceof Dictionary) {
            return $unserialized;
        }
        throw new \POPS\Exceptions\InvalidBytesException();
    }



}
