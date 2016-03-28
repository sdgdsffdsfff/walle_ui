<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "dynamic_config".
 *
 * @property integer $parameter_id
 * @property string $value
 *
 * @property Parameter $parameter
 */
class DynamicConfig extends BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dynamic_config';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parameter_id'], 'required'],
            [['parameter_id'], 'integer'],
            [['value'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'parameter_id' => 'Parameter ID',
            'value' => 'Value',
        ];
    }

    /**
     * expand parameter of toArray()
     */
    public function fields()
    {
        return array(
            "parameter_id",
            "value",
            "alias" => function() {
                if (isset($this->parameter))
                {
                    return $this->parameter->description . "(" . $this->parameter->name . ")";
                }
            }
        );
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParameter()
    {
        return $this->hasOne(Parameter::className(), ['id' => 'parameter_id']);
    }
    
    /**
     * 获得动态参数
     * @param int $platformId 平台id
     * @return array
     */
    public static function getData()
    {
        $result = DynamicConfig::find()->with('parameter')->asArray()->all();
        return $result;
    }
}
