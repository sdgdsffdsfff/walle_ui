<?php
/**
 * Logger class file
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
/**
 * Logger
 *
 * @category System
 * @package  basedata
 * @author   Alex Zhou<zhouruhong@playcrab.com>
 * @license  http://www.playcrab.com/license  Playcrab Software Distribution
 * @link     http://www.playcrab.com
 */

namespace clients\basedata\lib;

class Logger
{
    const LEVEL_TRACE = 1;
    const LEVEL_INFO = 2;
    const LEVEL_WARING = 3;
    const LEVEL_ERROR = 4;

    protected $logPath = '/tmp/sdk_logs';

    /**
     * 构造函数
     *
     * @param string $logPath log path
     *
     * @return void
     */
    public function __construct($logPath=null)
    {
        if (!empty($logPath)) {
            $this->logPath == $logPath;
        }
        $configLogPath = Config::get('log_path');
        if (!empty($configLogPath)) {
            $this->logPath == $configLogPath;
        }
    }

    /**
     * 设置日志存储路径
     *
     * @param string $logPath log path
     *
     * @return SdkLogger
     */
    public function setLogPath($logPath)
    {
        $logPath = trim($logPath);
        $logPath = rtrim($logPath, '/\\');
        $this->logPath = $logPath;
        return $this;
    }

    /**
     * 获取日志存储路径
     *
     * @return string
     */
    public function getLogPath()
    {
        return $this->logPath;
    }

    /**
     * 记录日志
     *
     * @param string $msg      message
     * @param int    $logLevel log level
     * @param string $logType  log type
     *
     * @return void
     */
    public function log($msg, $logLevel = self::LEVEL_TRACE, $logType='http_client')
    {
        $info = sprintf("%s %s %s %s\n", $logType, $logLevel, date("Y-m-d H:i:s"), $msg . PHP_EOL);
        $filename = $this->getLogPath() . DIRECTORY_SEPARATOR . sprintf("%s_%s.log", $logType, date("Ymd"));
        if ($logLevel > self::LEVEL_TRACE) {
            if (!file_exists($this->getLogPath())) {
                mkdir($this->getLogPath(), 0777, true);
            }
            error_log($info, 3, $filename);
        } else {
            echo $info;
        }
    }
}