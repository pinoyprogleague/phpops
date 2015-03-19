<?php

/*
 * Made under PHPOps Open-Source Non-proprietary Project
 *
 * Pinoy Programmers League
 */

namespace POPS\Requests;

/**
 * Base class for storing routes
 *
 * @author Allen
 */
class Router {

    /** @var \POPS\Collections\Dictionary */
    private $routes;

    /**
     *
     */
    public function __construct() {
        $this->routes = new \POPS\Collections\Dictionary();
    }


    /**
     * Add a route to this router
     *
     * @param string            $routename Name of the new router
     * @param \POPS\PageController  $pageController Page controller where such router will refer to
     *
     * @return \POPS\Requests\Router
     */
    public function addRoute($routename, \POPS\PageController $pageController)
    {
        $routename = trim(str_replace("/", "", urlencode($routename)));
        $kv = new \POPS\Elements\KeyValuePair($routename, $pageController);
        $position = $this->getRoutes()->getKeyPosition($kv->getKey());
        if ($position!==false) {
            $this->getRoutes()->setValue($kv->getKey(), $kv->getValue());
        }
        else {
            $this->getRoutes()->add($kv);
        }
        RETURN $this;
    }


    /**
     * Get all routes in this Router
     *
     * @return \POPS\Collections\Dictionary
     */
    public function &getRoutes()
    {
        return $this->routes;
    }


    public function getRoute(\POPS\PageController $pageController)
    {
        $routes = $this->getRoutes();
        for ($routes->startLooping(); $routes->isLooping(); $routes->loops())
        {
            $current = $routes->current();
            if ($current instanceof \POPS\Elements\KeyValuePair) {
                
            }
        }
    }


}
