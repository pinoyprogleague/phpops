<?php

/*
 * Made under PHPOps Open-Source Non-proprietary Project
 *
 * Pinoy Programmers League
 *
 * -----------------------------------------------------------------------------
 * Cache core
 *
 * This includes core helpers for basic Caching support
 */


/**
 * Set a value in cache
 *
 * @param string $key Cache key
 * @param mixed $value Cache value
 * @param int {=600} Cache lifespan in seconds, configurable at POPS_SYSTEM_PATH/config/startup.ini
 */
function core_cache_Set($key, $value, $lifespan=600)
{
    $cache = coresys_cache_Initialize();
    $cache->set($key, $value, $lifespan);
}



/**
 * Get a value from cache
 *
 * @param string $key
 *
 * @return mixed
 */
function core_cache_Get($key)
{
    $cache = coresys_cache_Initialize();
    RETURN $cache->get($key);
}



/**
 * Check if a key exists in cache
 *
 * @param string $key
 * @return boolean
 */
function core_cache_Has($key)
{
    $cache = coresys_cache_Initialize();
    RETURN $cache->get($key)!==NULL;
}



/**
 * Remove an entry from cache
 *
 * @param string $key
 */
function core_cache_Remove($key)
{
    if ( core_cache_Has($key) )
    {
        $cache = coresys_cache_Initialize();
        $cache->delete($key);
    }
}



/**
 * Reset a cache set
 *
 * @param string $key Key of the cache set
 */
function core_cache_Reset($key)
{
    $cache = coresys_cache_Initialize();
    if ( core_cache_Has($key) ) {
        $cache->delete($key);
    }
}



/**
 * [ SYSTEM USE ONLY ]
 */
function coresys_cache_Initialize($storage='auto')
{
    if ($storage !== phpFastCache::$storage) {
        phpFastCache::$storage = $storage;
    }
    return phpFastCache();
}