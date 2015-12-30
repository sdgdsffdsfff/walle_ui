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
use yii\helpers\ArrayHelper;
use app\models\Package;
use yii\db\Connection as Connection;
class TaskController extends Controller
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
        
//         if(!$version)
//         {
//            die("版本id错误！");   
//         }
//         $versionData = ArrayHelper::toArray($version);
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
//         $versionList = ArrayHelper::toArray($packageList);
//         var_dump($packageListData);
        
//         //获得升级序列下的30天发布的已上线版本列表
//         $startDate = date('Y-m-d 00:00:00' , strtotime('-30 day'));
//         $endDate = date('Y-m-d H:i:s' , time());
//         $versionList = Version::find()->where("upgrade_path_id=:upgrade_path_id and released=1",array(":upgrade_path_id"=>$upgradPathId))
//             ->andWhere(['>','release_time',$startDate])
//             ->andWhere(['<=','release_time',$endDate])->all();
//         $versionListData = array();
//         if($versionList)
//         {
//             $versionListData= ArrayHelper::toArray($versionList);
//         }
//         var_dump($versionListData);
        //获得动态参数
        
        //获得空闲打包机
        
        //随机选择空闲的一台打包机
        
        
        
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
