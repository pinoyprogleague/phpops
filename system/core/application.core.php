<?php

/**
 * Get the main controller
 */
function coresys_app_GetMainController()
{
    RETURN core_config_read(POPS_APPLICATION_PATH.'application.ini', 'DEFAULT_CONTROLLER');
}