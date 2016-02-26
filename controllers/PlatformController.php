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
        $sameName=Platform::find()->where(array('name'=>$name))->one();
        if($sameName&&$sameName['id']!=$id){
          $this->ajaxReturn(self::STATUS_FAILS, '该名称已经存在');
        }else{
          if($id){
          $info = Platform::findOne($id);
          $info->name = $name;
          $info->region_id=$region;
          $info->description = $description;
          $info->disable=$disable;
          $info->save();
         
        }else{
          $info = new Platform();
          $info->name = $name;
           $info->region_id=$region;
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
     * 平台配置参数列表
     */
    public function actionConfigList()
    {
        return $this->render('configList');
    }

    /**
     * 平台配置参数编辑页面
     */
    public function actionConfigEdit()
    {
        return $this->render('configEdit');
    }
}
