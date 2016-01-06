<?php
namespace app\controllers;
/**
 * Description of IndexController
 * 版本控制器类
 * @author zhaolu@playcrab.com
 */
use yii;
use yii\helpers\ArrayHelper;
use app\models\Version;
use app\models\Platform;
use app\models\Module;
use app\models\ModuleTag;
use app\models\UpgradePath;
use yii\data\Pagination;


class VersionController extends BaseController
{
    const STATUS = 10000;
    
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * 创建版本
     * @return type
     */
    public function actionAddVersion()
    {
        //获取全部可用模块
        $modules = Module::getAllDatas();
        //获取全部平台,区域信息
        $platforms = Platform::getAllPlatform();
        //获取全部升级序列
        $upgradePaths = UpgradePath::getAbleUpgradepath();

        if(yii::$app->getRequest()->isPost)
        {
            $versionId = yii::$app->getRequest()->post('version_id');
            if(empty($versionId))
            {
                $this->error('参数错误!', '/version/add-version');
            }

            //获取版本相关信息
            $this->getCurrentVersion($versionId, $modules);
        }

        return $this->render('addversion',[
            'module_list' => $modules,
            'platform_list' => $platforms,
            'upgradePath_list' => ArrayHelper::toArray($upgradePaths),
        ]);
    }
    
        
    public function actionList(){
        $platform=Platform::getAllPlatform();
        $upgradePath=UpgradePath::getAbleUpgradepath();
        $vid=$platform_id=$upgrade_path_id=$create_user=$release='';
        $params = yii::$app->getRequest()->get();
        $sql='1=1';
        if(isset($params['vid'])&&!empty($params['vid'])){
          $sql.=' and id='.$params['vid'];
          $vid=$params['vid'];
        }

        if(isset($params['release'])&&!empty($params['release'])){
          if($params['release']==2){$sql.=' and released=0';}else{
             $sql.=' and released='.$params['release'];
          }
         
          $release=$params['release'];
        }
         if(isset($params['platform_id'])&&!empty($params['platform_id'])){
          $sql.=' and platform_id='.$params['platform_id'];
          $platform_id=$params['platform_id'];
        }
         if(isset($params['upgrade_path_id'])&&!empty($params['upgrade_path_id'])){
          $sql.=' and upgrade_path_id='.$params['upgrade_path_id'];
          $upgrade_path_id=$params['upgrade_path_id'];
        }
         if(isset($params['create_user'])&&!empty($params['create_user'])){
          $sql.=" and create_user='".$params['create_user']."'";
          $create_user=$params['create_user'];
        }
        $object = Version::find()->where($sql)->orderBy('id DESC');
        $countQuery = clone $object;
        $totalCount=$countQuery->count();
        $pages = new Pagination(['totalCount' =>$totalCount,'pageSize'=>10]);
 
        $models = $object->select(['id','platform_id','upgrade_path_id','create_time', 'create_user', 'change_log','released','release_time'])
        ->offset($pages->offset)
        ->limit($pages->limit)
        ->with('upgradePath')
        ->with('platform')
        ->asArray()
        ->all();
   
      $pageCount=$pages->pageCount;
        
         return $this->render('list',[
         'models' => $models,
         'pages' => $pages,
         'platform' => $platform,
         'upgradePath' => $upgradePath,
         'vid'=>$vid,
         'platform_id'=>$platform_id,
         'upgrade_path_id'=>$upgrade_path_id,
         'create_user'=>$create_user,
         'pageCount'=>$pageCount,
         'totalCount'=>$totalCount,
         'release'=>$release
         ]);
    }
    
    //版本详情
    public function actionVersionDetail()
    {
        return $this->render('versiondetail');
    }
    
    /**
     * 根据版本id,获取版本和各模块相关信息
     * @param int $versionId 版本id
     * @param array $modules 模块相关信息
     */
    private function getCurrentVersion($versionId, $modules)
    {
        //根据版本id获取版本信息
        $versionInfo = Version::getDataById($versionId);
        //根据平台id获取平台信息
        $platformInfo = Platform::getDataById($versionInfo['platform_id']);
        
        //获取模块版本信息
        $moduleTag_array = array();
        foreach ($modules as $value)
        {
            $result = ModuleTag::getModuleTagByVersionIdAndModuleId($versionId, $value['id']);
            $moduleTag_array[] = [
                'name' => $value['name'],
                'tag' => empty($result['tag']) ? 'null' : $result['tag'],
            ];
        }
        
        $return = array(
            'region_name' => $platformInfo['region']['name'],
            'platform_name' => $platformInfo['name'],
            'upgrade_name' => $versionInfo['upgradePath']['name'],
            'module_tags' => $moduleTag_array,
        );
        
        echo $this->ajaxReturn(self::STATUS, $return);
    }
}
