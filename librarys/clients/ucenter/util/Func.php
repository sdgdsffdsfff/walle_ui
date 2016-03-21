<?php
/**
 * UtilFunc class file
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

/**
 * UtilFunc
 *
 * @category System
 * @package  ucenter
 * @author   Alex Zhou<zhouruhong@playcrab.com>
 * @license  http://api.ucenter.playcrab.com/license  Playcrab Software Distribution
 * @link     http://api.ucenter.playcrab.com/docs/index.html
 */

namespace clients\ucenter\util;

class Func
{
    /**
     * Define the RFC 2616-compliant date format.
     */
    const DATE_FORMAT_RFC2616 = 'D, d M Y H:i:s \G\M\T';

    /**
     * Define the ISO-8601-compliant date format.
     */
    const DATE_FORMAT_ISO8601 = 'Y-m-d\TH:i:s\Z';

    /**
     * Define the MySQL-compliant date format.
     */
    const DATE_FORMAT_MYSQL = 'Y-m-d H:i:s';

    /**
     * Define the Signature v4 date format.
     */
    const DATE_FORMAT_SIGV4 = 'Ymd\THis\Z';

    /**
     * Retrieves the value of a class constant, while avoiding the `T_PAAMAYIM_NEKUDOTAYIM` error. Misspelled because `const` is a reserved word.
     *
     * @param object $class (Required) An instance of the class containing the constant.
     * @param string $const (Required) The name of the constant to retrieve.
     *
     * @return mixed The value of the class constant.
     */
    public static function konst($class, $const)
    {
        if (is_string($class)) {
            $ref = new ReflectionClass($class);
        } else {
            $ref = new ReflectionObject($class);
        }

        return $ref->getConstant($const);
    }

    /**
     * Convert a HEX value to Base64.
     *
     * @param string $str (Required) Value to convert.
     *
     * @return string Base64-encoded string.
     */
    public static function hexToBase64($str)
    {
        $raw = '';

        for ($i = 0; $i < strlen($str); $i += 2) {
            $raw .= chr(hexdec(substr($str, $i, 2)));
        }

        return base64_encode($raw);
    }

    /**
     * Convert an associative array into a query string.
     *
     * @param array $array (Required) Array to convert.
     *
     * @return string URL-friendly query string.
     */
    public static function toQueryString($array)
    {
        $temp = array();

        foreach ($array as $key => $value) {
            if (is_string($key) && !is_array($value)) {
                $temp[] = rawurlencode($key) . '=' . rawurlencode($value);
            }
        }

        return implode('&', $temp);
    }

    /**
     * Convert a query string into an associative array. Multiple, identical keys will become an indexed array.
     *
     * @param string $qs (Required) Query string to convert.
     *
     * @return array Associative array of keys and values.
     */
    public static function queryToArray($qs)
    {
        $query = explode('&', $qs);
        $data = array();

        foreach ($query as $q) {
            $q = explode('=', $q);

            if (isset($data[$q[0]]) && is_array($data[$q[0]])) {
                $data[$q[0]][] = urldecode($q[1]);
            } elseif (isset($data[$q[0]]) && !is_array($data[$q[0]])) {
                $data[$q[0]] = array($data[$q[0]]);
                $data[$q[0]][] = urldecode($q[1]);
            } else {
                $data[urldecode($q[0])] = urldecode($q[1]);
            }
        }
        return $data;
    }

    /**
     * Return human readable file sizes.
     *
     * @param integer $size    (Required) Filesize in bytes.
     * @param string  $unit    (Optional) The maximum unit to use. Defaults to the largest appropriate unit.
     * @param string  $default (Optional) The format for the return string. Defaults to `%01.2f %s`.
     *
     * @return string The human-readable file size.
     *
     * @link http://aidanlister.com/repos/v/function.size_readable.php Original Function
     * @author Aidan Lister <aidan@php.net>
     * @author Ryan Parman <ryan@getcloudfusion.com>
     * @license http://www.php.net/license/3_01.txt PHP License
     */
    public static function sizeReadable($size, $unit = null, $default = null)
    {
        // Units
        $sizes = array('B', 'kB', 'MB', 'GB', 'TB', 'PB', 'EB');
        $mod = 1024;
        $ii = count($sizes) - 1;

        // Max unit
        $unit = array_search((string) $unit, $sizes);
        if ($unit === null || $unit === false) {
            $unit = $ii;
        }

        // Return string
        if ($default === null) {
            $default = '%01.2f %s';
        }

        // Loop
        $i = 0;
        while ($unit != $i && $size >= 1024 && $i < $ii) {
            $size /= $mod;
            $i++;
        }

        return sprintf($default, $size, $sizes[$i]);
    }

    /**
     * Convert a number of seconds into Hours:Minutes:Seconds.
     *
     * @param integer $seconds (Required) The number of seconds to convert.
     *
     * @return string The formatted time.
     */
    public static function timeHms($seconds)
    {
        $time = '';

        // First pass
        $hours = (int) ($seconds / 3600);
        $seconds = $seconds % 3600;
        $minutes = (int) ($seconds / 60);
        $seconds = $seconds % 60;

        // Cleanup
        $time .= ($hours) ? $hours . ':' : '';
        $time .= ($minutes < 10 && $hours > 0) ? '0' . $minutes : $minutes;
        $time .= ':';
        $time .= ($seconds < 10) ? '0' . $seconds : $seconds;

        return $time;
    }

    /**
     * Returns the first value that is set. Based on [Try.these()](http://api.prototypejs.org/language/Try/these/) from [Prototype](http://prototypejs.org).
     *
     * @param array  $attrs   (Required) The attributes to test, as strings. Intended for testing properties of the $base object, but also works with variables if you place an @ symbol at the beginning of the command.
     * @param object $base    (Optional) The base object to use, if any.
     * @param mixed  $default (Optional) What to return if there are no matches. Defaults to `null`.
     *
     * @return mixed Either a matching property of a given object, boolean `false`, or any other data type you might choose.
     */
    public static function tryThese($attrs, $base = null, $default = null)
    {
        if ($base) {
            foreach ($attrs as $attr) {
                if (isset($base->$attr)) {
                    return $base->$attr;
                }
            }
        } else {
            foreach ($attrs as $attr) {
                if (isset($attr)) {
                    return $attr;
                }
            }
        }

        return $default;
    }

    /**
     * Converts a SimpleXML response to an array structure.
     *
     * @param stdClass $object (Required) A response value.
     *
     * @return array The response value as a standard, multi-dimensional array.
     */
    public static function convertObjectToArray(stdClass $object)
    {
        return json_decode(json_encode($object), true);
    }

    /**
     * Converts an array structure to a SimpleXML structure
     *
     * @param array $array (Required) A response value.
     *
     * @return array The response value as an object.
     */
    public static function convertArrayToObject(array $array)
    {
        return json_decode(json_encode($array));
    }

    /**
     * Checks to see if a date stamp is ISO-8601 formatted, and if not, makes it so.
     *
     * @param string $datestamp (Required) A date stamp, or a string that can be parsed into a date stamp.
     *
     * @return string An ISO-8601 formatted date stamp.
     */
    public static function convertDateToIso8601($datestamp)
    {
        if (!preg_match('/\d{4}-\d{2}-\d{2}T\d{2}:\d{2}:\d{2}((\+|-)\d{2}:\d{2}|Z)/m', $datestamp)) {
            return gmdate(self::DATE_FORMAT_ISO8601, strtotime($datestamp));
        }

        return $datestamp;
    }

    /**
     * Determines whether the data is Base64 encoded or not.
     *
     * @param string $s (Required) The string to test.
     *
     * @return boolean Whether the string is Base64 encoded or not.
     *
     * @license http://us.php.net/manual/en/function.base64-decode.php#81425 PHP License
     */
    public static function isBase64($s)
    {
        return (bool) preg_match('/^[a-zA-Z0-9\/\r\n+]*={0,2}$/', $s);
    }

    /**
     * Determines whether the data is a JSON string or not.
     *
     * @param string $s (Required) The string to test.
     *
     * @return boolean Whether the string is a valid JSON object or not.
     */
    public static function isJson($s)
    {
        return !!(json_decode($s) instanceof stdClass);
    }

    /**
     * Decodes `\uXXXX` entities into their real unicode character equivalents.
     *
     * @param string $s (Required) The string to decode.
     *
     * @return string The decoded string.
     */
    public static function decodeUhex($s)
    {
        preg_match_all('/\\\u([0-9a-f]{4})/i', $s, $matches);
        $matches = $matches[count($matches) - 1];
        $map = array();

        foreach ($matches as $match) {
            if (!isset($map[$match])) {
                $map['\u' . $match] = html_entity_decode('&#' . hexdec($match) . ';', ENT_NOQUOTES, 'UTF-8');
            }
        }

        return str_replace(array_keys($map), $map, $s);
    }

    /**
     * Generates a random GUID.
     *
     * @author Alix Axel <http://www.php.net/manual/en/function.com-create-guid.php#99425>
     *
     * @license http://www.php.net/license/3_01.txt PHP License
     *
     * @return string A random GUID.
     */
    public static function generateGuid()
    {
        return sprintf(
            '%04X%04X-%04X-%04X-%04X-%04X%04X%04X',
            mt_rand(0, 65535),
            mt_rand(0, 65535),
            mt_rand(0, 65535),
            mt_rand(16384, 20479),
            mt_rand(32768, 49151),
            mt_rand(0, 65535),
            mt_rand(0, 65535),
            mt_rand(0, 65535)
        );
    }

    /**
     * Checks if an array is associative, returns true for yes, or not.
     * some examples as below,
     *     var_dump(is_assoc_array(array('a', 'b', 'c'))); // false
     *     var_dump(is_assoc_array(array("0" => 'a', "1" => 'b', "2" => 'c'))); // false
     *     var_dump(is_assoc_array(array("1" => 'a', "0" => 'b', "2" => 'c'))); // true
     *     var_dump(is_assoc_array(array("a" => 'a', "b" => 'b', "c" => 'c'))); // true
     *
     * @param array $var the array to be checked
     *
     * @return boolean
     */
    public static function isAssocArray($var)
    {
        if (!is_array($var)) {
            return false;
        }
        return array_diff_assoc(array_keys($var), range(0, sizeof($var)))
        ? true
        : false;
    }

    /**
     * 判断给定字符串是否以指定字符串结束
     *
     * @param string  $haystack 给定的被检查字符串
     * @param string  $needle   指定的结束字符串
     * @param boolean $case     是否大小写敏感
     *
     * @return boolean
     */
    public static function strEndsWith($haystack, $needle, $case=true)
    {
        if ($case) {
            return(
                strcmp(substr($haystack, strlen($haystack)-strlen($needle)), $needle)===0
            );
        }
        return (
            strcasecmp(substr($haystack, strlen($haystack)-strlen($needle)), $needle)===0
        );
    }


    /**
     * 转换数组到字符串
     *
     * @param array  $params 参数数组
     * @param string $glue   分隔符
     *
     * @return string
     */
    public static function convertArrayToStr(array $params, $glue='')
    {
        ksort($params);
        $str = '';
        if ($params && is_array($params)) {
            foreach ($params as $key => $value) {
                if (is_array($value)) {
                    sort($value);

                    $tmpStr = implode($glue, $value);
                    $str .=  $key . $tmpStr . $glue;
                } else {
                    $str .=  $key . $value . $glue;
                }
            }
        }
        return $str;
    }

}
