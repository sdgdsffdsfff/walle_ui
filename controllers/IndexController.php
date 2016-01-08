<?php
namespace app\controllers;
/**
 * Description of IndexController
 * 默认控制器类
 * @author zhaolu@playcrab.com
 */
use yii;
use yii\web\Controller;
use clients\ucenter\services\Game as Game;
use clients\ucenter\services\MainCategory as MainCategory;

class IndexController extends BaseController
{
	public $layout = "vms_index";
    
    /**
     * 游戏选择首页
     * @return type
     */
    public function actionIndex()
    {	
        yii::$app->session->remove('game_name');
        
        $userRoles = Yii::$app->getUser()->getIdentity()->getUserRoles();
            // var_dump($userRoles);die; 
        foreach ($userRoles as $key => $role)
        {
            if($role['game_id'] == 0)
            {
                $gameInfo = Game::getAll();              
                break;
            }
            else
            {
                $info = Game::getGameById($role['game_id']);
                $gameInfo[$key] = array(
                    'id' => $role['game_id'],
                    'name' => $info['name'],  //获取游戏名称
                    'alias'=>$info['alias']
                );
            }
        }

        return $this->render('index',['gameInfo'=>$gameInfo]);
    }

    /**
     * 数据库切换
     */
    public function actionSeldb()
    {
    	$alias = yii::$app->getRequest()->get('alias');
        $id = yii::$app->getRequest()->get('id');
        $userRoles = Yii::$app->getUser()->getIdentity()->getUserRoles();
        foreach ($userRoles as $key => $role)
        {
            if($role['game_id'] == 0||$role['game_id'] == $id)
            {
                $info = Game::getGameById((int)$id);
                yii::$app->session->set('game_name', $info['name']);
                
                //默认会开启session
                yii::$app->session->set('game_alias', $alias);
                header('Location:/version/add-version'); 
                exit;
            }
           
        }
        echo "对不起，您没有权限";exit;
      
    }
}
