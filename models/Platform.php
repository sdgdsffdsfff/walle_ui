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
class Platform extends \yii\db\ActiveRecord
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
}
