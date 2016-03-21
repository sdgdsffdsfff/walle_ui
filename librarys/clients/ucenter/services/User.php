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
 * @package clients\ucenter\services
 */
class User extends Base
{
    const URL_PATH = 'user/rpc';

    /**
     * 根据用户Id,获取用户信息
     *
     * @param number $id 用户Id
     *
     * @return array
     * @throws Exception
     */
    public static function getUserById($id)
    {
        $user = new self();
        $params = array('id' => $id);
        return $user->getClient()->postByCurl(__FUNCTION__, $params, self::URL_PATH);
    }

    /**
     * 根据多重条件,获取用户的角色信息
     *
     * @param int  $id               用户ID
     * @param int  $gameId           游戏ID
     * @param int  $platformId       平台ID
     * @param bool $includeFunctions 是否加载功能列表
     *
     * @return mixed
     * @throws Exception
     */
    public static function getRoles($id, $gameId, $platformId, $includeFunctions = true)
    {
        $user = new self();
        $params = array(
            'id' => $id,
            'game_id' => $gameId,
            'platform_id' => $platformId,
            'include_functions' => $includeFunctions
        );
        return $user->getClient()->postByCurl(__FUNCTION__, $params, self::URL_PATH);
    }


    /**
     * 根据用户Id,获取所有的用户角色信息
     *
     * @param int $id 用户id
     *
     * @return mixed
     * @throws Exception
     */
    public static function getRolesById($id)
    {
        $user = new self();
        $params = array(
            'id' => (int)$id
        );
        return $user->getClient()->postByCurl(__FUNCTION__, $params, self::URL_PATH);
    }

    /**
     * 根据用户Id,获取用户的可访问功能路径列表
     *
     * @param int $id         用户Id
     * @param int $gameId     游戏Id
     * @param int $platformId 平台ID
     *
     * @return array
     */
    public static function getFunctionPaths($id, $gameId = null, $platformId = null)
    {
        $user = new self();
        $params = array('id' => $id);
        if (null !== $gameId) {
            $params['game_id'] = $gameId;
        }

        if (null !== $platformId) {
            $params['platform_id'] = $platformId;
        }

        return $user->getClient()->postByCurl(__FUNCTION__, $params, self::URL_PATH);
    }
}