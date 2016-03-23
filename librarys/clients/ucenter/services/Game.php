<?php
/**
 * Game Client class file
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
 * Class Game
 * 默认使用SESSION缓存, 需开启SESSION
 * @package clients\ucenter\services
 */
class Game extends Base
{
    const URL_PATH = 'game/rpc';

    /**
     * 根据游戏Id获取游戏信息
     * @param int $id
     * @param bool $useCache 默认使用缓存 false 禁止使用缓存
     * @return array
     * @throws Exception
     */
    public static function getGameById($id, $useCache = true)
    {
        $game = new self();
        $params = ['id' => $id];

        if ($useCache) {
            $gameInfoCache = @$_SESSION['UCENTER:gameInfo'];

            if (!empty($gameInfoCache) && isset($gameInfoCache)) {
                return $gameInfoCache;
            }

            $gameInfo = $game->getClient()->postByCurl(__FUNCTION__, $params, self::URL_PATH);
            $_SESSION['UCENTER:gameInfo'] = $gameInfo;
            return $gameInfo;
        }
        return $game->getClient()->postByCurl(__FUNCTION__, $params, self::URL_PATH);
    }

    /**
     * 获取所有数据
     * @param bool $useCache 默认使用缓存, false 禁止使用缓存
     * @return array
     * @throws Exception
     */
    public static function getAll($useCache = true)
    {
        $game = new self();
        $params = array();

        if ($useCache) {
            $allDataCache = @$_SESSION['UCENTER:allData'];

            if (!empty($allDataCache) && isset($allDataCache)) {
                return $allDataCache;
            }

            $allData = $game->getClient()->postByCurl(__FUNCTION__, $params, self::URL_PATH);
            $_SESSION['UCENTER:allData'] = $allData;
            return $allData;
        }
        return $game->getClient()->postByCurl(__FUNCTION__, $params, self::URL_PATH);
    }


    /**
     * 根据游戏Id获取平台信息集合
     * @param $id
     * @param bool $useCache 默认使用缓存, false 禁止使用缓存
     * @return array
     * @throws Exception
     */
    public static function getPlatformsById($id, $useCache = true)
    {
        $game = new self();
        $params = ['id' => $id];

        if ($useCache) {
            $platformsByIdCache = @$_SESSION['UCENTER:platformsById'];

            if (!empty($platformsByIdCache) && isset($platformsByIdCache)) {
                return $platformsByIdCache;
            }

            $platformsById = $game->getClient()->postByCurl(__FUNCTION__, $params, self::URL_PATH);
            $_SESSION['UCENTER:platformsById'] = $platformsById;
            return $platformsById;
        }
        return $game->getClient()->postByCurl(__FUNCTION__, $params, self::URL_PATH);
    }

}