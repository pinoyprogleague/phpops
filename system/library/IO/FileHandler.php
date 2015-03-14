<?php

/*
 * Made under PHPOps Open-Source Non-proprietary Project
 *
 * Pinoy Programmers League
 */

namespace POPS\IO;

/**
 * Class for handling files
 *
 * @author Allen
 */
class FileHandler {

    const MODE_READ = 'r';
    const MODE_READ_WRITE = 'r+';
    const MODE_WRITE = 'w';
    const MODE_WRITE_READ = 'w+';
    const MODE_APPEND_WRITE = 'a';
    const MODE_APPEND_WRITE_READ = 'a+';
    const MODE_CREATE_WRITE = 'x';
    const MODE_CREATE_WRITE_READ = 'x+';
    const MODE_CREATESAFE_WRITE = 'c';
    const MODE_CREATESAFE_WRITE_READ = 'c+';


    private $resource;
    private $path;


    public function __construct($path, $create_if_not_exist=FALSE)
    {
        if ( file_exists($path) ) {
            if ( !is_file($path) ) {
                throw new \POPS\Exceptions\NotFileException($path);
            }
        }
        else if ( $create_if_not_exist ) {
            if ( !is_writable($path) ) {
                throw new \POPS\Exceptions\FileNoWriteException($path);
            }

            $this->resource = fopen($path, 'w');
            fwrite($this->resource, '');
            $this->__closeResource();
        }

        $this->__closeResource();
        $this->path = realpath($path);
    }



    public function &append(\POPS\Types\String $strObj)
    {
        $this->resource = self::CreateResource($this->getPath(), self::MODE_APPEND_WRITE);
        fwrite($this->resource, $strObj->getValue());
        fclose($this->resource);
        RETURN $this;
    }



    public function delete()
    {
        if ( !$this->exists() )
        {
            throw new \POPS\Exceptions\FileNotFoundException($this->path);
        }
        unlink($this->path);
    }



    public function exists()
    {
        RETURN file_exists($this->path);
    }



    public function getPath()
    {
        RETURN $this->path;
    }



    public function read()
    {

    }



    /**
     * Write String into the current file
     *
     * @param \POPS\Types\String $strObj
     * @return \POPS\IO\FileHandler
     */
    public function &write(\POPS\Types\String $strObj)
    {
        $this->resource = self::CreateResource($this->getPath(), self::MODE_WRITE);
        fwrite($this->resource, $strObj->getValue());
        $this->__closeResource();
        RETURN $this;
    }


    private function __closeResource()
    {
        if ( !is_null($this->resource) )
        {
            fclose($this->resource);
            $this->resource = NULL;
        }
    }



    /**
     * Alias of function `fopen()`
     *
     * @param string $filename If filename is of the form "scheme://...", it is assumed to be a URL and PHP will search for a protocol handler (also known as a wrapper) for that scheme. If no wrappers for that protocol are registered, PHP will emit a notice to help you track potential problems in your script and then continue as though filename specifies a regular file. IF PHP has decided that filename specifies a local file, then it will try to open a stream on that file. The file must be accessible to PHP, so you need to ensure that the file access permissions allow this access. If you have enabled safe mode, or open_basedir further restrictions may apply.
     *          If PHP has decided that filename specifies a registered protocol, and that protocol is registered as a network URL, PHP will check to make sure that allow_url_fopen is enabled. If it is switched off, PHP will emit a warning and the fopen call will fail.
     *          The list of supported protocols can be found in . Some protocols (also referred to as wrappers) support context and/or php.ini options. Refer to the specific page for the protocol in use for a list of options which can be set. (e.g. php.ini value user_agent used by the http wrapper).
     *          On the Windows platform, be careful to escape any backslashes used in the path to the file, or use forward slashes. $handle = fopen("c:\\folder\\resource.txt", "r");
     * @param string $mode Refer to FileHandler modes
     * @param boolean $use_include_path {=FALSE} Can be set to '1' or TRUE if you want to search for the file in the include_path, too.
     * @param resource $context {=NULL} Context support was added with PHP 5.0.0.
     *
     * @return resource
     */
    public static function CreateResource($filename, int $mode, $use_include_path=FALSE, $context=NULL)
    {
        RETURN fopen($filename, $mode, $use_include_path, $context);
    }


}
