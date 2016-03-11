<?php
namespace app\controllers;
/**
 * Description of BusinessController
 * 业务模块管理
 * @author zhaolu@playcrab.com
 */
use yii;
use app\models\Module;

class BusinessController extends BaseController
{
    /**
     * 业务模块列表
     */
    public function actionList()
    {
        $result = Module::getAllModules();
        
        return $this->render('list', [
            'allModule' => $result
        ]);
    }
    
    /**
     * 新增业务模块
     */
    public function actionCreate()
    {
        if(yii::$app->request->isPost)
        {
            $redirect_url = '/business/list';
            
            $post = yii::$app->request->post();
            if(!isset($post['module_name']) || empty($post['module_name']))
            {
                $this->error('请输入模块名称!', $redirect_url);
            }
            if(!isset($post['module_description']) || empty($post['module_description']))
            {
                $this->error('请输入模块描述信息!', $redirect_url);
            }
            if(!isset($post['module_repo_type']) || empty($post['module_repo_type']))
            {
                $this->error('请选择模块仓库类型!', $redirect_url);
            }
            
            $disabled = 1;  //禁用
            if(isset($post['module_disable']) || !empty($post['module_disable']))
            {
                $disabled = 0;  //启用
            }
            
            $datas['name'] = str_replace(array(' ','\t','\n','\r'), '', $post['module_name']);
            $datas['description'] = $post['module_description'];
            $datas['disable'] = $disabled;
            $datas['repo_type'] = $post['module_repo_type'];
            
            //确保模块名称唯一性
            $record = Module::getDataByName($datas['name']);
            if($record)
            {
                $this->ajaxReturn(self::STATUS_FAILS, array(), '该模块已存在!');
            }
            
            $bool = Module::createModule($datas);
            if($bool)
            {
                $this->ajaxReturn(self::STATUS_SUCCESS, array('redirect_url' => $redirect_url), '创建模块成功!');
            }
            else
            {
                $this->ajaxReturn(self::STATUS_FAILS, array(), '创建模块失败!');
            }
        }
        
        return $this->render('edit');
    }
    
    /**
     * 业务模块编辑
     */
    public function actionEdit()
    {
        $redirect_url = '/business/list';
        
        //编辑
        if(yii::$app->request->isPost)
        {
            $post = yii::$app->request->post();
            if(!isset($post['module_description']) || empty($post['module_description']))
            {
                $this->error('请输入模块描述信息!', $redirect_url);
            }
            if(!isset($post['module_repo_type']) || empty($post['module_repo_type']))
            {
                $this->error('请选择模块仓库类型!', $redirect_url);
            }
            
            $disabled = 1;  //禁用
            if(isset($post['module_disable']) || !empty($post['module_disable']))
            {
                $disabled = 0;  //启用
            }
            
            $datas['id'] = $post['module_id'];
            $datas['name'] = $post['module_name'];
            $datas['description'] = $post['module_description'];
            $datas['disable'] = $disabled;
            $datas['repo_type'] = $post['module_repo_type'];
            
            $bool = Module::eidtModule($datas);
            if($bool)
            {
                $this->ajaxReturn(self::STATUS_SUCCESS, array('redirect_url' => $redirect_url), '编辑模块成功!');
            }
            else
            {
                $this->ajaxReturn(self::STATUS_FAILS, array(), '编辑模块失败!');
            }
        }
        else
        {
            $get = yii::$app->request->get();
            $module = Module::getModuleById($get['module_id']);
            if(!$module)
            {
                $this->error('模块不存在!', $redirect_url);
            }
        }
        
        return $this->render('edit', [
            'module' => $module
        ]);
    }
}
