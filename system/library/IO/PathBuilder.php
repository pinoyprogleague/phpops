<?php

/*
 * Made under PHPOps Open-Source Non-proprietary Project
 *
 * Pinoy Programmers League
 */

use POPS\Types\Integer as Integer;
namespace POPS\IO;

/**
 * File/directory string path builder with validation
 */
class PathBuilder {

    protected
            /** @var POPS\Types\Collection */
            $pathComponents
    ;



    public function __construct(\POPS\Types\String $preString='/') {

        $this->pathComponents = new \POPS\Types\Collection($preString);

    }



    /**
     * Add a path component to this path builder instance
     *
     * @param \POPS\Types\String $pathComponent     The path component to be added to this path builder instance
     */
    public function add(\POPS\Types\String $pathComponent) {
        $this->pathComponents->add($pathComponent);
    }



    public function getPath() {

        $ret = '';
        $pathComponents = &$this->pathComponents;
        $ret .= $pathComponents->get(1);
    }

}
