<?php
/**
 * Config class file
 *
 * Playcrab Confidential
 * Copyright (c) 2011, Playcrab Corp. <support@playcrab.com>.
 * All rights reserved.
 *
 * PHP version 5
 *
 * @category System
 * @package  ucenter
 * @author   Alex Zhou<zhouruhong@playcrab.com>
 * @license  http://api.ucenter.playcrab.com/license  Playcrab Software Distribution
 * @link     http://api.ucenter.playcrab.com/docs/index.html
 */
namespace clients\ucenter\lib;
/**
 * Config
 *
 * @category System
 * @package  ucenter
 * @author   Alex Zhou<zhouruhong@playcrab.com>
 * @license  http://api.ucenter.playcrab.com/license  Playcrab Software Distribution
 * @link     http://api.ucenter.playcrab.com/docs/index.html
 */
class Config
{
    //配置的数组
    static $config;

    /**
     * 设置配置
     *
     * @return void
     */
    public static function set()
    {
        $params = func_get_args();
        $size = func_num_args();
        if ($size == 2) {
            $key = $params[0];
            $value = $params[1];
            self::$config[$key] = $value;
        } else {
            $value = $params[0];
            self::$config = $value;
        }
    }

    /**
     * 获取配置项的值或者全部配置
     *
     * @param string $key key
     *
     * @return mixed
     */
    public static function get($key=null)
    {
        if (empty($key)) {
            return self::$config;
        } else {
            return isset(self::$config[$key]) ? self::$config[$key] : null;
        }
    }

    /**
     * 获取配置项的值
     *
     * @param string $path such as a.b.c
     *
     * @return mixed
     */
    public static function getByPath($path)
    {
        $configs = self::$config;
        if (empty($path)) {
            return $configs;
        }

        $arr = explode(".", $path);
        foreach ($arr as $k) {
            $configs = isset($configs[$k]) ? null : $configs[$k];
        }
        return $configs;
    }

}