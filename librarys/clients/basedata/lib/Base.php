<?php
/**
 * basedata Base class file
 *
 * Playcrab Confidential
 * Copyright (c) 2011, Playcrab Corp. <support@playcrab.com>.
 * All rights reserved.
 *
 * PHP version 5
 *
 * @category System
 * @package  basedata
 * @author   Alex Zhou<zhouruhong@playcrab.com>
 * @license  http://www.playcrab.com/license  Playcrab Software Distribution
 * @link     http://www.playcrab.com
 */
namespace clients\basedata\lib;

$config_file = dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'config.inc.php';
if (!is_file($config_file)) {
    trigger_error('指定SDK配置文件不存在, '. $config_file, E_USER_ERROR);
}
require_once $config_file;
Config::set($config);
/**
 * Base
 *
 * @category System
 * @package  basedata
 * @author   Alex Zhou<zhouruhong@playcrab.com>
 * @license  http://www.playcrab.com/license  Playcrab Software Distribution
 * @link     http://www.playcrab.com
 */
class Base
{
    static $client = null;
    static $log;
    static $logType = 'sdk_base';
    protected $errorCode;
    protected $errorMsg;

    /**
     * 构造函数
     */
    public function __construct()
    {

    }

    /**
     * 获取Client对象
     *
     * @return Client|null
     */
    public function getClient()
    {
        return new Client();
    }

    /**
     * 获取logger对象
     *
     * @return Logger
     */
    public static function getLogger()
    {
        if (!self::$log instanceof Logger) {
            self::$log = new Logger();
        }
        return self::$log;
    }

    /**
     * log 日志
     *
     * @param string $msg      log message
     * @param int    $logLevel log level
     * @param string $logType  log type
     *
     * @return void
     */
    public static function log($msg, $logLevel, $logType='sdk_client')
    {
        self::getLogger()->log($msg, $logLevel, $logType);
    }

}