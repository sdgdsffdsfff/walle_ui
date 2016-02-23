<?php
namespace app\controllers;
/**
 * Description of WorkerController
 * 打包机控制器类
 * @author zhaolu@playcrab.com
 * @time 2016-02-23
 */

class WorkerController extends BaseController
{
    /**
     * 打包机配置列表
     * @return type
     */
    public function actionList()
    {
        return $this->render('list');
    }
    
    /**
     * 新增打包机
     */
    public function actionCreate()
    {
        return $this->render('edit');
    }
    
    /**
     * 打包机编辑
     */
    public function actionEdit()
    {
        return $this->render('edit');
    }
    
    /**
     * 打包机删除
     */
    public function actionDelete()
    {
        
    }
}
