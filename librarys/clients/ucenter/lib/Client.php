<?php
/**
 * Client class file
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
 * Client
 *
 * @category System
 * @package  ucenter
 * @author   Alex Zhou<zhouruhong@playcrab.com>
 * @license  http://api.ucenter.playcrab.com/license  Playcrab Software Distribution
 * @link     http://api.ucenter.playcrab.com/docs/index.html
 */
class Client extends HttpClient
{
    CONST HEADER_CONTENT_TYPE = 'Content-Type';
    CONST HEADER_AUTHORIZATION  = 'Authorization';
    CONST HEADER_AUTHORIZATION_PREFIX = 'PLAYCRAB';
    CONST HEADER_DATE = 'Date';

    private $_config;
    private $_params =  array();
    private $_headers = array();

    private $_api_url = null;
    private $_currentMethod;
    private $_path;
    protected static $log;
    static $logType = 'sdk_client';



    /**
     * 获取配置
     *
     * @return mixed
     */
    public function getConfig()
    {
        if (!$this->_config) {
            $this->_config = Func::convertArrayToObject(Config::get());
        }
        return $this->_config;
    }

    /**
     * 构造函数
     *
     * @throws exception
     */
    public function __construct()
    {
        parent::__construct();
        $this->getConfig();
        if (!$this->getApiUrl() || empty($this->_config->api_key) || empty($this->_config->api_secret_key)) {
            throw new \exception('Invalid API URL or API key or Secret key, please check config.inc.php');
        }
    }


    /**
     * POST wrapper，基于curl函数，需要支持curl函数才行
     *
     * @return mixed
     * @throws Exception
     */
    public function postByCurl()
    {
        $args = func_get_args();
        $this->_currentMethod    = trim($args[0]);
        $this->_params = $args[1];
        $this->_path = $args[2];
        $this->_generateRequestParams()->_generateHeaders();

        unset($args);
        $response = $this->post(
            $this->getApiUrl(),
            $this->_path,
            $this->_params,
            $this->_headers
        );

        if ($response === false) {
            $errMsg = curl_error($this->ch);
            throw new Exception($errMsg, -1);
        }

        if ($this->http_code != 200) {
            $msg = sprintf("url: %s, \$method:%s, \$params: %s, status: %s", $this->getApiUrl(), $this->_currentMethod,
                json_encode($this->_params), $this->http_code);
            Base::log($msg, Logger::LEVEL_WARING, self::$logType);
            $response = null;
        }

        return $this->parseResponse($response);
    }

    /**
     * Generate signature for sig parameter
     *
     * @return Client
     */
    private function _generateHeaders()
    {
        $date = date(\DateTime::ATOM, time());
        $authorization = sprintf(
            "%s %s:%s",
            self::HEADER_AUTHORIZATION_PREFIX,
            $this->_config->api_key,
            md5(Func::convertArrayToStr($this->_params) . $this->_config->api_secret_key. $date)
        );

        $this->_headers[] = sprintf("%s:%s", self::HEADER_CONTENT_TYPE, 'application/json');
        $this->_headers[] = sprintf("%s:%s", self::HEADER_DATE, $date);
        $this->_headers[] = sprintf("%s:%s", self::HEADER_AUTHORIZATION, $authorization);

        return $this;
    }

    /**
     * Generate request if for parameter
     *
     * @return void
     */
    private function _generateRequestParams()
    {
        $params = $this->_params;
        $requestParams = array(
            'id' => uniqid($this->_config->api_key),
            'method'=> $this->_currentMethod,
            'params' => $params,
            'jsonrpc' => '2.0'
        );
        $this->_params = $requestParams;
        return $this;
    }

    /**
     * 获取Sdk对应的API服务器URL地址
     *
     * @return string
     */
    public function getApiUrl()
    {
        if ($this->_api_url === null) {
            $this->_api_url = rtrim($this->_config->api_url, '/');
        }
        return $this->_api_url;
    }


    /**
     * Setting api url
     *
     * @param string $url url
     *
     * @return $this
     */
    public function setApiUrl($url)
    {
        $this->_config->api_url = $url;
        return $this;
    }
}
