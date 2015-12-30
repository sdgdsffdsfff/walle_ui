<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "deployment_config".
 *
 * @property integer $deployment_id
 * @property integer $parameter_id
 * @property string $value
 *
 * @property Parameter $parameter
 * @property Deployment $deployment
 */
class DeploymentConfig extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'deployment_config';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['deployment_id', 'parameter_id'], 'required'],
            [['deployment_id', 'parameter_id'], 'integer'],
            [['value'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'deployment_id' => 'Deployment ID',
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
    public function getDeployment()
    {
        return $this->hasOne(Deployment::className(), ['id' => 'deployment_id']);
    }
}
