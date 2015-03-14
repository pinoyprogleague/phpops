<?php

// crawl cache files
__crawl_files(POPS_SYSTEM_PATH . 'cache/');

// Initialize caches
cache_classes_Initialize();

if (CACHE_CLASSES_ENABLED == '0') {
    core_cache_Reset(CACHE_CLASSES_KEY);
}

// CACHE Open
$path = cache_classes_GetContentFilePath();
core_load_PHP($path, TRUE, TRUE);
unset($path);

// CACHE CLose