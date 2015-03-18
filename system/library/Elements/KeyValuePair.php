<?php

/*
 * Made under PHPOps Open-Source Non-proprietary Project
 *
 * Pinoy Programmers League
 */

namespace POPS\Elements;

/**
 * A datatype that represents a key and its corresponding value
 *
 * @author Allen
 */
class KeyValuePair {

    private $key;
    private $value;

    public function __construct($key, $value) {
        $this->key = $key;
        $this->value = $value;
    }

    /**
     * Get the key
     *
     * @return string
     */
    public function getKey() {
        return $this->key;
    }


    /**
     * Get the value
     *
     * @return string
     */
    public function getValue() {
        return $this->value;
    }


    /**
     * Swap the key and value of this pair
     */
    public function swap() {
        $tmp = $this->getValue();
        $this->value = $this->getKey();
        $this->key = $tmp;
    }


    /**
     * Convert this Key-Value pair into an associative-array element
     *
     * @return array
     */
    public function toArrayElement() {
        $res[$this->getKey()] = $this->getValue();
        return $res;
    }

}
