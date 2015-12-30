<?php
/**
 * Encoding class file
 *
 * Playcrab Confidential
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
 * The Encoding classes lists the character encodings we supported currently
 *
 * @category System
 * @package  basedata
 * @author   Alex Zhou<zhouruhong@playcrab.com>
 * @license  http://www.playcrab.com/license  Playcrab Software Distribution
 * @link     http://www.playcrab.com
 */
namespace clients\basedata\util;


class Encoding
{
    const ASCII = 'ASCII';
    const UTF8 = 'UTF-8';
    const GBK = 'GBK';
    const GB2312 = 'GB2312';

    /**
     * 给内容转码
     *
     * @param string $source 字符串
     * @param string $in     原始编码
     * @param string $out    要转的编码
     *
     * @return string
     */
    public static function convert($source, $in, $out)
    {
        $in = strtoupper($in);
        $out = strtoupper($out);
        if ($in == "UTF8") {
            $in = self::UTF8;
        }
        if ($out == "UTF8") {
            $out = self::UTF8;
        }
        if ($in==$out) {
            return $source;
        }
        if (function_exists('mb_convert_encoding')) {
            return mb_convert_encoding($source, $out, $in);
        } elseif (function_exists('iconv')) {
            return iconv($in, $out."//IGNORE", $source);
        }
        return $source;
    }
}