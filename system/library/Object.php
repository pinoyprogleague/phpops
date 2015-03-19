<?php

/*
 * Made under PHPOps Open-Source Non-proprietary Project
 *
 * Pinoy Programmers League
 */

namespace POPS;

/**
 * The base and parent-most class of all derived PHPOps classes
 *
 * @author Allen
 */
class Object {


    /**
     * Check if this instance or object is equals to another instance
     *
     * @param mixed     $value The instance/object which this will be compared with
     * @param boolean   $is_strict {=false} If strict data-type checking will be used
     *
     * @return boolean
     */
    public function equals($value, $is_strict=false) {
        return $is_strict ? $this === $value : $this == $value;
    }


    /**
     * Get the string value of this instance
     *
     * @return string
     */
    public function toString() {
        return $this->__toString();
    }

    public function __toString() {
        return strval($this);
    }


}
