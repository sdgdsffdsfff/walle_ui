<?php
namespace app\controllers;
/**
 * Description of ErrorController
 * 数据库切换显示错误页
 * @author playcrab
 */
use yii;

class ErrorController extends BaseController
{
    private $game_name;
    
    /**
     * 游戏数据库未配置提示
     */
    public function actionConfigError()
    {
        $this->game_name = yii::$app->session->get('game_name');
        $this->error("未配置游戏\"{$this->game_name}\"的数据库信息，请联系系统管理员!", '/index/index', 10);
    }
    
    /**
     * 游戏数据库连接失败
     */
    public function actionConnectionError()
    {
        $this->game_name = yii::$app->session->get('game_name');
        $this->error("游戏\"{$this->game_name}\"连接数据库失败，请联系系统管理员!", '/index/index', 10);
    }
}
