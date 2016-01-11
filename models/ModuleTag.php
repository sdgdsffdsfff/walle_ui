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
    
    /**
     * 根据版本id和模块id,获取模板版本信息
     * @param int $versionId 版本号
     * @param int $moduleId 模块id
     * @return array
     */
    public static function getModuleTagByVersionIdAndModuleId($versionId, $moduleId)
    {
        $resource = ModuleTag::find()
                    ->where(['version_id' => $versionId, 'module_id' => $moduleId])
                    ->asArray()
                    ->one();
        
        return $resource;
    }
    
    /**
     * 添加新的子模块tag数据
     * @param array $datas 新数据
     * @return bool
     */
    public static function CreateModuleTag($datas)
    {
        $moduleTag = new ModuleTag();
        $moduleTag->version_id = $datas['version_id'];
        $moduleTag->module_id = $datas['module_id'];
        $moduleTag->tag = $datas['tag'];
        
        $bool = $moduleTag->insert();
        
        return $bool;
    }
    
    /**
     * 根据版本号获取数据
     * @param int $versionId 版本号
     * @return array
     */
    public static function getVersionModuleTag($versionId)
    {
        $fields = ['tag','module_id'];
        $condition = ['version_id' => $versionId];
    
        $resource = ModuleTag::find()->where($condition);
        $result = $resource->select($fields)
        ->with([
                'module' => function($resource)
                {
                    $resource->select('*')->where(['disable' => 0]);
                }
        ])->asArray()->all();
    
        return $result;
    }
}
