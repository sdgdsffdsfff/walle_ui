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

class IndexController extends Controller
{
	public $layout = "vms_index";
    public function actionIndex()
    {	$gameInfo = Game::getAll();   
        return $this->render('index',['gameInfo'=>$gameInfo]);
    }

    public function actionSeldb(){
    	$alias=yii::$app->getRequest()->get('alias');
    	$_SESSION['game_alias']=$alias;
    	header('Location:/version/add-version'); 
    	exit;
    }
}
