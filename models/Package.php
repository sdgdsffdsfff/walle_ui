<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "package".
 *
 * @property integer $id
 * @property string $name
 * @property integer $platform_id
 * @property integer $disable
 * @property string $description
 *
 * @property ClientPackage[] $clientPackages
 * @property Platform $platform
 * @property PackageConfig[] $packageConfigs
 * @property Parameter[] $parameters
 */
class Package extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'package';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['platform_id', 'disable'], 'integer'],
            [['name', 'description'], 'string', 'max' => 255],
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
            'platform_id' => 'Platform ID',
            'disable' => 'Disable',
            'description' => 'Description',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClientPackages()
    {
        return $this->hasMany(ClientPackage::className(), ['package_id' => 'id']);
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
    public function getPackageConfigs()
    {
        return $this->hasMany(PackageConfig::className(), ['package_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParameters()
    {
        return $this->hasMany(Parameter::className(), ['id' => 'parameter_id'])->viaTable('package_config', ['package_id' => 'id']);
    }
}
