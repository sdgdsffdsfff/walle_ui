<?php
namespace app\controllers;
/**
 * Description of IndexController
 * 默认控制器类
 * @author zhaolu@playcrab.com
 */
use yii;
use app\models\Version;
use app\models\Platform;
use app\models\Deployment;
use app\models\DynamicConfig;
use app\models\Worker;
use yii\helpers\ArrayHelper;
use app\models\Package;
use app\models\Job;
use yii\helpers\Url;
use yii\data\Pagination;
use app\models\UpgradePath;
use app\models\Module;
use app\models\ModuleTag;
use app\models\PackageConfig;
use app\models\Parameter;
use app\models\Region;
use app\models\RegionConfig;
use app\models\PlatformConfig;
use app\models\DeploymentConfig;
use app\models\UpgradePathConfig;

class TaskController extends BaseController
{
    const STATUS_SUCCESS = 10000;

    public function actionIndex()
    {
        return $this->render('index');
    }
    
    /**
     * 任务状态js轮询此接口，获取当前job status and all tasks status然后渲染页面
     * @param job_id
     * @return json
     */
    public function actionJobstatus()
    {
        $job_id = yii::$app->getRequest()->post('job_id');
        if (empty($job_id))
        {
            $this->newajaxReturn(self::STATUS_FAILS, array(), "job_id不能为空！");
        }
        $job = Job::findOne($job_id);
        if (empty($job))
        {
            $this->newajaxReturn(self::STATUS_FAILS, array(), "参数错误,此Job不存在！");
        }
        $job_status = $job->status;
        $job_log_url = $job->log_url;
        $tasks = $job->tasks;
        foreach ($tasks as $task)
        {
            $job_tasks[] = ArrayHelper::toArray($task);
        }
        $data = array(
            "status" => $job_status,
            "tasks" => $job_tasks,
            "log_url" => $job_log_url,
        );
        $this->newajaxReturn(self::STATUS_SUCCESS, $data);
    }

    /**
     * kill job ajax 终止任务
     * @param job_id int
     * @return json
     */
    public function actionKilljob()
    {
        $job_id = yii::$app->getRequest()->post('job_id');
        if (empty($job_id))
        {
            $this->newajaxReturn(self::STATUS_FAILS, array(), "参数错误，执行失败！");
        }
        $job = Job::findOne($job_id);
        if (empty($job) || $job->status != 1)
        {
            $this->newajaxReturn(self::STATUS_FAILS, array(), "终止任务失败，当前任务已完成！");
        }
        $gameAlias = yii::$app->session->get('game_alias');
        //调用脚本执行kill job 
        $scriptPath = Yii::$app->params['scriptPath'];
        //log-level 固定DEBUG
        $command = "LANG=en_US.UTF-8 {$scriptPath}walle job kill \
                        --log-level DEBUG \
                        --game {$gameAlias} \
                        --job-id {$job_id}";
        exec($command, $output, $returnVar);
        //根据脚本执行结果返回前端页面
        if ($returnVar != 0)
        {
            $this->newajaxReturn(self::STATUS_FAILS, array(), "后台命令，执行失败！");
        }
        
        $this->newajaxReturn(self::STATUS_SUCCESS, array(),"终止任务成功！");
    }

    /**
     * 发布任务
     * @return 
     */
    public function actionPublish()
    {
        //获得版本号
        $versionId = yii::$app->getRequest()->get("version_id");
        $versionData           = array();
        $deploymentListData    = array();
        $packageListData       = array();
        $versionUpdateListData = array();
        
        $isVersionsUpdatePackage = true;
        $isPackageListContent = true;
        
        if(!empty($versionId))
        {
            $versionData = Version::getById($versionId);
            if(!$versionData)
            {
                $this->error('版本参数错误！', Url::toRoute('index/index'));
            }
            
            $platformId   = $versionData['platform_id'];
            $upgradPathId = $versionData['upgrade_path_id'];
            
            //获得平台下的发布位置
            $deploymentListData =Deployment::getDataByPlatformId($platformId);
            if(!$deploymentListData)
            {
//                 $this->error('平台下无发布位置！', Url::toRoute('index/index'));
            }
            //         var_dump($deploymentListData);
            
            //获得平台下安装包
            $packageListData = Package::getDataByPlatformId($platformId);
//             if(!$packageListData)
//             {
//                 $this->error('平台下无安装包！', Url::toRoute('index/index'));
//             }
            //         var_dump($packageListData);
            
            // 获得升级序列下的30天发布的已上线版本列表
            $startDate = date('Y-m-d 00:00:00', strtotime('-30 day'));
            $endDate = date('Y-m-d H:i:s', time());
            $versionUpdateListData = Version::getUpdateVersion($startDate, $endDate, $upgradPathId, $versionId);
//             if(!$versionUpdateListData)
//             {
//                  $this->error('平台下无安装包！', Url::toRoute('index/index'));
//             } 
            //         var_dump($versionUpdateListData);
        }
        
        // 获得动态参数
        $dynamicConfigListData = DynamicConfig::getData();
//         var_dump($dynamicConfigListData);
        
        //获得非禁用打包机
        $workerListData = Worker::getFreeData();
        //将空闲打包机筛选出来
        $workerList = array();
        foreach ($workerListData as $worker)
        {
            $bool = Job::getJobStatusByWorkerId($worker['id']);
            if($bool)
            {
                continue;
            }
            
            $workerList[] = $worker;
        }
        
        // 随机选择空闲的一台打包机
        $randMax = count($workerList);
        $randIndex = rand(0, $randMax-1);
        $freeWorker = $workerList[$randIndex];

//         var_dump($workerListData);

        $contentList = $this->getDynamicConfigContent($dynamicConfigListData);
        
        $data['version']                = $versionData;
        $data['deploymentList']         = $deploymentListData;
        $data['packageList']            = $packageListData;
        $data['versionUpdateList']      = $versionUpdateListData;
        $data['dynamicConfigList']      = $dynamicConfigListData;
        $data['workerList']             = $workerList;
        $data['freeWorker']             = $freeWorker;
        $data['rules']                  = $contentList['rules'];
        $data['dynamicConfigContent']   = $contentList['content'];
        $data['deploymentListContent']  = $this->getDeploymentList($deploymentListData);
        $data['packageListContent']     = $this->getPackagelist($packageListData);
        $data['versionUpdateContent']   = $this->getVersionupdatelist($versionUpdateListData);
        $data['isPackageListContent']   = $data['packageListContent']!= null? true:false;
        $data['isVersionsUpdatePackage']  = $data['versionUpdateContent']!= null? true:false;
        return $this->render('publish',['data'=>$data]);
    }
    
    /**
     * 克隆任务
     * @return Ambigous <string, string>
     */
    public function actionClonepublish()
    {
        $jobId = yii::$app->getRequest()->get("job_id");
        
        if (empty($jobId))
        {
            $this->newajaxReturn(self::STATUS_FAILS, array(), "job_id不能为空！");
        }
        $job = Job::findOne($jobId);
        if (empty($job))
        {
            $this->newajaxReturn(self::STATUS_FAILS, array(), "参数错误,此Job不存在！");
        }
        
        $jobInfo = ArrayHelper::toArray($job);
        $jobConfig = json_decode($jobInfo['job_config'], true);
//        var_dump($jobConfig);die;
        //获得版本号
        $versionId = $jobInfo['version_id'];
        $versionData           = array();
        $deploymentListData    = array();
        $packageListData       = array();
        $versionUpdateListData = array();
    
        $targetTasks = $jobInfo['target_tasks'];
        
        $isServerUpdatePackage = true;
        $isVersionsUpdatePackage = true;
        $isPackageListContent = true;
        
        if(strpos($targetTasks,'upload_server_update_package') === false)
        {
            $isServerUpdatePackage = false;
        }
        if(strpos($targetTasks,'upload_client_update_config,upload_client_update_package') === false)
        {
            $isVersionsUpdatePackage = false;
        }
        if(strpos($targetTasks,'create_client_package') === false)
        {
            $isPackageListContent = false;
        }
        
        //clone的更新包
        $cloneUpdatePackage =  $jobConfig['versions_need_client_update_package'];
        //clone的安装包
        $cloneInstallPackage = array();
        
        foreach ($jobConfig['package_config'] as $key =>$value)
        {
            array_push($cloneInstallPackage, $value['package_id']);
        }
        if(!empty($versionId))
        {
            $versionData = Version::getById($versionId);
            if(!$versionData)
            {
                $this->error('版本参数错误！', Url::toRoute('index/index'));
            }
    
            $platformId   = $versionData['platform_id'];
            $upgradPathId = $versionData['upgrade_path_id'];
    
            //获得平台下的发布位置
            $deploymentListData =Deployment::getDataByPlatformId($platformId);
//             if(!$deploymentListData)
//             {
                //                 $this->error('平台下无发布位置！', Url::toRoute('index/index'));
//             }
            //         var_dump($deploymentListData);
    
            //获得平台下安装包
            $packageListData = Package::getDataByPlatformId($platformId);
            //             if(!$packageListData)
                //             {
                //                 $this->error('平台下无安装包！', Url::toRoute('index/index'));
                //             }
                    //         var_dump($packageListData);
    
            // 获得升级序列下的30天发布的已上线版本列表
            $startDate = date('Y-m-d 00:00:00', strtotime('-30 day'));
            $endDate = date('Y-m-d H:i:s', time());
            $versionUpdateListData = Version::getUpdateVersion($startDate, $endDate, $upgradPathId, $versionId);
             //             if(!$versionUpdateListData)
             //             {
             //                  $this->error('平台下无安装包！', Url::toRoute('index/index'));
             //             }
             //         var_dump($versionUpdateListData);
        }
    
        //获得动态参数
        $dynamicConfigListData = DynamicConfig::getData();
        //         var_dump($dynamicConfigListData);
    
        //获得非禁用打包机
        $workerListData = Worker::getFreeData();
        //将空闲打包机筛选出来
        $workerList = array();
        foreach ($workerListData as $worker)
        {
            $bool = Job::getJobStatusByWorkerId($worker['id']);
            if($bool)
            {
                continue;
            }
    
            $workerList[] = $worker;
        }
    
        // 随机选择空闲的一台打包机
        $randMax = count($workerList);
        $randIndex = rand(0, $randMax-1);
        $freeWorker = $workerList[$randIndex];
    
        //         var_dump($workerListData);
        $dynamicConfig = $jobConfig['dynamic_config'];
        $contentList = $this->getDynamicConfigContent2($dynamicConfigListData,$dynamicConfig);
    
        $data['version']                 = $versionData;
        $data['deploymentList']          = $deploymentListData;
        $data['packageList']             = $packageListData;
        $data['versionUpdateList']       = $versionUpdateListData;
        $data['dynamicConfigList']       = $dynamicConfigListData;
        $data['workerList']              = $workerList;
        $data['freeWorker']              = $jobConfig['worker_id'];//clone任务选择的打包机
        $data['rules']                   = $contentList['rules'];
        $data['dynamicConfigContent']    = $contentList['content'];
        $data['deploymentListContent']   = $this->getDeploymentList($deploymentListData, $jobInfo['deployment_id']);
        $data['isServerUpdatePackage']   = $isServerUpdatePackage;
        $data['isPackageListContent']    = $isPackageListContent;
        $data['isVersionsUpdatePackage'] = $isVersionsUpdatePackage;
        $data['cloneUpdatePackage']      = $cloneUpdatePackage;
        $data['cloneInstallPackage']     = $cloneInstallPackage;
        return $this->render('clonepublish',['data'=>$data]);
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
     * 返回指定的job信息，查询条件：version_id, create_user,deployment_id
     */
    public function actionList()
    {
        $rend_data = array();//渲染view数据
        $version_id = yii::$app->getRequest()->get('version_id');
        $create_user = yii::$app->getRequest()->get('create_user');
        $deployment_id = yii::$app->getRequest()->get('deployment_id');

        $rend_data['version_id'] = $version_id;
        $rend_data['create_user'] = $create_user;
        $rend_data['deployment_id'] = $deployment_id;

        //获取所有未禁用的发布位置
        $deployments = Deployment::getAllDeployment();
        $rend_data['deployments'] = $deployments;

        $condition = array();//where 条件
        if (!empty($version_id))
        {
            $condition['version_id'] = $version_id;
        }
        if (!empty($create_user))
        {
            $condition['create_user'] = $create_user;
        }
        if (!empty($deployment_id))
        {
            $condition['deployment_id'] = $deployment_id;
        }

        if (empty($condition))
        {
            $job_aq_obj = Job::find()->orderBy('id DESC');
        }
        else
        {
            $job_aq_obj = Job::find()->where($condition)->orderBy('id DESC');
        }
        //分页
        $total_count = $job_aq_obj->count();
        $pages = new Pagination(['totalCount' =>$total_count,'pageSize'=>10]);
        $page_count = $pages->pageCount;
        $jobs = $job_aq_obj->offset($pages->offset)->limit($pages->limit)->all();
        $job_list = array();
        if (!empty($jobs))
        {
            foreach ($jobs as $job) {
                $job_list[] = $job->toArray(['id', 'version_id', 'create_time', 'create_user', 'finish_time', 'status', 'target_tasks'],['deployment_name']);
            }
        }

        $rend_data['pages'] = $pages;
        $rend_data['total_count'] = $total_count;
        $rend_data['page_count'] = $page_count;
        $rend_data['job_list'] = $job_list;

        return $this->render('list', $rend_data);
    }

    /**
     * 任务详情页
     */
    public function actionDetail()
    {
        $job_id = yii::$app->getRequest()->get("job_id");
        if (empty($job_id))
        {
            $this->error("参数错误！", "/task/list");
        }

        $rend_data['job_id'] = $job_id;
        $job = Job::findOne($job_id);
        if (empty($job)) {
            $this->error("参数错误！", "/task/list");
        }
        $job_status = $job->status;
        $log_url = $job->log_url;
        $job_config = $job->job_config;
        $job_config_arr = array();
        if (!empty($job_config))
        {
            //job_config 需要解析json，查找对应key 在parameter表中对应的description值,拼成数组传递到view层
            $job_config_arr = $this->replaceJobConfigDescription($job_config);
        }
        $rend_data['job_status'] = $job_status;
        $rend_data['log_url'] = $log_url;
        $rend_data['job_config'] = $job_config_arr;

        return $this->render("detail", $rend_data);
    }
    
    /**
     * ajax发布任务
     * @return
     */
    public function actionJpublish()
    {
        //获得版本号
        $versionId = yii::$app->getRequest()->post("version_id");
        $versionData = Version::getById($versionId);
        //          var_dump($versionData);
        if(!$versionData)
        {
            $this->ajaxReturn(self::STATUS_FAILS, array(), "版本参数错误,请输入正确的版本号!");
        }
        
        $platformId   = $versionData['platform_id'];
        $upgradPathId = $versionData['upgrade_path_id'];
        
        //获得平台下的发布位置
        $deploymentListData =Deployment::getDataByPlatformId($platformId);
//         if(!$deploymentListData)
//         {
//             $this->ajaxReturn(false, array(), "该版本无发布位置,请配置相关发布位置！");
//         }
//                 var_dump($deploymentListData);
        
        //获得平台下安装包
        $packageListData = Package::getDataByPlatformId($platformId);
//         if(!$packageListData)
//         {
//              $this->ajaxReturn(false,array(), "该版本无安装包,请配置相关安装包！");
//         }
        //         var_dump($packageListData);
        
        // 获得升级序列下的30天发布的已上线版本列表
        $startDate = date('Y-m-d 00:00:00', strtotime('-30 day'));
        $endDate = date('Y-m-d H:i:s', time());
        $versionUpdateListData = Version::getUpdateVersion($startDate, $endDate, $upgradPathId, $versionId);
        $data['version']                = $versionData;
//         $data['deploymentList']         = $deploymentListData;
//         $data['packageList']            = $packageListData;
//         $data['versionUpdateList']      = $versionUpdateListData;
        $data['deploymentListContent']  = $this->getDeploymentList($deploymentListData);
        $data['packageListContent']     = $this->getPackagelist($packageListData);
        $data['versionUpdateContent']   = $this->getVersionupdatelist($versionUpdateListData);
        $this->ajaxReturn(self::STATUS_SUCCESS, $data, "切换版本数据成功");
    }
    public function actionDopublish()
    {
        $params = yii::$app->request->post();
        
        $versionId    = $params['version_id'];
        $deploymentId = $params['deployment_id'];
        $targetTasks  = $params['target_tasks'];
        $workerId       = $params['worker_id'];
        $versionsUpdatePackage= $params['package_update_config'];
        $packageConfig= $params['package_config'];
        
        if(empty($targetTasks))
        {
            $this->ajaxReturn(self::STATUS_FAILS, array(),"请选择发布任务目标！");
        }
        
        if(in_array('upload_client_update_config,upload_client_update_package', $targetTasks) && empty($versionsUpdatePackage))
        {
            $this->ajaxReturn(self::STATUS_FAILS, array(),"请选择客户端更新包！");
        }
        
        if(in_array('create_client_package', $targetTasks) && empty($packageConfig))
        {
            $this->ajaxReturn(self::STATUS_FAILS, array(),"请选择客户端安装包！");
        }
        
        $targetTasksStr = !empty($targetTasks)? implode(",", $targetTasks) : "";
        $versionsUpdatePackageStr = !empty($versionsUpdatePackage) && in_array('upload_client_update_config,upload_client_update_package', $targetTasks)? implode(",", $versionsUpdatePackage) :"";
        $packageConfigStr = !empty($packageConfig) &&  in_array('create_client_package', $targetTasks)? implode(",", $packageConfig) : "";
        
        //模板参数
        $dynamicConfig = array();
        foreach ($params as $key => $value) {
            if (preg_match("/^dynamic_config_/",$key))
            {
                $templateName= substr($key,15);
                if(isset($params[$key]) && !empty($params[$key]))
                {
                    $dynamicConfig[$templateName]=$value;
                }
            }
        }
        
        //入库
        $job['version_id'] = intval($versionId);
        $job['deployment_id'] = $deploymentId;
        $job['worker_id'] = $workerId;
        $job['target_tasks'] = $targetTasksStr;
        $job['create_user'] = yii::$app->getUser()->getIdentity()->account;
        $job['create_time'] = date('Y-m-d H:i:s');
        $job['status'] = 0;
//         $job['log_url'] = "http://logpath.com";
        
        $gameAlias = yii::$app->session->get('game_alias');
        
//         $job['job_config'] = "oo";
//         $job['finish_time']= date('Y-m-d H:i:s');
        $resJob = Job::createJob($job);
        if($resJob)
        {
            $job['id'] = $resJob;
            $jobConfig = $this->setJobConfig($job, $gameAlias, $versionsUpdatePackageStr, $packageConfigStr, $dynamicConfig);
            $resUpdate = Job::modifyJobConfig($resJob, json_encode($jobConfig));
            
            $logLevel = isset($jobConfig['dynamic_config']['log_level']) ?  $jobConfig['dynamic_config']['log_level'] : 'DEBUG';
            
            $targetTask = explode(',', $targetTasksStr);
            foreach ($targetTask as $value) {
                $targetTaskContent .= " --target-task {$value} ";
            }
            
           //调用脚本执行job TODO
            $logPath='/data/work/walle/log/jobrun_'.time().'.log';
            touch($logPath);
            $scriptPath = Yii::$app->params['scriptPath'];
            $command = "(LANG=en_US.UTF-8 {$scriptPath}walle job run --log-level DEBUG --game {$gameAlias} --job-id {$resJob}";
            $command .= $targetTaskContent .") >{$logPath} 2>&1 &";
            exec($command);
            $this->ajaxReturn(self::STATUS_SUCCESS, $resJob,"发布任务成功！");
        }
        else
        {
            $this->ajaxReturn(self::STATUS_FAILS, array(), "发布任务失败！");
        }
    }
    
    /**
     *  获得发布位置
     * @return
     */
    public function getDeploymentList($deploymentList, $defaultValue ="")
    {
        $deploymentListContent= "<select id=\"deployment_select\" class=\"js-source-states\" name=\"deployment_id\" style=\"width: 100%\">";
        $trContent ="";
        foreach ($deploymentList as $key => $value) {
            if($defaultValue != "" && $value['id'] == $defaultValue)
            {
              $trContent .=  "<option value=\"{$value['id']}\" selected = selected>{$value['name']}</option>";
            }
            else
            {
              $trContent .=  "<option value=\"{$value['id']}\">{$value['name']}</option>";
            }
        }
        $deploymentListContent .= $trContent;
        $deploymentListContent .=  "</select>";
        return $deploymentListContent;
    }
    /**
     *  获得平台下安装包数据
     * @return
     */
    public function getPackagelist($packageList)
    {
        if (empty($packageList))
        {
            return null;
        }
        $packageContent= "<table id=\"package_table\" class=\"table table-condensed table-striped\" cellpadding=\"1\" cellspacing=\"1\" >".
                "<thead>".
                "<tr>".
                "<th>安装包</th>".
                "<th>是否选择</th>".
                "</tr>". 
                "<thead>".
               "<tbody>";
        $trContent ="";
        foreach ($packageList as $key => $value) {
            $trContent .= "<tr>".
                    "<td>{$value['name']}</td>".
                    "<td><input id=\"package_{$key}\" type=\"checkbox\" name=\"package_config[]\" value=\"{$value['id']}\" ></td>".
                    "</tr>";
        }
        $packageContent .= $trContent;
        $packageContent .=  "</tbody>".
                "</table>";
        return $packageContent;
    }
    
    /**
     * 获得升级序列下的30天发布的已上线版本列表
     * @return
     */
    public function getVersionupdatelist($versionUpdateList)
    {
        if (empty($versionUpdateList))
        {
            return null;
        }
        $versionUpdateContent = "<table id=\"version_update_table\" class=\"table table-condensed table-striped\" cellpadding=\"1\" cellspacing=\"1\"  style=\"table-layout:fixed;\" >".
                                    "<thead>".
                                    "<tr>".
                                    "<th>版本号</th>".
                                    "<th>创建时间</th>".
                                    "<th>上线时间</th>".
                                    "<th>是否选择</th>".
                                    "</tr>".
                                    "</thead>".
                                    "<tbody>";

        $trContent ="";
        foreach ($versionUpdateList as $key => $value) {
            $trContent .= "<tr>".
                            "<td>{$value['id']}</td>".
                            "<td>{$value['create_time']}</td>".
                            "<td>{$value['release_time']}</td>".
                            "<td><input id=\"chk_all_{$key}\"  type=\"checkbox\" name=\"package_update_config[]\" value=\"{$value['id']}\" checked></td>".
            "</tr>";
        }
        $versionUpdateContent .= $trContent;
        $versionUpdateContent .=  "</tbody>".
                                 "</table>";
        return $versionUpdateContent;
    }
    
    /**
     * 获得动态参数内容
     * @param unknown $dynamicConfigData
     * @return string
     */
    private function getDynamicConfigContent($dynamicConfigData)
    {
        $content = "";
        $rules   = "";
        foreach ($dynamicConfigData as $value) {
            switch ($value['parameter']['value_type'])
            {
                
                case 'enum' :
                    $optionsList  = explode(',', $value['parameter']['options']);
                    $valueContent = "";
                    foreach ($optionsList as $option) {
                       if( trim($value['value']) === trim($option))
                       {
                           $valueContent .= "<option value=\"$option\"  selected = selected>$option</option>";
                       }
                       else
                       {
                           $valueContent .= "<option value=\"$option\">$option</option>";
                       }
                    }
                    $content.="<div class=\"form-group\">\n".
                                    "<label class=\"col-sm-4 control-label\">{$value['parameter']['description']}</label>\n".
                                    "<div class=\"col-sm-8\">\n".
                                    "<select id=\"{$value['parameter']['name']}\"  class=\"js-source-states\" name=\"dynamic_config_{$value['parameter']['name']}\" style=\"width: 100%\">\n".
                                         $valueContent.
                                     "</select>\n".
                                    "</div> \n".
         						"</div>\n" ;
                    $rules  .= "$(\"#{$value['parameter']['name']}\").rules(\"add\",{required: true, messages:{required:\"请输入{$value['parameter']['description']}\"}});\n";
                    break;
                case 'string' :
                    if($value['parameter']['name'] == 'concurrent_task_count')
                    {
                        $content.= "<div class=\"form-group\">".
                                "<label class=\"col-sm-4 control-label\">{$value['parameter']['description']}</label>".
                                "<div class=\"col-sm-8\">".
                                "<input id=\"{$value['parameter']['name']}\" type=\"text\"  class=\"form-control\" name=\"dynamic_config_{$value['parameter']['name']}\" value=\"{$value['value']}\" style=\"width: 100%\"></label>\n".
                                "</div> ".
                                "</div>" ;
                         
                        $rules  .= "$(\"#{$value['parameter']['name']}\").rules(\"add\",{required: true, number:true,min:1,max:4, messages:{required:\"请输入{$value['parameter']['description']}\",number:\"请输入数字\",min:\"请输入大于0的数字\",max:\"请输入小于5的数字\"}});\n";
                    }
                    else
                    {
                        $content.= "<div class=\"form-group\">".
                                "<label class=\"col-sm-4 control-label\">{$value['parameter']['description']}</label>".
                                "<div class=\"col-sm-8\">".
                                "<input id=\"{$value['parameter']['name']}\" type=\"text\"  class=\"form-control\" name=\"dynamic_config_{$value['parameter']['name']}\" value=\"{$value['value']}\" style=\"width: 100%\"></label>\n".
                                "</div> ".
                                "</div>" ;
                         
                        $rules  .= "$(\"#{$value['parameter']['name']}\").rules(\"add\",{required: true, messages:{required:\"请输入{$value['parameter']['description']}\"}});\n";
                    }
                   
                    break;
                case 'bool' :
                    if(trim($value['value']) === 'true')
                    {
                        $content.= "<div class=\"form-group\">\n".
                                    "<label class=\"col-sm-4 control-label\">{$value['parameter']['description']}</label>\n".
                                    "<div class=\"col-sm-8\">\n".
                                            "<input id=\"{$value['parameter']['name']}\" type=\"checkbox\" name=\"dynamic_config_{$value['parameter']['name']}\" value=\"true\" checked>\n".
                                    "</div>\n".
         						"</div>\n" ;
                    }
                    else
                    {
                       $content.="<div class=\"form-group\">\n".
                                    "<label class=\"col-sm-4 control-label\">{$value['parameter']['description']}</label>\n".
                                    "<div class=\"col-sm-8\">". "<input id=\"{$value['parameter']['name']}\" type=\"checkbox\" name=\"dynamic_config_{$value['parameter']['name']}\" value=\"true\">".
                                    "</div> ".
         						"</div>" ;
                    }
                    break;
                default :
                   break;
            }
          
        }
        $contentList['content']=$content;
        $contentList['rules']=$rules;
        return $contentList;
       
    }
    /**
     * 获得动态参数内容
     * @param unknown $dynamicConfigData
     * @return string
     */
    private function getDynamicConfigContent2($dynamicConfigData, $dynamicConfig)
    {
        $content = "";
        $rules   = "";
        foreach ($dynamicConfigData as $value) {
            switch ($value['parameter']['value_type'])
            {
    
                case 'enum' :
                    $optionsList  = explode(',', $value['parameter']['options']);
                    $valueContent = "";
                    foreach ($optionsList as $option) {
                        if( trim($dynamicConfig[$value['parameter']['name']]) === trim($option))
                        {
                            $valueContent .= "<option value=\"$option\"  selected = selected>$option</option>";
                        }
                        else
                        {
                            $valueContent .= "<option value=\"$option\">$option</option>";
                        }
                    }
                    $content.="<div class=\"form-group\">\n".
                            "<label class=\"col-sm-4 control-label\">{$value['parameter']['description']}</label>\n".
                            "<div class=\"col-sm-8\">\n".
                            "<select id=\"{$value['parameter']['name']}\"  class=\"js-source-states\" name=\"dynamic_config_{$value['parameter']['name']}\" style=\"width: 100%\">\n".
                            $valueContent.
                            "</select>\n".
                            "</div> \n".
                            "</div>\n" ;
                    $rules  .= "$(\"#{$value['parameter']['name']}\").rules(\"add\",{required: true, messages:{required:\"请输入{$value['parameter']['description']}\"}});\n";
                    break;
                case 'string' :
                    if($value['parameter']['name'] == 'concurrent_task_count')
                    {
                        $content.= "<div class=\"form-group\">".
                                "<label class=\"col-sm-4 control-label\">{$value['parameter']['description']}</label>".
                                "<div class=\"col-sm-8\">".
                                "<input id=\"{$value['parameter']['name']}\" type=\"text\"  class=\"form-control\" name=\"dynamic_config_{$value['parameter']['name']}\" value=\"{$dynamicConfig[$value['parameter']['name']]}\" style=\"width: 100%\"></label>\n".
                                "</div> ".
                                "</div>" ;
                         
                        $rules  .= "$(\"#{$value['parameter']['name']}\").rules(\"add\",{required: true, number:true,min:1,max:4, messages:{required:\"请输入{$value['parameter']['description']}\",number:\"请输入数字\",min:\"请输入大于0的数字\",max:\"请输入小于5的数字\"}});\n";
                    }
                    else
                    {
                        $content.= "<div class=\"form-group\">".
                                "<label class=\"col-sm-4 control-label\">{$value['parameter']['description']}</label>".
                                "<div class=\"col-sm-8\">".
                                "<input id=\"{$value['parameter']['name']}\" type=\"text\"  class=\"form-control\" name=\"dynamic_config_{$value['parameter']['name']}\" value=\"{$dynamicConfig[$value['parameter']['name']]}\" style=\"width: 100%\"></label>\n".
                                "</div> ".
                                "</div>" ;
                         
                        $rules  .= "$(\"#{$value['parameter']['name']}\").rules(\"add\",{required: true, messages:{required:\"请输入{$value['parameter']['description']}\"}});\n";
                    }
                     
                    break;
                case 'bool' :
                    if(trim($dynamicConfig[$value['parameter']['name']]) === 'true')
                    {
                        $content.= "<div class=\"form-group\">\n".
                                "<label class=\"col-sm-4 control-label\">{$value['parameter']['description']}</label>\n".
                                "<div class=\"col-sm-8\">\n".
                                "<input id=\"{$value['parameter']['name']}\" type=\"checkbox\" name=\"dynamic_config_{$value['parameter']['name']}\" value=\"true\" checked>\n".
                                "</div>\n".
                                "</div>\n" ;
                    }
                    else
                    {
                        $content.="<div class=\"form-group\">\n".
                                "<label class=\"col-sm-4 control-label\">{$value['parameter']['description']}</label>\n".
                                "<div class=\"col-sm-8\">". "<input id=\"{$value['parameter']['name']}\" type=\"checkbox\" name=\"dynamic_config_{$value['parameter']['name']}\" value=\"true\">".
                                "</div> ".
                                "</div>" ;
                    }
                    break;
                default :
                    break;
            }
    
        }
        $contentList['content']=$content;
        $contentList['rules']=$rules;
        return $contentList;
         
    }
    
    /**
     * 获得jobConfig
     * @param unknown $versionId
     * @param unknown $deploymentId
     * @param unknown $targetTasksStr
     * @param unknown $workerId
     * @param unknown $versionsUpdatePackageStr
     * @param unknown $packageConfigStr
     * @param unknown $dynamicConfig
     */
    public function setJobConfig($jobInfo, $game , $versionsUpdatePackageStr, $packageConfigStr, $dynamicConfig)
    {
        $jobConfig = array();
        $jobConfig['job_id'] = $jobInfo['id'];
        $jobConfig['game'] = $game;
        $versionData = Version::getById($jobInfo['version_id']);
//         if ( ! $versionData)
//         {
//             return $this->error('版本参数错误！', Url::toRoute('index/index'));
//         }
        $jobConfig['version'] = $jobInfo['version_id'];
        
        $platformId   = $versionData['platform_id'];
        $upgradPathId = $versionData['upgrade_path_id'];
        $platformInfo = Platform::getDataById($platformId);
//         var_dump($platformInfo);
//         if ( ! $platformInfo)
//         {
//             return $this->error('无平台信息！', Url::toRoute('index/index'));
//         }
        $jobConfig['region'] = $platformInfo['region']['name'];
        $jobConfig['platform'] = $platformInfo['name'];
        
        $deploymentInfo = Deployment::getById($jobInfo['deployment_id']);
//         if ( ! $deploymentInfo)
//         {
//             return $this->error('无发布位置信息！', Url::toRoute('index/index'));
//         }
        $jobConfig['deployment'] = $deploymentInfo['name'];
        
        //升级序列
        $upgradPathInfo = UpgradePath::getById($upgradPathId);
//         if ( ! $upgradPathInfo)
//         {
//             return $this->error('无升级序列信息！', Url::toRoute('index/index'));
//         }
        $jobConfig['upgrade_path'] = $upgradPathInfo['name'];
        
        $jobConfig['create_user'] = $jobInfo['create_user'];
        $jobConfig['create_time'] = $jobInfo['create_time'];
        
        //打包机
        $workInfo = Worker::getById($jobInfo['worker_id']);
//         if ( ! $workInfo)
//         {
//             return $this->error('无打包机信息！', Url::toRoute('index/index'));
//         }
        $jobConfig['worker'] = $workInfo['hostname'];
        
        //获得模块信息
        $modulesTag = ModuleTag::getVersionModuleTag($jobInfo['version_id']);
//         if ( ! $modulesTag)
//         {
//             return $this->error('无模块信息！', Url::toRoute('index/index'));
//         }
        $modulesTagArr = array();
        if(!empty($modulesTag))
        {
            foreach ($modulesTag as $value)
            {
                $subModules = array();
                $subModules['tag'] = $value['tag'];
                $subModules['name'] = $value['module']['name'];
                array_push($modulesTagArr, $subModules);
            }
        }
        
        $jobConfig['module_tag'] = $modulesTagArr;
        
        //target_tasks
        $jobConfig['target_tasks'] = !empty($jobInfo['target_tasks']) ? explode(",", $jobInfo['target_tasks']) : array();
        
        //客户端更新版本号
        
        $jobConfig['versions_need_client_update_package'] = !empty($versionsUpdatePackageStr) ? explode(",", $versionsUpdatePackageStr) : array();
        foreach ($jobConfig['versions_need_client_update_package'] as $key => $value) {
            $jobConfig['versions_need_client_update_package'][$key]=intval($value);
        }
        
        //默认参数
        $paramerList = Parameter::find()->asArray()->all();
        $defaultConfigList = array();
        foreach ($paramerList as $value) {
            $defaultConfigList[$value['name']] = $value['default_value'];
        }
//         var_dump($defaultConfigList);
        $jobConfig['default_config'] = $defaultConfigList;
        
        //地区参数配置region_config
        $regionConfigList = RegionConfig::getRegionConfigById($platformInfo['region']['id']);
        $regionConfig = array();
        if(!empty($regionConfigList))
        {
           foreach ($regionConfigList as $value) {
               $regionConfig[$value['parameter']['name']] = $value['value'];
           } 
        }
        $jobConfig['region_config'] = $regionConfig;
        
        //平台参数配置platform_config
        $platformConfigList = PlatformConfig::getPlatformConfigById($platformId);
        $platformConfig = array();
        if(!empty($platformConfigList))
        {
            foreach ($platformConfigList as $value) {
                $platformConfig[$value['parameter']['name']] = $value['value'];
            }
        }
        $jobConfig['platform_config'] = $platformConfig;
        
        //发布位置参数配置deployment_config
        $deploymentConfigList = DeploymentConfig::getPlatformConfigById($jobInfo['deployment_id']);
        $deploymentConfig = array();
        if(!empty($deploymentConfigList))
        {
            foreach ($deploymentConfigList as $value) {
                $deploymentConfig[$value['parameter']['name']] = $value['value'];
            }
        }
        $jobConfig['deployment_config'] = $deploymentConfig;
        
        
        //升级序列参数配置upgrade_path_config
        $upgradPathConfigList = UpgradePathConfig::getUpgradePathById($upgradPathId);
        $upgradPathConfig = array();
        if(!empty($upgradPathConfigList))
        {
            foreach ($upgradPathConfigList as $value) {
                $upgradPathConfig[$value['parameter']['name']] = $value['value'];
            }
        }
        $jobConfig['upgrade_path_config'] = $upgradPathConfig;
        
        //安装包配置信息
        $packageIdArr  = !empty($packageConfigStr) ? explode(",", $packageConfigStr) : array();
        $packageConfigList = PackageConfig::getPackageConfigParams($packageIdArr);
        
        $oldPackageConfig = array();
        $newPackageConfig = array();
        if(!empty($packageConfigList))
        {
            foreach ($packageConfigList as $value) {
                if(!isset($oldPackageConfig[$value['package_id']])){
                    $oldPackageConfig[$value['package_id']] = array();
                }    
                $oldPackageConfig[$value['package_id']]['package_id'] = intval($value['package_id']);
                $oldPackageConfig[$value['package_id']]['package_name'] = $value['package']['name'];
                $oldPackageConfig[$value['package_id']][$value['parameter']['name']] = $value['value'];
            }
            foreach ($oldPackageConfig as $value) {
                array_push($newPackageConfig, $value);
            }
        }
       
        $jobConfig['package_config'] = $newPackageConfig;
        
        //动态参数
        $dynamicConfigList = DynamicConfig::getData();
        $dynamicConfigNew = array();
       
        if(!empty($dynamicConfigList))
        {
            foreach ($dynamicConfigList as $value) {
                if($value['parameter']['value_type'] == 'bool' && $dynamicConfig[$value['parameter']['name']] == "")
                {
                    $dynamicConfigNew[$value['parameter']['name']] = 'false';
                }
                else
                {
                $dynamicConfigNew[$value['parameter']['name']] = $dynamicConfig[$value['parameter']['name']];
                }
            }
        }
        $jobConfig['dynamic_config'] = $dynamicConfigNew;
        return $jobConfig;
    }


    //解析job_config,替换key为对应的description中文描述 
    private function replaceJobConfigDescription($job_config) 
    {
        $task_param_arr = array(
            "module_tag",
            "target_tasks",
            "versions_need_client_update_package",
            "package_config",
        );
        $job_config = json_decode($job_config, true);
        $job_config_cn = array();
        foreach ($job_config as $key => $value)
        {
            if (!is_array($value))
            {
                $tmp['type'] = "任务参数";
                $tmp['name'] = $key;
                $tmp['value'] = $value;
                $job_config_cn[] = $tmp;
            }
            else
            {
                if (in_array($key, $task_param_arr))
                {
                    $tmp['type'] = "任务参数";
                    $tmp['name'] = $key;
                    $tmp_v = "";
                    switch ($key)
                    {
                        case "module_tag":
                            foreach ($value as $v)
                            {
                                $tmp_v .= $v['name']."：".$v['tag']."</br>";
                            }
                            break;
                        case "package_config":
                            foreach ($value as $v)
                            {
                                $tmp_v .= $v['package_name']."</br>";
                            }
                            break;
                        case "target_tasks":
                            foreach ($value as $v)
                            {
                                if ($v == "upload_server_update_package")
                                {
                                    $v="服务端更新包";
                                }
                                else if ($v == "create_client_package")
                                {
                                    $v="客户端安装包";
                                } 
                                else if ($v == "upload_client_update_package")
                                { 
                                    $v="客户端更新包";
                                } 
                                else 
                                {
                                    $v="";
                                }
                                $tmp_v .= empty($v) ? $v : "$v</br>";
                            }
                            break;
                        case "versions_need_client_update_package":
                            $tmp['type'] = "任务参数";
                            $tmp['name'] = $key;
                            $tmp_v = "";
                            foreach ($value as $v)
                            {
                                $tmp_v .= $v.";";
                            }
                            break;
                        default:
                            break;
                    }
                    $tmp['value'] = $tmp_v;
                    $job_config_cn[] = $tmp;
                }
                else
                {
                    foreach ($value as $param => $v)
                    {
                        $tmp['type'] = $key;
                        //查parameter表
                        $description = Parameter::getDesByName($param);
                        $tmp['name'] = $description;
                        $tmp['value'] = $v;
                        $job_config_cn[] = $tmp;
                    }
                }
            }
        }

        return $job_config_cn;
    } 
    
    /**
     * 发布任务对比
     */
    public function actionCompare()
    {
        return $this->render('compare');
    }
    
    public function actionCompareDetail()
    {
        return $this->render('comparedetail');
    }
}
