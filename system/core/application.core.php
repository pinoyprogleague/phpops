<?php

/*
 * Made under PHPOps Open-Source Non-proprietary Project
 *
 * Pinoy Programmers League
 *
 * -----------------------------------------------------------------------------
 * Application core
 *
 * This includes core helpers for application-related operations
 */

/**
 * Get the main controller
 */
function coresys_app_GetMainController()
{
    RETURN core_config_Read(POPS_APPLICATION_PATH.'application.ini', 'DEFAULT_CONTROLLER');
}