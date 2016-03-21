<?php
/**
 * Config inc file
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

$config = array(
	'api_url' => 'http://119.254.111.26:8086/',
    //'api_url' => 'http://api.ucenter.playcrab.com/',  //线上地址
    'api_key' => '3462071649',
    //'api_secret_key' => '6deb3c19f94363b11915421b68c8c8a0',  //线上key
    'api_secret_key' => '21ae25708f1d5e6d5d4d97d33c478a1d',
    // 'api_secret_key' => '21ae25708f1d5e6d5d4d97d33c478a1d',
    // 'api_url' => 'http://api.ucenter.playcrab.com/',
    // 'api_key' => '1547219295',
    // 'api_secret_key' => 'fdd6f79217a7038bc0f965e93ea25edf',
    'log_path' => dirname(__FILE__).'/logs'
);
