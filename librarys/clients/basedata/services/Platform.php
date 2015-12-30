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
 * @package  basedata
 * @author   Alex Zhou<zhouruhong@playcrab.com>
 * @license  http://www.playcrab.com/license  Playcrab Software Distribution
 * @link     http://www.playcrab.com
 */
/**
 * Platform class
 *
 * @category System
 * @package  basedata
 * @author   Alex Zhou<zhouruhong@playcrab.com>
 * @license  http://www.playcrab.com/license  Playcrab Software Distribution
 * @link     http://www.playcrab.com
 */
namespace clients\basedata\services;

use clients\basedata\lib\Base;

class Platform extends Base
{
    const SORT_ID_ASC = 0;
    const SORT_ID_DESC = 1;

    const FIELD_ID = 'id';
    const FIELD_MAIN_CATEGORY_ID = 'main_category_id';
    const FIELD_NAME = 'name';
    const FIELD_PREFIX = 'prefix';
    const FIELD_API_URL = 'api_url';
    const FIELD_ASSETS_ID = 'assets_id';
    const FIELD_IS_DEL = 'is_del';
    const FIELD_STATUS = 'status';
    const FIELD_IS_REBOT = 'is_rebot';
    const FIELD_OPEN_DATETIME = 'open_datetime';
    const FIELD_CLOSE_DATETIME = 'close_datetime';
    const FIELD_FRONT_DOMAIN_NAME = 'front_domain_name';
    const FIELD_ADMIN_DOMAIN_NAME = 'admin_domain_name';
    const FIELD_PAY_API = 'pay_api';


    /**
     * 根据多个游戏平台ID,获取平台数据集合
     *
     * @param array $ids    ids
     * @param array $fields 字段名称
     *
     * @return array
     * @throws Exception
     */
    public static function getByIds(array $ids, array $fields = array())
    {
        $platform = new self();
        $params = array('ids'=> $ids, 'fields'=>$fields);
        return $platform->getClient()->postByCurl('getPlatformsByIds', $params);
    }


    /**
     * 搜索游戏平台数据集合
     *
     * @param array $conditions 条件数组
     * @param int   $pageNum    页码
     * @param int   $pageSize   分页长度
     * @param int   $sort       排序
     * @param array $fields     字段名称
     *
     * @return array
     * @throws Exception
     */
    public static function search(array $conditions = array(), $pageNum = 1,  $pageSize = 20, $sort = self::SORT_ID_ASC, array $fields = array())
    {
        $platform = new self();
        $options = array(
            'page_num' => $pageNum,
            'page_size' => $pageSize,
            'sort' => $sort,
            'fields' => $fields
        );
        $params = array_merge($conditions, $options);
        return $platform->getClient()->postByCurl('getPlatforms', $params);
    }


    /**
     * 根据游戏类目Id,获取平台名称集合
     *
     * @param number $mainCategoryId 游戏类目Id
     *
     * @return array
     */
    public static function getNamesByMainCategoryId($mainCategoryId)
    {
        $platform = new self();
        return $platform->search(array(self::FIELD_MAIN_CATEGORY_ID => $mainCategoryId), 1, 1000,
            self::SORT_ID_ASC, array(self::FIELD_ID, self::FIELD_NAME));
    }

    /**
     * 根据平台ID获取平台名称
     *
     * @param number $id  游戏平台Id
     *
     * @return string
     */
    public static function getNamesById($id)
    {
        $data = self::getByIds(array($id), array(self::FIELD_NAME));
        if ($data) {
            $data = array_shift($data);
        }
        return isset($data[self::FIELD_NAME]) ? $data[self::FIELD_NAME] : '';
    }
}