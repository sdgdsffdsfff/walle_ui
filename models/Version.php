<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "version".
 *
 * @property integer $id
 * @property integer $platform_id
 * @property integer $upgrade_path_id
 * @property string $create_time
 * @property string $create_user
 * @property string $change_log
 * @property string $release_time
 * @property integer $released
 *
 * @property ClientPackage[] $clientPackages
 * @property ClientUpdatePackage[] $clientUpdatePackages
 * @property ClientUpdatePackage[] $clientUpdatePackages0
 * @property Job[] $jobs
 * @property ModuleTag[] $moduleTags
 * @property Module[] $modules
 * @property Platform $platform
 * @property UpgradePath $upgradePath
 */
class Version extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'version';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['platform_id', 'upgrade_path_id', 'released'], 'integer'],
            [['create_time', 'release_time'], 'safe'],
            [['change_log'], 'string'],
            [['create_user'], 'string', 'max' => 32]
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
            'upgrade_path_id' => 'Upgrade Path ID',
            'create_time' => 'Create Time',
            'create_user' => 'Create User',
            'change_log' => 'Change Log',
            'release_time' => 'Release Time',
            'released' => 'Released',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClientPackages()
    {
        return $this->hasMany(ClientPackage::className(), ['version_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClientUpdatePackages()
    {
        return $this->hasMany(ClientUpdatePackage::className(), ['from_version' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClientUpdatePackages0()
    {
        return $this->hasMany(ClientUpdatePackage::className(), ['to_version' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJobs()
    {
        return $this->hasMany(Job::className(), ['version_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getModuleTags()
    {
        return $this->hasMany(ModuleTag::className(), ['version_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getModules()
    {
        return $this->hasMany(Module::className(), ['id' => 'module_id'])->viaTable('module_tag', ['version_id' => 'id']);
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
    public function getUpgradePath()
    {
        return $this->hasOne(UpgradePath::className(), ['id' => 'upgrade_path_id']);
    }
}
