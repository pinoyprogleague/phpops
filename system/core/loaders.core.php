<?php

/**
 * Include a PHP file
 *
 * @param string $path Path to the PHP file
 * @param boolean $is_require {=true} If `require` will be used, otherwise, `include`
 * @param boolean $destroy {=false} If file should be deleted after being loaded
 * @param boolean $redundant {=false} If file can be loaded redundantly, otherwise, `require_once` or `include_once` will be used
 * @param boolean $nobuffer {=false} If operation should be done w/o buffering
 */
function core_load_PHP($path, $is_require=true, $destroy=false, $redundant=false, $nobuffer=false)
{
    if ( !$nobuffer ) {
        // start buffer
        ob_start();
    }

    if ($redundant) {
        IF ($is_require)    require $path;
        ELSE                include $path;
    }
    else {
        IF ($is_require)    require_once $path;
        ELSE                include_once $path;
    }

    if ( !$nobuffer ) {
        // print buffer and clean
        echo ob_get_clean();
    }

    if ( $destroy && file_exists($path) ) {
        unlink($path);
    }
}



/**
 * [ SYSTEM USE ONLY ]
 */
function coresys_load_Class($classname)
{
    if (cache_classes_IsLoaded($classname) )
    {
        RETURN; // do nothing if class is already cached
    }

    $csegments = explode('\\', $classname); // class name segments
    $conclusion = '';                       // resulting include path

    $appLoadable = strpos($classname,'\\')!==FALSE && count($csegments)>1;

    /**
     * What kind of class is this?
     */
    $is_system = $appLoadable && $csegments[0]==='POPS';
    $is_module = $appLoadable && strtoupper($csegments[0])===strtoupper(POPS_APP_MODULES_DIRNAME);
    $is_template = $appLoadable && strtoupper($csegments[0])===strtoupper(POPS_APP_TEMPLATES_DIRNAME);
    $is_page = $appLoadable && strtouper($csegments[0])===strotupper(POPS_APP_PAGES_DIRNAME);


    for ( $x=($is_system||$is_module||$is_template||$is_page)?1:0; $x<count($csegments)-1; $x++,next($csegments) )
    {
        if (intval(key($csegments))!=$x ) {
            $x--;
            continue;
        }
        $conclusion .= current($csegments).'/';
    }

    $conclusion .= $csegments[count($csegments)-1];

    /**
     * Class loading proper
     */
    if ( $is_system ) {
        /**
         * System class?
         */
        $bpath = POPS_SYSTEM_PATH . 'library/' . $conclusion.'.php';
    }
    else if ( $is_module ) {
        /**
         * Module class?
         */
        $bpath = POPS_APP_MODULES_PATH . $conclusion.'.php';
    }
    else if ( $is_template ) {
        /**
         * Template class?
         */
        $bpath = POPS_APP_TEMPLATES_PATH . $conclusion.'.php';
    }
    else if ( $is_page ) {
        /**
         * PageController class?
         */
        $bpath = POPS_APP_PAGES_PATH . $conclusion . '.php';
    }
    else {
        /**
         * otherwise, this is an "addon" class
         */
        $allowed_exts = array( 'php', 'addon.php', 'class.php' ); // allowed addon file extensions
        $addonpath = POPS_ADDON_PATH . $conclusion;
        foreach ( $allowed_exts as $ext )
        {
            $bpath = $addonpath . '.' . $ext;
            if ( file_exists($bpath) ) {
                core_load_PHP($bpath, TRUE);
                cache_classes_Add($classname, $bpath);
                RETURN;
            }
        }
        RETURN;
    }


    core_load_PHP($bpath, TRUE);
    cache_classes_Add($classname, $bpath);
    RETURN;
}

?>