<?php

namespace POPS\Controllers;

/**
 * Page Controller
 */
class PageController extends \POPS\Controller {

    /** @var TemplateController */
    private $template;

    /** @var \POPS\Types\Collection */
    private $children;

    /** @var \POPS\View */
    private $defaultView;



    /**
     * Create a new Page controller instance
     *
     * @param \POPS\View $defaultView                 The default view for this PageController
     * @param \POPS\ModuleComponent $parent           {=NULL} Parent Module component of this Page controller
     * @param \POPS\Types\Collection $childCollection {=NULL} Collection of child Module components
     */
    public function __construct(\POPS\View $defaultView, \POPS\ModuleComponent $parent=NULL, \POPS\Types\Collection $childCollection=NULL) {
        parent::__construct($parent);
        $this->children = $childCollection;
        $this->template = NULL;
    }



    /**
     * Add a child Module component
     *
     * @param \POPS\ModuleComponent $child The Module component to be added (View, Canvas, TemplateController)
     *
     * @return PageController [reference] The resulting instance
     */
    public function &addChild($uri, \POPS\ModuleComponent $child) {
        $child->setParent($this);
        $child->setUri($uri);
        $this->children->add($child);
        RETURN $this;
    }



    /**
     * Get all child Module components of this Page controller
     *
     * @return \POPS\Types\Collection
     */
    public function getChildCollection() {
        RETURN $this->children;
    }




    /**
     * Get the default view of this PageController
     *
     * @return \POPS\View
     */
    public function &getDefaultView() {
        RETURN $this->defaultView;
    }



    /**
     * Check if this Page controller has child Module components
     *
     * @return boolean      If this PageController has child components
     */
    public function hasChild() {
        RETURN $this->getChildCollection()->isEmpty();
    }



    /**
     * Check if this PageController has default template
     *
     * @return boolean
     */
    public function hasTemplate() {
        RETURN $this->template!==NULL;
    }



    /**
     * Run this page controller
     *
     * @param \POPS\Types\Collection $paramCollection A collection of `Parameter` object
     */
    public function run(\POPS\Collections\PageParameterCollection $paramCollection=NULL) {

        // Declare page parameters as Global variable
        if ( $paramCollection!==NULL )
        {
            for ( $paramCollection->startLooping(); $paramCollection->isLooping(); $paramCollection->loops() ) {
                $current = $paramCollection->current();
                $key = 'PARAM_' . $current->getName();
                $GLOBALS[$key] = $current->getValue();
            }
        }

        // Look for a template
        if ( $this->hasTemplate() ) {
            $this->template->render();
        }
        // otherwise, look for the Default view
        else {

        }

    }



    /**
     * Set its default template controller
     *
     * @param \POPS\Controllers\TemplateController $template The new template controller to be plugged to this page
     */
    public function setTemplate(TemplateController $template) {

        $this->template = $template;
        $this->template->setParent($this);

    }



    /**
     * Show this Page controller
     *
     * @param \POPS\ModuleComponent $sourceComponent The source Module component that called this Page controller
     * @param \POPS\Types\Collection $paramCollection {=NULL} A collection of `PageParameter` to be passed
     */
    public function show(\POPS\ModuleComponent $sourceComponent, \POPS\Collections\PageParameterCollection $paramCollection=NULL) {

    }

}