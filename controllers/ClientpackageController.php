<?php
namespace app\controllers;
/**
 * Description of IndexController
 * 客户端安装包下载控制器类
 * @author zhaolu@playcrab.com
 */
use yii;
use yii\web\Controller;
use app\controllers\BaseController;
use app\models\Version;
use app\models\Platform;
use app\models\Region;
use app\models\Job;
use app\models\ClientUpdatePackage;
use app\models\UpgradePath;
use yii\data\Pagination;
use app\models\Deployment;
use app\models\ClientPackage;
use app\models\Package;
use app\models\Parameter;
use app\models\PackageConfig;

class ClientpackageController extends BaseController
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * 安装包下载列表
     * @return type
     */
    public function actionList()
    {
    	$platform = Platform::getAllPlatform();
        $upgradePath = UpgradePath::getAbleUpgradepath();
        $deployment = Deployment::find()->where(['disable' => 0])->all();
        
        $vid = $platform_id = $upgrade_path_id = $create_user = $deployment_id = '';
        $params = yii::$app->getRequest()->get();
        
        $sql = 'select a.url,a.deployment_id,b.* from client_package as a inner JOIN version as b on a.version_id=b.id ';
        $countSql = 'select count(a.id) as count from client_package as a inner JOIN version as b on a.version_id=b.id ';
        if(isset($params['vid']) && !empty($params['vid']))
        {
            $sql .= ' and a.version_id=' . (int)$params['vid'];
            $countSql .= ' and a.version_id=' . (int)$params['vid'];
            $vid = $params['vid'];
        }
     
        if(isset($params['platform_id']) && !empty($params['platform_id']))
        {
            $sql .= ' and b.platform_id=' . $params['platform_id'];
            $countSql .= ' and b.platform_id=' . $params['platform_id'];
            $platform_id = $params['platform_id'];
        }

        if(isset($params['upgrade_path_id']) && !empty($params['upgrade_path_id']))
        {
            $sql .= ' and b.upgrade_path_id=' . $params['upgrade_path_id'];
            $countSql .= ' and b.upgrade_path_id=' . $params['upgrade_path_id'];
            $upgrade_path_id = $params['upgrade_path_id'];
        }
        if(isset($params['deployment_id']) && !empty($params['deployment_id']))
        {
            $sql .= ' and a.deployment_id=' . $params['deployment_id'];
            $countSql .= ' and a.deployment_id=' . $params['deployment_id'];
            $deployment_id = $params['deployment_id'];
        }
        $sql.=" order by id desc";
        $res = Clientpackage::findBySql($countSql)->asArray()->all();
        $totalCount = $res[0]['count']; 

        $pages = new Pagination(['totalCount' =>$totalCount,'pageSize'=>10]);
        $sql .= " limit " . $pages->offset . "," . $pages->limit;
 
     	$models = Clientpackage::findBySql($sql)->asArray()->all();
 		foreach ($models as $k => $v) 
        {
 			$up = UpgradePath::find()->where('id=' . $v['upgrade_path_id'])->one();
 			$de = Deployment::find()->where('id=' . $v['deployment_id'])->one();
            $pl = Platform::find()->where('id=' . $v['platform_id'])->with('region')->asArray()->one();

 			$models[$k]['upgrade_name'] = $up['name'];
 			$models[$k]['deployment_name'] = $de['name'];
            $models[$k]['platform_name'] = $pl['name'];
            $models[$k]['region_name'] = $pl['region']['name'];
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
    }


    
    public function actionRequest(){ 
        $url=yii::$app->getRequest()->post('url_info');
        $curl = curl_init(); 
        curl_setopt($curl, CURLOPT_URL, $url); 
        curl_setopt($curl, CURLOPT_FILETIME, true); 
        curl_setopt($curl, CURLOPT_NOBODY, true); 
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); 
        $header = curl_exec($curl); 
        $info = curl_getinfo($curl); 
        curl_close($curl); 
        $this->ajaxReturn($info['http_code'],array('msg'=>'ok'));

    }   



}
