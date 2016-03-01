<?php
namespace app\controllers;
/**
 * Description of WorkerController
 * 打包机控制器类
 * @author zhaolu@playcrab.com
 * @time 2016-02-23
 */
use yii;
use app\models\Worker;

class WorkerController extends BaseController
{
    /**
     * 打包机配置列表
     * @return type
     */
    public function actionList()
    {
        $result = Worker::getAllData();
        
        return $this->render('list',[
            'allData' => $result
        ]);
    }
    
    /**
     * 新增打包机
     */
    public function actionCreate()
    {
        if(yii::$app->request->isPost)
        {
            $post = yii::$app->request->post();
            if(!isset($post['workerName']) || empty($post['workerName']))
            {
                $this->error('请输入主机名', '/worker/list');
            }
            
            $disabled = 1;  //禁用
            if(isset($post['workerDisable']) || !empty($post['workerDisable']))
            {
                $disabled = 0;  //启用
            }
            
            $datas['hostname'] = str_replace(array(' ','\t','\n','\r'), '', $post['workerName']);
            $datas['disable'] = $disabled;
            
            //确保主机名唯一性
            $record = Worker::getDataByHostname($datas['hostname']);
            if($record)
            {
                $this->ajaxReturn(self::STATUS_FAILS, array(), '该打包机已存在!');
            }
            
            $bool = Worker::createWorker($datas);
            if($bool)
            {
                $this->ajaxReturn(self::STATUS_SUCCESS, array(), '创建打包机成功!');
            }
            else
            {
                $this->ajaxReturn(self::STATUS_FAILS, array(), '创建打包机失败!');
            }
        }
        
        return $this->render('edit');
    }
    
    /**
     * 打包机编辑
     */
    public function actionEdit()
    {
        //编辑
        if(yii::$app->request->isPost)
        {
            $post = yii::$app->request->post();
            if(!isset($post['workerName']) || empty($post['workerName']))
            {
                $this->error('请输入主机名', '/worker/list');
            }
            
            $disabled = 1;  //禁用
            if(isset($post['workerDisable']) || !empty($post['workerDisable']))
            {
                $disabled = 0;  //启用
            }
            
            $datas['id'] = $post['workerId'];
            $datas['hostname'] = str_replace(array(' ','\t','\n','\r'), '', $post['workerName']);
            $datas['disable'] = $disabled;
            
            $bool = Worker::eidtWorker($datas);
            if($bool)
            {
                $this->ajaxReturn(self::STATUS_SUCCESS, array(), '编辑打包机成功!');
            }
            else
            {
                $this->ajaxReturn(self::STATUS_FAILS, array(), '编辑打包机失败!');
            }
        }
        else
        {
            $get = yii::$app->request->get();
            $worker = Worker::getById($get['worker_id']);
            if(!$worker)
            {
                $this->error('打包机不存在!', '/worker/list');
            }
        }
        
        return $this->render('edit', [
            'worker' => $worker
        ]);
    }
}
