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
     * @return array
     * @throws Exception
     */
    public static function getUsers()
    {
        $project = new self();
        $params = array();
        return $project->getClient()->postByCurl(__FUNCTION__, $params, self::URL_PATH);
    }

    /**
     * 获取项目所有授权角色信息
     *
     * @return array
     * @throws Exception
     */
    public static function getRoles()
    {
        $project = new self();
        $params = array();
        return $project->getClient()->postByCurl(__FUNCTION__, $params, self::URL_PATH);
    }


    /**
     * 获取项目所有功能角色信息
     *
     * @return array
     * @throws Exception
     */
    public static function getFunctions()
    {
        $project = new self();
        $params = array();
        return $project->getClient()->postByCurl(__FUNCTION__, $params, self::URL_PATH);
    }

    /**
     * 获取项目所有管理员信息
     *
     * @return array
     * @throws Exception
     */
    public static function getAdmins()
    {
        $project = new self();
        $params = array();
        return $project->getClient()->postByCurl(__FUNCTION__, $params, self::URL_PATH);
    }
}