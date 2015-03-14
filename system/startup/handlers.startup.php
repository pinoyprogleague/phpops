<?php

/**
 *  Initializes the autoload function
 */
spl_autoload_register('coresys_load_class');

/**
 * Initiaize the Error handler
 */
set_error_handler('coresys_handle_error');

/**
 * Initialize the Exception handler
 */
set_exception_handler('coresys_handle_exception');