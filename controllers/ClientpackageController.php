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
use app\models\clientpackage;

class ClientpackageController extends BaseController
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionList(){
    	$platform=Platform::getAllPlatform();
        $upgradePath=UpgradePath::getAbleUpgradepath();
        $deployment=Deployment::find()->all();
        $vid=$platform_id=$upgrade_path_id=$create_user=$deployment_id='';
        $params = yii::$app->getRequest()->get();
        $sql='select a.url,a.deployment_id,b.* from client_package as a inner JOIN version as b on a.version_id=b.id ';
        $countSql='select count(a.id) as count from client_package as a inner JOIN version as b on a.version_id=b.id ';
        if(isset($params['vid'])&&!empty($params['vid'])){
          $sql.=' and a.version_id='.(int)$params['vid'];
          $countSql.=' and a.version_id='.(int)$params['vid'];
          $vid=$params['vid'];
        }
     
         if(isset($params['platform_id'])&&!empty($params['platform_id'])){
          $sql.=' and b.platform_id='.$params['platform_id'];
          $countSql.=' and b.platform_id='.$params['platform_id'];
          $platform_id=$params['platform_id'];
        }

         if(isset($params['upgrade_path_id'])&&!empty($params['upgrade_path_id'])){
          $sql.=' and b.upgrade_path_id='.$params['upgrade_path_id'];
          $countSql.=' and b.upgrade_path_id='.$params['upgrade_path_id'];
          $upgrade_path_id=$params['upgrade_path_id'];
        }
           if(isset($params['deployment_id'])&&!empty($params['deployment_id'])){
          $sql.=' and a.deployment_id='.$params['deployment_id'];
           $countSql.=' and a.deployment_id='.$params['deployment_id'];
          $deployment_id=$params['deployment_id'];
        }

        
       
        $res=Clientpackage::findBySql($countSql)->asArray()->all();
        $totalCount = $res[0]['count']; 

        $pages = new Pagination(['totalCount' =>$totalCount,'pageSize'=>10]);
        $sql.=" limit ".$pages->offset.",".$pages->limit;
 
     	$models=Clientpackage::findBySql($sql)->asArray()->all();
 		foreach ($models as $k=>$v) {

 			$up=UpgradePath::find()->where('id='.$v['upgrade_path_id'])->one();
 			$de=Deployment::find()->where('id='.$v['deployment_id'])->one();
 			$models[$k]['upgrade_name']=$up['name'];
 			$models[$k]['deployment_name']=$de['name'];
 		}
   
      $pageCount=$pages->pageCount;
        
         return $this->render('list',[
         'models' => $models,
         'pages' => $pages,
         'platform' => $platform,
         'upgradePath' => $upgradePath,
         'vid'=>$vid,
         'platform_id'=>$platform_id,
         'upgrade_path_id'=>$upgrade_path_id,
         'deployment_id'=>$deployment_id,
         'create_user'=>$create_user,
         'pageCount'=>$pageCount,
         'totalCount'=>$totalCount,
         'deployment'=>$deployment
         ]);
    	return $this->render('list');
    }
}
