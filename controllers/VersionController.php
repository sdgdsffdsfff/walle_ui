<?php
namespace app\controllers;
/**
 * Description of IndexController
 * 版本控制器类
 * @author zhaolu@playcrab.com
 */
use yii\web\Controller;

class VersionController extends BaseController
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    //创建版本
    public function actionAddVersion()
    {
        return $this->render('addversion');
    }
    
    public function actionList()
    {
    	return $this->render('list');
    }
    
    //版本详情
    public function actionVersionDetail()
    {
        return $this->render('versiondetail');
    }
}
