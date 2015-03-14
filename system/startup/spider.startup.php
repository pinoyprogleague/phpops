<?php

if ( function_exists('__crawl_files')===FALSE ) {
    /**
     * Craw all PHP and PHTML files in certain directory
     *
     * @param string $location Path/location where to crawl files
     * @param array $exts {=[]} Array of file extensions to be included in search. PHP and PHTML are default extensions
     */
    function __crawl_files($location, $exts=array())
    {
        // process allowed extensions
        $extensions = count($exts)===0 ? 'php|phtml' : implode('|', $exts);

        // add slash
        $location = rtrim(str_replace('\\', '/', $location),'/').'/';

        $files = glob($location.'*');
        // iterate over every file path found
        FOREACH ( $files as $file )
        {
            // Check if:
            // -- we are not crawling our own body
            // -- the path points to a file
            // -- the path contains one of the specified extensions from "$exts" parameter
            IF ( strtolower($file)!==str_replace('\\', '/', strtolower(__FILE__)) && !is_dir($file) && \preg_match('/.+\.(' . $extensions . ')$/i', $file) === 1)
            {
                ob_start();
                require_once $file;
                echo ob_get_clean();
            }
            ELSE IF ( is_dir($file) )
            {
                // if it is a directory path, then do recursive crawl
                __crawl_files($file.'/', $exts);
            }
        }
        unset($files); // free up content
    }
}