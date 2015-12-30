<?php
/**
 * UCenter 应用程序开发 Example
 */
namespace example;
//加载autoload文件
require_once(dirname(dirname((dirname(__DIR__)))) . "/autoload.php");
use clients\ucenter\services\Common;


//拼回调地址
$callbackUrl = 'http://'.$_SERVER['HTTP_HOST'].'/index.php?example=login_callback';

//获取远程服务器登录地址
$loginUrl = Common::loginUrl($callbackUrl);

//执行跳转
header("Location: $loginUrl");
die;


