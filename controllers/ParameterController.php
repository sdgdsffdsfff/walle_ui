<?php
namespace app\controllers;
/**
 * Description of ParameterController
 * 配置参数控制器类
 * @author zhaolu@playcrab.com
 * @time 2016-02-22
 */

class ParameterController extends BaseController
{
    public function actionList()
    {
        return $this->render('list');
    }
    
    public function actionCreate()
    {
        return $this->render('edit');
    }
    
    public function actionEdit()
    {
        return $this->render('edit');
    }
    
    public function actionDelete()
    {
        return true;
    }
}
