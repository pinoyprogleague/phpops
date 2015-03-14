<?php

/**
 * Base path for 3rd-party libraries and providers
 */
$basepath = POPS_SYSTEM_PATH.'3rd/';


// import 3rd-party stuff
REQUIRE_ONCE $basepath.'phpfastcache/phpfastcache.php';


// release resource
unset($basepath);