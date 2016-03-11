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
use app\models\UpgradePath;
use yii\data\Pagination;
use app\models\Deployment;
use app\models\Clientpackage;
use app\models\Package;
use app\models\Parameter;
use app\models\PackageConfig;

class PackageController extends BaseController
{
    /**
     * 安装包配置列表
     */
    public function actionConfigList()
    {
        $packageConfigs = PackageConfig::find()->all();
        $data = array();
        if (!empty($packageConfigs))
        {
            foreach ($packageConfigs as $packageConfig)
            {
                $data[] = $packageConfig->toArray();
            }
        }

        return $this->render('configlist', array("data" => $data));
    }

    /**
     * 安装包配置编辑
     */
    public function actionConfigEdit()
    {
        $packageId = yii::$app->getRequest()->get('package_id');
        $parameterId = yii::$app->getRequest()->get('parameter_id');
        if (empty($packageId) && empty($parameterId))
        {
            //新增配置页面、查找全部package和parameter
            $packageList = Package::find()->where(array("disable" => 0))->addSelect(array('id', 'name'))->asArray()->all();
            $parameterList = Parameter::getAllParameterByEnable();

            return $this->render('configadd', array("packageList" => $packageList, "parameterList" => $parameterList));
        }
        else
        {
            //编辑已存在配置
            $package = Package::findOne($packageId);
            $parameter = Parameter::findOne($parameterId);
            if (!$package || !$parameter)
            {
                $this->error('您要编辑的内容不存在', '/package/config-list');
            }
            $packageConfig = PackageConfig::find()->where(array("package_id" => $packageId, "parameter_id" => $parameterId))->one();
            if (!$packageConfig)
            {
                $this->error('您要编辑的内容不存在', '/package/config-list');
            }

            return $this->render('configedit', array("package" => $package, "parameter" => $parameter, "value" => $packageConfig->value));
        }

    }

    /**
     * 保存安装包配置
     */
    public function actionConfigSave()
    {
        $packageId = yii::$app->getRequest()->post('package_id');
        $parameterId = yii::$app->getRequest()->post('parameter_id');
        $parameterValue = yii::$app->getRequest()->post('parameter_value');

        if (empty($packageId) || empty($parameterId))
        {
            $this->newajaxReturn(self::STATUS_FAILS, array(), '请求参数有误!');
        }
        $valueType = Parameter::findOne($parameterId)->value_type;
        //value_type为string 的参数，参数值允许为空
        if ($valueType != "string" && empty($parameterValue))
        {
            $this->newajaxReturn(self::STATUS_FAILS, array(), '请求参数有误!');
        }
        //查找packageConfig判断请求为新增还是编辑
        $packageConfig = PackageConfig::find()->where(array("package_id" => $packageId, "parameter_id" => $parameterId))->one();
        if (!$packageConfig)
        {
            //新增配置
            $packageConfig = new PackageConfig();
            $packageConfig->package_id = $packageId;
            $packageConfig->parameter_id = $parameterId;
        }
        $packageConfig->value = $parameterValue;

        if ($packageConfig->save())
        {
            $this->newajaxReturn(self::STATUS_SUCCESS, array(), '保存成功!');
        }

        $this->newajaxReturn(self::STATUS_FAILS, array(), '保存失败!');
    }

    /**
     * 删除安装包配置
     */
    public function actionConfigDelete()
    {
        $packageId = yii::$app->getRequest()->post('package_id');
        $parameterId = yii::$app->getRequest()->post('parameter_id');

        if (empty($packageId) || empty($parameterId))
        {
            $this->newajaxReturn(self::STATUS_FAILS, '', '请求参数有误!');
        }

        $packageConfig = packageConfig::find()->where(array("package_id" => $packageId, "parameter_id" => $parameterId))->one();

        if (!$packageConfig)
        {
            $this->newajaxReturn(self::STATUS_FAILS, '', '未找到相关配置!');
        }

        if ($packageConfig->delete())
        {
            $this->newajaxReturn(self::STATUS_SUCCESS, array(), '删除成功!');
        }

        $this->newajaxReturn(self::STATUS_FAILS, '', '删除失败!');
    }
}
