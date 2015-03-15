<?php

/*
 * Made under PHPOps Open-Source Non-proprietary Project
 *
 * Pinoy Programmers League
 */

namespace POPS\Types;

/**
 * Datatype for integer values, includes fundamental arithmetic operations
 */
class Integer extends \POPS\Lang\AbstractDatatype implements \POPS\Lang\IDatatypeNumeric {

    protected
            $value,
            $lastresult,
            $min,
            $max
    ;



    /**
     * Construct an instance of Integer datatype
     *
     * @param int $value    The integer value to be assigned to this Integer instance
     * @param mixed $min    {=null} The minimum value this Integer instance should handle, default is null (auto)
     * @param int $max      {=PHP_INT_MAX} The maximum value this Integer instance should handle, default is PHP_INT_MAX (auto)
     * @throws \POPS\Exceptions\InvalidIntegerException
     */
    public function __construct($value, $min=null, $max=PHP_INT_MAX) {
        $this->value = $value;
        $this->lastresult = null;
        $this->min = $min===null ? (PHP_INT_MAX * -1) : $min;
        $this->max = $max;
        if (!$this->isValid()) {
            unset($this->value);
            throw new \POPS\Exceptions\InvalidIntegerException();
        }
    }



    /**
     * Add an Integer
     *
     * @param \POPS\Types\Integer $integer  The Integer instance to be added
     * @return int  The resulting int value
     */
    public function add(Integer $integer) {
        $this->lastresult = $this->getValue() + $integer->getValue();
        RETURN $this->getLastResult()->getValue();
    }



    /**
     * Commit the last arithmetic operation into the current value
     *
     * @return \POPS\Types\Integer  The resulting Integer instance
     */
    public function commitLastResult() {
        $this->value = $this->getLastResult()->getValue();
        RETURN $this;
    }


    /**
     * Divide this with an Integer
     *
     * @param \POPS\Types\Integer $integer  The Integer instance as the divisor
     * @return int  The resulting int value
     */
    public function divide(Integer $integer) {
        $this->lastresult = $this->getValue() / $integer->getValue();
        RETURN $this->getLastResult()->getValue();
    }



    /**
     * Get the result from the last performed arithemtic operation (add, divide, modulus, multiply, subtract)
     *
     * @return \POPS\Types\Integer  The last result's Integer instance
     */
    public function getLastResult() {
        if (is_null($this->lastresult)) {
            throw new \POPS\Exceptions\NullPropertyException();
        }
        RETURN new Integer($this->lastresult);
    }


    /**
     * Get the remainder if this instance is divided by an Integer
     *
     * @param \POPS\Types\Integer $integer  The Integer instance as the divisor
     * @return int  The resulting int value
     */
    public function modulus(Integer $integer) {
        $this->lastresult = $this->getValue() % $integer->getValue();
        RETURN $this->getLastResult()->getValue();
    }


    /**
     * Multiply this with an Integer
     *
     * @param \POPS\Types\Integer $integer  The Integer instance to be multiplied to
     * @return int  The resulting int value
     */
    public function multiply(Integer $integer) {
        $this->lastresult = $this->getValue() * $integer->getValue();
        RETURN $this->getLastResult()->getValue();
    }


    /**
     * Raise this Integer instance to an exponential power
     *
     * @param \POPS\Types\Integer $exponent  The Integer instance as the exponent
     * @return int  The resulting int value
     */
    public function raiseTo(Integer $exponent) {
        $this->lastresult = pow($this->getValue(), $exponent->getValue());
        RETURN $this->getLastResult()->getValue();
    }



    /**
     * Check if current value is a valid integer
     *
     * @return boolean  If current value is a valid integer
     */
    public function isValid() {
        RETURN is_integer($this->getValue()) && $this->isWithinRange();
    }


    /**
     * Subtract this with an Integer
     *
     * @param \POPS\Types\Integer $integer  The Integer instance as subtrahend
     * @return int  The resulting int value
     */
    public function subtract(Integer $integer) {
        $this->lastresult = $this->getValue() - $integer->getValue();
        RETURN $this->getLastResult()->getValue();
    }

    /**
     * Get the maximum integer value
     *
     * @return type
     */
    public function getMax() {
        return $this->max;
    }

    /**
     * Get the minimum integer value
     *
     * @return int
     */
    public function getMin() {
        return $this->min;
    }

    /**
     * Check if current value is within the allowed range
     *
     * @return boolean  If current value is within the allowed range
     */
    public function isWithinRange() {
        return $this->getValue() >= $this->getMin() && $this->getValue() <= $this->getMax();
    }

}