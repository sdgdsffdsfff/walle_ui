<?php
namespace app\controllers;
/**
* RegionController.php
* 
* Developed by Ocean.Liu<liuhaiyang@playcrab.com>
* Copyright (c) 2016 www.playcrab.com
* 
* Changelog:
* 2016-02-22 - created
* 
*/
use yii;
use yii\web\Controller;
use app\controllers\BaseController;
use app\models\Version;
use app\models\Platform;
use app\models\UpgradePath;
use yii\data\Pagination;
use app\models\Deployment;
use app\models\Clientpackage;
use app\models\RegionConfig;
use app\models\Parameter;
use app\models\Region;


class RegionController extends BaseController
{
    
         /**
    * [列表页]
    * @return [type] [description]
    */
    public function actionList()
    {    $data=array();
       $data=Region::find()->asArray()->all();
       return $this->render('list',array('data'=>$data));
    }

    /**
     * [新增编辑页]
     * @return [type] [description]
     */
   public function actionEdit()
    { $info=array();
      $id = yii::$app->getRequest()->get('id');
      if($id){
        $info=Region::findOne($id);
        if(!$info){
          $this->error('您要编辑的内容不存在', '/region/list');
        }
      }
       return $this->render('edit',array('info'=>$info,'id'=>$id));
    }
    /**
     * [编辑保存操作]
     * @return [type] [description]
     */
    public function actionDoedit(){
      $id = yii::$app->getRequest()->post('id');
      $name = yii::$app->getRequest()->post('name');
      $description = yii::$app->getRequest()->post('description');
      $disable = yii::$app->getRequest()->post('disable');
      if($name&&$description){
        $sameName=Region::find()->where(array('name'=>$name))->one();
        if($sameName&&$sameName['id']!=$id){
          $this->ajaxReturn(self::STATUS_FAILS, '该名称已经存在');
        }else{
          if($id){
          $info = Region::findOne($id);
          //$info->name = $name;
          $info->description = $description;
          $info->disable=$disable;
          $info->save();
         
        }else{
          $info = new Region();
          $info->name = $name;
          $info->description = $description;
          $info->disable=$disable;
          $info->insert();
        }
          $this->ajaxReturn(self::STATUS_SUCCESS,'保存成功');
        }
        
      }else{
        $this->ajaxReturn(self::STATUS_FAILS, '缺少参数');
      }
      
    }

    /**
     * 发行地区配置列表
     */
    public function actionConfigList()
    {
        //获取region
        $regions = Region::find()->where(array("disable" => 0))->addSelect(array('id', 'name'))->asArray()->all();
        //获取parameter
        $parameters = Parameter::find()->where(array("disable" => 0))->addSelect(array('id', 'name', 'description'))->asArray()->all();
        $regionConfigs = RegionConfig::find()->all();
        $data = array();
        if (!empty($regionConfigs))
        {
            foreach ($regionConfigs as $regionConfig)
            {
                $data[] = $regionConfig->toArray();
            }
        }
        
        return $this->render('configlist', array("data" => $data, "regions" => $regions, "parameters" => $parameters));
    }

    /**
     * 编辑和新增发行地区配置
     */
    public function actionConfigEdit()
    {
        $regionId = yii::$app->getRequest()->get('region_id');
        $parameterId = yii::$app->getRequest()->get('parameter_id');
        if (empty($regionId) && empty($parameterId))
        {
            //新增配置页面、查找全部region和parameter
            $regionList = Region::find()->where(array("disable" => 0))->addSelect(array('id', 'name'))->asArray()->all();
            $parameterList = Parameter::getAllParameterByEnable();
        
            return $this->render('configadd', array("regionList" => $regionList, "parameterList" => $parameterList));
        }
        else
        {
            //编辑已存在配置
            $region = Region::findOne($regionId);
            $parameter = Parameter::findOne($parameterId);
            if (!$region || !$parameter)
            {
                $this->error('您要编辑的内容不存在', '/region/config-list');
            }
            $value = RegionConfig::find()->where(array("region_id" => $regionId, "parameter_id" => $parameterId))->one()->value;
            if (!$value)
            {
                $this->error('您要编辑的内容不存在', '/region/config-list');
            }

            return $this->render('configedit', array("region" => $region, "parameter" => $parameter, "value" => $value));
        }

    }

    /**
     * 保存发行地区配置
     */
    public function actionConfigSave()
    {
        $regionId = yii::$app->getRequest()->post('region_id');
        $parameterId = yii::$app->getRequest()->post('parameter_id');
        $parameterValue = yii::$app->getRequest()->post('parameter_value');

        if (empty($regionId) || empty($parameterId))
        {
            $this->newajaxReturn(self::STATUS_FAILS, array(), '请求参数有误!');
        }
        $valueType = Parameter::findOne($parameterId)->value_type;
        //value_type为string 的参数，参数值允许为空
        if ($valueType != "string" && empty($parameterValue))
        {
            $this->newajaxReturn(self::STATUS_FAILS, array(), '请求参数有误!');
        }
        //查找regionConfig判断请求为新增还是编辑
        $regionConfig = RegionConfig::find()->where(array("region_id" => $regionId, "parameter_id" => $parameterId))->one();
        if (!$regionConfig)
        {
            //新增配置
            $regionConfig = new RegionConfig();
            $regionConfig->region_id = $regionId;
            $regionConfig->parameter_id = $parameterId;
        }
        $regionConfig->value = $parameterValue;

        if ($regionConfig->save())
        {
            $this->newajaxReturn(self::STATUS_SUCCESS, array(), '保存成功!');
        }

        $this->newajaxReturn(self::STATUS_FAILS, array(), '保存失败!');
    }

    /**
     * 删除发行地区配置
     */
    public function actionConfigDelete()
    {
        $regionId = yii::$app->getRequest()->post('region_id');
        $parameterId = yii::$app->getRequest()->post('parameter_id');
        
        if (empty($regionId) || empty($parameterId))
        {
            $this->newajaxReturn(self::STATUS_FAILS, '', '请求参数有误!');
        }
        
        $regionConfig = RegionConfig::find()->where(array("region_id" => $regionId, "parameter_id" => $parameterId))->one();

        if (!$regionConfig)
        {
            $this->newajaxReturn(self::STATUS_FAILS, '', '未找到相关配置!');
        }

        if ($regionConfig->delete())
        {
            $this->newajaxReturn(self::STATUS_SUCCESS, array(), '删除成功!');
        }

        $this->newajaxReturn(self::STATUS_FAILS, '', '删除失败!');
    }

}
