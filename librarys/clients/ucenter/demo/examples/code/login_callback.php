<?php
/**
 * UCenter 应用程序开发 Example
 */
namespace example;
//加载autoload文件
require_once(dirname(dirname((dirname(__DIR__)))) . "/autoload.php");
use clients\ucenter\services\Common;
use clients\ucenter\services\User;

//获取token
$token = isset($_GET['token']) ? $_GET['token'] : null;

if (empty($token)) {
    die("no token");
}

//验证token
$uid = Common::checkToken($token);

if (!$uid) {
    //token 无效不合法
    die("Invalid token");
}

//通过uid 获取用户数据
$user = User::getUserById($uid);

//写状态
setcookie('Example_auth', join("\t", [$uid, $user['name']]));
//首页Url
$indexUrl = 'http://'.$_SERVER['HTTP_HOST'].'/index.php';
echo '登录成功'.'<br><a href="'.$indexUrl.'">继续</a>';
exit;







