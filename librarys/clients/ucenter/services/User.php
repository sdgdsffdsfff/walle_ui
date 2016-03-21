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
class User extends Base
{
    const URL_PATH = 'user/rpc';

    /**
     * 根据用户Id,获取用户信息
     * @param $id
     * @param bool $useCache 默认使用缓存, false 禁止使用缓存
     * @return mixed
     * @throws Exception
     */
    public static function getUserById($id, $useCache = true)
    {
        $user = new self();
        $params = array('id' => $id);

        if ($useCache) {
            $userByIdCache = @$_SESSION['UCENTER:userById'];

            if (!empty($userByIdCache) && isset($userByIdCache)) {
                return $userByIdCache;
            }

            $userById = $user->getClient()->postByCurl(__FUNCTION__, $params, self::URL_PATH);
            $_SESSION['UCENTER:userById'] = $userById;
            return $userById;
        }
        return $user->getClient()->postByCurl(__FUNCTION__, $params, self::URL_PATH);
    }

    /**
     * 根据用户ID,获取用户的角色信息
     *
     * @param int  $id               用户ID
     * @param int  $gameId           游戏ID
     * @param int  $platformId       平台ID
     * @param bool $includeFunctions 是否加载功能列表
     * @param bool $useCache 默认使用缓存, false 禁止使用缓存
     *
     * @return mixed
     * @throws Exception
     */

    public static function getRoles($id, $gameId, $platformId, $includeFunctions = true, $useCache = true)
    {
        $user = new self();
        $params = array(
            'id' => $id,
            'game_id' => $gameId,
            'platform_id' => $platformId,
            'include_functions' => $includeFunctions
        );

        if ($useCache) {
            $rolesCache = @$_SESSION['UCENTER:roles'];

            if (!empty($rolesCache) && isset($rolesCache)) {
                return $rolesCache;
            }
            $roles = $user->getClient()->postByCurl(__FUNCTION__, $params, self::URL_PATH);
            $_SESSION['UCENTER:roles'] = $rolesById;
            return $roles;
        }

        return $user->getClient()->postByCurl(__FUNCTION__, $params, self::URL_PATH);
    }

    /**
     * 根据用户Id,获取所有的用户角色信息
     *
     * @param int $id 用户id
     * @param bool $useCache 默认使用缓存, false 禁止使用缓存
     *
     * @return mixed
     * @throws Exception
     */
    public static function getRolesById($id, $useCache = true)
    {
        $user = new self();
        $params = array(
            'id' => $id
        );

        if ($useCache) {
            $rolesByIdCache = @$_SESSION['UCENTER:rolesById'];

            if (!empty($rolesByIdCache) && isset($rolesByIdCache)) {
                return $rolesByIdCache;
            }
            $rolesById = $user->getClient()->postByCurl(__FUNCTION__, $params, self::URL_PATH);
            $_SESSION['UCENTER:rolesById'] = $rolesById;
            return $rolesById;
        }
        
        return $user->getClient()->postByCurl(__FUNCTION__, $params, self::URL_PATH);
    }


    /**
     * 根据用户Id,获取用户的可访问功能路径列表
     * @param int $id 用户Id
     * @param null $gameId
     * @param null $platformId
     * @param bool $useCache 默认使用缓存, false 禁止使用缓存
     * @return array
     * @throws Exception
     */
    public static function getFunctionPaths($id, $gameId = null, $platformId = null, $useCache = true)
    {
        $user = new self();
        $params = array('id' => $id);
        if (null !== $gameId) {
            $params['game_id'] = $gameId;
        }

        if (null !== $platformId) {
            $params['platform_id'] = $platformId;
        }

        if ($useCache){
            $functionsPathsCache = @$_SESSION['UCENTER:functionsPaths'];

            if (!empty($functionsPathsCache) && isset($functionsPathsCache)) {
                return $functionsPathsCache;
            }
            $functionsPaths = $user->getClient()->postByCurl(__FUNCTION__, $params, self::URL_PATH);;
            $_SESSION['UCENTER:functionsPaths'] = $functionsPaths;
            return $functionsPaths;
        }

        return $user->getClient()->postByCurl(__FUNCTION__, $params, self::URL_PATH);
    }
}