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
    /**
     * 模块更新版本列表
     * @return type
     */
    public function actionIndex()
    {
    	$models = Module::find()->all();

        return $this->render('index',['models'=>$models]);
    }
    
    /**
     * 模块更新操作
     */
    public function actionUpdate()
    {
    	$chk_value = yii::$app->getRequest()->post('chk_value');
    	if(count($chk_value)){
    		$params = ' --log-level DEBUG';
    		$params .= ' --game icx';  //这个地方要根据选择的游戏不同,进行切换
    		foreach ($chk_value as $key => $value) {
    			$params .= ' --module '.$value;
    		}
            $logPath='/data/work/walle/log/updatetaglist_'.time().'.log';
    		$pid = exec(yii::$app->params['scriptPath']."walle updatetaglist".$params.' >$logPath 2>&1 & echo &!', $b); 
    		$this->ajaxReturn(1,array('pid'=>$pid,'log_path'=>$logPath));
    	}else{
    		 $this->ajaxReturn(0,'没有选择更新内容');
    	}

    }

  
}
