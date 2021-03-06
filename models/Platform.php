<?php

namespace app\models;

use Yii;
/**
 * This is the model class for table "platform".
 *
 * @property integer $id
 * @property integer $region_id
 * @property string $name
 * @property integer $disable
 * @property string $description
 *
 * @property Deployment[] $deployments
 * @property Package[] $packages
 * @property Region $region
 * @property PlatformConfig[] $platformConfigs
 * @property Parameter[] $parameters
 * @property Version[] $versions
 */
class Platform extends BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'platform';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['region_id', 'disable'], 'integer'],
            [['name'], 'required'],
            [['name'], 'string', 'max' => 32],
            [['description'], 'string', 'max' => 255],
            //[['name'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'region_id' => 'Region ID',
            'name' => 'Name',
            'disable' => 'Disable',
            'description' => 'Description',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDeployments()
    {
        return $this->hasMany(Deployment::className(), ['platform_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPackages()
    {
        return $this->hasMany(Package::className(), ['platform_id' => 'id']);
    }

    /**
     * 1个平台对应1个区域,是1对1关系
     * @return \yii\db\ActiveQuery
     */
    public function getRegion()
    {
        return $this->hasOne(Region::className(), ['id' => 'region_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlatformConfigs()
    {
        return $this->hasMany(PlatformConfig::className(), ['platform_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParameters()
    {
        return $this->hasMany(Parameter::className(), ['id' => 'parameter_id'])->viaTable('platform_config', ['platform_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVersions()
    {
        return $this->hasMany(Version::className(), ['platform_id' => 'id']);
    }
    
    /**
     * 获取所有非禁用用平台信息
     * @return array
     */
    public static function getAllPlatform()
    {
        $object = Platform::find()->where(['disable'=>0]);
        $platform = $object->select(['id','name','region_id'])
                    ->with(['region'=>function($object){$object->select('*');}])
                    ->asArray()
                    ->all();
        
        return $platform;
    }
    
    /**
     * 获取所有非禁用平台信息
     * 解决平台或区域禁用时,历史信息为null的问题
     * @return type
     */
    public static function getAllPlatformById($platformId)
    {
        $fields = ['id','name','region_id'];
        $condition = [
            'id' => $platformId
        ];

        $resource = Platform::find()->where($condition);
        $result = $resource->select($fields)
                  ->with([
                      'region' => function($resource)
                      {
                          $resource->select('*');
                      }
                  ])->asArray()->one();
        
        return $result;
    }
    
    /**
     * 根据平台id,获取平台和相关联区域信息
     * @param int $platformId 平台id
     * @return array
     */
    public static function getDataById($platformId)
    {
        $fields = ['id','name','region_id'];
        $condition = [
            'id' => $platformId,
            'disable' => 0
        ];

        $resource = Platform::find()->where($condition);
        $result = $resource->select($fields)
                  ->with([
                      'region' => function($resource)
                      {
                          $resource->select('*')->where(['disable' => 0]);
                      }
                  ])->asArray()->one();
        
        return $result;
    }
}
