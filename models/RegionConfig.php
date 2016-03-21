<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "region_config".
 *
 * @property integer $region_id
 * @property integer $parameter_id
 * @property string $value
 *
 * @property Region $region
 * @property Parameter $parameter
 */
class RegionConfig extends BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'region_config';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['region_id', 'parameter_id'], 'required'],
            [['region_id', 'parameter_id'], 'integer'],
            [['value'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'region_id' => 'Region ID',
            'parameter_id' => 'Parameter ID',
            'value' => 'Value',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRegion()
    {
        return $this->hasOne(Region::className(), ['id' => 'region_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParameter()
    {
        return $this->hasOne(Parameter::className(), ['id' => 'parameter_id']);
    }
    
    /**
     * 根据地区id获取发行地区配置
     * @param int $versionId 版本号
     * @return array
     */
    public static function getRegionConfigById($regionId)
    {
        $condition = ['region_id' => $regionId];
    
        $resource = RegionConfig::find()->where($condition);
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
