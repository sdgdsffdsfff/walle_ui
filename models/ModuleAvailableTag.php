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
    
    /**
     * 根据moduleId,获取tag信息
     * @param int $moduleId moduleId
     * @return array
     */    
    public static function getModuleAvailableTagByModuleId($moduleId)
    {
        $resource = ModuleAvailableTag::find()
                    ->where(['module_id' => $moduleId])
                    ->orderBy(['create_time' => SORT_DESC])
                    ->asArray()
                    ->all();
        
        return $resource;
    }
}
