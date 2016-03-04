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
class DeploymentConfig extends BaseModel
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
     * expand parameter of toArray()
     */
    public function fields()
    {
        return array(
            "deployment_id",
            "parameter_id",
            "value",
            "deployment_name" => function() {
                if (isset($this->deployment))
                {
                    return $this->deployment->name;
                }
            },
            "parameter_name" => function() {
                if (isset($this->parameter))
                {
                    return $this->parameter->name;
                }
            },
            "parameter_des" => function() {
                if (isset($this->parameter))
                {
                    return $this->parameter->description;
                }
            },
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
     * @return \yii\db\ActiveQuery
     */
    public function getDeployment()
    {
        return $this->hasOne(Deployment::className(), ['id' => 'deployment_id']);
    }
    /**
     * 根据发布位置id获取发布位置配置
     * @param int deployment_id 发布位置
     * @return array
     */
    public static function getPlatformConfigById($deploymentId)
    {
        $condition = ['deployment_id' => $deploymentId];
    
        $resource = DeploymentConfig::find()->where($condition);
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
