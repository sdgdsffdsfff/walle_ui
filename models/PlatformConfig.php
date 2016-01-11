<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "platform_config".
 *
 * @property integer $platform_id
 * @property integer $parameter_id
 * @property string $value
 *
 * @property Parameter $parameter
 * @property Platform $platform
 */
class PlatformConfig extends BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'platform_config';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['platform_id', 'parameter_id'], 'required'],
            [['platform_id', 'parameter_id'], 'integer'],
            [['value'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'platform_id' => 'Platform ID',
            'parameter_id' => 'Parameter ID',
            'value' => 'Value',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParameter()
    {
        return $this->hasOne(Parameter::className(), ['id' => 'parameter_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlatform()
    {
        return $this->hasOne(Platform::className(), ['id' => 'platform_id']);
    }
    
    /**
     * 根据平台id获取平台配置
     * @param int $versionId 版本号
     * @return array
     */
    public static function getPlatformConfigById($platformId)
    {
        $condition = ['platform_id' => $platformId];
    
        $resource = PlatformConfig::find()->where($condition);
        $result = $resource->select('*')
        ->with([
                'parameter' => function($resource)
                {
                    $resource->select('*');
                }
        ])->asArray()->all();
    
        return $result;
    }
}
