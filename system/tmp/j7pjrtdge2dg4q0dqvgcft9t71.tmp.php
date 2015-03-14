<?php


/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Person
 *
 * 
 */
class Person {

    public $name;

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        RETURN $this->name;
    }

}
?>

<?php


/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Animal
 *
 * 
 */
class Animal {

    public $type;

    public function __construct($type)
    {
        $this->type = $type;
    }

    public function getType()
    {
        RETURN $this->type;
    }

}
?>

<?php


/*
 * Proudly made with Netbeans 8.0.1
 * This file is created under the TLC, Inc. and FAITH joint research project\
 *
 * Project team in-charge: [ MARCOM Cloud ]
 * Programmer: [ Allen Linatoc ]
 * API Documentation: [ Allen Linatoc ]
 */

namespace POPS\Request;

/**
 * Class for URL string encapsulations
 *
 * 
 * @property-write string $urlstring
 */
class URLObject {

    const REQUEST_NAME = 1;
    const REQUEST_VALUE = 2;
    const URL_PROTOCOL = 1;
    const URL_BASEURL = 2;
    const URL_PATH = 3;
    const URL_REQUESTS = 4;

    private static $REGEXP = '/(^([A-Za-z]{3,}(:\/\/)))[A-Za-z0-9.\/]{5,}([A-Za-z0-9\/]){0,}((\?)[A-Za-z0-9=\-_&.%]{0,})*(#){0,}/';

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
        $filter_match = \allen\STRING::Filter(trim($string), self::$REGEXP);
        if ( $filter_match!==$string )
        {
            throw new \allen\Exceptions\InvalidUrlException($string);
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
     * @return \allen\Objects\URLObject The resulting <code>URLObject</code> instance
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

        \allen\ARRAYS::InsertAssociative($key, $value, $this->requests
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
        if ( !\allen\ARRAYS::__IsEmpty($requests) )
        {
            $ret = \allen\ARRAYS::ImplodeAssoc($requests, '=', '&');
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
                $ret_ext = null;
                $posfslash = \allen\STRING::FindNthPosition($url, 3, '/');
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
                $ret_ext = null;
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
                $pos_qmark = \allen\STRING::FindNthPosition($url, 1, '?');

                if ( $pos_qmark!==FALSE && $pos_qmark!==(strlen($url)-1) )
                {
                    $startpoint = $pos_qmark+1;
                    $length = strlen($url)-$startpoint;
                    $explode = explode('&', substr($url, $startpoint, $length));
                    foreach($explode as $req)
                    {
                        $a_req = explode('=', $req);
                        if ( count($a_req) > 0 )
                        {
                            $ret_ext[$a_req[0]] = ( count($a_req)>=2 ? $a_req[1] : null );
                        }
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

    public function getUrl()
    {
        return $this->__toString();
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
        return !\allen\ARRAYS::__IsEmpty($requests);
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
        if ( !\allen\ARRAYS::__IsEmpty($this->requests) )
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
     * <b>Note:</b> This needs <code>\allen\URL</code> to be included
     *
     * @return \allen\Objects\URLObject The derived <code>UrlString</code> instance
     */
    public static function CreateFromCurrentURL()
    {
        $url = new URLObject(\allen\URL::GetUrl());
        return $url;
    }


    /**
     * Create an instance of <code>UrlString</code> from a string
     *
     * @param string $urlstring the URL string
     *
     * @return \allen\Objects\URLObject The derived <code>UrlString</code> instance
     */
    public static function CreateFromString($urlstring)
    {
        $url = new URLObject($urlstring);
        return $url;
    }

}


namespace allen\Exceptions;
/**
 * Exception thrown when an invalid URL format string occured
 */
class InvalidUrlException extends \Exception
{
    public function __construct($url) {
        parent::__construct('Provided URL "'.$url.'" is an invalid URL', 0);
    }
}?>

