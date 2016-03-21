<?php
/**
 * UCenter 应用程序开发 Example
 */
header("Content-type:text/html;charset=utf-8");
if(!empty($_COOKIE['Example_auth'])) {
    list($Example_uid, $Example_username) = explode("\t", $_COOKIE['Example_auth']);
} else {
    $Example_uid = $Example_username = '';
}

/**
 * 各个功能的 Example 代码
 */
switch(@$_GET['example']) {
    case 'login':
        //UCenter 用户登录的 Example 代码
        include 'code/login.php';
    break;
    case 'logout':
        include 'code/logout.php';
    break;
    case 'login_callback':
        //UCenter 用户退出的 Example 代码
        include 'code/login_callback.php';
    break;
}

echo '<hr />';
if(!$Example_username) {
    //用户未登录
    echo '<a href="'.$_SERVER['PHP_SELF'].'?example=login">登录</a> ';
} else {
    //用户已登录
    echo $Example_username.' <a href="http://'.$_SERVER['HTTP_HOST'].'/index.php?example=logout">退出</a> ';
}
