<?php

/*
 * Made under PHPOps Open-Source Non-proprietary Project
 *
 * Pinoy Programmers League
 */

namespace POPS\Lang;

/**
 * Interface class renderable UI components/controller
 */
interface IRenderable {


    /**
     * Render this content
     *
     * @param string $return {=FALSE} If rendered content should be returned as string
     *
     * @return mixed The rendered `string` content, OTHERWISE, it won't return anything
     */
    function render($return=false);

}
