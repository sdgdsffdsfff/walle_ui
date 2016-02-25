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
    /**
     * 参数配置列表
     * @return type
     */
    public function actionList()
    {
        return $this->render('list');
    }
    
    /**
     * 参数配置创建
     * @return type
     */
    public function actionCreate()
    {
        return $this->render('edit');
    }
    
    /**
     * 参数配置编辑
     * @return type
     */
    public function actionEdit()
    {
        return $this->render('edit');
    }

    /**
     * 动态参数配置
     * @return type
     */
    public function actionDynamicConfig()
    {
        return $this->render('dynamic');
    }

    /**
     * 动态参数编辑
     * @return type
     */
    public function actionDynamicConfigEdit()
    {
        return $this->render('dynamicedit');
    }
}
