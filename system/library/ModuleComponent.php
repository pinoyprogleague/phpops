<?php

namespace POPS;

/**
 * Main Class for all module Controllers and Views
 */
class ModuleComponent {

    /** @var string */
    private $uri;

    /** @var ModuleComponent */
    private $parentComponent;



    /**
     * Initialize a ModuleComponent instance
     *
     * @param \POPS\ModuleComponent $parent {=null} Parent component of this component
     * @param string $uri {=null} This component's URI
     */
    public function __construct(ModuleComponent &$parent=null, $uri=null) {
        $this->uri = $uri;
        $this->parentComponent = $parent;
    }



    /**
     * Get the name of this component
     *
     * @param boolean $absolute {=false} If component's absolute name should be returned, otherwise, namespace will be included
     * @return string   The component's name
     */
    public function getObjectName($absolute=false) {
        $classSegmentedName = $absolute ? explode('\\', get_class($this)) : get_class($this);
        RETURN $absolute ? $classSegmentedName[count($classSegmentedName)-1] : $classSegmentedName;
    }



    /**
     * Get the parent component
     *
     * @return ModuleComponent  The parent component
     */
    public function &getParent() {
        RETURN $this->parentComponent;
    }



    /**
     * Get the URI assigned to this component
     *
     * @return string   The URI assigned to this component
     */
    public function getUri() {
        RETURN $this->uri;
    }



    /**
     * Check if this component has URI assigned
     *
     * @return boolean  If this component has URI assigned
     */
    public function hasUri() {
        RETURN $this->getParent()!==NULL && $this->uri!==NULL;
    }



    /**
     * Set the parent component of this component
     *
     * @param \POPS\ModuleComponent $parent     [reference] The parent component to be assigned
     */
    public function setParent(ModuleComponent &$parent) {
        $this->parentComponent = $parent;
    }



    /**
     * Set the URI for this component
     *
     * @param string $uri   The URI to be assigned to this component
     */
    public function setUri($uri) {
        $this->uri = $uri;
    }

}
