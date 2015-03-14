<?php

/*
 * PHPOps Front manager
 */
//------------------------------------------------------------------------------
//  1)  ENABLE ERROR REPORTING and SESSION
//------------------------------------------------------------------------------
error_reporting(E_ALL | E_STRICT);
session_start();

//------------------------------------------------------------------------------
//  2)  APPLICATION constants
//------------------------------------------------------------------------------

/** Directory name */
define( 'POPS_APPLICATION_DIRNAME', 'application');
/** Path */
define( 'POPS_APPLICATION_PATH'
    , str_replace('\\', '/', rtrim(rtrim(realpath(POPS_APPLICATION_DIRNAME), '/'), '\\')).'/' );

//------------------------------------------------------------------------------
//  3)  SYSTEM constants
//------------------------------------------------------------------------------

/** Directory name */
define('POPS_SYSTEM_DIRNAME', 'system');
/** Path */
define( 'POPS_SYSTEM_PATH'
    , str_replace('\\', '/', rtrim(rtrim(realpath(POPS_SYSTEM_DIRNAME), '/'), '\\')).'/' );

//------------------------------------------------------------------------------
//  4)  Application MODULES constants
//------------------------------------------------------------------------------

/** Directory name */
define('POPS_APP_MODULES_DIRNAME', 'modules');
/** Path */
define( 'POPS_APP_MODULES_PATH'
    , POPS_APPLICATION_PATH . POPS_APP_MODULES_DIRNAME . '/' );

//------------------------------------------------------------------------------
//  5)  Application TEMPLATES constants
//------------------------------------------------------------------------------

/** Directory name */
define('POPS_APP_TEMPLATES_DIRNAME', 'templates');
/** Path */
define( 'POPS_APP_TEMPLATES_PATH'
    , POPS_APPLICATION_PATH . POPS_APP_TEMPLATES_DIRNAME . '/' );

//------------------------------------------------------------------------------
//  6)  ADDON constants
//------------------------------------------------------------------------------

/** Directory name */
define('POPS_ADDON_DIRNAME', 'addons');
/** Path */
define( 'POPS_ADDON_PATH'
    , str_replace('\\', '/', rtrim(rtrim(realpath(POPS_ADDON_DIRNAME), '/'), '\\')).'/' );


//------------------------------------------------------------------------------
//  7)  LOAD STARTUP ITEMS (ordered)
//------------------------------------------------------------------------------
$_basepath = POPS_SYSTEM_PATH . 'startup/';
# FileSpider
require_once $_basepath . 'spider.startup.php';
# system configs
require_once $_basepath . 'configs.startup.php';
# core loader
require_once $_basepath . 'coreloader.startup.php';
# handlers (autoload, error, exception, etc.)
require_once $_basepath . 'handlers.startup.php';
# 3rd-party providers
require_once $_basepath . '3rdparty.startup.php';
# system cache
require_once $_basepath . 'cache.startup.php';
# cleaners
require_once $_basepath . 'cleaners.startup.php';

unset($basepath); // release resource



/**
 * -----------------------------------------------------------------------------
 * Ready... Launch!
 * -----------------------------------------------------------------------------
 */
coresys_deck_LaunchApp();