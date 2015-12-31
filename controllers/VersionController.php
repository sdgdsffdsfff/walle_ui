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
    
    public function actionList()
    {   
    	return $this->render('list');
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
