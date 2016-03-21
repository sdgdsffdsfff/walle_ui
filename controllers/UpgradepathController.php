<?php
namespace app\controllers;
/**
 * Description of IndexController
 * 升级序列制器类
 * @author zhaolu@playcrab.com
 */
use yii;
use app\controllers\BaseController;
use app\models\UpgradePath;
use app\models\UpgradePathConfig;
use app\models\Parameter;

class UpgradepathController extends BaseController
{
    /**
     * [升级序列列表页]
     * @return [type] [description]
     */
    public function actionList()
    {	 
        $data = array();
        $data = UpgradePath::find()->orderBy(['id' => SORT_DESC])->asArray()->all();
        
        return $this->render('list', array('data' => $data));
    }

    /**
     * [升级序列新增编辑页]
     * @return [type] [description]
     */
    public function actionEdit()
    { 
        $info = array();
        $id = yii::$app->getRequest()->get('id');
        if($id)
        {
            $info = UpgradePath::findOne($id);
            if(!$info)
            {
                $this->error('您要编辑的内容不存在', '/upgradepath/list');
            }
        }
        
        return $this->render('edit', array('info' => $info, 'id' => $id));
    }
    
    /**
     * [升级序列编辑保存操作]
     * @return [type] [description]
     */
    public function actionDoedit()
    {
        $id = yii::$app->getRequest()->post('id');
        $name = yii::$app->getRequest()->post('name');
        $description = yii::$app->getRequest()->post('description');
        $disable = yii::$app->getRequest()->post('disable');
        
        if($name && $description)
        {
            $sameName = UpgradePath::find()->where(array('name' => $name))->one();
            if($sameName && $sameName['id'] != $id)
            {
                $this->ajaxReturn(self::STATUS_FAILS, '该名称已经存在!');
            }
            else
            {
                if($id)
                {
                    $info = UpgradePath::findOne($id);
                    //$info->name = $name;
                    $info->description = $description;
                    $info->disable=$disable;
                    $info->save();

                }
                else
                {
                    $info = new UpgradePath();
                    $info->name = $name;
                    $info->description = $description;
                    $info->disable=$disable;
                    $info->insert();
                }
                $this->ajaxReturn(self::STATUS_SUCCESS,'编辑升级序列成功!');
            }
        }
        else
        {
            $this->ajaxReturn(self::STATUS_FAILS, '缺少参数!');
        }
    }

    /**
     * [复制升级序列操作]
     * @return [type] [description]
     */
    public function actionDocopy()
    {
        $cid=yii::$app->getRequest()->post('id');
        $name = yii::$app->getRequest()->post('name');
        $description = yii::$app->getRequest()->post('description');
        $disable = yii::$app->getRequest()->post('disable');
        
        if($cid && $name && $description)
        {
            $sameName = UpgradePath::find()->where(array('name' => $name))->one();
            if($sameName)
            {
                $this->ajaxReturn(self::STATUS_FAILS, '该名称已经存在!');
            }
            else
            {
                $info = new UpgradePath();
                $info->name = $name;
                $info->description = $description;
                $info->disable = $disable;
                $info->insert();
                
                $id = $info->attributes['id'];
                $config = UpgradePathConfig::find()->where(array('upgrade_path_id' => $cid))->asArray()->all();
                if($config)
                {
                    foreach ($config as $v) 
                    {
                        $up = new UpgradePathConfig();
                        $up->upgrade_path_id = $id;
                        $up->parameter_id = $v['parameter_id'];
                        $up->value = $v['value'];
                        $up->insert();
                    }
                }
                
                $this->ajaxReturn(self::STATUS_SUCCESS,'复制升级序列相关配置成功!');
            }
        }
        else
        {
            $this->ajaxReturn(self::STATUS_FAILS, '缺少参数!');
        }
    }
    
    /**
     * [复制升级序列页]
     * @return [type] [description]
     */
    public function actionCopy()
    {   
        $info = array();
        $id = yii::$app->getRequest()->get('id');
        if($id)
        {
            $info = UpgradePath::findOne($id);
            if(!$info)
            {
                $this->error('您要编辑的内容不存在', '/upgradepath/list');
            }
        }
        
        return $this->render('copy', array('info' => $info, 'id' => $id));
    }
    
    /**
     * 升级序列配置列表
     * @return type
     */
    public function actionConfigList()
    {
        //获取升级序列列表传来的升级序列id
        $upgrade_path_id = yii::$app->request->get('id');
        
        $upgradePathSelect = $parameterSelect = $upgradePathConfigSelect = array();
        
        $flag = true;
        if(!empty($upgrade_path_id))
        {
            //根据升级序列id,查询是否有对应的congfig数据
            $record = UpgradePathConfig::getUpgradePathById($upgrade_path_id, true);
            if(!$record)
            {
                $flag = false;
            }
        }
        
        //获取全部升级序列config信息
        $result = UpgradePathConfig::getAllUpgradePathConfig();

        if($result)
        {
            //获取下拉框数据
            foreach ($result as $upgradePathConfig)
            {
                $upgradePathConfigSelect[] = $upgradePathConfig['value'];
                $upgradePathSelect[$upgradePathConfig['upgradePath']['id']] = $upgradePathConfig['upgradePath']['name'];
                $parameterSelect[$upgradePathConfig['parameter']['name']] = $upgradePathConfig['parameter']['description'];
            }
        }
        
        return $this->render('configlist', [
            'upgradePathSelect' => array_unique($upgradePathSelect),
            'parameterSelect' => array_unique($parameterSelect),
            'upgradePathConfigSelect' => array_unique($upgradePathConfigSelect),
            'list' => $result,
            'upgrade_path_id' => $upgrade_path_id,
            'flag' => $flag
         ]);
    }
    
    /**
     * 新增升级序列
     * @return type
     */
    public function actionConfigCreate()
    {
        $upgradePathList = array();
        //获取升级序列信息
        $objects = UpgradePath::getAbleUpgradepath();
        foreach ($objects as $obj)
        {
            $upgradePathList[] = [
                'id' => $obj->id,
                'name' => $obj->name
            ];
        }
        //获取可用参数信息
        $parametars = Parameter::getAllParameterByEnable();
        
        if(yii::$app->request->isPost)
        {
            $redirect_url = '/upgradepath/config-list';
            
            $post = yii::$app->request->post();
            if(!isset($post['sel_upgradepath']) || empty($post['sel_upgradepath']))
            {
                $this->error('请选择升级序列', $redirect_url);
            }
            if(!isset($post['sel_parameter']) || empty($post['sel_parameter']))
            {
                $this->error('请选择参数', $redirect_url);
            }
            
            //根据参数类型判断
            if((!isset($post['parameter_value']) || empty($post['parameter_value'])) && 
                ($post['parameter_type'] == 'enum' || $post['parameter_type'] == 'bool'))
            {
                $this->error('请选择参数值', $redirect_url);
            }
            
            $datas['upgrade_path_id'] = $post['sel_upgradepath'];
            $datas['parameter_id'] = $post['sel_parameter'];
            $datas['value'] = $post['parameter_value'];
            
            //确保升级序列和参数对的唯一性
            $record = UpgradePathConfig::getDataByUpgradePathAndParameter($datas);
            if($record)
            {
                $this->ajaxReturn(self::STATUS_FAILS, array(), '该升级序列配置已存在!');
            }
            
            $bool = UpgradePathConfig::createUpgradePathConfig($datas);
            if($bool)
            {
                $this->ajaxReturn(self::STATUS_SUCCESS, array('redirect_url' => $redirect_url), '创建升级序列配置成功!');
            }
            else
            {
                $this->ajaxReturn(self::STATUS_FAILS, array(), '创建升级序列配置失败!');
            }
        }
        
        return $this->render('configadd', [
            'upgradePathList' => $upgradePathList,
            'parameters' => $parametars
        ]);
    }
    
    /**
     * 编辑升级序列
     * @return type
     */
    public function actionConfigEdit()
    {
        $redirect_url = '/upgradepath/config-list';
        
        //编辑
        if(yii::$app->request->isPost)
        {
            $post = yii::$app->request->post();
            if((!isset($post['sel_parameter_value']) || empty($post['sel_parameter_value'])) && 
                ($post['parameter_type'] == 'enum' || $post['parameter_type'] == 'bool'))
            {
                $this->error('请选择参数值', $redirect_url);
            }
            
            $parameterVal = '';
            if($post['parameter_type'] == 'enum' || $post['parameter_type'] == 'bool')
            {
                $parameterVal = $post['sel_parameter_value'];
            }
            else
            {
                $parameterVal = $post['parameter_value'];
            }
            
            $datas['upgrade_path_id'] = $post['upgradePath_id'];
            $datas['parameter_id'] = $post['parameter_id'];
            $datas['value'] = $parameterVal;
            
            $bool = UpgradePathConfig::eidtUpgradePathConfig($datas);
            if($bool)
            {
                $this->ajaxReturn(self::STATUS_SUCCESS, array('redirect_url' => $redirect_url), '编辑升级序列配置成功!');
            }
            else
            {
                $this->ajaxReturn(self::STATUS_FAILS, array(), '编辑升级序列配置失败!');
            }
        }
        else
        {
            $get = yii::$app->request->get();
            $datas = [
                'upgrade_path_id' => $get['upgradepath_id'],
                'parameter_id' => $get['param_id'],
            ];
            
            $upgradePathConfig = UpgradePathConfig::getDataByUpgradePathAndParameter($datas);
            if(!$upgradePathConfig)
            {
                $this->error('参数配置不存在!', $redirect_url);
            }
            
            //根据升级序列id获取升级序列信息
            $upgradePath = UpgradePath::getById($get['upgradepath_id']);
            //根据参数id获取参数信息
            $parame = Parameter::getParameterById($get['param_id']);
        }
        
        return $this->render('configedit', [
            'upgradePathConfig' => $upgradePathConfig,
            'upgradePath' => $upgradePath,
            'parame' => $parame
        ]);
    }
    
    /**
     * 删除升级序列
     * @return boolean
     */
    public function actionConfigDelete()
    {
        $post = yii::$app->request->post();
        
        $datas['upgrade_path_id'] = $post['upgradePath_id'];
        $datas['parameter_id'] = $post['parameter_id'];
        
        $bool = UpgradePathConfig::deleteUpgradePathConfig($datas);
        if($bool)
        {
            $this->ajaxReturn(self::STATUS_SUCCESS, array(), '删除配置信息成功!');
        }
        else
        {
            $this->ajaxReturn(self::STATUS_FAILS, array(), '删除配置信息失败!');
        }
    }
}
