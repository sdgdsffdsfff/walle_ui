<?php
namespace app\controllers;
/**
 * Description of IndexController
 * 版本控制器类
 * @author zhaolu@playcrab.com
 */
use yii;
use yii\web\Controller;
use app\models\Module;

class ModuleController extends BaseController
{
    public function actionIndex()
    {
    	$models=Module::find()->all();

        return $this->render('index',['models'=>$models]);
    }
    public function actionUpdate()
    {
    	$chk_value = yii::$app->getRequest()->post('chk_value');
    	if(count($chk_value)){
    		//system("dir",$out); 
    	}else{
    		 $this->ajaxReturn(1,'设置成功');
    	}

    }

  
}
