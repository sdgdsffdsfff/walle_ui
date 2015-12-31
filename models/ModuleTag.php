<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "module_tag".
 *
 * @property integer $version_id
 * @property integer $module_id
 * @property string $tag
 *
 * @property Version $version
 * @property Module $module
 */
class ModuleTag extends BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'module_tag';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['version_id', 'module_id'], 'required'],
            [['version_id', 'module_id'], 'integer'],
            [['tag'], 'string', 'max' => 64]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'version_id' => 'Version ID',
            'module_id' => 'Module ID',
            'tag' => 'Tag',
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
    public function getModule()
    {
        return $this->hasOne(Module::className(), ['id' => 'module_id']);
    }
}
