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
          $info->name = $name;
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
        $regions = Region::find()->addSelect(array('id', 'name'))->asArray()->all();
        //获取parameter
        $parameters = Parameter::find()->addSelect(array('id', 'name', 'description'))->asArray()->all();
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
        if (empty($regionId))
        {
            //查找全部region
        
        }
        else
        {
            $region = Region::findOne($regionId);
        
        }
        if (empty($parameterId))
        {
            //查找全部parameter
        }
        else
        {
        
        }

        return $this->render('configedit');
    }

}
