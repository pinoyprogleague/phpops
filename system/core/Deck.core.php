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
    if ( $uri===NULL ) {
        // get current URI if no specified
        $uri = core_uri_Get();
    }

    $commands = core_deck_ReadURI(strtolower(core_uri_Get()));
    $derivedControllerCallable = strtoupper(POPS_APP_MODULES_DIRNAME).'\\';

    if ( count($commands)==0 ) {
        // use Default Controller
        $derivedControllerCallable .= coresys_app_GetMainController();
    }
    else {

    }

    RETURN $derivedControllerCallable;
}



/**
 * Read current URI into a URI commands array
 *
 * @param string $uricmd The URI command, you may want to use the function core_uri_Get() ^_^
 *
 * @return array Chunked URIs in array, otherwise, blank array if provided URI has no commands
 */
function core_deck_ReadURI($uricmd)
{
    $uricmd = core_str_RemoveConsecutive(trim(ltrim(rtrim($uricmd,'/'), '/')), new POPS\Types\Character('/'));
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
    $PageController = new $controllerCallable();

    // Get the parameters for this page
    $Parameters = POPS\Requests\PageParameter::getPageParameters($controllerCallable);

    // Run the controller
    $PageController->run($Parameters===FALSE ? NULL : $Parameters);
}