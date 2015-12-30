<?php
/**
 * HttpClient class file
 *
 * Playcrab Confidential
 * Copyright (c) 2011, Playcrab Corp. <support@playcrab.com>.
 * All rights reserved.
 *
 * PHP version 5
 *
 * @category System
 * @package  ucenter
 * @author   zhouruhong <zhouruhong@playcrab.com>
 * @license  http://api.ucenter.playcrab.com/license  Playcrab Software Distribution
 * @link     http://api.ucenter.playcrab.com/docs/index.html
 */
/**
 * HttpClient class file
 * 要求最低的PHP版本是5.2.0，并且还要支持以下库：cURL, Libxml 2.6.0
 * This class for invoke remote RESTful Webservice
 * The requirement of PHP version is 5.2.0 or above, and support as below:
 * cURL, Libxml 2.6.0
 *
 * Playcrab Confidential
 * Copyright (c) 2011, Playcrab Corp. <support@playcrab.com>.
 * All rights reserved.
 *
 * PHP version 5
 *
 * @category System
 * @package  ucenter
 * @author   Alex Zhou<zhouruhong@playcrab.com>
 * @license  http://api.ucenter.playcrab.com/license  PlayCrab Software Distribution
 * @link     http://api.ucenter.playcrab.com/docs/index.html
 */
namespace clients\ucenter\lib;
use clients\ucenter\util\Func;
/**
 * HttpClient
 *
 * @category System
 * @package  ucenter
 * @author   Alex Zhou<zhouruhong@playcrab.com>
 * @license  http://api.ucenter.playcrab.com/license  Playcrab Software Distribution
 * @link     http://api.ucenter.playcrab.com/docs/index.html
*/
class HttpClient
{
    /** cURL Object */
    public $ch;
    /** Contains the last HTTP status code returned. */
    public $http_code;
    /** #Contains the last API call. */
    public $http_url;
    /** #Set up the API root URL. */
    public $api_url;
    /** #Set timeout default. */
    public $timeout = 30;
    /** #Set connect timeout. */
    public $connecttimeout = 30;
    /** #Verify SSL Cert. */
    public $ssl_verifypeer = false;
    /** #Response format. */
    public $format = ''; // Only support json & xml for extension
    public $decodeFormat = 'json'; //default is json
    public $encode       ='utf-8';
    /** #Decode returned json data. */
    //public $decode_json = true;
    /** #Contains the last HTTP headers returned. */
    public $http_info = array();
    public $http_header = array();
    public $postFields = array();
    public $headerFields = array();

    public static $paramsOnUrlMethod = array('GET','DELETE');
    public static $supportExtension  = array('json','xml');
    /** #For tmpFile */
    public $file = null;
    /** #Set the useragnet. */
    public static $userAgent = 'Timescode_RESTClient v0.0.1-alpha';
    /** #Set the jsonRpc version */
    public static $jsonRpcVersion = '2.0';

    /**
     * 构造函数
     */
    public function __construct()
    {
        $this->ch = curl_init();
        /* cURL settings */
        curl_setopt($this->ch, CURLOPT_USERAGENT, self::$userAgent);
        curl_setopt($this->ch, CURLOPT_CONNECTTIMEOUT, $this->connecttimeout);
        curl_setopt($this->ch, CURLOPT_TIMEOUT, $this->timeout);
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->ch, CURLOPT_AUTOREFERER, true);
        curl_setopt($this->ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, $this->ssl_verifypeer);
        curl_setopt($this->ch, CURLOPT_HEADERFUNCTION, array($this, 'getHeader'));
        curl_setopt($this->ch, CURLOPT_HEADER, false);
    }

    /**
     * post 数据
     *
     * @param string $url      target url
     * @param string $urlPath  urlPath
     * @param array  $params   post params
     * @param array  $headers  headers
     *
     * @return mixed
     */
    public function post($url, $urlPath, $params = null, $headers = null)
    {
        $url = rtrim($url, '/');
        $url .= '/' . trim($urlPath);
        if (strrpos($url, 'https://') !== 0 && strrpos($url, 'http://') !== 0 && !empty($this->format)) {
            $url = "{$this->api_url}{$url}.{$this->format}";
        }

        $this->http_url = $url;
        $this->postFields = $params;
        $this->headerFields = $headers;

        is_resource($this->ch) or $this->__construct();
        curl_setopt($this->ch, CURLOPT_POST, true);
        curl_setopt($this->ch, CURLOPT_URL, $this->http_url);

        if ($this->postFields != null) {
            curl_setopt($this->ch, CURLOPT_POSTFIELDS, json_encode($this->postFields));
        }

        if ($this->headerFields != null) {
            curl_setopt($this->ch, CURLOPT_HTTPHEADER, $this->headerFields);
        }

        $response = curl_exec($this->ch);

        $this->http_code = curl_getinfo($this->ch, CURLINFO_HTTP_CODE);
        $this->http_info = array_merge($this->http_info, curl_getinfo($this->ch));

        $this->close();
        return $response;
    }


    /**
     * Parse response, including json
     *
     * @param string $resp response
     * @return mixed
     * @throws Exception
     */
    public function parseResponse($resp)
    {
        $resp = json_decode($resp, true);

        if (is_array($resp) && isset($resp['error']['code'])) {
            throw new Exception($resp['error']['message'], $resp['error']['code']);
        }

        return $resp['result'];
    }


    /**
     * 对象转数组
     *
     * @param stdClass $obj object
     *
     * @return array
     */
    public static function objectToArray($obj)
    {
        return get_object_vars($obj);
    }

    /**
     * parses the url and rebuilds it to be scheme://host/path
     *
     * @return string
     */
    public function getHttpUrl()
    {
        $parts = parse_url($this->http_url);
        $port = empty($parts['port']) ? 80 : $parts['port'];
        $scheme = empty($parts['scheme']) ? 'http' : $parts['scheme'];
        $host = $parts['host'];
        $path = empty($parts['path']) ? '' : $parts['path'];

        $port or $port = ($scheme == 'https') ? '443' : '80';

        if (($scheme == 'https' && $port != '443') || ($scheme == 'http' && $port != '80')) {

            $host = "$host:$port";
        }
        return "$scheme://$host$path";
    }

    /**
     * Get the header info to store.
     *
     * @param mixed  $ch     curl handle
     * @param string $header header string
     *
     * @return string
     */
    public function getHeader($ch, $header)
    {
        $i = strpos($header, ':');
        if (!empty($i)) {
            $key = str_replace('-', '_', strtolower(substr($header, 0, $i)));
            $value = trim(substr($header, $i + 2));
            $this->http_header[$key] = $value;
        }
        return strlen($header);
    }

    /**
     * Closes the connection and release resources
     *
     * @return void
     */
    public function close()
    {
        curl_close($this->ch);
        if ($this->file != null) {
            fclose($this->file);
        }
    }

}

