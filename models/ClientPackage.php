<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "client_package".
 *
 * @property integer $id
 * @property integer $version_id
 * @property integer $deployment_id
 * @property integer $package_id
 * @property string $url
 * @property integer $job_id
 * @property string $create_time
 *
 * @property Version $version
 * @property Deployment $deployment
 * @property Package $package
 */
class ClientPackage extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'client_package';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id', 'version_id', 'deployment_id', 'package_id', 'job_id'], 'integer'],
            [['create_time'], 'safe'],
            [['url'], 'string', 'max' => 1024]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'version_id' => 'Version ID',
            'deployment_id' => 'Deployment ID',
            'package_id' => 'Package ID',
            'url' => 'Url',
            'job_id' => 'Job ID',
            'create_time' => 'Create Time',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVersion()
    {
        return $this->hasOne(Version::className(), ['id' => 'version_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDeployment()
    {
        return $this->hasOne(Deployment::className(), ['id' => 'deployment_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPackage()
    {
        return $this->hasOne(Package::className(), ['id' => 'package_id']);
    }
}
