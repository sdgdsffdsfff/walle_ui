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
        $gameAlias = yii::$app->session->get('game_alias');
        
		if(empty($gameAlias))
        {
			return yii::$app->db;
		} 
        else 
        {
            $dbConfig = yii::$app->params['dbConfig'][$gameAlias];
			return ManagerConnection::getConnection($dbConfig);
		}
    }
}
