<?php
/**
 * MainCategory Client class file
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
 * MainCategory class
 *
 * @category System
 * @package  basedata
 * @author   Alex Zhou<zhouruhong@playcrab.com>
 * @license  http://www.playcrab.com/license  Playcrab Software Distribution
 * @link     http://www.playcrab.com
 */
namespace clients\basedata\services;


use clients\basedata\lib\Base;

class MainCategory extends Base
{
    const TYPE_NORMAL = 0;
    const TYPE_GAME = 1;

    const SORT_ID_ASC = 0;
    const SORT_ID_DESC = 1;

    const FIELD_ID = 'id';
    const FIELD_PREFIX = 'prefix';
    const FIELD_NAME = 'name';
    const FIELD_APP_TYPE = 'app_type';
    const FIELD_TYPE = 'type';
    const FIELD_STATUS = 'status';
    const FIELD_IS_MONITOR = 'is_monitor';
    const FIELD_IS_DEL = 'is_del';


    /**
     * 根据多个游戏应用ID,获取游戏区组数据集合
     *
     * @param array $ids    ids
     * @param array $fields 字段名称
     *
     * @return array
     * @throws Exception
     */
    public static function getByIds(array $ids, array $fields = array())
    {
        $mainCategory = new MainCategory();
        $params = array('ids'=> $ids, 'fields'=>$fields);
        return $mainCategory->getClient()->postByCurl('getCategoryByIds', $params);
    }

    /**
     * 搜索游戏数据集合
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
        $mainCategory = new MainCategory();
        $options = array(
            'page_num' => $pageNum,
            'page_size' => $pageSize,
            'sort' => $sort,
            'fields' => $fields
        );
        $params = array_merge($conditions, $options);
        return $mainCategory->getClient()->postByCurl('getCategories', $params);
    }


    /**
     * 获取name名称集合
     *
     * @param array $conditions 条件数组
     *
     * @return array
     */
    public static function getNames(array $conditions = array())
    {
        return self::search($conditions, 1, 1000, self::SORT_ID_ASC, array(self::FIELD_ID, self::FIELD_NAME));
    }

    /**
     * 根据游戏ID游戏平台名称
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