<?php
namespace app\controllers;
/**
 * Description of IndexController
 * 安装包控制器类
 * @author zhaolu@playcrab.com
 */
use yii;
use app\controllers\BaseController;
use app\models\Platform;
use app\models\Region;
use app\models\Job;
use app\models\ClientUpdatePackage;
use app\models\Package;
use app\models\Parameter;
use app\models\PackageConfig;

class PackagestatusController extends BaseController
{
    
    
    /**
     * 客户端更新包状态
     * @return type
     */
    public function actionList()
    {
        $job_id = yii::$app->getRequest()->get('id');
        
        $data = array();
        $condition = array();
        if(isset($job_id))
        {
            $job = Job::findOne($job_id);
            if($job)
            {
                $job_config = json_decode($job['job_config'],true);
                $to_version = $job['version_id'];
                if(isset($job_config['versions_need_client_update_package']))
                {
                    $from_version = $job_config['versions_need_client_update_package'];
                    $condition['to_version'] = trim($to_version);
                    $getArr = array('upgrade_path_config','deployment_config','platform_config','region_config','default_config');
                    $url_root = '';
                    foreach ($getArr as $value) 
                    {
                        if(isset($job_config[$value]['cdn_url_root']) && !empty($job_config[$value]['cdn_url_root']))
                        {
                            $url_root = $job_config[$value]['cdn_url_root'];
                            break;
                        }
                    }

                    foreach($from_version as $i=>$r)
                    {
                        $condition['from_version'] = $r;
                        $config = ClientUpdatePackage::find()->where($condition)->asArray()->one();
                        $data[$i]['filename'] = array();
                        if($config)
                        {
                            $url_config = json_decode($config['packages'], true);
                            foreach ($url_config as $key => $res) 
                            {
                                $arr[$key] = $res['url'];
                            }
                            $data[$i]['filename'] = $arr;
                        }
                        $data[$i]['to_version'] = $to_version;
                        $data[$i]['from_version'] = $r;
                        $data[$i]['url'] = $url_root.yii::$app->session->get('game_alias').'/update/';
                    }            
                }
            }  
        }

        
        return $this->render('list', array('data'=>$data, 'job_id'=>$job_id));
    }


    /**
     * 发起请求
     */
    public function actionRequest()
    { 
        $url = yii::$app->getRequest()->post('url_info');
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
