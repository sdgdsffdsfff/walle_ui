<?php
namespace app\models;
/**
 * This is the model class for table "upgrade_path_config".
 *
 * @property integer $upgrade_path_id
 * @property integer $parameter_id
 * @property string $value
 *
 * @property UpgradePath $upgradePath
 * @property Parameter $parameter
 */

class UpgradePathConfig extends BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'upgrade_path_config';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['upgrade_path_id', 'parameter_id'], 'required'],
            [['upgrade_path_id', 'parameter_id'], 'integer'],
            [['value'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'upgrade_path_id' => 'Upgrade Path ID',
            'parameter_id' => 'Parameter ID',
            'value' => 'Value',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpgradePath()
    {
        return $this->hasOne(UpgradePath::className(), ['id' => 'upgrade_path_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParameter()
    {
        return $this->hasOne(Parameter::className(), ['id' => 'parameter_id']);
    }
    
    /**
     * 根据升级序列id获得升级序列配置
     * @param int upgrade_path_id 升级序列id
     * @return array
     */
    public static function getUpgradePathById($upgradePathId)
    {
        $condition = ['upgrade_path_id' => $upgradePathId];
        
        $resource = UpgradePathConfig::find()->where($condition);
        $result = $resource->select('*')
                ->with([
                        'parameter' => function($resource)
                        {
                            $resource->select('*');
                        }
                ])->asArray()->all();
        
        return $result;
    }
    
    /**
     * 获取全部升级序列配置信息
     * @return array
     */
    public static function getAllUpgradePathConfig()
    {
        $resource = UpgradePathConfig::find();
        $result = $resource->select('*')
                  ->with([
                      'upgradePath' => function($resource)
                      {
                           $resource->select(['id', 'name', 'description']);
                      },
                      'parameter' => function($resource)
                      {
                          $resource->select(['id', 'name', 'description']);
                      }
                  ])->asArray()->all();
                  
        return $result;
    }
    
    /**
     * 根据主机名获取记录
     * @param array $datas 条件
     * @return mixed
     */
    public static function getDataByUpgradePathAndParameter($datas)
    {
        $condition = [
            'upgrade_path_id' => $datas['upgrade_path_id'],
            'parameter_id' => $datas['parameter_id']
        ];
        $result = UpgradePathConfig::findOne($condition);
        
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
    public static function createUpgradePathConfig($datas)
    {
        $upgradePathConfig = new UpgradePathConfig();
        $upgradePathConfig->upgrade_path_id = $datas['upgrade_path_id'];
        $upgradePathConfig->parameter_id = $datas['parameter_id'];
        $upgradePathConfig->value = $datas['value'];

        $bool = $upgradePathConfig->save();
        
        return $bool;
    }
    
    /**
     * 编辑记录
     * @param array $datas 所需数据
     * @return bool
     */
    public static function eidtUpgradePathConfig($datas)
    {
        $condition = [
            'upgrade_path_id' => $datas['upgrade_path_id'],
            'parameter_id' => $datas['parameter_id']
        ];
        
        $upgradePathConfig = UpgradePathConfig::findOne($condition);
        $upgradePathConfig->upgrade_path_id = $datas['upgrade_path_id'];
        $upgradePathConfig->parameter_id = $datas['parameter_id'];
        $upgradePathConfig->value = $datas['value'];
        
        $bool = $upgradePathConfig->save();
        
        return $bool;
    }
    
    /**
     * 删除记录
     * @param array $datas 所需数据
     * @return type
     */
    public static function deleteUpgradePathConfig($datas)
    {
        $condition = [
            'upgrade_path_id' => $datas['upgrade_path_id'],
            'parameter_id' => $datas['parameter_id']
        ];
        
        $upgradePathConfig = UpgradePathConfig::findOne($condition);
        $bool = $upgradePathConfig->delete();
        
        return $bool;
    }
}
