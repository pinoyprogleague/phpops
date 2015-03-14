<?php


/**
 * Get the value of a system info parameter through a system info key
 *
 * @param string    $infokey The key of requested system info parameter
 *
 * @return mixed    The value of the requested system info key, otherwise FALSE if key does not exist from system info file
 */
function coresys_get_SysInfo($infokey)
{
    $path = core_io_ParsePath(POPS_SYSTEM_PATH . "system.ini");
    return core_config_Read($path, $infokey);
}