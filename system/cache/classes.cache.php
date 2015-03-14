<?php

/**
 * [ SYSTEM USE ONLY ]
 */
function cache_classes_Initialize()
{
    if ( !core_cache_Has(CACHE_CLASSES_KEY) ) {
        core_cache_Set(CACHE_CLASSES_KEY, array(), CACHE_CLASSES_TTL);
    }
}



/**
 * Add class to cache
 *
 * @param type $classname
 * @param type $path
 */
function cache_classes_Add($classname, $path)
{
    cache_classes_Initialize();

    $filecontents = file_get_contents($path);
    $cache = core_cache_Get(CACHE_CLASSES_KEY);
    $cache[$classname] = $filecontents;
    core_cache_Set(CACHE_CLASSES_KEY, $cache, CACHE_CLASSES_TTL);
}



/**
 * Destroy a cache content file
 *
 * @param string    $content_file_path Path to the content file
 */
function cache_classes_DestroyContentFile($content_file_path=NULL)
{
    $filepath = POPS_SYSTEM_PATH.'tmp/'.session_id().'.tmp.php';
    if ( $content_file_path!==NULL ) {
        $filepath = $content_file_path;
    }
    // try to delete file
    if (file_exists($filepath) ) {
        unlink($filepath);
    }
}



function cache_classes_GetContentFilePath()
{
    cache_classes_Initialize();

    $content_file = POPS_SYSTEM_PATH.'tmp/'.session_id().'.tmp.php';
    $cached_contents = '';
    $cache = core_cache_Get(CACHE_CLASSES_KEY);

    // join all cache contents into a single importable php file
    for ( $x=0,reset($cache); $x<count($cache); $x++,next($cache) )
    {
        $cached_contents .= '<?php'.str_replace('?>', PHP_EOL, str_replace('<?php', PHP_EOL, current($cache))).'?>'.PHP_EOL.PHP_EOL;
    }

    // verify first if existing content file needs to be updated with current cache contents
    if ( file_exists($content_file) ) {
        if ( md5($cached_contents)!==md5(file_get_contents($content_file)) ) {
            // destroy if obsolete content was detected
            cache_classes_DestroyContentFile($content_file);
        }
    }
    file_put_contents($content_file, $cached_contents);

    RETURN $content_file;
}



/**
 * Check if a class is already loaded/cached
 *
 * @param string $classname Name of the class
 * @return boolean
 */
function cache_classes_IsLoaded($classname)
{
    $cache = core_cache_Get(CACHE_CLASSES_KEY);
    RETURN array_key_exists($classname, $cache);
}