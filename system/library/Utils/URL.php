<?php

/*
 * Proudly made with Netbeans 8.0.1
 * This file is created under PHPOps open-source non-profit project
 *
 * Project team in-charge: [ MARCOM Cloud ]
 * Programmer: [ Allen Linatoc ]
 */

namespace POPS\Utils;

/**
 * Class for URL helpers/utilities
 *
 * 
 */
class URL {


    /**
     * Get the Query string used in the URL of current page
     *
     * @param boolean $include_qmark {true} If question mark (?) should be included
     * @return string
     */
    public static function GetQuery($include_qmark=true)
    {
        $ret = ($include_qmark ? '?':'') . $_SERVER['QUERY_STRING'];
        return $ret;
    }


    /**
     * Get the base url (e.g. www.domain.com, localhost)
     *
     * @param boolean $include_protocol {true} If the protocol (e.g. http://, etc.)
     *      should be included
     * @return string
     */
    public static function GetBaseUrl($include_protocol=true)
    {
        return trim(($include_protocol ? $_SERVER['REQUEST'].'://':'').$_SERVER['SERVER_NAME'], '/');
    }


    /**
     * Get the URL of current page
     *
     * @param boolean $include_query {true} If GET queries in URL should be included
     * @param boolean $include_protocol {true} If protocol (http://, etc.) should be included
     * @return string
     */
    public static function GetUrl($include_query=true, $include_protocol=true)
    {
        $ret = ($include_protocol ? $_SERVER['REQUEST_SCHEME'].'://':'')
                . $_SERVER['SERVER_NAME']
                . $_SERVER['REQUEST_URI'];
        if ( !$include_query && strpos($ret, '?')!==FALSE ) {
            $ret = substr($ret, 0, strpos($ret, '?'));
        }
        RETURN $ret;
    }



    /**
     * Get the URL path <b>(e.g. /root/path)</b> of current page
     *
     * @return string
     */
    public static function GetUrlPath()
    {
        return $_SERVER['REQUEST_URI'];
    }



    public static function __IsSafeUrl($url)
    {
        RETURN filter_var($url, FILTER_SANITIZE_URL);
    }

}
