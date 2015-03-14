<?php

namespace POPS;

/**
 * Base Controller class of PHPOps
 */
class Controller extends ModuleComponent {

    public function __construct(ModuleComponent &$parent=NULL) {
        parent::__construct($parent);
    }

}
