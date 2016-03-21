<?php
namespace app\models;
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
    
    /**
     * 获取所有可用模块
     * @return array
     */
    public static function getAllDatas()
    {
        $resource = Module::find()->where(['disable' => 0])
                    ->asArray()
                    ->all();
        
        return $resource;
    }
    
    /**
     * 获取所有模块
     * @return array
     */
    public static function getAllModules()
    {
        $resource = Module::find()->orderBy(['id' => SORT_DESC])->asArray()->all();
        
        return $resource;
    }
    
    /**
     * 根据id获取数据
     * @param int id 模块id
     * @return array
     */
    public static function getModuleById($id)
    {
        $fields = ['id','name','description','disable','repo_type'];
    
        $condition = ['id' => $id];
        $result = Module::find()->select($fields)
                ->where($condition)
                ->asArray()
                ->one();
        
        return $result;
    }
    
    /**
     * 根据名称获取模块
     * @param string $name 模块名称
     * @return mixed
     */
    public static function getDataByName($name)
    {
        $condition = ['name' => $name];
        $result = Module::findOne($condition);
        
        if(!empty($result))
        {
            return $result->toArray();
        }
        else
        {
            return false;
        }
    }
    
    /**
     * 添加新的记录
     * @param array $datas 新数据
     * @return bool
     */
    public static function createModule($datas)
    {
        $module = new Module();
        $module->name = $datas['name'];
        $module->description = $datas['description'];
        $module->disable = $datas['disable'];
        $module->repo_type = $datas['repo_type'];

        $bool = $module->save();
        
        return $bool;
    }
    
    /**
     * 编辑记录
     * @param array $datas 所需数据
     * @return bool
     */
    public static function eidtModule($datas)
    {
        $module = Module::findOne($datas['id']);
        $module->name = $datas['name'];
        $module->description = $datas['description'];
        $module->disable = $datas['disable'];
        $module->repo_type = $datas['repo_type'];
        
        $bool = $module->save();
        
        return $bool;
    }
}
