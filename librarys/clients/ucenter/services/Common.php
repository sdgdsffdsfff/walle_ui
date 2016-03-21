<?php
/**
 * Common Client class file
 *
 * App Confidential
 * Copyright (c) 2011, Playcrab Corp. <support@playcrab.com>.
 * All rights reserved.
 *
 * PHP version 5
 *
 * @category System
 * @package  ucenter
 * @author   Alex Zhou<zhouruhong@playcrab.com>
 * @license  http://www.playcrab.com/license  Playcrab Software Distribution
 * @link     http://www.playcrab.com
 */
namespace clients\ucenter\services;
use clients\ucenter\lib\Base;
use clients\ucenter\lib\Exception;


/**
 * Class Common
 * 默认使用SESSION缓存, 需开启SESSION
 * @package clients\ucenter\services
 */
class Common extends Base
{
    const URL_PATH = 'common/rpc';

    /**
     * 获取登录地址
     * @param string $callback
     * @param bool $useCache 默认使用缓存 false 禁止使用缓存
     * @return mixed
     * @throws Exception
     */
    public static function loginUrl($callback, $useCache = true)
    {
        $common = new self();
        $params = array();
        $params['callback'] = $callback;

        if ($useCache) {
            $loginUrlCache = @$_SESSION['UCENTER:loginUrl'];

            if (!empty($loginUrlCache) && isset($loginUrlCache)) {
                return $loginUrlCache;
            }

            $loginUrl = $common->getClient()->postByCurl(__FUNCTION__, $params, self::URL_PATH);
            $_SESSION['UCENTER:loginUrl'] = $loginUrl;
            return $loginUrl;
        }

        return $common->getClient()->postByCurl(__FUNCTION__, $params, self::URL_PATH);
    }

    /**
     * 获取登出地址
     * @param string $callback
     * @param bool $useCache 默认使用缓存, false 禁止使用缓存
     * @return mixed
     * @throws Exception
     */
    public static function logoutUrl($callback = '', $useCache = true)
    {
        $common = new self();
        $params = array();

        if ($callback) {
            $params['callback'] = $callback;
        }

        if ($useCache) {
            $logoutUrlCache = @$_SESSION['UCENTER:logoutUrl'];

            if (!empty($logoutUrlCache) && isset($logoutUrlCache)) {
                return $logoutUrlCache;
            }

            $logoutUrl = $common->getClient()->postByCurl(__FUNCTION__, $params, self::URL_PATH);
            $_SESSION['UCENTER:logoutUrl'] = $logoutUrl;
            return $logoutUrl;
        }

        return $common->getClient()->postByCurl(__FUNCTION__, $params, self::URL_PATH);
    }


    /**
     * 检验token
     * @param string $token
     * @param bool $useCache 默认使用缓存, false 禁止使用缓存
     * @return mixed
     * @throws Exception
     */
    public static function checkToken($token, $useCache = true)
    {
        $common = new self();
        $params = array('token' => $token);

        if ($useCache) {
            $checkTokenCache = @$_SESSION['UCENTER:checkToken'];

            if (!empty($checkTokenCache) && isset($checkTokenCache)) {
                return $checkTokenCache;
            }

            $checkToken = $common->getClient()->postByCurl(__FUNCTION__, $params, self::URL_PATH);
            $_SESSION['UCENTER:checkToken'] = $checkToken;
            return $checkToken;
        }

        return $common->getClient()->postByCurl(__FUNCTION__, $params, self::URL_PATH);
    }

}
