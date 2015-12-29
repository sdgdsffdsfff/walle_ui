<?php
namespace app\controllers;
/**
 * Description of IndexController
 * 默认控制器类
 * @author zhaolu@playcrab.com
 */
use yii;
use yii\web\Controller;

class TaskController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }
    
    /**
     * 发布任务
     * @return 
     */
    public function actionPublish()
    {
        //return 'test yii2';
        $params = yii::$app->getRequest()->get();
        
        return $this->render('publish');
    }
    
    /**
     * 发布任务列表
     */
    public function actionList()
    {
        return $this->render('list');
    
    }

    /**
     * 任务详情页
     */
    public function actionDetail()
    {
        return $this->render("detail");
    }
}
