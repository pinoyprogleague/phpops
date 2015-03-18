<?php

/*
 * Made under PHPOps Open-Source Non-proprietary Project
 *
 * Pinoy Programmers League
 *
 * -----------------------------------------------------------------------------
 * Data core
 *
 * This includes core helpers that can be used for system-level data
 */

/**
 * Get the value of a session key
 *
 * @param string $key
 *
 * @return mixed
 */
function core_session_Get($key)
{
    RETURN $_SESSION[$key];
}



/**
 * Get the current URI to this application
 *
 * @param boolean   $include_alphaslash {=false} If forward slash at the beginning should be included
 *
 * @return string
 */
function core_uri_Get($include_alphaslash=false)
{
    $url = $_SERVER['REQUEST_URI'];
    $basepos = defined('BASE_URI') ? strpos($url, BASE_URI) : FALSE;
    if ( $basepos!==FALSE && $basepos===0 ) {
        $url = substr($url, $basepos + strlen(BASE_URI), strlen($url) - $basepos);
    }
    RETURN ($include_alphaslash ? "/" : "") . rtrim(ltrim($url, '/'), '/');
}


/**
 * Check if a session key exists
 *
 * @param string $key
 *
 * @return boolean
 */
function core_session_Contains($key)
{
    RETURN isset($_SESSION[$key]);
}


/**
 * Set a session key
 *
 * @param string $key
 * @param mixed $value
 */
function core_session_Set($key, $value)
{
    $_SESSION[$key] = $value;
}