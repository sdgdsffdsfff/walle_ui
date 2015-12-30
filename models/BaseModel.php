<?php
namespace app\models;
/**
 * Description of BaseModel
 * Model基类
 * @author zhaolu@playcrab.com
 */
use yii;
use app\components\ManagerConnection;
use yii\db\ActiveRecord;

class BaseModel extends ActiveRecord
{
    public $db = null;

	public function init() 
    {
		$this->db = static::getDb();
	}
    
    /**
     * 实现多数据库的切换
     * @return Object
     */
    public static function getDb()
    {
        $gameId = yii::$app->session->get('gameId');

		if(empty($gameId)) 
        {
			return yii::$app->db; // 使用名为 "db" 的应用组件
		} 
        else 
        {
            $dbConfig = yii::$app->params['dbConfig']['walleui'];
			return ManagerConnection::getConnection($dbConfig);
		}
    }
}
