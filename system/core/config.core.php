<?php

/*
 * Made under PHPOps Open-Source Non-proprietary Project
 *
 * Pinoy Programmers League
 *
 * -----------------------------------------------------------------------------
 * Configuration helpers
 *
 * This includes core helpers for configuration files
 */

/**
 * Read configuration
 *
 * @param string $path Path to the configuration file
 * @param string $key {=NULL} Key to be looked up
 * @return mixed The config contents in array will be returned IF KEY WAS NOT SPECIFIED, otherwise, the value of the key. FALSE if key or config file doesn't exist.
 */
function core_config_Read($path, $key=NULL)
{
    $parsed = parse_ini_file($path);
    if ( $parsed!==FALSE )
    {
        if ( $key===NULL ) {
            RETURN $parsed;
        }

        if ( !array_key_exists($key, $parsed) ) {
            RETURN FALSE;
        }
        else {
            RETURN $parsed[$key];
        }
    }

    RETURN FALSE;
}

?>