<?php

$sys_ini_files = glob(POPS_SYSTEM_PATH.'config/*.ini');
$app_ini_files = glob(POPS_APPLICATION_PATH.'*.ini');

$ini_files = array_merge($sys_ini_files, $app_ini_files);

foreach ( $ini_files as $ini )
{
    if ( is_file($ini) )
    {
        $contents = parse_ini_file($ini);
        for ( $x=0; $x<count($contents); $x++,next($contents) )
        {
            define(strtoupper(key($contents)), current($contents));
        }
    }
}