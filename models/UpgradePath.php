<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "upgrade_path".
 *
 * @property integer $id
 * @property string $name
 * @property integer $disable
 * @property string $description
 *
 * @property ClientModuleFile[] $clientModuleFiles
 * @property ClientModuleStatus[] $clientModuleStatuses
 * @property UpgradePathConfig[] $upgradePathConfigs
 * @property Parameter[] $parameters
 * @property Version[] $versions
 */
class UpgradePath extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'upgrade_path';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['disable'], 'integer'],
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
            'name' => 'Name',
            'disable' => 'Disable',
            'description' => 'Description',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClientModuleFiles()
    {
        return $this->hasMany(ClientModuleFile::className(), ['upgrade_path_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClientModuleStatuses()
    {
        return $this->hasMany(ClientModuleStatus::className(), ['upgrade_path_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpgradePathConfigs()
    {
        return $this->hasMany(UpgradePathConfig::className(), ['upgrade_path_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParameters()
    {
        return $this->hasMany(Parameter::className(), ['id' => 'parameter_id'])->viaTable('upgrade_path_config', ['upgrade_path_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVersions()
    {
        return $this->hasMany(Version::className(), ['upgrade_path_id' => 'id']);
    }
}
