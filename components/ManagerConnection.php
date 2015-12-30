<?php
namespace app\components;
/**
 * Description of BaseActiveRecord
 * 建立新的数据库连接
 * @author zhaolu@playcrab.com
 */
use yii\db\Connection;

class ManagerConnection
{
    /**
     * 切换数据库时,建立新的数据库连接
     * @param array $config 数据库配置信息
     * @return Connection
     * @throws Exception
     */
    public static function getConnection($config)
    {
        if(empty($config) || !is_array($config))
        {
            throw new Exception('数据库配信息错误!');
        }
        
        try
        {
            $connection = new Connection([
                'dsn' => $config['dsn'],
                'username' => $config['username'],
                'password' => $config['password'],
                'charset' => $config['charset'],
            ]);
            
            $connection->open();
        } 
        catch (Exception $e)
        {
            throw new Exception('数据库连接失败!');
        }
        
        return $connection;
    }
}
