<?php
namespace app\controllers;
/**
 * Description of IndexController
 * 版本控制器类
 * @author zhaolu@playcrab.com
 */
use yii;
use yii\web\Controller;
use app\controllers\BaseController;
use app\models\Version;
use app\models\Platform;
use app\models\Region;
use app\models\UpgradePath;
use yii\data\Pagination;
use app\models\Parameter;
use app\models\Deployment;
use app\models\DeploymentConfig;
use app\models\Clientpackage;


class DeploymentController extends BaseController
{
    
    /**
    * [列表页]
    * @return [type] [description]
    */
    public function actionList()
    {    $data=array();
       $data=Deployment::find()->with('platform')->asArray()->all();
       foreach ($data as $k => $v) {
         $region=Region::findOne($v['platform']['region_id']);
         $data[$k]['region']=$v['platform']['name'].'-'.$region['name'];
       }
       return $this->render('list',array('data'=>$data));
    }

    /**
     * [新增编辑页]
     * @return [type] [description]
     */
   public function actionEdit()
    { 
        $region=Platform::find()->where(array('disable'=>0))->with('region')->asArray()->all();
     $info=array();
      $id = yii::$app->getRequest()->get('id');
      if($id){
        $info=Deployment::findOne($id);
        if(!$info){
          $this->error('您要编辑的内容不存在', '/deployment/list');
        }
      }
       return $this->render('edit',array('info'=>$info,'id'=>$id,"region"=>$region));
    }
    /**
     * [编辑保存操作]
     * @return [type] [description]
     */
    public function actionDoedit(){
      $id = yii::$app->getRequest()->post('id');
      $region = yii::$app->getRequest()->post('region');
      $name = yii::$app->getRequest()->post('name');
      $description = yii::$app->getRequest()->post('description');
      $disable = yii::$app->getRequest()->post('disable');
      if($name&&$description&&$region){
        $sameName=Deployment::find()->where(array('name'=>$name,'platform_id'=>$region))->one();
        if($sameName&&$sameName['id']!=$id){
          $this->ajaxReturn(self::STATUS_FAILS, '该名称已经存在');
        }else{
          if($id){
          $info = Deployment::findOne($id);
          $info->name = $name;
          $info->platform_id=$region;
          $info->description = $description;
          $info->disable=$disable;
          $info->save();
         
        }else{
          $info = new Deployment();
          $info->name = $name;
           $info->platform_id=$region;
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
     * 部署位置配置列表
     */
    public function actionConfigList()
    {
        $deployments = Deployment::find()->where(array("disable" => 0))->addSelect(array('id', 'name'))->asArray()->all();
        //获取parameter
        $parameters = Parameter::find()->where(array("disable" => 0))->addSelect(array('id', 'name', 'description'))->asArray()->all();
        $deploymentConfigs = DeploymentConfig::find()->all();
        $data = array();
        if (!empty($deploymentConfigs))
        {
            foreach ($deploymentConfigs as $deploymentConfig)
            {
                $data[] = $deploymentConfig->toArray();
            }
        }

        return $this->render('configlist', array("data" => $data, "deployments" => $deployments, "parameters" => $parameters));
    }

    /**
     * 编辑部署位置
     */
    public function actionConfigEdit()
    {
        $deploymentId = yii::$app->getRequest()->get('deployment_id');
        $parameterId = yii::$app->getRequest()->get('parameter_id');
        if (empty($deploymentId) && empty($parameterId))
        {
            //新增配置页面、查找全部deployment和parameter
            $deploymentList = Deployment::find()->where(array("disable" => 0))->addSelect(array('id', 'name'))->asArray()->all();
            $parameterList = Parameter::find()->where(array("disable" => 0))->addSelect(array('id', 'name', 'description'))->asArray()->all();

            return $this->render('configadd', array("deploymentList" => $deploymentList, "parameterList" => $parameterList));
        }
        else
        {
            //编辑已存在配置
            $deployment = Deployment::findOne($deploymentId);
            $parameter = Parameter::findOne($parameterId);
            if (!$deployment || !$parameter)
            {
                $this->error('您要编辑的内容不存在', '/deployment/config-list');
            }
            $deploymentConfig = DeploymentConfig::find()->where(array("deployment_id" => $deploymentId, "parameter_id" => $parameterId))->one();
            if (!$deploymentConfig)
            {
                $this->error('您要编辑的内容不存在', '/deployment/config-list');
            }

            return $this->render('configedit', array("deployment" => $deployment, "parameter" => $parameter, "value" => $deploymentConfig->value));
        }

    }

    /**
     * 保存部署位置配置
     */
    public function actionConfigSave()
    {
        $deploymentId = yii::$app->getRequest()->post('deployment_id');
        $parameterId = yii::$app->getRequest()->post('parameter_id');
        $parameterValue = yii::$app->getRequest()->post('parameter_value');

        if (empty($deploymentId) || empty($parameterId))
        {
            $this->newajaxReturn(self::STATUS_FAILS, array(), '请求参数有误!');
        }
        $valueType = Parameter::findOne($parameterId)->value_type;
        //value_type为string 的参数，参数值允许为空
        if ($valueType != "string" && empty($parameterValue))
        {
            $this->newajaxReturn(self::STATUS_FAILS, array(), '请求参数有误!');
        }
        //查找deploymentConfig判断请求为新增还是编辑
        $deploymentConfig = DeploymentConfig::find()->where(array("deployment_id" => $deploymentId, "parameter_id" => $parameterId))->one();
        if (!$deploymentConfig)
        {
            //新增配置
            $deploymentConfig = new DeploymentConfig();
            $deploymentConfig->deployment_id = $deploymentId;
            $deploymentConfig->parameter_id = $parameterId;
        }
        $deploymentConfig->value = $parameterValue;

        if ($deploymentConfig->save())
        {
            $this->newajaxReturn(self::STATUS_SUCCESS, array(), '保存成功!');
        }

        $this->newajaxReturn(self::STATUS_FAILS, array(), '保存失败!');
    }

    /**
     * 删除部署位置配置
     */
    public function actionConfigDelete()
    {
        $deploymentId = yii::$app->getRequest()->post('deployment_id');
        $parameterId = yii::$app->getRequest()->post('parameter_id');

        if (empty($deploymentId) || empty($parameterId))
        {
            $this->newajaxReturn(self::STATUS_FAILS, '', '请求参数有误!');
        }

        $deploymentConfig = deploymentConfig::find()->where(array("deployment_id" => $deploymentId, "parameter_id" => $parameterId))->one();

        if (!$deploymentConfig)
        {
            $this->newajaxReturn(self::STATUS_FAILS, '', '未找到相关配置!');
        }

        if ($deploymentConfig->delete())
        {
            $this->newajaxReturn(self::STATUS_SUCCESS, array(), '删除成功!');
        }

        $this->newajaxReturn(self::STATUS_FAILS, '', '删除失败!');
    }

}
