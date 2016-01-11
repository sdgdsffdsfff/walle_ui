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
class Deployment extends BaseModel
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

    /**
     * 获取未禁用的发布位置
     * @return array
     */
    public static function getAllDeployment()
    {
        $deployments = Deployment::find()->where(['disable' => 0])
            ->select(['id', 'platform_id', 'name'])
            ->asArray()
            ->all();

        return $deployments;
    }

    /**
     * 根据平台下的发布位置
     * @param int $platformId 平台id
     * @return array
     */
    public static function getDataByPlatformId($platformId)
    {
        $condition = ['platform_id' => $platformId,'disable'=> 0 ];
        $result = Deployment::find()
        ->where($condition)
        ->asArray()
        ->all();
        return $result;
    }
    /**
     *  根据平台id获取数据
     * @param int id 平台id
     * @return array
     */
    public static function getById($id)
    {
        $fields = ['id','platform_id','name','disable'];
    
        $condition = ['id' => $id];
        $result = Deployment::find()->select($fields)
        ->where($condition)
        ->asArray()
        ->one();
        return $result;
    }
}
