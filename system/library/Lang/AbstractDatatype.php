<?php

/*
 * Made under PHPOps Open-Source Non-proprietary Project
 *
 * Pinoy Programmers League
 */

namespace POPS\Lang;

/**
 * Abstract class for Datatype implementations. Requirements: { $value }
 */
abstract class AbstractDatatype {

    /**
     * Check if its value is equal to another object/instance
     *
     * @param mixed $object The value to be checked
     * @param boolean $is_strict {=TRUE} If checking will include data-type checking, otherwise, loose-type checking
     *
     * @return boolean If specified object is equal to this instance
     */
    public function equals($object, $is_strict=TRUE) {
        RETURN $is_strict ? $this->getValue()===$object : $this==$object;
    }



    /**
     * Get the length of its value (in string)
     *
     * @return mixed The length, otherwise FALSE if current value is null
     */
    public function getLength() {
        RETURN $this->isNull() ? FALSE : strlen(strval($this->value));
    }



    /**
     * Get current value
     *
     * @return mixed
     */
    public function getValue() {
        RETURN $this->value;
    }



    /**
     * Check if it has null value (no value) or if value of this instance is not set
     *
     * @return boolean
     */
    public function isNull() {
        RETURN is_null($this->value);
    }



    /**
     * (MUST IMPLEMENT) Check if the current value of this DataType is valid, could be by using any form of checking
     *
     * @throws \POPS\Exceptions\NotImplementedException
     */
    public function isValid() {
        // if this was still invoked, it means this method was not implemented
        throw new \POPS\Exceptions\NotImplementedException(__CLASS__, __FUNCTION__);
    }



    /**
     * Serialize this instance into a byte-stream format
     *
     * @return string   The serialized object in byte-stream format
     */
    public function serialize() {
        RETURN serialize($this);
    }



    /**
     * Set the value of this instance
     *
     * @param mixed $value The new value to be assigned
     */
    public function setValue($value) {
        $this->value = $value;
    }


}
