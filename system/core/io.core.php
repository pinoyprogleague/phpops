<?php


/**
 * Remove a directory (whether empty directory or not)
 *
 * @param string    $dirpath The path of the directory to be removed
 */
function core_io_DirRemove($dirpath) {
    core_io_DirTruncate($dirpath);
    rmdir($dirpath);
}



/**
 * Truncate the contents of a directory
 *
 * @param string    $dirpath The path of the directory to be truncated
 */
function core_io_DirTruncate($dirpath) {
    $expression = core_io_ParsePath($dirpath) . "*"; // build GLOB expression
    $children = glob($expression);
    // Iterate for each child file entity
    foreach ($children as $child) {
        if (is_file($child)) {
            core_io_FileDelete($child, 10);
            continue;
        }
        if (is_dir($child)) {
            core_io_DirTruncate($child);
        }
    }
    if (!core_io_IsEmpty($dirpath)) {
        core_io_DirTruncate($dirpath);
        return;
    }
}



/**
 * Delete a file with optional max attempt
 *
 * @param string    $filepath Path to the target file
 * @param int       $maxattempts {=1} The number of max attempts to be made on file deletion failure
 *
 * @throws Exception    An exception is thrown after a number of attempts to delete
 */
function core_io_FileDelete($filepath, $maxattempts=1) {
    $filepath = core_io_ParsePath($filepath);
    
    // Check if file exists
    if (!file_exists($filepath) || !is_file($filepath)) {
        return;
    }
    // Loop deletion
    for ($x=0; $x < $maxattempts; $x++) {
        if (unlink($filepath)) {
            return;
        }
    }
    throw new Exception(sprintf("Unable to delete file \"%s\" after %d retries", $filepath, $maxattempts));
}



/**
 * Find a file and return its exact path
 *
 * @param string $filename Filename to search for
 * @param string $location Location where to search specified filename
 * @param boolean $debugmode {=FALSE} If search progress should be shown
 * @param boolean $case_sensitive {=FALSE} If case-sensitive search or not
 *
 * @return mixed The exact path (string) to the result, otherwise FALSE
 */
function core_io_FileFind($filename, $location, $debugmode=FALSE, $case_sensitive=FALSE)
{
    $cResults = POPS\Types\Collection::CreateFromArray(core_io_FileSearch($filename, $location, $debugmode));

    if ( $cResults->count() > 0 ) {
        for ( $cResults->startLooping(); $cResults->isLooping(); $cResults->loops() )
        {
            $basename = $case_sensitive ? pathinfo($cResults->current(), PATHINFO_BASENAME)
                    : strtolower(pathinfo($cResults->current(), PATHINFO_BASENAME));

            $search = $case_sensitive ? $filename : strtolower($filename);

            if ( file_exists($cResults->current()) && $basename===$search )
            {
                RETURN core_io_ParsePath($cResults->current());
            }
        }
    }
    RETURN FALSE;
}



/**
 * Search for matching files/filenames given filename criteria
 *
 * @param string $filename Name of the file, better to include file extension, NOT CASE-SENSITIVE
 * @param string $location Location/path you want to search on
 * @param array $matches Nothing, `never mind` this field ^_^
 *
 * @return mixed The array containing the matched file paths, otherwise FALSE if provided search location does not exist
 */
function core_io_FileSearch($filename, $location, $debugmode=FALSE, &$matches=NULL)
{
    $result = $matches!==NULL ? $matches : array();
    $path = core_io_ParsePath($location);
    if ( $path===FALSE ) {
        RETURN FALSE;
    }

    $files = glob($path.'*');

    if ( $debugmode ) echo '-- Searching at '.$path.'<br>';
    if ( $debugmode ) echo '<ul style="list-style:none;">';
    foreach ( $files as $file )
    {
        if ( realpath($path)==realpath($file) ) {
            // prevent infinite recursions
            continue;
        }

        if ( is_dir($file) ) {
            core_io_FileSearch($filename, $file, $debugmode, $result);
        }
        else {
            $baseFilename = pathinfo(realpath($file), PATHINFO_BASENAME);

            if ( $debugmode ) echo '<li><b>-- Comparing file '. $baseFilename .'</b></li>';

            if ( strpos(strtolower($file),strtolower($filename))!==FALSE ) {
                array_push($result, realpath($file));
            }
        }
    }
    if ( $debugmode ) echo '</ul>';

    if ( $matches===NULL ) {
        RETURN $result;
    }
    else {
        $matches = $result;
    }
}



/**
 * Delete multiple files
 *
 * @param array     $a_files The array of paths to files to be deleted
 * @param int       $maxattempts {=1} The number of max attempts to be made on file deletion failure
 *
 * @throws Exception    An exception is thrown after a number of attempts to delete
 */
function core_io_FilesDelete($a_files, $maxattempts=1) {
    foreach($a_files as $filepath) {
        core_io_FileDelete($filepath, $maxattempts);
    }
}



/**
 * Check if a path is an empty file or empty directory.
 * If the path points to a file, it will check for empty file.
 * If the path points to a directory, it will check if the directory contains no file nor directory inside.
 * Otherwise, FALSE if the path does not exist
 *
 * @param string    $path The path to the target file or directory
 * @return boolean  If a path is an empty file or empty directory.
 *
 * @throws \Exception   Generic exception when path given cannot be determined if it is a file, directory or non-existent
 */
function core_io_IsEmpty($path) {
    if (!file_exists($path)) {
        return false;
    }
    $path = core_io_ParsePath($path);
    if (is_file($path)) {
        return filesize($path) === 0;
    }
    else if (is_dir($path)) {
       $result = glob(rtrim($path, "*") . "*");
       return is_array($result) && sizeof($result) > 0;
    }
    else {
        throw new \Exception("Generic exception when path given cannot be determined if a file, directory or non-existent");
    }
}



/**
 * Parse a directory path or file path into standard format
 *
 * @param string $path Path value to be parsed
 * @return mixed The `string` value of the supplied path in Standard format, OTHERWISE, `false` if specified path does not exist
 */
function core_io_ParsePath($path)
{
    if (!is_dir($path) && !is_file($path) ) {
        RETURN FALSE;
    }
    $ret = str_replace('\\', '/', $path);
    RETURN is_file($ret) ? $ret : rtrim($ret, '/').'/';
}



/**
 * Parse an array of paths
 *
 * @param array $a_path An array of paths (string values)
 * @param boolean $is_ignorant {=false} If invalid directory values should be ignored and be excluded from the result
 * @return mixed The `array` of processed valid path values IF in Ignorant mode, otherwise, `FALSE` if an invalid path value was detected from the input array
 */
function core_io_ParsePathArray($a_path, $is_ignorant=FALSE)
{
    $ret = array();
    foreach ( $a_path as $path )
    {
        if ( is_string($path) ) {
            $path = core_io_ParsePath($path);
            if ( $path===FALSE ) {
                if ( $is_ignorant ) {
                    // eliminate invalid paths
                    CONTINUE;
                }
                else {
                    // otherwise, break and return FALSE
                    RETURN FALSE;
                }
            }
            else {
                array_push($ret, $path);
            }
        }
        else if ( is_array($path) ) {
            array_push($ret, core_io_ParsePathArray($path, $is_ignorant));
        }
        else {
            // return FALSE if supplied data was invalid
            RETURN FALSE;
        }
    }
    RETURN $ret;
}