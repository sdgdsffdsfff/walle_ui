<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "deployment".
 *
 * @property integer $id
 * @property integer $platform_id
 * @property string $name
 * @property integer $disable
 * @property string $description
 *
 * @property ClientPackage[] $clientPackages
 * @property Platform $platform
 * @property DeploymentConfig[] $deploymentConfigs
 * @property Parameter[] $parameters
 * @property Job[] $jobs
 */
class Deployment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'deployment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['platform_id', 'disable'], 'integer'],
            [['name'], 'required'],
            [['name'], 'string', 'max' => 32],
            [['description'], 'string', 'max' => 255],
            [['platform_id', 'name'], 'unique', 'targetAttribute' => ['platform_id', 'name'], 'message' => 'The combination of Platform ID and Name has already been taken.']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'platform_id' => 'Platform ID',
            'name' => 'Name',
            'disable' => 'Disable',
            'description' => 'Description',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClientPackages()
    {
        return $this->hasMany(ClientPackage::className(), ['deployment_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlatform()
    {
        return $this->hasOne(Platform::className(), ['id' => 'platform_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDeploymentConfigs()
    {
        return $this->hasMany(DeploymentConfig::className(), ['deployment_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParameters()
    {
        return $this->hasMany(Parameter::className(), ['id' => 'parameter_id'])->viaTable('deployment_config', ['deployment_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJobs()
    {
        return $this->hasMany(Job::className(), ['deployment_id' => 'id']);
    }
}
