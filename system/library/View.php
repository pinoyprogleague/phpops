<?php


namespace POPS;

/**
 * File containing interface elements for TemplateController or PageController
 */
class View extends ModuleComponent implements Lang\IRenderable {

    /** @var string Constant for Default views */
    const DEFAULTVIEW = 'DEFAULT';



    private
            /** @var string */
            $path
    ;


    public function __construct($path, \POPS\ModuleComponent &$parent=NULL) {

        parent::__construct($parent);
        $this->path = core_io_ParsePath($path . '.phtml');
        if ( $this->path===FALSE ) {
            throw new Exceptions\FileNotFoundException($path . '.phtml');
        }

    }



    /**
     * Get the buffered contents of this view
     *
     * @return string
     */
    protected function getContents() {

        ob_start();
        require $this->getPath();
        RETURN ob_get_clean();

    }



    /**
     * Get the path to this view's file
     *
     * @return string
     */
    public function getPath() {
        RETURN $this->path;
    }



//------------------------------------------------------------------------------
//  Interface methods
//------------------------------------------------------------------------------


    /**
     * Render this view
     *
     * @param string $return {=FALSE} If rendered content should be returned as string
     * @return mixed The rendered `string` content, OTHERWISE, it won't return anything
     */
    public function render($return=false) {

        $contents = $this->getContents();
        if ( $return ) {
            RETURN $contents;
        }
        echo $contents;
        
    }

}
