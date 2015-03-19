<?php

/**
 * Base path for 3rd-party libraries and providers
 */
$basepath = POPS_SYSTEM_PATH . '3rd/';


/**
 * phpFastCache
 */
REQUIRE_ONCE $basepath . 'phpfastcache/phpfastcache.php';

/**
 * Phroute
 */
REQUIRE_ONCE $basepath . 'Phroute/Exception/BadRouteException.php';
REQUIRE_ONCE $basepath . 'Phroute/Exception/HttpException.php';
REQUIRE_ONCE $basepath . 'Phroute/Exception/HttpMethodNotAllowedException.php';
REQUIRE_ONCE $basepath . 'Phroute/Exception/HttpRouteNotFoundException.php';
REQUIRE_ONCE $basepath . 'Phroute/Dispatcher.php';
REQUIRE_ONCE $basepath . 'Phroute/Route.php';
REQUIRE_ONCE $basepath . 'Phroute/RouteParser.php';
REQUIRE_ONCE $basepath . 'Phroute/RouteCollector.php';
REQUIRE_ONCE $basepath . 'Phroute/HandlerResolverInterface.php';
REQUIRE_ONCE $basepath . 'Phroute/HandlerResolver.php';


// release resource
unset($basepath);