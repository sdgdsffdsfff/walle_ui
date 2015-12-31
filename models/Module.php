<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "module".
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property integer $disable
 * @property string $repo_type
 *
 * @property ClientModuleFile[] $clientModuleFiles
 * @property ClientModuleStatus[] $clientModuleStatuses
 * @property ModuleAvailableTag[] $moduleAvailableTags
 * @property ModuleTag[] $moduleTags
 * @property Version[] $versions
 */
class Module extends BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'module';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['disable'], 'integer'],
            [['repo_type'], 'string'],
            [['name'], 'string', 'max' => 32],
            [['description'], 'string', 'max' => 256],
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
            'description' => 'Description',
            'disable' => 'Disable',
            'repo_type' => 'Repo Type',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClientModuleFiles()
    {
        return $this->hasMany(ClientModuleFile::className(), ['module_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClientModuleStatuses()
    {
        return $this->hasMany(ClientModuleStatus::className(), ['module_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getModuleAvailableTags()
    {
        return $this->hasMany(ModuleAvailableTag::className(), ['module_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getModuleTags()
    {
        return $this->hasMany(ModuleTag::className(), ['module_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVersions()
    {
        return $this->hasMany(Version::className(), ['id' => 'version_id'])->viaTable('module_tag', ['module_id' => 'id']);
    }
}
