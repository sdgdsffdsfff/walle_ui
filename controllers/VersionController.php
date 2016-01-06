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
use app\models\Module;
use app\models\ModuleTag;
use app\models\UpgradePath;
use app\models\ModuleAvailableTag;

class VersionController extends BaseController
{
    const STATUS_SUCCESS = 10000;
    const STATUS_FAILS = 40004;
    
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
            'create_user' => 'luis',
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
            $this->error('参数错误!', '/version/add-version');
        }
        
        $bool = Version::modifyChangeLog($versionId, $changeLog);
        if($bool)
        {
            return $this->redirect('/task/publish?version_id='.$versionId);
        }
        else
        {
            $this->error500();
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
                'tag' => empty($result['tag']) ? 'null' : $result['tag'],
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
        
        echo $this->ajaxReturn(self::STATUS_SUCCESS, $return);
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
            //生成验证规则
            $rules .= <<<EOT
new_{$module['name']}: { required: true },\r\n
EOT;

            //生成验证信息
            if((strtolower($module['name']) == 'asset' || strtolower($module['name']) == 'config') && ($module['repo_type'] == 'SVN'))
            {
                $messages .= <<<EOT
new_{$module['name']}: { required: "请输入{$module['name']}" },\r\n
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
        public function actionReleased(){
      $id= yii::$app->getRequest()->post('id');
      $release_time=yii::$app->getRequest()->post('release_time');
      if($id&&$release_time){
        $info = Version::findOne($id);
        $info->released = 1;
        $info->release_time = $release_time;
        $info->update();
        echo $this->ajaxReturn(1,'设置成功');
      }else{
         echo $this->ajaxReturn(0,'参数不全');
      }
    }
}
