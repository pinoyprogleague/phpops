<?php

namespace MODULES;

use POPS\Controllers\PageController;

/**
 * Home controller
 */
class Home extends PageController {

    public function __construct() {
        die($this->getObjectName(TRUE));
        parent::__construct(new View( POPS_APP_MODULES_PATH . $this->getObjectName(TRUE)));
        $this->hasChild();
    }

}
