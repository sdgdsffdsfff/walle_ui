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
use app\models\UpgradePath;
use yii\data\Pagination;
use app\models\Deployment;
use app\models\Region;
use app\models\PlatformConfig;
use app\models\Parameter;


class PlatformController extends BaseController
{
    
             /**
    * [列表页]
    * @return [type] [description]
    */
    public function actionList()
    {    $data=array();
       $data=Platform::find()->with('region')->asArray()->all();
       return $this->render('list',array('data'=>$data));
    }

    /**
     * [新增编辑页]
     * @return [type] [description]
     */
   public function actionEdit()
    { 
    	$region=Region::find()->where(array('disable'=>0))->asArray()->all();
     $info=array();
      $id = yii::$app->getRequest()->get('id');
      if($id){
        $info=Platform::findOne($id);
        if(!$info){
          $this->error('您要编辑的内容不存在', '/platform/list');
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
        $sameName=Platform::find()->where(array('name'=>$name,'region_id'=>$region))->one();
        if($sameName&&$sameName['id']!=$id){
          $this->ajaxReturn(self::STATUS_FAILS, '该名称已经存在');
        }else{
          if($id){
          $info = Platform::findOne($id);
          //$info->name = $name;
          //$info->region_id=$region;
          $info->description = $description;
          $info->disable=$disable;
          $res=$info->save();
         
        }else{
          $info = new Platform();
          $info->name = $name;
          $info->region_id=$region;
          $info->description = $description;
          $info->disable=$disable;
          $res=$info->insert();
        }
          if($res){
            $this->ajaxReturn(self::STATUS_SUCCESS,'保存成功');
          }else{
            $this->ajaxReturn(self::STATUS_FAILS, '保存失败');
          }
          
        }
        
      }else{
        $this->ajaxReturn(self::STATUS_FAILS, '缺少参数');
      }
      
    }

    /**
     * 平台配置参数列表
     */
    public function actionConfigList()
    {
        //获取platform
        $platforms = Platform::find()->with('region')->where(array("disable" => 0))->asArray()->all();
        //获取parameter
        $parameters = Parameter::find()->where(array("disable" => 0))->addSelect(array('id', 'name', 'description'))->asArray()->all();
        $platformConfigs = PlatformConfig::find()->all();
        $data = array();
        if (!empty($platformConfigs))
        {
            foreach ($platformConfigs as $platformConfig)
            {
                $data[] = $platformConfig->toArray();
            }
        }

        return $this->render('configList', array("data" => $data, "platforms" => $platforms, "parameters" => $parameters));
    }

    /**
     * 平台配置参数编辑页面
     */
    public function actionConfigEdit()
    {
        $platformId = yii::$app->getRequest()->get('platform_id');
        $parameterId = yii::$app->getRequest()->get('parameter_id');
        if (empty($platfromId) && empty($parameterId))
        {
            //新增配置页面、查找全部platform和parameter
            $platformList = Platform::find()->with('region')->where(array("disable" => 0))->asArray()->all();
            $parameterList = Parameter::find()->where(array("disable" => 0))->addSelect(array('id', 'name', 'description'))->asArray()->all();

            return $this->render('configadd', array("platformList" => $platformList, "parameterList" => $parameterList));
        }
        else
        {
            //编辑已存在配置
            $platform = Platform::findOne($platformId);
            $parameter = Parameter::findOne($parameterId);
            if (!$platform || !$parameter)
            {
                $this->error('您要编辑的内容不存在', '/platform/config-list');
            }
            $platformConfig = PlatformConfig::find()->where(array("platform_id" => $platformId, "parameter_id" => $parameterId))->one();
            if (!$platformConfig)
            {
                $this->error('您要编辑的内容不存在', '/platform/config-list');
            }

            return $this->render('configedit', array("platform" => $platform, "parameter" => $parameter, "value" => $platformConfig->value));
        }

    }

    /**
     * 保存平台配置
     */
    public function actionConfigSave()
    {
        $platformId = yii::$app->getRequest()->post('platform_id');
        $parameterId = yii::$app->getRequest()->post('parameter_id');
        $parameterValue = yii::$app->getRequest()->post('parameter_value');

        if (empty($platformId) || empty($parameterId))
        {
            $this->newajaxReturn(self::STATUS_FAILS, array(), '请求参数有误!');
        }
        $valueType = Parameter::findOne($parameterId)->value_type;
        //value_type为string 的参数，参数值允许为空
        if ($valueType != "string" && empty($parameterValue))
        {
            $this->newajaxReturn(self::STATUS_FAILS, array(), '请求参数有误!');
        }
        //查找PlatformConfig判断请求为新增还是编辑
        $platformConfig = PlatformConfig::find()->where(array("platform_id" => $platformId, "parameter_id" => $parameterId))->one();
        if (!$platformConfig)
        {
            //新增配置
            $platformConfig = new PlatformConfig();
            $platformConfig->platform_id = $platformId;
            $platformConfig->parameter_id = $parameterId;
        }
        $platformConfig->value = $parameterValue;

        if ($platformConfig->save())
        {
            $this->newajaxReturn(self::STATUS_SUCCESS, array(), '保存成功!');
        }

        $this->newajaxReturn(self::STATUS_FAILS, array(), '保存失败!');
    }

    /**
     * 删除平台配置
     */
    public function actionConfigDelete()
    {
        $platform_id = yii::$app->getRequest()->post('platform_id');
        $parameterId = yii::$app->getRequest()->post('parameter_id');

        if (empty($platform_id) || empty($parameterId))
        {
            $this->newajaxReturn(self::STATUS_FAILS, '', '请求参数有误!');
        }

        $platformConfig = PlatformConfig::find()->where(array("platform_id" => $platform_id, "parameter_id" => $parameterId))->one();

        if (!$platformConfig)
        {
            $this->newajaxReturn(self::STATUS_FAILS, '', '未找到相关配置!');
        }

        if ($platformConfig->delete())
        {
            $this->newajaxReturn(self::STATUS_SUCCESS, array(), '删除成功!');
        }

        $this->newajaxReturn(self::STATUS_FAILS, '', '删除失败!');
    }
    
}
