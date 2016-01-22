<?php
namespace app\components;
/**
 * Description of BaseActiveRecord
 * 建立新的数据库连接
 * @author zhaolu@playcrab.com
 */
use yii\db\Connection;
use yii\db\Exception;

class ManagerConnection
{
    private static $_instance;
    
    private function __construct() { }
    
    private function __clone() { }

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
            header('Location:/error/config-error');
            exit;
            //throw new Exception('数据库配信息错误!');
        }
        
        if(!(self::$_instance instanceof Connection))
        {
            try
            {
                self::$_instance = new Connection([
                    'dsn' => $config['dsn'],
                    'username' => $config['username'],
                    'password' => $config['password'],
                    'charset' => $config['charset'],
                ]);

                self::$_instance->open();
            } 
            catch (Exception $e)
            {
                header('Location:/error/connection-error');
                exit;
                //throw new Exception();
            }
        }

        return self::$_instance;
    }
}
