<?php

/*
 * Made under PHPOps Open-Source Non-proprietary Project
 *
 * Pinoy Programmers League
 */

namespace TEMPLATES;


/**
 * Default template
 */
class DefaultTemplate extends \POPS\Controllers\TemplateController {

    public function __construct(\POPS\ModuleComponent &$parent = NULL) {

        $defaultView = new \POPS\View(\POPS\View::DEFAULTVIEW, POPS_APP_TEMPLATES_PATH.'DefaultTemplate/hello');

        parent::__construct($defaultView, $parent);

    }

}
