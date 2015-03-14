<?php

/*
 * Made under PHPOps Open-Source Non-proprietary Project
 *
 * Pinoy Programmers League
 */

namespace POPS\Types;

/**
 * Data type for PHP renderable file
 */
class RenderableFile extends \POPS\Lang\AbstractDatatype implements \POPS\Lang\IDatatype, \POPS\Lang\IRenderable {

    private $value;




    /**
     * Initialize a `RenderableFile` instance
     *
     * @param string $path The path of the target file
     *
     * @throws \POPS\Exceptions\FileNotFoundException Thrown if supplied path to file does not exist
     */
    public function __construct(String $path) {
        $path = core_io_ParsePath($path);
        if ( $path===FALSE )
        {
            throw new \POPS\Exceptions\FileNotFoundException($path);
        }
        $this->value = $path;
    }



    /**
     * Render this PHP file
     */
    public function render() {
        ob_start();
        require_once $this->getValue();
        RETURN ob_get_clean();
    }

}
