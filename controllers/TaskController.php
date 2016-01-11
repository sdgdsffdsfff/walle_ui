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
use app\models\Job;
use yii\db\Connection as Connection;
use yii\helpers\Url;
use yii\data\Pagination;

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
            //提示错误跳转页面
        }
        $job = Job::findOne($job_id);
        if (empty($job))
        {
            //提示错误跳转页面
        }
        $job_status = $job->status;
        $tasks = $job->tasks;
        foreach ($tasks as $task)
        {
            $job_tasks[] = ArrayHelper::toArray($task);
        }
        $data = array(
            "status" => $job_status,
            "tasks" => $job_tasks,
        );
        return $this->ajaxReturn(self::STATUS_SUCCESS, $data);
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
        //todo job_id 为空的时候怎么处理？
        $rend_data['job_id'] = $job_id;
        $rend_data['log_url'] = "http://deploy1.saiya.com";
        //todo 查找job表、返回job_config log_url job_status(根据status判断是否显示终止任务按钮)
        



        return $this->render("detail", $rend_data);
    }
    
    /**
     * ajax发布任务
     * @return
     */
    public function actionJpublish()
    {
        //获得版本号
        $version_id = yii::$app->getRequest()->get("version_id");
        $data['versionUpdateContent'] = "<table id=\"version_update_table\" class=\"table table-condensed table-striped\" cellpadding=\"1\" cellspacing=\"1\"  style=\"table-layout:fixed;\" >".
                                              "<thead>".
                                                "<tr>".
                                                    "<th>版本号</th>".
                                                    "<th>发布时间</th>".
                                                    "<th>是否选择</th>".
                                                "</tr>".
                                                "</thead>".
                                                "<tbody>".
                                                "<tr>".
                                                    "<td>112</td>".
                                                    "<td>2015-12-28 16:09:22</td>".
                                                    "<td><input id=\"chk_all_1\" type=\"checkbox\" name=\"package_update_config\" value=\"1\" checked></td>".
                                                "</tr>".
                                                "<tr>".
                                                    "<td>112</td>".
                                                    "<td>2015-12-28 16:09:22</td>".
                                                    "<td><input id=\"chk_all_1\" type=\"checkbox\" name=\"package_update_config\" value=\"2\" checked></td>".
                                                "</tr>".         
                            		           "</tbody>".
                                        "</table>";
        
        $data['packageContent']= "<table id=\"package_table\" class=\"table table-condensed table-striped\" cellpadding=\"1\" cellspacing=\"1\"  style=\"table-layout:fixed;\" >".
                                    "<thead>".
                                    "<tr>".
                                        "<th>安装包</th>".
                                        "<th>是否选择</th>".
                                    "</tr>".
                                    "</thead>".
                                    "<tbody>".
                                    "<tr>".
                                        "<td>appstore_debug</td>".
                                        "<td><input id=\"package_1\" type=\"checkbox\" name=\"package_config\" value=\"3\" ></td>".
                                    "</tr>".
                                    "<tr>".
                                        "<td>appstore_release</td>".
                                        "<td><input id=\"package_1\" type=\"checkbox\" name=\"package_config\" value=\"4\" ></td>".
                                    "</tr>".
                                    "</tbody>".
                                "</table>";
        
        $data['deploymentContent']="<select id=\"deployment_select\" class=\"js-source-states\" name=\"deployment_id\" style=\"width: 100%\">".
                                        "<option value=\"1\">deploy2.walle.playcrab-inc.com</option>".
                                        "<option value=\"2\">deploy2.walle.playcrab-inc.com</option>".
                                    "</select>";
          echo json_encode($data);
          die();
    }
    
}
