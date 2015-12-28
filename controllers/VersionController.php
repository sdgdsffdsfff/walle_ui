<?php
namespace app\controllers;
/**
 * Description of IndexController
 * 默认控制器类
 * @author zhaolu@playcrab.com
 */
use yii\web\Controller;

class VersionController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionList(){
    	return $this->render('list');
    }
}
