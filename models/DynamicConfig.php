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
class DynamicConfig extends \yii\db\ActiveRecord
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
     * @return \yii\db\ActiveQuery
     */
    public function getParameter()
    {
        return $this->hasOne(Parameter::className(), ['id' => 'parameter_id']);
    }
}
