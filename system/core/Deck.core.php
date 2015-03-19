<?php

/*
 * Made under PHPOps Open-Source Non-proprietary Project
 *
 * Pinoy Programmers League
 *
 * -----------------------------------------------------------------------------
 * The Main Deck
 *
 * Mostly system-related helpers for launching current framework
 *
 */



/**
 * Launch this whole system/application
 */
function coresys_deck_LaunchApp()
{
    // Run derived controller callable
    coresys_deck_RunController(coresys_deck_DeriveCallable());
}



/**
 * Derive the ControllerCallable command
 *
 * @param string $uri
 *
 * @return type
 */
function coresys_deck_DeriveCallable($uri=NULL)
{
    print_r(core_deck_ReadURI(core_uri_Get()));

    $router = new \Phroute\RouteCollector();
    $router->addRoute(Phroute\Route::ANY, "/{name:[a-zA-Z0-9_]+}/{anything}", function($name) {
        return "Hello $name";
    });

    $dispatcher = new \Phroute\Dispatcher($router);
    $response = $dispatcher->dispatch($_SERVER['REQUEST_METHOD'], core_uri_Get(true));
    echo $response;
}



/**
 * Read current URI into a URI commands array
 *
 * @param string    $uricmd {=null} The URI command to be read, otherwise, current URI will be read
 *
 * @return array Chunked URIs in array, otherwise, blank array if provided URI has no commands
 */
function core_deck_ReadURI($uricmd = null)
{
    if ($uricmd == null) {
        $uricmd = core_uri_Get();
    }
    echo $uricmd.'<br>';
    $filterGroup = new \POPS\Types\FilterCharGroup("/", 'l');
    $uricmd = $filterGroup->filter(new POPS\Types\String(trim(ltrim(rtrim($uricmd,'/'), '/'))))->getValue();
//    $uricmd = core_str_RemoveConsecutive(trim(ltrim(rtrim($uricmd,'/'), '/')), new POPS\Types\Character('/'));
    if (strlen($uricmd) > 0 ) {
        RETURN explode('/', $uricmd);
    }
    RETURN array();
}



/**
 * Run a controller through a callable controller name
 *
 * @param string $controllerCallable Callable controller name
 */
function coresys_deck_RunController($controllerCallable) {

}