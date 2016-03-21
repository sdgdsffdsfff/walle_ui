<?php
/**
 * Project Client class file
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
 * Class Project
 * @package clients\ucenter\services
 */
class Project extends Base
{
    const URL_PATH = 'project/rpc';

    /**
     * 获取项目中所有授权用户信息
     *
     * @param bool $useCache 默认使用缓存, false 禁止使用缓存
     * @return array
     * @throws Exception
     */
    public static function getUsers($useCache = true)
    {
        $project = new self();
        $params = array();

        if ($useCache) {
            $getUsersCache = @$_SESSION['UCENTER:getUsers'];

            if (!empty($getUsersCache) && isset($getUsersCache)) {
                return $getUsersCache;
            }

            $getUsers = $project->getClient()->postByCurl(__FUNCTION__, $params, self::URL_PATH);
            $_SESSION['UCENTER:getUsers'] = $getUsers;
            return $getUsers;
        }
        return $project->getClient()->postByCurl(__FUNCTION__, $params, self::URL_PATH);
    }

    /**
     * 获取项目所有授权角色信息
     *
     * @param bool $useCache 默认使用缓存, false 禁止使用缓存
     * @return array
     * @throws Exception
     */
    public static function getRoles($useCache = true)
    {
        $project = new self();
        $params = array();

        if ($useCache) {
            $getRolesCache = @$_SESSION['UCENTER:getRoles'];

            if (!empty($getRolesCache) && isset($getRolesCache)) {
                return $getRolesCache;
            }

            $getRoles = $project->getClient()->postByCurl(__FUNCTION__, $params, self::URL_PATH);
            $_SESSION['UCENTER:getUsers'] = $getRoles;
            return $getRoles;
        }

        return $project->getClient()->postByCurl(__FUNCTION__, $params, self::URL_PATH);
    }


    /**
     * 获取项目所有功能角色信息
     *
     * @param bool $useCache 默认使用缓存, false 禁止使用缓存
     * @return array
     * @throws Exception
     */
    public static function getFunctions($useCache = true)
    {
        $project = new self();
        $params = array();

        if ($useCache) {
            $getFunctionsCache = @$_SESSION['UCENTER:getFunctions'];

            if (!empty($getFunctionsCache) && isset($getFunctionsCache)) {
                return $getFunctionsCache;
            }

            $getFunctions = $project->getClient()->postByCurl(__FUNCTION__, $params, self::URL_PATH);
            $_SESSION['UCENTER:getUsers'] = $getFunctions;
            return $getFunctions;
        }

        return $project->getClient()->postByCurl(__FUNCTION__, $params, self::URL_PATH);
    }

    /**
     * 获取项目所有管理员信息
     *
     * @param bool $useCache 默认使用缓存, false 禁止使用缓存
     * @return array
     * @throws Exception
     */
    public static function getAdmins($useCache = true)
    {
        $project = new self();
        $params = array();

        if ($useCache) {
            $getAdminsCache = @$_SESSION['UCENTER:getAdmins'];

            if (!empty($getAdminsCache) && isset($getAdminsCache)) {
                return $getAdminsCache;
            }

            $getAdmins = $project->getClient()->postByCurl(__FUNCTION__, $params, self::URL_PATH);
            $_SESSION['UCENTER:getUsers'] = $getAdmins;
            return $getAdmins;
        }
        return $project->getClient()->postByCurl(__FUNCTION__, $params, self::URL_PATH);
    }
}