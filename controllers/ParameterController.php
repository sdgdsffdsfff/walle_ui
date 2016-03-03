<?php
namespace app\controllers;
/**
 * Description of ParameterController
 * 配置参数控制器类
 * @author zhaolu@playcrab.com
 * @time 2016-02-22
 */
use yii;
use app\models\Parameter;

class ParameterController extends BaseController
{
    /**
     * 参数配置列表
     * @return type
     */
    public function actionList()
    {
        $allParameter = Parameter::getAllParameters();
        
        return $this->render('list', [
            'allParameter' => $allParameter
        ]);
    }
    
    /**
     * 新增参数配置
     * @return type
     */
    public function actionCreate()
    {
        if(yii::$app->request->isPost)
        {
            $redirect_url = '/parameter/list';
            
            $post = yii::$app->request->post();
            if(!isset($post['param_name']) || empty($post['param_name']))
            {
                $this->error('请输入参数名称!', $redirect_url);
            }
            if(!isset($post['param_value_type']) || empty($post['param_value_type']))
            {
                $this->error('请选择参数类型!', $redirect_url);
            }
            if(!isset($post['param_description']) || empty($post['param_description']))
            {
                $this->error('请输入参数描述信息!', $redirect_url);
            }
            if(!isset($post['param_default_value']) || empty($post['param_default_value']))
            {
                $this->error('请输入参数默认值!', $redirect_url);
            }
            
            //根据参数类型,判断options字段是否必填
            if(($post['param_value_type'] == 'enum' || $post['param_value_type'] == 'bool') && 
              (!isset($post['param_options']) || empty($post['param_options'])))
            {
                $this->error('请输入备选项!', $redirect_url);
            }
            
            $disabled = 1;  //禁用
            if(isset($post['param_disable']) || !empty($post['param_disable']))
            {
                $disabled = 0;  //启用
            }
            
            $datas['name'] = str_replace(array(' ','\t','\n','\r'), '', $post['param_name']);
            $datas['value_type'] = $post['param_value_type'];
            $datas['description'] = $post['param_description'];
            $datas['default_value'] = $post['param_default_value'];
            $datas['disable'] = $disabled;
            $datas['options'] = $post['param_options'];
            
            //确保模块名称唯一性
            $record = Parameter::getDataByName($datas['name']);
            if($record)
            {
                $this->ajaxReturn(self::STATUS_FAILS, array(), '该参数已存在!');
            }
            
            $bool = Parameter::createParameter($datas);
            if($bool)
            {
                $this->ajaxReturn(self::STATUS_SUCCESS, array('redirect_url' => $redirect_url), '创建参数成功!');
            }
            else
            {
                $this->ajaxReturn(self::STATUS_FAILS, array(), '创建参数失败!');
            }
        }
        
        return $this->render('edit');
    }
    
    /**
     * 参数配置编辑
     * @return type
     */
    public function actionEdit()
    {
        $redirect_url = '/parameter/list';
        
        //编辑
        if(yii::$app->request->isPost)
        {
            $post = yii::$app->request->post();
            if(!isset($post['param_value_type']) || empty($post['param_value_type']))
            {
                $this->error('请选择参数类型!', $redirect_url);
            }
            if(!isset($post['param_description']) || empty($post['param_description']))
            {
                $this->error('请输入参数描述信息!', $redirect_url);
            }
            if(!isset($post['param_default_value']) || empty($post['param_default_value']))
            {
                $this->error('请输入参数默认值!', $redirect_url);
            }
            
            //根据参数类型,判断options字段是否必填
            if(($post['param_value_type'] == 'enum' || $post['param_value_type'] == 'bool') && 
              (!isset($post['param_options']) || empty($post['param_options'])))
            {
                $this->error('请输入备选项!', $redirect_url);
            }
            
            $disabled = 1;  //禁用
            if(isset($post['param_disable']) || !empty($post['param_disable']))
            {
                $disabled = 0;  //启用
            }
            
            $datas['id'] = $post['param_id'];
            $datas['name'] = str_replace(array(' ','\t','\n','\r'), '', $post['param_name']);
            $datas['value_type'] = $post['param_value_type'];
            $datas['description'] = $post['param_description'];
            $datas['default_value'] = $post['param_default_value'];
            $datas['disable'] = $disabled;
            $datas['options'] = $post['param_options'];
            
            $bool = Parameter::eidtParameter($datas);
            if($bool)
            {
                $this->ajaxReturn(self::STATUS_SUCCESS, array('redirect_url' => $redirect_url), '编辑参数成功!');
            }
            else
            {
                $this->ajaxReturn(self::STATUS_FAILS, array(), '编辑参数失败!');
            }
        }
        else
        {
            $get = yii::$app->request->get();
            $parameter = Parameter::getParameterById($get['parameter_id']);
            if(!$parameter)
            {
                $this->error('参数不存在!', $redirect_url);
            }
        }
        
        return $this->render('edit', [
            'parameter' => $parameter
        ]);
    }

    /**
     * 动态参数配置
     * @return type
     */
    public function actionDynamicConfig()
    {
        return $this->render('dynamic');
    }

    /**
     * 动态参数编辑
     * @return type
     */
    public function actionDynamicConfigEdit()
    {
        return $this->render('dynamicedit');
    }
}
