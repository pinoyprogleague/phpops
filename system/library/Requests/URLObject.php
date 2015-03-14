<?php

namespace POPS\Requests;

/**
 * Class for URL string encapsulations
 */
class URLObject {

    const REQUEST_NAME = 1;
    const REQUEST_VALUE = 2;
    const URL_PROTOCOL = 1;
    const URL_BASEURL = 2;
    const URL_PATH = 3;
    const URL_REQUESTS = 4;

    private static $REGEXP = '/(^([A-Za-z]{3,}(:\/\/)))[A-Za-z0-9.\/]{5,}([A-Za-z0-9_\-\/]){0,}((\?)[A-Za-z0-9=\-_&.%]{0,})(#){0,}/';

    private $urlstring;
    private $requests;


    /**
     * Initiaize an instance of <code>UrlString</code>
     * <br>
     * Note: Trailing spaces from both ends will be trimmed
     *
     * @param string $string URL string which should include protocol
     *      (e.g. http://, ftp://, etc.)
     * @param boolean $encodeurl {false} If URL will be url-encoded or not
     *
     * @throws InvalidUrlException If URL provided is an invalid URL
     */
    public function __construct($string, $encodeurl=false)
    {
//        $filter_match = \POPS\Utils\STRING::Filter(trim($string), self::$REGEXP);
        if ( parse_url($string)===FALSE )
        {
            throw new \POPS\Exceptions\InvalidUrlException($string);
        }
        $this->urlstring = $encodeurl ? urlencode($string) : $string;
        $this->requests = $this->getUrlInfo(self::URL_REQUESTS);
    }


    //--------------------------------------------------------------------------
    //      Methods
    //--------------------------------------------------------------------------

    /**
     * Add a request to current URL
     *
     * @param string $request request name
     * @param string $value {null} value for this request
     * @param mixed $enqueue {false} This will satisfy the following values:
     * <ol type="1">
     * <li><code>true</code> will insert the request at first position</li>
     * <li><code>false</code> will insert the request at the last position</li>
     * <li>any <code>int</code> index value will insert the request at the
     *      specified index value</li>
     * </ol>
     *
     * @return \POPS\Utils\Objects\URLObject The resulting <code>URLObject</code> instance
     */
    public function addRequest($request, $value=null, $enqueue=false)
    {
        $reqs = $this->getRequests();
        $key = urlencode($request);
        $value = !is_null($value) ? urlencode($value):NULL;

        for ( $x=0,reset($reqs); $x<count($reqs); $x++,next($reqs) )
        {
            if ( strtolower($key)===strtolower(key($reqs)) ) {
                $key = key($reqs);
                break;
            }
        }

        \POPS\Utils\ARRAYS::InsertAssociative($key, $value, $this->requests
                , (is_integer($enqueue) ? $enqueue : ($enqueue?0:NULL)));
        return $this;
    }

    /**
     * Serialize the array of requests in this instance into a string<br>
     *
     * @param booliean $include_qmark {false} If question mark should be included
     *      from the resulting serialized requests
     * @return type
     */
    public function getSerializedRequests($include_qmark=false)
    {
        $ret = '';
        $requests = $this->getRequests();
        if ( !\POPS\Utils\ARRAYS::__IsEmpty($requests) )
        {
            $ret = \POPS\Utils\ARRAYS::ImplodeAssoc($requests, '=', '&');
        }
        return ($include_qmark ? '?':'').$ret;
    }

    /**
     * Get URL sliced infos within the provided string<br>
     * <b>Note: </b>Any changes you added in <code>requests</code> field
     *      will not reflect here
     *
     * @param int $info_type {null} Constant values which are:<br>
     * <ul>
     * <li>URLObject::URL_PROTOCOL = 1</li>
     * <li>URLObject::URL_BASEURL = 2</li>
     * <li>URLObject::URL_PATH = 3</li>
     * <li>URLObject::URL_REQUESTS = 4</li>
     * </ul>
     * <br>
     * @return mixed If <code>$info_type</code> parameter is not specified,
     *      then <b>all possible infos</b> from the URL will be returned in
     *      an associative array form, otherwise, the <b>specific requested
     *      info</b> will be returned.
     */
    public function getUrlInfo($info_type=null)
    {
        $url = $this->urlstring;
        $ret = array();
        $pos = null;
        $posfslash = null;

        switch ($info_type)
        {
            case null : { /* do nothing */ }
            case self::URL_PROTOCOL :
            {
                $ret_ext = null;
                $pos = strpos($url, '://');
                if ( $pos!==FALSE ) {
                    $ret_ext = substr($url, 0, ($pos));
                }
                if ( $info_type!==NULL ) {
                    return $ret_ext;
                } else {
                    $ret[self::URL_PROTOCOL] = $ret_ext;
                }
            }
            case self::URL_BASEURL :
            {
                $ret_ext = NULL;
                if ( $pos===NULL ) {
                    $pos = strpos($url, '://');
                }

                $posfslash = \POPS\Utils\STRING::FindNthPosition($url, 3, '/');
                $length = $posfslash!==FALSE ?
                        $posfslash - $pos - 3
                      : strlen($url) - $pos
                ;
                $ret_ext = substr($url, $pos+3, $length);
                if ( $info_type!==NULL ) {
                    return $ret_ext;
                } else {
                    $ret[self::URL_BASEURL] = $ret_ext;
                }
            }
            case self::URL_PATH :
            {
                $ret_ext = NULL;
                if ( $posfslash===NULL ) {
                    $posfslash = \POPS\Utils\STRING::FindNthPosition($url, 3, '/');
                }

                if ( $posfslash!==FALSE )
                {
                    $startpoint = $posfslash + 1;
                    $pos_qmark = strpos($url, '?');
                    $length = $pos_qmark!==FALSE ?
                            $pos_qmark - $startpoint : (
                                strrpos($url, '/')===$posfslash ?
                                strlen($url)-$startpoint : strrpos($url, '/')
                            )
                    ;
                    $ret_ext = substr($url, $startpoint, $length);
                }
                if ( $info_type!==null ) {
                    return $ret_ext;
                }
                else {
                    $ret[self::URL_PATH] = $ret_ext;
                }
            }
            case self::URL_REQUESTS :
            {
                $ret_ext = array();
                $pos_qmark = \POPS\Utils\STRING::FindNthPosition($url, 1, '?');

                if ( $pos_qmark!==FALSE && $pos_qmark!==(strlen($url)-1) )
                {
                    $startpoint = $pos_qmark+1;
                    $length = strlen($url)-$startpoint;
                    $explode = explode('&', substr($url, $startpoint));
                    foreach ( $explode as $request ) {
                        $part = explode('=', $request);
                        $ret_ext[$part[0]] = count($part) > 1 ? $part[1] : NULL;
                    }
                }
                if ( $info_type!==null ) {
                    return $ret_ext;
                }
                else {
                    $ret[self::URL_REQUESTS] = $ret_ext;
                }
            }
            default :
            {
                break;
            }
        }
        // return $ret
        return $ret;
    }



    /**
     * Get URL string of this object
     *
     * @return type
     */
    public function getUrl()
    {
        return $this->__toString();
    }



    /**
     * Get the URI part by nth position (e.g. path/to/directory at 1 will return 'path' )
     *
     * @param int $nth Nth position in URI component of this URL
     * @return mixed The URI part (string), otherwise, FALSE if not found
     */
    public function getUriAt($nth)
    {
        $path = explode('/', rtrim(ltrim($this->getUrlInfo(self::URL_PATH), '/'), '/'));
        if ( $nth > count($path) || $nth <= 0 ) {
            // disallow unbound range
            RETURN FALSE;
        }
        RETURN $path[$nth-1];
    }



    /**
     * Get URL requests array from this instance
     *
     * @return array
     */
    public function getRequests()
    {
        return $this->requests;
    }



    /**
     * Get a request by priority number/position
     *
     * @param int $nth Priority number or position of request
     * @return mixed <code></code> Associative array element if given position
     *      exists:<br>
     *      <code>array(<br>
     *          REQUEST_NAME => 'REQUEST_NAME',<br>
     *          REQUEST_VALUE => 'REQUEST_VALUE'<br>
     *      )</code><br>
     *      otherwise, returns <code>NULL</code>
     */
    public function getRequestAt($nth)
    {
        $ret = null;
        $requests = $this->getRequests();
        for ( $x=0,reset($requests); $x<count($requests); $x++,next($requests) )
        {
            if ( $x+1==$nth ) {
                $ret = array(
                    self::REQUEST_NAME => key($requests),
                    self::REQUEST_VALUE => current($requests)
                );
                break;
            }
        }
        return $ret;
    }



    /**
     * If this URL instance has URL requests in it
     *
     * @return boolean
     */
    public function __HasRequests()
    {
        $requests = $this->getUrlInfo(self::URL_REQUESTS);
        return !\POPS\Utils\ARRAYS::__IsEmpty($requests);
    }

    /**
     * Get the string value of this URL instance
     *
     * @return type
     */
    public function __toString() {
        $info = $this->getUrlInfo();
        $ret = $info[self::URL_PROTOCOL].'://'
               . $info[self::URL_BASEURL].($info[self::URL_PATH]!==null||count($info[self::URL_REQUESTS])>0 ? '/':'')
               . $info[self::URL_PATH];
        if ( !\POPS\Utils\ARRAYS::__IsEmpty($this->requests) )
        {
            $ret .= $this->getSerializedRequests(true);
        }
        $this->urlstring = $ret;
        return $this->urlstring;
    }



    //--------------------------------------------------------------------------
    //      Static Methods
    //--------------------------------------------------------------------------

    /**
     * Create an instance of <code>UrlString</code> from the current page URL<br>
     * <b>Note:</b> This needs <code>\POPS\Utils\URL</code> to be included
     *
     * @return \POPS\Utils\Objects\URLObject The derived <code>UrlString</code> instance
     */
    public static function CreateFromCurrentURL()
    {
        $url = new URLObject(\POPS\Utils\URL::GetUrl());
        return $url;
    }


    /**
     * Create an instance of <code>UrlString</code> from a string
     *
     * @param string $urlstring the URL string
     *
     * @return \POPS\Utils\Objects\URLObject The derived <code>UrlString</code> instance
     */
    public static function CreateFromString($urlstring)
    {
        $url = new URLObject($urlstring);
        return $url;
    }

}


namespace POPS\Exceptions;
/**
 * Exception thrown when an invalid URL format string occured
 */
class InvalidUrlException extends \Exception
{
    public function __construct($url) {
        parent::__construct('Provided URL "'.$url.'" is an invalid URL', 0);
    }
}