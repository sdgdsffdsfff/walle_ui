<?php
namespace app\controllers;
/**
 * Description of IndexController
 * 版本控制器类
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
use app\models\Clientpackage;
use app\models\Package;

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
        $deployment = Deployment::find()->all();
        
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

    public function actionListstatus()
    {
        $job_id=yii::$app->getRequest()->get('id');
        $data=array();
        $condition=array();
        if(isset($job_id)){
            $job=Job::findOne($job_id);
            if($job){
                $job_config=json_decode($job['job_config'],true);
                $to_version=$job['version_id'];
                if(isset($job_config['versions_need_client_update_package'])){
                    $from_version=$job_config['versions_need_client_update_package'];
                    $condition['to_version'] = trim($to_version);
                    $getArr=array('upgrade_path_config','deployment_config','platform_config','region_config','default_config');
                    $url_root='';
                    foreach ($getArr as $value) {
                        if(isset($job_config[$value]['cdn_url_root'])&&!empty($job_config[$value]['cdn_url_root'])){
                            $url_root=$job_config[$value]['cdn_url_root'];
                            break;
                        }
                    }

                    foreach($from_version as $i=>$r){
                        $condition['from_version'] = $r;
                        $config=ClientUpdatePackage::find()->where($condition)->asArray()->one();
                        $data[$i]['filename']=array();
                        if($config){
                          $url_config=json_decode($config['packages'],true);
                           foreach ($url_config as $key => $res) {
                               $arr[$key]=$res['filename'];
                           }
                            $data[$i]['filename']=$arr;
                        }
                        $data[$i]['to_version']=$to_version;
                        $data[$i]['from_version']=$r;
                        $data[$i]['url']=$url_root.yii::$app->session->get('game_alias').'/update/';
                        
                    }            
                }
            }
             
                

            
        }
        return $this->render('liststatus',array('data'=>$data,'job_id'=>$job_id));
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

    /**
     * 安装包配置列表
     */
    public function actionPackageConfigList()
    {
        return $this->render('packageConfigList');
    }

    /**
     * 安装包配置编辑
     */
    public function actionPackageConfigEdit()
    {
        return $this->render('packageConfigEdit');
    }

     /**
    * [列表页]
    * @return [type] [description]
    */
    public function actionTolist()
    {    $data=array();
       $data=Package::find()->with('platform')->asArray()->all();
       foreach ($data as $k => $v) {
         $region=Region::findOne($v['platform']['region_id']);
         $data[$k]['region_name']=$region['name'];
       }
       return $this->render('tolist',array('data'=>$data));
    }

    /**
     * [新增编辑页]
     * @return [type] [description]
     */
   public function actionEdit()
    { 
        $region=Platform::find()->where(array('disable'=>0))->with('region')->asArray()->all();
     $info=array();
      $id = yii::$app->getRequest()->get('id');
      if($id){
        $info=Package::findOne($id);
        if(!$info){
          $this->error('您要编辑的内容不存在', '/clientpackage/list');
        }
      }
       return $this->render('edit',array('info'=>$info,'id'=>$id,"region"=>$region));
    }
    /**
     * [编辑保存操作]
     * @return [type] [description]
     */
    public function actionDoedit(){
      $id = yii::$app->getRequest()->post('id');
      $region = yii::$app->getRequest()->post('region');
      $name = yii::$app->getRequest()->post('name');
      $description = yii::$app->getRequest()->post('description');
      $disable = yii::$app->getRequest()->post('disable');
      if($name&&$description&&$region){
        $sameName=Package::find()->where(array('name'=>$name))->one();
        if($sameName&&$sameName['id']!=$id){
          $this->ajaxReturn(self::STATUS_FAILS, '该名称已经存在');
        }else{
          if($id){
          $info = Package::findOne($id);
          $info->name = $name;
          $info->platform_id=$region;
          $info->description = $description;
          $info->disable=$disable;
          $info->save();
         
        }else{
          $info = new Package();
          $info->name = $name;
           $info->platform_id=$region;
          $info->description = $description;
          $info->disable=$disable;
          $info->insert();
        }
          $this->ajaxReturn(self::STATUS_SUCCESS,'保存成功');
        }
        
      }else{
        $this->ajaxReturn(self::STATUS_FAILS, '缺少参数');
      }
      
    }

}
