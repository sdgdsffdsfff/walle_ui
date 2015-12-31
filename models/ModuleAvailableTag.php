<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "module_available_tag".
 *
 * @property integer $module_id
 * @property string $tag
 * @property string $create_time
 * @property string $record_time
 *
 * @property Module $module
 */
class ModuleAvailableTag extends BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'module_available_tag';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['module_id'], 'integer'],
            [['create_time', 'record_time'], 'safe'],
            [['tag'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'module_id' => 'Module ID',
            'tag' => 'Tag',
            'create_time' => 'Create Time',
            'record_time' => 'Record Time',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getModule()
    {
        return $this->hasOne(Module::className(), ['id' => 'module_id']);
    }
}
