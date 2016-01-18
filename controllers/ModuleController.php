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
    	$models = Module::findBySql('select * from module where repo_type!="svn"')->asArray()->all();

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
    		$params .= ' --game '.yii::$app->session->get('game_alias');;  //这个地方要根据选择的游戏不同,进行切换
    		foreach ($chk_value as $key => $value) {
    			$params .= ' --module '.$value;
    		}
            $logPath='/data/work/walle/log/updatetaglist_'.time().'.log';
            touch($logPath);
    		$pid = exec("LANG=en_US.UTF-8 ".yii::$app->params['scriptPath']."walle updatetaglist".$params.' >'.$logPath.' 2>&1 & echo $!'); 
            if($pid){
                $this->ajaxReturn(self::STATUS_SUCCESS,'模块更新成功',array('pid'=>$pid,'log_path'=>$logPath));
            }else{
                $this->ajaxReturn(self::STATUS_FAILS,'脚本执行失败');
            }
    		
    	}else{
    		 $this->ajaxReturn(self::STATUS_FAILS,'没有选择更新内容');
    	}

    }

  
}
