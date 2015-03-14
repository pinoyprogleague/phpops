<?php

/*
 * Made under PHPOps Open-Source Non-proprietary Project
 *
 * Pinoy Programmers League
 */

namespace POPS\Controllers;

/**
 * Template controller for holding template contents
 */
class TemplateController
        extends \POPS\Controller
        implements \POPS\Lang\IRenderable {

    /** @var \POPS\View */
    private $defaultView;

    /**
     * Initialize `TemplateController`
     *
     * @param View $view A view which is set to be the default renderable object
     * @param \POPS\ModuleComponent $parent {=NULL} Template's parent Module Component
     */
    public function __construct(\POPS\View $view, \POPS\ModuleComponent &$parent = NULL) {
        parent::__construct($parent);
        $this->defaultView = $view;
        $this->childCollection = new \POPS\Types\Collection();
    }



    /**
     * Get this template's default view
     *
     * @return \POPS\View   The default view
     */
    public function getDefaultView() {
        RETURN $this->defaultView;
    }



    /**
     * Render this TemplateController
     *
     * @param boolean $return If rendered contents should be returned
     * @return string   The rendered output
     */
    public function render($return=false) {
        if ($return) ob_start();

        echo $this->getDefaultView()->render(TRUE);
        if ($return) {
            RETURN ob_get_clean();
        }
    }

}
