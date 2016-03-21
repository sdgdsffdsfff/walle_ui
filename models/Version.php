<?php
namespace app\models;
use app\models\ModuleTag;
use app\models\Deployment;
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

class Version extends BaseModel
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
     * expand parameter of toArray()
     */
    public function extraFields()
    {
        return array(
            'region' => function() {
                if (isset($this->platform) && isset($this->platform->region)) {
                    return $this->platform->region->name;
                }
            },
            'platform' => function() {
                if (isset($this->platform)) {
                    return $this->platform->name;
                }
            },
            'upgrade_path' => function() {
                if (isset($this->upgradePath)) {
                    return $this->upgradePath->name;
                }
            }
        );
    
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
     * 一个版本对应一个平台,二者1对1关系
     * @return \yii\db\ActiveQuery
     */
    public function getPlatform()
    {
        return $this->hasOne(Platform::className(), ['id' => 'platform_id']);
    }

    /**
     * 一个版本对应一个升级序列,二者1对1关系
     * @return \yii\db\ActiveQuery
     */
    public function getUpgradePath()
    {
        return $this->hasOne(UpgradePath::className(), ['id' => 'upgrade_path_id']);
    }
    
    /**
     * 根据版本号获取数据
     * @param int $versionId 版本号
     * @return array
     */
    public static function getDataById($versionId)
    {
        $fields = ['id','platform_id','upgrade_path_id','create_time','create_user','change_log'];
        $condition = ['id' => $versionId];
        
        $resource = Version::find()->where($condition);
        $result = $resource->select($fields)
                  ->with([
                      'upgradePath' => function($resource)
                      {
                          $resource->select('*')->where(['disable' => 0]);
                      }
                  ])->asArray()->one();
        
        return $result;
    }
    
    /**
     * 添加新数据
     * @param array $datas 新增的版本数据
     * @return bool
     */
    public static function createVersion($datas)
    {
        $version = new Version();
        $version->platform_id = $datas['platform_id'];
        $version->upgrade_path_id = $datas['upgrade_path_id'];
        $version->create_time = date('Y-m-d H:i:s');
        $version->create_user = $datas['create_user'];
        $version->change_log = $datas['change_log'];
        
        $bool = $version->insert();
        if($bool)
        {
            return $version->getOldAttribute('id');
        }
        else
        {
            return false;
        }
    }
    
    /**
     * 根据版本id,更新change_log
     * @param int $versionId 版本id
     * @param string $changeLog 更新日志
     * @return boolean
     */
    public static function modifyChangeLog($versionId, $changeLog)
    {
        $version = Version::findOne($versionId);
        $version->change_log = $changeLog;
        $bool = $version->save();
        
        return $bool;
    }
    /**
     *  根据版本号获取数据
     * @param int $versionId 版本号
     * @return array
     */
    public static function getById($versionId)
    {
        $fields = ['id','platform_id','upgrade_path_id'];
        
        $condition = ['id' => $versionId];
        $result = Version::find()->select($fields)
                  ->where($condition)
                  ->asArray()
                  ->one();
        return $result;
    }
    
    /**
     * 获得三十天内已上线版本
     * @param int $versionId 版本号
     * @return array
     */
    public static function getUpdateVersion($startDate, $endDate, $upgradPathId, $versionId)
    {
        $condition = ['upgrade_path_id' => $upgradPathId,'released' =>1];
        $fields = ['id','platform_id','upgrade_path_id'];
        $versionUpdateList = Version::find()
                            ->where($condition)
                            ->andWhere(['>','release_time', $startDate])
                            ->andWhere(['<=', 'release_time',$endDate])
                            ->andWhere(['<', 'id',$versionId])
                            ->asArray()
                            ->orderBy('id desc')
                            ->all();
        return $versionUpdateList;
    }

    /**
     * 获取版本详情，包括部署位置、module等信息，供版本对比使用
     * @param version id
     * @return array
     */
    public static function getVersionDetial($id)
    {
        $versionInfo = Version::findOne($id)->toArray(array(),array("region", "platform", "upgrade_path"));
        $deployment = Deployment::getDataByPlatformId($versionInfo['platform_id']);
        $moduleInfo = ModuleTag::getVersionModuleTag($id);
        if (empty($versionInfo) || empty($deployment) || empty($moduleInfo))
        {
            return false;
        }
        foreach ($deployment as $value)
        {
            $versionInfo['deployment'][] = $value['name']; 
        }
        $versionInfo['module'] = array();
        foreach ($moduleInfo as $value)
        {
            $versionInfo['module'][$value['module']['name']] = $value['tag'];
        }
    
        return $versionInfo;
    }
}
