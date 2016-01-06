<?php
namespace app\controllers;
/**
 * Description of IndexController
 * 版本控制器类
 * @author zhaolu@playcrab.com
 */
use yii\web\Controller;
use app\models\Module;

class ModuleController extends BaseController
{
    public function actionIndex()
    {
    	$models=Module::find()->all();

        return $this->render('index',['models'=>$models]);
    }

  
}
