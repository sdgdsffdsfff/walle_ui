<?php
/**
 * UCenter 应用程序开发 Example
 *
 */
namespace example;
require_once(dirname(dirname((dirname(__DIR__)))) . "/autoload.php");
use clients\ucenter\services\Common;

//注销本地状态
setcookie('Example_auth', '', -86400);

//获取远程地址
$logoutUrl = Common::logoutUrl();

//执行跳转
header("Location: $logoutUrl");
die;