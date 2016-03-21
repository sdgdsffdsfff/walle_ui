<?php
/**
 * Platform Client class file
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
 * Class Platform
 * @package clients\ucenter\services
 */
class Platform extends Base
{
    const URL_PATH = 'platform/rpc';

    /**
     * 根据平台Id,获取平台信息
     *
     * @param number $id id
     *
     * @return array
     * @throws Exception
     */
    public static function getPlatformById($id)
    {
        $platform = new self();
        $params = ['id' => $id];
        return $platform->getClient()->postByCurl(__FUNCTION__, $params, self::URL_PATH);
    }
}