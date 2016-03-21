<?php
require "../autoload.php";
use clients\ucenter\services\Common;
use clients\ucenter\services\User;
use clients\ucenter\services\Game;
use clients\ucenter\services\Platform;
use clients\ucenter\services\Project;

################################### Common Service Start ###############################################################
//获取登录Url
$loginUrl = Common::loginUrl('http://admin.tds.playcrab.com/index.php?r=ucenter/callback');
echo $loginUrl . "\n";

//获取登出Url
$logoutUrl = Common::logoutUrl('http://admin.tds.playcrab.com/index.php?r=ucenter/callback');
echo $logoutUrl . "\n";

//验证登录Token
$result = Common::checkToken('abcdedf');
echo  $result ? 1 : 0 . "\n";
################################## Common Service End ##################################################################
################################## User Service Start ##################################################################
//根据用户ID,获取用户信息
$user = User::getUserById(1);
print_r($user);

//根据条件,获取用户的角色(全部游戏，全部平台)
$roles = User::getRoles(291, 0, 0, false);
print_r($roles);

//获取用户所有角色
$roles = User::getRolesById(131);
print_r($roles);

//获取用户的所有功能列表
$functions = User::getFunctionPaths(85);
print_r($functions);
################################# User Service End     #################################################################
################################## Game Services Start #################################################################
//根据游戏Id, 获取游戏信息
$game = Game::getGameById(1);
print_r($game);

//获取所有游戏数据
$allGames = Game::getAll();
print_r($allGames);

//根据游戏ID获取平台信息集合
$platforms = Game::getPlatformsById(1);
print_r($platforms);
################################# Game Services End ###################################################################
################################# Platform Services Start #############################################################
//根据平台ID获取平台信息
$platform = Platform::getPlatformById(1);
print_r($platform);
################################ Platform Services End ################################################################
################################ Platform Services End ################################################################
//获取项目中所有已授权的用户
$users = Project::getUsers();
print_r($users);
//获取项目中所有已授权的管理员
$admins = Project::getAdmins();
print_r($admins);
//获取项目中所有已授权角色
$roles = Project::getRoles();
print_r($roles);
//获取项目中所有已授权功能
$functions = Project::getFunctions();
print_r($functions);





