<?php
namespace app\controllers;
/**
 * Description of IndexController
 * 版本控制器类
 * @author zhaolu@playcrab.com
 */
use yii\web\Controller;
use app\controllers\BaseController;

class ClientpackageController extends BaseController
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionList(){
    	return $this->render('list');
    }
}
