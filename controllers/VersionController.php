<?php
namespace app\controllers;
/**
 * Description of IndexController
 * 版本控制器类
 * @author zhaolu@playcrab.com
 */
use yii;
use yii\helpers\ArrayHelper;
use yii\data\Pagination;
use app\models\Version;
use app\models\Platform;
use app\models\Deployment;
use app\models\Region;
use app\models\Module;
use app\models\ModuleTag;
use app\models\UpgradePath;
use app\models\ModuleAvailableTag;
use app\models\ClientUpdatePackage;

class VersionController extends BaseController
{   
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
        //获取子模块下拉列表的值;
        $moduleAvailableTags = $this->getModuleAvailableTag($modules);
        //生成子模块验证的js脚本
        $jsArray = $this->generateJS($modules);
        
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
            'moduleAvailableTag_list' => $moduleAvailableTags,
            'rules' => $jsArray['rules'],
            'messages' => $jsArray['messages'],
            'changes' => $jsArray['changes'],
        ]);
    }
    
    /**
     * 版本列表
     * @return type
     */    
    public function actionList()
    {
        $platform = Platform::getAllPlatform();
        $upgradePath = UpgradePath::getAbleUpgradepath();
        
        $vid = $platform_id = $upgrade_path_id = $create_user = $release = '';
        $params = yii::$app->getRequest()->get();
        $sql = '1=1';
        if(isset($params['vid']) && !empty($params['vid']))
        {
            $sql .= ' and id='.(int)$params['vid'];
            $vid = $params['vid'];
        }

        if(isset($params['release']) && !empty($params['release']))
        {
            if($params['release'] == 2)
            {
                $sql .= ' and released=0';
                
            }
            else
            {
                $sql .= ' and released='.$params['release'];
            }
         
            $release = $params['release'];
        }
        if(isset($params['platform_id']) && !empty($params['platform_id']))
        {
            $sql .= ' and platform_id='.$params['platform_id'];
            $platform_id = $params['platform_id'];
        }
        if(isset($params['upgrade_path_id']) && !empty($params['upgrade_path_id']))
        {
            $sql .= ' and upgrade_path_id='.$params['upgrade_path_id'];
            $upgrade_path_id = $params['upgrade_path_id'];
        }
        if(isset($params['create_user']) && !empty($params['create_user']))
        {
            $sql .= " and create_user='".$params['create_user']."'";
            $create_user = $params['create_user'];
        }
        $object = Version::find()->where($sql)->orderBy('id DESC');
        $countQuery = clone $object;
        $totalCount = $countQuery->count();
        $pages = new Pagination(['totalCount' =>$totalCount,'pageSize'=>10]);
 
        $models = $object->select(['id','platform_id','upgrade_path_id','create_time', 'create_user', 'change_log','released','release_time'])
                        ->offset($pages->offset)
                        ->limit($pages->limit)
                        ->with('upgradePath')
                        ->with('platform')
                        ->asArray()
                        ->all();
        foreach ($models as $k => $v) 
        {
            $res=ModuleTag::find()->where('version_id='.$v['id'])->select(['version_id','module_id','tag'])
                            ->with('module')
                            ->asArray()
                            ->all();
            $region=Region::find()->where('id='.$v['platform']['region_id'])->select(['name'])
            ->asArray()
            ->one();
            $models[$k]['modules']=$res;
            $models[$k]['region']=$region['name'];
        }

        $pageCount = $pages->pageCount;
        
        return $this->render('list',[
            'models' => $models,
            'pages' => $pages,
            'platform' => $platform,
            'upgradePath' => $upgradePath,
            'vid' => $vid,
            'platform_id' => $platform_id,
            'upgrade_path_id' => $upgrade_path_id,
            'create_user' => $create_user,
            'pageCount' => $pageCount,
            'totalCount' => $totalCount,
            'release' => $release
        ]);
    }
    
    /**
     * 导入版本信息的操作
     */
    public function actionImportVersion()
    {
        $versionId = yii::$app->getRequest()->post('version_id');
        if(empty($versionId))
        {
            $this->error('参数错误!', '/version/add-version');
        }
        
        //获取全部可用模块
        $modules = Module::getAllDatas();
        //获取版本相关信息
        $this->getCurrentVersion($versionId, $modules);
    }
    
    /**
     * 创建版本信息
     */
    public function actionCreateVersion()
    {
        $post = yii::$app->getRequest()->post();
        
        $url = '/version/add-version';
        if(!isset($post['new_platform']) || empty($post['new_platform']))
        {
            $this->error('平台参数错误!', $url);
        }
        if(!isset($post['new_upgrade_path']) || empty($post['new_upgrade_path']))
        {
            $this->error('升级序列参数错误!', $url);
        }
        
        //获取全部可用模块
        $modules = Module::getAllDatas();
        foreach ($modules as $moudle)
        {
            //子模块数据验证
            if(!isset($post["new_{$moudle['name']}"]) || empty($post["new_{$moudle['name']}"]))
            {
                $this->error($moudle['name'].'参数错误!', $url);
                die;
            }
        }
        
        //新建版本信息
        $version_data = array(
            'platform_id' => $post['new_platform'],
            'upgrade_path_id' => $post['new_upgrade_path'],
            'create_user' => yii::$app->getUser()->getIdentity()->account,
            'change_log' => $post['changelog'],
        );
        $bool_version = Version::createVersion($version_data);
        if($bool_version)
        {
            //新建子模块信息
            $moduleTag_data = array();
            $i = 0;
            foreach ($modules as $module)
            {
                $key = 'new_'.strtolower($module['name']);
                if(!isset($post[$key]))
                {
                    continue;
                }
                
                $moduleTag_data['version_id'] = $bool_version;
                $moduleTag_data['module_id'] = $module['id'];
                $moduleTag_data['tag'] = $post[$key];
                $bool_moduleTag = ModuleTag::CreateModuleTag($moduleTag_data);
                if($bool_moduleTag)
                {
                    $i++;
                }
            }
        }

        if(!$bool_version || $i != count($modules))
        {
            $this->ajaxReturn(self::STATUS_FAILS, array('msg' => 'fails'));
        }
        else 
        {
            $this->ajaxReturn(self::STATUS_SUCCESS, array('msg' => 'success', 'version_id' => $bool_version));
        }
    }
    
    /**
     * 版本详情
     * @return type
     */
    public function actionVersionDetail()
    {
        $versionId = yii::$app->getRequest()->get('version_id');
        
        //获取全部可用模块
        $modules = Module::getAllDatas();
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
                'description' => $value['description'],
            ];
        }

        return $this->render('versiondetail', [
            'moduleTags' => $moduleTag_array,
            'versionInfo' => $versionInfo,
            'platformInfo' => $platformInfo,
            'versionId' => $versionId,
        ]);
    }
    
    /**
     * 更新版本changeLog
     * @return type
     */
    public function actionModify()
    {
        $post = yii::$app->getRequest()->post();
        $versionId = $post['version_id'];
        $changeLog = $post['changelog'];
        
        if(empty($versionId))
        {
            $this->ajaxReturn(self::STATUS_FAILS, array('result' => 'fails', 'msg' => '参数错误!'));
        }
        
        $bool = Version::modifyChangeLog($versionId, $changeLog);
        if($bool)
        {
            $this->ajaxReturn(self::STATUS_SUCCESS, array('result' => 'success', 'msg' => '更新changLog成功!'));
        }
        else
        {
            $this->ajaxReturn(self::STATUS_FAILS, array('result' => 'fails', 'msg' => '更新changLog失败!'));
        }
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
                'module_id' => $value['id'],
                'name' => $value['name'],
                'tag' => $result['tag'],
                'module_type' => $value['repo_type'],
            ];
        }
        
        $return = array(
            'region_name' => $platformInfo['region']['name'],
            'region_id' => $platformInfo['region']['id'],
            'platform_name' => $platformInfo['name'],
            'platform_id' => $platformInfo['id'],
            'upgrade_name' => $versionInfo['upgradePath']['name'],
            'upgrade_id' => $versionInfo['upgrade_path_id'],
            'module_tags' => $moduleTag_array,
        );
        
        $this->ajaxReturn(self::STATUS_SUCCESS, $return);
    }
    
    /**
     * 根据模块信息,获取模块相应的tag列表
     * @param array $modules 模块信息
     * @return array
     */
    private function getModuleAvailableTag($modules)
    {
        $return = array();
        foreach ($modules as $value)
        {
            $result = ModuleAvailableTag::getModuleAvailableTagByModuleId($value['id']);
            if(empty($result))
            {
                continue;
            }
            
            foreach($result as $tag)
            {
                if($tag['module_id'] == $value['id'])
                {
                    $return[$tag['module_id']][] = $tag['tag'];
                }
            }
        }
        
        return $return;
    }
    
    /**
     * 生成验证的js
     * @param array $modules 子模块数组
     * @return array
     */
    private function generateJS($modules)
    {
        $rules = $messages = $changes = '';
        foreach($modules as $module)
        {
            //生成验证规则,SVN类型只能输入正整数
            if((strtolower($module['name']) == 'asset' || strtolower($module['name']) == 'config') && ($module['repo_type'] == 'SVN'))
            {
                $rules .= <<<EOT
new_{$module['name']}: { required: true, digits: true },\r\n
EOT;
            }
            else
            {
                $rules .= <<<EOT
new_{$module['name']}: { required: true },\r\n
EOT;
            }

            //生成验证信息
            if((strtolower($module['name']) == 'asset' || strtolower($module['name']) == 'config') && ($module['repo_type'] == 'SVN'))
            {
                $messages .= <<<EOT
new_{$module['name']}: { required: "请输入{$module['name']}", digits: "请输入正整数" },\r\n
EOT;
            }
            else
            {
                $messages .= <<<EOT
new_{$module['name']}: { required: "请选择{$module['name']}" },\r\n
EOT;
            }
            
            //生成选中或输入值时,再次验证
            $changes .= <<<EOT
$("#new_{$module['name']}").change(function(){ $(this).valid(); });\r\n
EOT;
        }
        
        return array(
            'rules' => $rules, 
            'messages' => $messages, 
            'changes' => $changes
        );
    }
    
    /**
     * 设置上线时间
     */
    public function actionReleased()
    {
        $id = yii::$app->getRequest()->post('id');
        $release_time = yii::$app->getRequest()->post('release_time');
        if($id && $release_time)
        {
            $info = Version::findOne($id);
            $info->released = 1;
            $info->release_time = $release_time;
            $info->update();
            
            $this->ajaxReturn(self::STATUS_SUCCESS,'设置成功');
        }
        else
        {
             $this->ajaxReturn(self::STATUS_FAILS,'参数不全');
        }
    }

    /**
     * 版本对比
     */
    public function actionCompare()
    {
        $oldVersionId = yii::$app->getRequest()->get('old_version_id');
        $newVersionId = yii::$app->getRequest()->get('new_version_id');
        if (empty($oldVersionId) && empty($newVersionId))
        {
            return $this->render('compare');
        }
        //通过version_id查找version详情
        $oldVersionInfo = Version::getVersionDetial($oldVersionId);
        $newVersionInfo = Version::getVersionDetial($newVersionId);
        if (empty($oldVersionInfo) || empty($newVersionInfo))
        {
            $this->error('请求参数异常!', '/version/compare');
        }

        //获取客户端更新包
        $clientUpdatePackages = ClientUpdatePackage::getUpdatePackages($oldVersionId, $newVersionId);
        $clientUpdatePackageList = array();
        if (!empty($clientUpdatePackages))
        {
            $gameAlias = yii::$app->session->get('game_alias');
            foreach ($clientUpdatePackages as $clientUpdatePackage)
            {
                $tmp['url'] = yii::$app->params['uploadPath'].$gameAlias."/client_update_package/".$clientUpdatePackage['url'];
                $tmp['size'] = $clientUpdatePackage['size'];
                array_push($clientUpdatePackageList, $tmp);
            }
        }
        //计算改动文件详情
        $updateFileList = array();
        //分类型计算文件改动数量
        $updateStatistics = array();
        $totalNum = 0;
        $totalSize = 0;
        //计算asset、script、config 三种类型的改动文件
        $typeArr = array("asset", "script", "config");//如果类型名称改变这里需要改变，最好定义为const
        foreach ($typeArr as $type)
        {
            if (empty($oldVersionInfo['module'][$type]) || empty($newVersionInfo['module'][$type]))
            {
                $this->error('请求参数异常!', '/version/compare');
            }
            $updateFileList[$type] = $this->countUpdateFiles($type, $oldVersionInfo['upgrade_path_id'], $oldVersionInfo['module'][$type], $newVersionInfo['module'][$type]);
            if ($updateFileList[$type] === false)
            {
                $this->error('sql计算失败!', '/version/compare');
            }
            $num = 0;
            $size = 0;
            if (!empty($updateFileList[$type]))
            {
                foreach ($updateFileList[$type] as $fileDetial)
                {
                    $num++;
                    $size += $fileDetial['size'];
                }
            }
            $updateStatistics[$type]['num'] = $num;
            $updateStatistics[$type]['size'] = $size;
            $totalNum += $num;
            $totalSize += $size;
        }

        $data = array(
            "oldVersionInfo" => $oldVersionInfo,
            "newVersionInfo" => $newVersionInfo,
            "clientUpdatePackageList" => $clientUpdatePackageList,
            "totalNum" => $totalNum,
            "totalSize" => $totalSize,
            "updateStatistics" => $updateStatistics,
            "updateFileList" => $updateFileList,
        );
        return $this->render('comparedetail', $data);
    }

    /**
     * 计算客户端更新文件
     * @param $type string 类型
     * @param $upgrade_path_id 升级序列
     * @param $old_module_tag 源版本模块tag
     * @param $new_module_tag 新版本模块tag
     * @return array ['filename', 'size', 'md5', 'url']
     */
    private function countUpdateFiles($type, $upgrade_path_id, $old_module_tag, $new_module_tag)
    {
        $module_id = Module::findOne(array("name" => $type))->id;
        //使用数据库连接执行sql计算语句，由于数据库根据游戏更改设置时没有定义全局使用的connection
        //这里使用自定义model基类时初始化的db
        $model = new Module();
        $connection = $model->db;
        $sql = "select n.filename, n.size, n.md5, n.url from
            (
                select * from client_module_file where
                upgrade_path_id={$upgrade_path_id} and module_id={$module_id} and module_tag='{$new_module_tag}'
            ) n
            left join
            (
                select * from client_module_file where
                upgrade_path_id={$upgrade_path_id} and module_id={$module_id} and module_tag='{$old_module_tag}'
            ) o
            ON n.filename = o.filename
            WHERE 
            o.filename is null or o.url != n.url";
        try {
            $command = $connection->createCommand($sql);
            $result = $command->queryAll();
        } catch (Exception $e) {
            return false;
        }

        if (!empty($result))
        {
            $gameAlias = yii::$app->session->get('game_alias');
            foreach ($result as &$info)
            {
                $info['url'] = yii::$app->params['uploadPath'].$gameAlias."/client_file/".$info['url'];
            }
        }
        return $result;
    }
}
