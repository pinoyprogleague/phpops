<?php

/*
 * Made under PHPOps Open-Source Non-proprietary Project
 *
 * Pinoy Programmers League
 */

namespace POPS\Types;

/**
 * Generic Collection object
 */
class Collection implements \POPS\Lang\IListable, \POPS\Lang\ICollectionTypeMatchable, \Iterator {

    /** @var array The collection items */
    private $items;

    /** @var int Current internal pointer position */
    private $position;



    /**
     * Construct an instance of Collection
     *
     * @param INDEFINITE $_ (optional) All items to be assigned in this collection
     */
    public function __construct() {
        $this->items = array();
        if ( func_num_args()===1 && func_get_arg(0) instanceof Collection ) {
            $newinstance = func_get_arg(0);
            $this->items = $newinstance->items;
            $this->position = $newinstance->position;
        }
        else {
            for ( $x=0; $x<func_num_args(); $x++ ) {
                array_push($this->items, func_get_arg($x));
            }
        }
        $this->rewind();
    }


    /**
     * Clear the items in this collection
     */
    public function clear() {
        $this->items = array();
    }


    /**
     * Check if this Collection contains certain object
     *
     * @param \POPS\Types\Generic $object The object to be searched for
     *
     * @return boolean If this collection has the specified object
     */
    public function contains(Generic $object) {
        $coll = clone $this;
        for ( $coll->startLooping(); $coll->isLooping(); $coll->loops() )
        {
            if ( $coll->current()===$object->getValue() )
            {
                RETURN TRUE;
            }
        }
        RETURN FALSE;
    }


    /**
     * Copy the items in this collection to another collection
     *
     * @param \POPS\Types\Collection    $collection The destination instance where copy will take place
     * @param boolean   $is_overwrite   {=false} If items will be overwritten
     */
    public function copyTo(Collection &$collection, $is_overwrite=false) {
        if ($is_overwrite) {
            $collection->clear();
        }
        for ($this->startLooping(); $this->isLooping(); $this->loops()) {
            $collection->add($this->current());
        }
    }



    /**
     * Return the number of items in this collection
     *
     * @return int
     */
    public function count() {
        RETURN count($this->items);
    }



    /**
     * Return the current item at internal pointer
     *
     * @return mixed
     */
    public function current()
    {
        RETURN current($this->items);
    }


    /**
     * Get the index (first-occurence) of an item, otherwise returns FALSE if not found
     *
     * @param mixed     $item The item to be looked up
     *
     * @return boolean
     */
    public function indexOf($item)
    {
        for ($this->startLooping(); $this->isLooping(); $this->loops())
        {
            if ($this->current() == $item) {
                return $this->getIndex();
            }
        }
        return false;
    }


    /**
     * Check if this Collection is still iterating (useful for loops)
     *
     * @return boolean
     */
    public function isLooping()
    {
        RETURN $this->valid() && ($this->getPosition() <= count($this->items));
    }



    /**
     * Check if this is an empty collection
     *
     * @return boolean
     */
    public function isEmpty() {
        RETURN $this->count()==0;
    }



    /**
     * Loop iteration (useful for loops), alias of `next()`
     *
     * @return mixed The value of the next item on internal pointer, otherwise, FALSE
     */
    public function loops() {
        RETURN $this->next();
    }



    /**
     * Return the key (internal pointer value) of the current item
     *
     * @return mixed
     */
    public function key() {
        RETURN key($this->items);
    }


    /**
     * Get the last index (last-occurence) of an item, otherwise returns FALSE if not found
     *
     * @param mixed     $item The item to be looked up
     *
     * @return boolean
     */
    public function lastIndexOf($item)
    {
        for ($x=$this->count(); $x > 0; $x--) {
            if ($this->get($x)==$item) {
                return $x - 1;
            }
        }
        return false;
    }



    /**
     * Advance this collection's internal pointer
     *
     * @return The value of the next item on internal pointer, otherwise FALSE
     */
    public function next() {
        $ret = next($this->items);
        $this->position++;
        RETURN $ret;
    }



    /**
     * Rewind the internal pointer to the first element of this collection
     *
     * @return mixed The value of the first item
     */
    public function rewind() {
        $ret = reset($this->items);
        if ( $ret!==FALSE || count($this->items)>0 ) {
            $this->position = 1;
        }
        else {
            $this->position = 0;
        }
        RETURN $ret;
    }



    /**
     * Start looping in this collection (useful for loops)
     *
     * @param Integer $startPosition    {=null} If NULL/undefined, looping will be started from the very first pointer
     * @param boolean $is_index     {=false} If true, start position will be treated as index (zero-based)
     */
    public function startLooping(Integer $startPosition=NULL, $is_index=FALSE) {
        if ($startPosition===NULL) {
            $this->rewind();
        }
        else if ($is_index) {
            $this->setIndex($startPosition->getValue());
        }
        else {
            $this->setPosition($startPosition->getValue());
        }
    }



    /**
     * Check if current internal pointer position is valid
     *
     * @return type
     */
    public function valid() {
        RETURN ( ($this->getPosition() > 0) && ($this->getPosition() <= $this->count()) );
    }



    /**
     * Add an item to this collection
     *
     * @param mixed $item The item to be added
     */
    public function add($item) {
        array_push($this->items, $item);
    }



    /**
     * Gets the item/value at `nth` position
     *
     * @param int $nth Position of item
     *
     * @return mixed
     */
    public function &get($nth) {
        if ( $nth > $this->count() || $nth <= 0 ) {
            RETURN NULL;
        }
        RETURN $this->items[$nth-1];
    }



    /**
     * Get the current internal pointer index (starts at 0)
     *
     * @return int  The current internal pointer index
     */
    public function getIndex() {
        $ret = $this->position-1;
        if ( $ret<0 ) {
            $ret = -1;
        }
        RETURN $ret;
    }



    /**
     * Get the current internal pointer position (starts at 1)
     *
     * @return int  The current internal pointer position
     */
    public function getPosition() {
        RETURN $this->position;
    }



    /**
     * Remove an item in `nth` position
     *
     * @param int $nth Position of item to be removed
     *
     * @return boolean If target item was removed by this  (useful for multithreaded operations)
     */
    public function remove($nth) {
        if ( $this->get($nth)!==NULL ) {
            unset($this->items[$nth-1]);
            RETURN TRUE;
        }
        RETURN FALSE;
    }



    /**
     * Set a value in `nth` position
     *
     * @param int $nth Position of target item
     * @param mixed $newvalue New value to be assigned
     *
     * @return mixed The old value before new value assignment has been made
     *
     * @throws \POPS\Exceptions\NullPointerException
     */
    public function set($nth, $newvalue) {
        if ( $this->get($nth)===NULL ) {
            throw new \POPS\Exceptions\NullPointerException();
        }
        $oldval = $this->items[$nth-1];
        $this->items[$nth-1] = $newvalue;
        RETURN $oldval;
    }



    /**
     * Set the index pointer (zero-based)
     *
     * @param int $index    The index pointer
     */
    public function setIndex($index) {
        $this->setPosition($index+1);
    }



    /**
     * Set the position pointer (non-zero-based)
     *
     * @param int $position The position pointer
     *
     * @throws \POPS\Exceptions\NullPointerException
     * @throws \OutOfRangeException
     */
    public function setPosition($position) {
        if ($position<0) {
            throw new \POPS\Exceptions\NullPointerException();
        }
        if ($position>$this->count()) {
            throw new \OutOfRangeException();
        }
        $this->position = $position;
    }



    /**
     * Convert this instance into array
     *
     * @return array
     */
    public function toArray() {
        RETURN $this->items;
    }



    /**
     * Convert this instance into ArrayObject
     *
     * @return \ArrayObject
     */
    public function toArrayObject() {
        RETURN new \ArrayObject($this->toArray());
    }



    /**
     * Convert this instance into byte-stream
     *
     * @return string
     */
    public function toBytes() {
        RETURN serialize($this);
    }


    /**
     * THIS IS UNDER DEVELOPMENT STAGE
     *
     * @param string $type
     * @return boolean
     */
    public function typeMatch($type) {
        for ( $this->startLooping(); $this->isLooping(); $this->loops() ) {
            if ( !($this->current() instanceof $type) ) {
                RETURN FALSE;
            }
        }
        RETURN TRUE;
    }



    /**
     * Create an instance of `Collection` from an array
     *
     * @param array $array
     * @return \POPS\Types\Collection
     */
    public static function CreateFromArray($array) {
        $new = new Collection();
        for ( $x=0,reset($array); $x<count($array); $x++,next($array) ) {
            $new->add(current($array));
        }
        RETURN $new;
    }



    /**
     * Create an instance of `Collection` from bytes (serialized byte-stream/string)
     *
     * @param string $buffer Serialized byte-stream
     *
     * @return mixed The resulting instance of `Collection` if given stream is bytes of Collection, otherwise, FALSE
     * @throws \POPS\Exceptions\InvalidBytesException
     */
    static function CreateFromBytes($buffer) {
        $unserialized = unserialize($buffer);
        if ( $unserialized instanceof Collection ) {
            RETURN new Collection($unserialized);
        }
        throw new \POPS\Exceptions\InvalidBytesException();
    }

}
