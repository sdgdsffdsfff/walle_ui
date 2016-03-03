<?php
namespace app\models;
/**
 * This is the model class for table "parameter".
 *
 * @property integer $id
 * @property string $name
 * @property string $value_type
 * @property string $description
 * @property string $default_value
 * @property string $options
 *
 * @property DeploymentConfig[] $deploymentConfigs
 * @property Deployment[] $deployments
 * @property DynamicConfig $dynamicConfig
 * @property PackageConfig[] $packageConfigs
 * @property Package[] $packages
 * @property PlatformConfig[] $platformConfigs
 * @property Platform[] $platforms
 * @property RegionConfig[] $regionConfigs
 * @property Region[] $regions
 * @property UpgradePathConfig[] $upgradePathConfigs
 * @property UpgradePath[] $upgradePaths
 */

class Parameter extends BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'parameter';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['value_type', 'description'], 'string'],
            [['name'], 'string', 'max' => 32],
            [['default_value', 'options'], 'string', 'max' => 255],
            [['name'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'value_type' => 'Value Type',
            'description' => 'Description',
            'default_value' => 'Default Value',
            'options' => 'Options',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDeploymentConfigs()
    {
        return $this->hasMany(DeploymentConfig::className(), ['parameter_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDeployments()
    {
        return $this->hasMany(Deployment::className(), ['id' => 'deployment_id'])->viaTable('deployment_config', ['parameter_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDynamicConfig()
    {
        return $this->hasOne(DynamicConfig::className(), ['parameter_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPackageConfigs()
    {
        return $this->hasMany(PackageConfig::className(), ['parameter_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPackages()
    {
        return $this->hasMany(Package::className(), ['id' => 'package_id'])->viaTable('package_config', ['parameter_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlatformConfigs()
    {
        return $this->hasMany(PlatformConfig::className(), ['parameter_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlatforms()
    {
        return $this->hasMany(Platform::className(), ['id' => 'platform_id'])->viaTable('platform_config', ['parameter_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRegionConfigs()
    {
        return $this->hasMany(RegionConfig::className(), ['parameter_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRegions()
    {
        return $this->hasMany(Region::className(), ['id' => 'region_id'])->viaTable('region_config', ['parameter_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpgradePathConfigs()
    {
        return $this->hasMany(UpgradePathConfig::className(), ['parameter_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpgradePaths()
    {
        return $this->hasMany(UpgradePath::className(), ['id' => 'upgrade_path_id'])->viaTable('upgrade_path_config', ['parameter_id' => 'id']);
    }

    /**
     * 通过name查找对应的description
     * @param string $name
     * @return string $description | false
     */
    public static function getDesByName($name)
    {
        $parameter = Parameter::findOne(['name' => $name]);
        if ($parameter)
        {
            return $parameter->description;
        }
        return false;
    }
    
    /**
     * 获取所有参数
     * @return array
     */
    public static function getAllParameters()
    {
        $resource = Parameter::find()->asArray()->all();
        
        return $resource;
    }
    
    /**
     * 根据id获取数据
     * @param int id 参数id
     * @return array
     */
    public static function getParameterById($id)
    {
        $fields = ['id','name','value_type','description','default_value','disable','options'];
    
        $condition = ['id' => $id];
        $result = Parameter::find()->select($fields)
                ->where($condition)
                ->asArray()
                ->one();
        
        return $result;
    }
    
    /**
     * 根据名称获取参数
     * @param string $name 参数名称
     * @return mixed
     */
    public static function getDataByName($name)
    {
        $condition = ['name' => $name];
        $result = Parameter::findOne($condition);
        
        if(!empty($result))
        {
            return $result->toArray();
        }
        else
        {
            return false;
        }
    }
    
    /**
     * 添加新的记录
     * @param array $datas 新数据
     * @return bool
     */
    public static function createParameter($datas)
    {
        $parameter = new Parameter();
        $parameter->name = $datas['name'];
        $parameter->value_type = $datas['value_type'];
        $parameter->description = $datas['description'];
        $parameter->default_value = $datas['default_value'];
        $parameter->disable = $datas['disable'];
        $parameter->options = $datas['options'];

        $bool = $parameter->save();
        
        return $bool;
    }
    
    /**
     * 编辑记录
     * @param array $datas 所需数据
     * @return bool
     */
    public static function eidtParameter($datas)
    {
        $parameter = Parameter::findOne($datas['id']);
        $parameter->name = $datas['name'];
        $parameter->value_type = $datas['value_type'];
        $parameter->description = $datas['description'];
        $parameter->default_value = $datas['default_value'];
        $parameter->disable = $datas['disable'];
        $parameter->options = $datas['options'];
        
        $bool = $parameter->save();
        
        return $bool;
    }
}
