<?php
namespace app\controllers;
/**
 * Description of IndexController
 * 默认控制器类
 * @author zhaolu@playcrab.com
 */
use yii;
use yii\web\Controller;
use app\models\Version;
use app\models\Platform;
use app\models\Deployment;
use app\models\DynamicConfig;
use app\models\Worker;
use yii\helpers\ArrayHelper;
use app\models\Package;
use yii\db\Connection as Connection;
use yii\helpers\Url;
class TaskController extends BaseController
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
//         //获得版本号
//         $versionId = yii::$app->getRequest()->get("version_id");
//         $version = Version::findOne($versionId);
// //            $this->error('参数错误', Url::toRoute('index/index'));
        
//         if(!$version)
//         {
//            die("版本id错误！");   
//         }
//         $versionData = ArrayHelper::toArray($version);
//         var_dump($versionData);
//         $platformId   = $versionData['platform_id'];
//         $upgradPathId = $versionData['upgrade_path_id'];
        
//         //获得平台下的发布位置
//         $deploymentList = Deployment::find()->where("platform_id=:platform_id",array(":platform_id"=>$platformId))->all();
//         if(!$deploymentList)
//         {
//             die("平台下无发布位置！");
//         }
//         $deploymentListData = ArrayHelper::toArray($deploymentList);
        
//         //获得平台下的安装包
//         $packageList = Package::find()->where("platform_id=:platform_id and disable=0",array(":platform_id"=>$platformId))->all();
//         if(!$packageList)
//         {
//             die("平台下无安装包！");
//         }
//         $packageListData = ArrayHelper::toArray($packageList);
//         var_dump($packageListData);
        
//         //获得升级序列下的30天发布的已上线版本列表
//         $startDate = date('Y-m-d 00:00:00' , strtotime('-30 day'));
//         $endDate = date('Y-m-d H:i:s' , time());
//         $versionUpdateList = Version::find()->where("upgrade_path_id=:upgrade_path_id and released=1",array(":upgrade_path_id"=>$upgradPathId))
//             ->andWhere(['>','release_time',$startDate])
//             ->andWhere(['<=','release_time',$endDate])->all();
//         $versionUpdateListData = array();
//         if($versionUpdateList)
//         {
//             $versionUpdateListData= ArrayHelper::toArray($versionUpdateList);
//         }
//         var_dump($versionUpdateListData);
//         //获得动态参数
//         $dynamicConfigList = DynamicConfig::find()->all();
//         $dynamicConfigListData = array();
//         if($dynamicConfigList)
//         {
//             $dynamicConfigListData= ArrayHelper::toArray($dynamicConfigList);
//         }
//         var_dump($dynamicConfigListData);
//         //获得空闲打包机
//         $workerList = Worker::find()->where("disable=0")->all();
//         if(!$workerList)
//         {
//             die("平台下无安装包！");
//         }

//         $workerListData= ArrayHelper::toArray($workerList);
//         var_dump($workerListData);
//         //随机选择空闲的一台打包机
//         $randMax   = count(workerListData);
//         $randIndex = rand(0,$randMax-1);
//         $freeWorker  = $workerListData[$randIndex];

//         $data['version']           = $versionData;
//         $data['deploymentList']    = $deploymentListData;
//         $data['packageList']       = $packageListData;
//         $data['versionUpdateList'] = $versionUpdateListData;
//         $data['dynamicConfigList'] = $dynamicConfigListData;
//         $data['workerList']        = $workerListData;
//         $data['freeWorker']        = $freeWorker;
        
//         var_dump($data);die;
        return $this->render('publish');
    }
    
    /**
     *  确认发布任务
     * @return
     */
    public function actionRepublish()
    {
        //return 'test yii2';
        $params = yii::$app->getRequest()->post();
    
        return $this->render('republish');
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
    
    /**
     * ajax发布任务
     * @return
     */
    public function actionJpublish()
    {
        //获得版本号
        $version_id = yii::$app->getRequest()->get("version_id");
    }
    
}
