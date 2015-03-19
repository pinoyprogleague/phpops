<?php

/*
 * Made under PHPOps Open-Source Non-proprietary Project
 *
 * Pinoy Programmers League
 */

/**
 * Utility class for generic purposes of various types of objects
 *
 * @author Allen
 */
class OBJECTS {


    public static function Jsonify($object)
    {
        $ret = array();
        $reflectionClass = new ReflectionClass(get_class($object));
        $properties = $reflectionClass->getProperties();
        foreach ($properties as $property) {
            $d = new ReflectionProperty($property, $name);
            $d->getDocComment();
            $ret[$property] = $object->{$property};
        }
    }


}
