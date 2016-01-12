<?php

namespace app\models;

use Yii;

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
class UpgradePathConfig extends \yii\db\ActiveRecord
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
        $result = UpgradePathConfig::find()->where($condition)->with('parameter')->asArray()->all();
        
//         $resource = UpgradePathConfig::find()->where($condition);
//         $result = $resource->select('*')
//         ->with([
//                 'parameter' => function($resource)
//                 {
//                     $resource->select('*');
//                 }
//         ])->asArray()->all();
        return $result;
    }
}
