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
use app\models\UpgradePathConfig;
use yii\data\Pagination;
use app\models\Deployment;
use app\models\Clientpackage;


class UpgradepathController extends BaseController
{
	 /**
    * [升级序列列表页]
    * @return [type] [description]
    */
    public function actionList()
    {	 $data=array();
       $data=UpgradePath::find()->asArray()->all();
       return $this->render('list',array('data'=>$data));
    }
    /**
     * [升级序列新增编辑页]
     * @return [type] [description]
     */
   public function actionEdit()
    { $info=array();
      $id = yii::$app->getRequest()->get('id');
      if($id){
        $info=UpgradePath::findOne($id);
        if(!$info){
          $this->error('您要编辑的内容不存在', '/upgradepath/list');
        }
      }
       return $this->render('edit',array('info'=>$info,'id'=>$id));
    }
    /**
     * [升级序列编辑保存操作]
     * @return [type] [description]
     */
    public function actionDoedit(){
      $id = yii::$app->getRequest()->post('id');
      $name = yii::$app->getRequest()->post('name');
      $description = yii::$app->getRequest()->post('description');
      $disable = yii::$app->getRequest()->post('disable');
      if($name&&$description){
        $sameName=UpgradePath::find()->where(array('name'=>$name))->one();
        if($sameName){
          $this->ajaxReturn(self::STATUS_FAILS, '该名称已经存在');
        }else{
          if($id){
          $info = UpgradePath::findOne($id);
          $info->name = $name;
          $info->description = $description;
          $info->disable=$disable;
          $info->save();
         
        }else{
          $info = new UpgradePath();
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
     * [复制升级序列操作]
     * @return [type] [description]
     */
     public function actionDocopy(){
      $cid=yii::$app->getRequest()->post('id');
      $name = yii::$app->getRequest()->post('name');
      $description = yii::$app->getRequest()->post('description');
      $disable = yii::$app->getRequest()->post('disable');
      if($cid&&$name&&$description){
        $sameName=UpgradePath::find()->where(array('name'=>$name))->one();
        if($sameName){
          $this->ajaxReturn(self::STATUS_FAILS, '该名称已经存在');
        }else{
          
          $info = new UpgradePath();
          $info->name = $name;
          $info->description = $description;
          $info->disable=$disable;
          $info->insert();
          $id=$info->attributes['id'];
          $config=UpgradePathConfig::find()->where(array('upgrade_path_id'=>$cid))->asArray()->all();
          if($config){
               foreach ($config as $v) {
            $up=new UpgradePathConfig();
            $up->upgrade_path_id=$id;
            $up->parameter_id=$v['parameter_id'];
            $up->value=$v['value'];
            $up->insert();
          }
          }
       
        
          $this->ajaxReturn(self::STATUS_SUCCESS,'保存成功');
        }
        
      }else{
        $this->ajaxReturn(self::STATUS_FAILS, '缺少参数');
      }
    }
    /**
     * [复制升级序列页]
     * @return [type] [description]
     */
     public function actionCopy()
    {   $info=array();
      $id = yii::$app->getRequest()->get('id');
      if($id){
        $info=UpgradePath::findOne($id);
        if(!$info){
          $this->error('您要编辑的内容不存在', '/upgradepath/list');
        }
      }
       return $this->render('copy',array('info'=>$info,'id'=>$id));
    }
}
